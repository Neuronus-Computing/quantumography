<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FilePassPeriod;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use QrCode;
use App\Models\FilePass;
use App\Models\TemporaryFile;
use App\Models\User;
use App\Models\Payment;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Mail;
use App\Mail\UserRegistration;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File as FileSystem;

class FilePassController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pageTitle ="FILEPass";
        $periods = FilePassPeriod::all();
        if (!session()->has('errors') && session()->has('order_no')) {
            $orderNumber = session()->get('order_no');
            $files = TemporaryFile::where('order_no',$orderNumber)->get();
            $directory='';
            if($files){
                foreach($files as $file){
                    $directory = pathinfo($file->path, PATHINFO_DIRNAME);
                    Storage::delete($file->path);
                    $file->delete();
                }
                // Check if the directory is empty
                if (Storage::directories($directory) === [] && Storage::files($directory) === []) {
                    // Delete the directory
                    Storage::deleteDirectory($directory);
                }
            }
            session()->remove('order_no');
        }
        return view('file-pass.index',compact('pageTitle','periods'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(session()->has('order_no')){
            $orderNumber = session()->get('order_no');
            $fileCount = TemporaryFile::where('order_no', $orderNumber)->count();
            if($fileCount < 1){
                return back()->with(['error' => 'Please select atleast one file to upload.']);
            }

        }
        else{
            return back()->with(['error' => 'Please select atleast one file to upload.']);
        }
        $request->merge(['order_no'=>$orderNumber]);
        $request->validate([
            'period' => 'required|exists:file_pass_periods,id',
            'password' => 'nullable|required_if:password_protected,1|confirmed|min:8',
            'total_size'=>'required',
            'file_price'=>"required"
            ],[
               'password.required_if'=>"Password is required, When password protection is enabled.",
            ]
        );       
        $period = FilePassPeriod::where('id', $request->period)->first();
         // Hash the password if it is present
         if (isset($request->password_protected) && !empty($request->password)) {
            $password = Hash::make($request->password);
        } else {
            // If password is not present or password protection is not enabled, set password to null
            $password = null;
        }
        if($request->amount > 0){
            $files = TemporaryFile::where('order_no', $orderNumber)->sum('size');
            $fileDetails = [
                'password_protected'=>$request->password_protected ?? 0,
                'password'=>$password,
                'period'=>$period,
                'expirationDate' => now()->addMonths($period->period_value),
                'amount'=>$request->amount,
                'is_paid'=>0,
                'order_no'=>$orderNumber,
                'size_selected'=>$request->total_size,
                'file_price'=>$request->file_price
            ];
            // Store user details in the session
            session()->put(['fileDetails'=> $fileDetails]);
            // Redirect to the checkout form
            return redirect()->route('file.pass.checkout');
        }
        else{
            $files = TemporaryFile::where('order_no', $orderNumber)->get();
            foreach ($files as $file) {
                // Save details in the database
                FilePass::create([
                    'user_id' => auth()->id() ?? null, 
                    'file_name' => $file->file_name,
                    'size' => $file->size,
                    'path'=>$file->path,
                    'password_protected'=>$request->password_protected ?? 0,
                    'password'=>$password,
                    'order_no' => $file->order_no, // You need to implement a function to generate an order number
                    'expiration_date' => now()->addDays(7), // Adjust as per your logic
                ]);
                $file->delete();
            }
            session()->remove('order_no');
            return redirect()->route('file.pass.success', $orderNumber);
        }
    }
    public function storeFile(Request $request)
    {
        $request->validate(['file' => 'required|file|max:500000000']);
        if(!session()->has('order_no')){
            $orderNumber = str_pad(mt_rand(1, 99999999), 8, '0', STR_PAD_RIGHT);
            session()->put(['order_no'=>$orderNumber]);
        }else{
            $orderNumber = session()->get('order_no');
        }
        try{
            $file =$request->file('file');
            // Store the file in storage
            $path = $file->storeAs('public/'.$orderNumber, $file->getClientOriginalName());
            // Save details in the database
            TemporaryFile::create([
                'file_name' => $file->getClientOriginalName(),
                'size' => $file->getSize(),
                'path'=>$path,
                'order_no' => $orderNumber
            ]);
            
            $tempFiles = TemporaryFile::where('order_no', $orderNumber)->get();
            return response()->json(['success'=>true,'files'=>$tempFiles],200);
        } catch (\Exception $e) {
            // Handle exceptions here
            return response()->json(['error' => 'Something went wrong, please contact our support team.'],500);
        }
    }
    public function getUploadedFiles(){
        if (session()->has('order_no')) {
            $orderNumber = session()->get('order_no');
            try{
                $tempFiles = TemporaryFile::where('order_no', $orderNumber)->get();
                return response()->json(['success'=>true,'files'=>$tempFiles],200);
            } catch (\Exception $e) {
                    // Handle exceptions here
                    return response()->json(['error' => 'Something went wrong, please contact our support team.'],500);
            }
        }else{
            return response()->json(['success' =>true],200);
        }
    }
    public function removeFile(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:temporary_files,id'
        ]);
        $file = TemporaryFile::where('id',$request->id)->first();
        $orderNumber = $file->order_no;
        // Remove the file from storage
        Storage::delete($file->path);
        // Remove the record from the database
        $file->delete();
        // Get the remaining files after deletion
        $tempFiles = TemporaryFile::where('order_no', $orderNumber)->get();
        return response()->json(['success' => true, 'files' => $tempFiles], 200);
    }
    public function success(Request $request, $orderNumber)
    {
        $pageTitle = "FILEPass";
        $submenu=['link'=>route('file.pass.index'), 'title'=>"FILEPass"];

        $file=FilePass::where('order_no', $orderNumber)->first();
        $shortLink = env('APP_URL') . '/file/' . base64_encode($orderNumber);
        if ($file) {
            if(!$file->qr_code){
                // Generate QR code
                $qrCode = QrCode::format('png')->size(500)->backgroundColor(255, 255, 255);
                // Get the path to your logo image
                $logoPath = public_path('assets/logo/logo-white-0073.jpg');
                // Check if the logo file exists
                if (file_exists($logoPath)) {
                    // Merge the QR code with the logo
                    $qrCode->merge($logoPath, 0.2, true);
                }
                $filename=substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 8);
                // Generate the final QR code
                $qrCode = $qrCode->generate($shortLink);
                // Save QR code to storage
                $filePath = "public/qrcodes/{$filename}.png";
                Storage::put($filePath, $qrCode);
                FilePass::where('order_no', $orderNumber)->update(['qr_code'=>$filePath]);
            }
            $file=FilePass::where('order_no', $orderNumber)->first();
            $qrpath =$file->qr_code;
            $expiry = $file->expiration_date;
            return view('file-pass.success', compact('shortLink', 'pageTitle', 'qrpath','expiry','submenu'));
        } else {
            return redirect()->route('file.pass.index')->with("error", "File(s) not found. , Please upload again and share.");
        }
    }
    public function checkout(Request $request)
    {
        if(session()->has('fileDetails')){
            $pageTitle = "Checkout page";
            $submenu=['link'=>route('file.pass.index'), 'title'=>"FILEPass"];
            $details =session()->get('fileDetails');
            $orderNumber = $details['order_no'];
            return view('file-pass.checkout_form', compact('details', 'pageTitle','orderNumber','submenu'));
        }
        else{
            return redirect()->route('file.pass.index')->with('error','Please select your file and upload files to share.');
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
        $details = session()->get('fileDetails');
        $orderNumber = session()->get('order_no');
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
        if($details['period']->type == 'days'){
            $expiryDate = now()->addDays($details['period']->period_value);
        }
        else{
            $expiryDate = now()->addMonths($details['period']->period_value);
        }
        Stripe::setApiKey(config('services.stripe.secret'));
        try{
            // Create a Payment Intent with Stripe
            $paymentIntent = PaymentIntent::create([
                'amount' => $amount * 100,
                'currency' => 'usd', 
                'payment_method' => $request->input('payment_method'), 
                'confirm' => true,
                'description' => 'Payment for file pass.', 
                'receipt_email' => $user->email,
                'metadata' => [
                    'cardholder_name' => $request->input('name'),
                ],
                'return_url' => route('file.pass.success', $orderNumber)
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
                return redirect()->back()->with('error', 'Payment failed, Please try again.');
            }
        }catch (\Exception $e) {
                return redirect()->back()->with('error', $e->getMessage());
        }
        $files = TemporaryFile::where('order_no', $orderNumber)->get();
        foreach ($files as $file) {
            FilePass::create([
                'user_id' => $user->id ?? null, 
                'file_name' => $file->file_name,
                'size' => $file->size,
                'path'=>$file->path,
                'password_protected'=>$details['password_protected'] ?? 0,
                'password'=>$details['password'],
                'order_no' => $file->order_no,
                'expiration_date' => $expiryDate, 
            ]);
            $file->delete();
        }
        session()->remove('fileDetails');
        session()->remove('order_no');
        return redirect()->route('file.pass.success', $orderNumber);
    }
    public function verifyPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|string',
            'orderNumber' => 'required',
        ]);
        $file = FilePass::where('order_no', $request->orderNumber)->first();
        // Check if the provided password matches the actual password
        if (Hash::check($request->input('password'), $file->password)) {
            $files = FilePass::where('order_no', $request->orderNumber)->get();
            return response()->json(['status' => 'success', 'files'=>$files]);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Incorrect password.']);
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($orderNumber)
    {
        $pageTitle="FILEPass";
        $submenu=['link'=>route('file.pass.index'), 'title'=>"FILEPass"];
        $file = FilePass::where('order_no',$orderNumber)->first();
        if($file){
            $expiry = $file->expiration_date;
            return view('file-pass.show',compact('pageTitle','orderNumber','expiry','submenu'));
        }
        else{
            return redirect()->route('file.pass.index')->with('error', 'File not found.');
        }
    }
    public function getFiles(Request $request, $orderNumber)
    {
        $files = FilePass::where('order_no',$orderNumber)->first();
        if (!$files) {
            return response()->json(['status' => 'error', 'message' => 'File not found.']);
        }
        if($files->password_protected == 1) {
            return response()->json(['status' => 'success', 'protected' => true, 'files'=>'']);
        }
        else{
            $files = FilePass::where('order_no',$orderNumber)->get();
            return response()->json(['status' => 'success', 'files' => $files]);
        }
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
