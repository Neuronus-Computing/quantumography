<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VangographyPlan;
use App\Models\EncryptedFile;
use App\Models\User;
use Stripe\PaymentIntent;
use Stripe\PaymentMethod;
use Stripe\Subscription;
use Carbon\Carbon;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserRegistration;
class VangographyPaymentController extends Controller
{
    public function checkout(Request $request)
    {
        if(session()->has('fileDetails')){
            $pageTitle = "Checkout page";
            $submenu=['link'=>route('index'), 'title'=>"Quantumography"];
            $details =session()->get('fileDetails');
            $orderNumber = session()->get('order_no');
            return view('quantumography.checkout_form', compact('details', 'pageTitle','orderNumber','submenu'));
        }
        else{
            return redirect()->route('quantumography.encode')->with('error','Please select your files to encrypt.');
        }
    }
    public function processPayment(Request $request)
    {
        $request->validate([
            'payment_method'=>'required',
            'amount'=>'required',
            'name'=>'required',
            'email'=>'required|email',
        ]);
        // $details = session()->get('fileDetails');
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
            $paymentMethod = PaymentMethod::create([
                'type' => 'card',
                'card' => [
                    'token' => $request->input('payment_method'),
                ],
            ]);
            $paymentIntent = PaymentIntent::create([
                'amount' => $amount * 100,
                'currency' => 'usd', 
                'payment_method' =>$paymentMethod->id, 
                'confirm' => true,
                'description' => 'Payment for file encryption.', 
                'receipt_email' => $user->email,
                'metadata' => [
                    'cardholder_name' => $request->input('name'),
                ],
                'return_url' => route('quantumography.encode')
            ]);
            // Verify that the payment intent is successful
            if ($paymentIntent->status === 'succeeded') {
                // $expiryDateString = $expiryDate->format('Y-m-d');
                // $payment =Payment::create([
                //     'user_id' => $user->id,
                //     'amount' => $paymentIntent->amount/100,
                //     'currency' => $paymentIntent->currency,
                //     'payment_method' => $paymentIntent->payment_method,
                //     'transaction_id' => $paymentIntent->id, 
                //     'period'=>$details['period']->id,
                //     'expiry_date'=>$expiryDateString,
                //     'order_no'=>$request->order_number,
                // ]);
            }
            else{
                return response()->json(['error', 'Payment failed, Please try again.'],500);
            }
        }catch (\Exception $e) {
                return response()->json(['error', $e->getMessage()],500);
        }
        return response()->json(['paid'=>true ],200);
    }
    public function success(Request $request, $id)
    {        
        $pageTitle = "Encryption Success";
        $submenu=['link'=>route('index'), 'title'=>"Quantumography"];
        $file=EncryptedFile::where('id', $id)->where('is_paid', '1')->first();
        if ($file) {
            return view('quantumography.success', compact('file', 'pageTitle','submenu'));
        } else {
            return redirect()->route('quantumography.encode')->with("error", "File(s) not found. , Please try again.");
        }
    }
    public function pricing(){
        $plans = VangographyPlan::all();
        $pageTitle = "Quantumography Pricing Plan";
        $submenu=['link'=>route('index'), 'title'=>"Quantumography"];
        return view('quantumography.plan.index',compact('plans','pageTitle','submenu'));
    }
}
