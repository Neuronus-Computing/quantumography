<?php

namespace App\Http\Controllers;

use App\Models\VirtualMachiene;
use App\Models\OperatingSystem;
use App\Models\Period;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Setting;
use Mail;
use App\Mail\UserRegistration;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class VmController extends Controller
{
    public function index()
    {
        $tool = "Virtual Machines";
        $pageTitle = 'Virtual Machines';
        $virtualMachienes = VirtualMachiene::all();
        $operatingSystems = OperatingSystem::all();
        $periods = Period::all();
        return view('vm.index', compact('pageTitle', 'tool', 'virtualMachienes', 'operatingSystems', 'periods'));
    }
    public function os()
    {
        $tool = "Virtual Machienes";
        $pageTitle = 'Operating Systems';
        return view('vm.os', compact('pageTitle', 'tool'));
    }
    public function buy(Request $request) {
        $rules = [
            'vm' => 'required|exists:virtual_machienes,id',
            'vm_location' => 'required',
            'os' => 'required|exists:operating_systems,id',
            'period' => 'required|integer',
            'vpnSwitch' => 'nullable',
            'vpn_location' => [
                'required_if:vpnSwitch,13', 
            ],
        ];

        // Define custom error messages
        $customMessages = [
            'vm.exists' => 'Please select a valid VM.',
            'vm.required'=> 'The VM tarrif field is required.',
            'os.exists' => 'Please select a valid operating system.',
            'period.integer' => 'Please select a valid period.',
            'vpn_location.required_if'=>"VPN location field is required, when VPN is on."
        ];

        // Validate the request data
        $request->validate($rules, $customMessages);
        // Collect user details from the initial form submission
        $userDetails = $request->all();

        // Store user details in the session
        session()->put('userDetails', $userDetails);

        // Redirect to the checkout form
        return redirect()->route('vm.checkout');
    }
    public function checkout(Request $request)
    {
        if(session()->has('userDetails')){
            $pageTitle = "Checkout page";
            $details = session()->get('userDetails');
            $orderNumber = '#' . str_pad(mt_rand(1, 99999999), 8, '0', STR_PAD_LEFT);
            $vm = VirtualMachiene::where('id', $details['vm'])->first();
            $os = OperatingSystem::where('id', $details['os'])->first();
            return view('vm.checkout_form', compact('details', 'pageTitle', 'vm', 'os', 'orderNumber'));
        }
        else{
            return redirect()->route('vm.index')->with('error','Please select your virtual machine to buy.');
        }
    }
    public function processPayment(Request $request)
    {
        $request->validate([
            'payment_method'=>'required',
            'amount'=>'required',
            'name'=>'required',
            'order_number'=>'required',
            'email'=>'required|email',
        ]);
        $user = User::where('email', $request->email)->first();
        if(!$user){
            $password = str_pad(mt_rand(1, 99999999), 8, '0', STR_PAD_LEFT); 
            $hashedPassword = Hash::make($password);
            $user = User::create([
                'name'=>$request->name,
                'email' => $request->email,
                'password' => $hashedPassword,
            ]);
            Mail::to($user->email)->send(new UserRegistration($user, $password));
        }
        $amount = $request->input('amount'); 
        $payment="";
        Stripe::setApiKey(config('services.stripe.secret'));
        try{
            // Create a Payment Intent with Stripe
            $details = session()->get('userDetails');
            $paymentIntent = PaymentIntent::create([
                'amount' => $amount * 100, // Amount in cents
                'currency' => 'eur', // Euro currency code
                'payment_method' => $request->input('payment_method'), 
                'confirm' => true,
                'description' => 'Payment for virtual machine.', 
                'receipt_email' => $user->email,
                'metadata' => [
                    'cardholder_name' => $request->input('name'),
                ],
                'return_url' => route('vm.payment.success')
            ]);
            // Verify that the payment intent is successful
            if ($paymentIntent->status === 'succeeded') {
                // Payment was successful store payment details in the database
                $currentDate = Carbon::now();
                // Add a specified number of months to the current date
                $expiryDate = $currentDate->addMonths($details['period']); 
                // Format the expiry date 
                $expiryDateString = $expiryDate->format('Y-m-d'); // Format to 'YYYY-MM-DD'
                $payment =Payment::create([
                    'user_id' => $user->id,
                    'amount' => $paymentIntent->amount/100,
                    'currency' => $paymentIntent->currency,
                    'payment_method' => $paymentIntent->payment_method,
                    'transaction_id' => $paymentIntent->id, 
                    'operating_system_id'=>$details['os'],
                    'virtual_machiene_id'=>$details['vm'],
                    'period'=>$details['period'],
                    'vm_location'=>$details['vm_location'],
                    'vpn_location'=>$details['vpn_location'] ?? '',
                    'expiry_date'=>$expiryDateString,
                    'order_no'=>$request->order_number,
                ]);
            }
            else{
                return redirect()->back()->with('error', 'Payment failed, Please try again.');
            }
        }catch (\Exception $e) {
                return redirect()->back()->with('error', $e->getMessage());
        }
        $validated_cc_emails = [];
        $emails = Setting::where('key','admin_emails')->where('status',1)->first();
        if($emails) {
            $cc_emails = explode(',', $emails->value);    
            foreach ($cc_emails as $email) {
                $email = trim($email, ' "');
                if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    array_push($validated_cc_emails, $email);
                }
            }
        }
        $data = [
            'payment_details' => $payment,
            'user' => $user,
        ];
        $pdf = PDF::loadView('email.vm_payment_success_pdf', $data);
        Mail::send('email.vm_payment_success', ['emailData' => $data],function ($message) use ($data, $user,$validated_cc_emails, $pdf) {
            $message->to($data["user"]->email)
                ->subject("Virtual Machine - Payment Success")
                ->cc($validated_cc_emails)
                ->attachData($pdf->output(), 'invoice.pdf');
        });
        session()->remove('userDetails');
        return redirect()->route('vm.payment.success', ['payment' => $payment]);
    }
    public function paymentSuccess(Request $request , $payment='')
    {
        $tool = "Virtual Machines";
        $pageTitle = 'Payment Success';
        $payment = Payment::where('id',$payment)->first();
        if($payment){
            return view('vm.payment_success', compact('payment','pageTitle','tool'));
        }
        else{
            return redirect()->route('vm.index')->with('error','Payment record not found, please try again.');
        }
    }
}
