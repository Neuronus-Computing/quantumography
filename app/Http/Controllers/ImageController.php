<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Storage;
use Illuminate\Support\Facades\File;
use App\Models\EnlargeImage;
use App\Models\Plan;
use App\Models\UserApiSecret;
use Auth;
use Mail;
use Illuminate\Support\Str;


class ImageController extends Controller
{
    public function index(Request $request)
    {
        $pageTitle = 'Image Enlarger';
        return view('image.enlarge', compact('pageTitle'));
    }
    public function vpnWarning(Request $request)
    {
        $pageTitle = 'VPN Warning';
        $submenu=['link'=>route('image.index'), 'title'=>"Image Enlarger"];
        return view('image.vpn-warning', compact('pageTitle','submenu'));
    }
    public function checkAllowedRequests(Request $request)
    {
        $count = 0;
        $allowed = env('IMAGE_REQUESTS_ALLOWED_PER_MONTH');
        $remaning = 0;
        $user = Auth::user();
        if ($user) {
            if ($user->subscriptions()->count()) {
                $payment = $user->subscriptions()->latest()->first();
                $payId = $payment->stripe_price;
                if ($payId) {
                    $plan = Plan::where('price_id', $payId)->first();
                    if($plan->total_images_allowed){
                        $allowed = $plan->total_images_allowed;
                    }
                    else{
                        $allowed = "Unlimited" ;
                    }
                }
                $count = EnlargeImage::where('user_id', $user->id)->where('subscription_id', $payment->id)->currentMonth()->count();
            }
            else{
                $count = EnlargeImage::where('user_id', $user->id)->currentMonth()->count();
            }
        } else {
            $count = EnlargeImage::where('user_ip', $request->ip())->currentMonth()->count();
        }
        $remaning = $allowed == "Unlimited"  ? "Unlimited" : $allowed - $count;
        return response()->json(['allowed' => $allowed, 'used' => $count, 'remaining' => $remaning]);
    }
    public function imageEnlarge(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg|max:3072',
            'noise' => 'required|in:-1,0,1,2,3',
            'scale' => 'required|in:1,2,3,4,8',
            'format' => 'required|in:png,webp,jpg,jpeg',
        ]);
        $count = 0;
        $allowed = env('IMAGE_REQUESTS_ALLOWED_PER_MONTH');
        $user = Auth::user();
        $payment ='';
        if ($user) {
            if ($user->subscriptions()->count()) {
                $payment = $user->subscriptions()->latest()->first();
                $payId = $payment->stripe_price;
                if ($payId) {
                    $plan = Plan::where('price_id', $payId)->first();
                    if($plan->total_images_allowed){
                        $allowed = $plan->total_images_allowed;
                    }
                    else{
                        $allowed == "Unlimited" ;
                    }
                }
                $count = EnlargeImage::where('user_id', $user->id)->where('subscription_id', $payment->id)->currentMonth()->count();
            }
            else{
                $count = EnlargeImage::where('user_id', $user->id)->currentMonth()->count();
            }            
            if($allowed != "Unlimited"){
                if ($count >= $allowed) {
                    session()->put(['error' => "You already used allowed image requests, please buy any subscription for more requests."]);
                    return response()->json(['url' => route('plan.index')]);
                }
            }
        } else {
            $count = EnlargeImage::where('user_ip', $request->ip())->currentMonth()->count();
            if ($count >= $allowed) {
                session()->put(['error' => "You already used allowed image requests, please buy any subscription for more requests."]);
                return response()->json(['url' => route('register')]);
            }
        }

        // Mail::send('email.limit-alert', ['emailData' => $data], function ($message) use ($data, $validated_cc_emails) {
        //     $message->to($validated_cc_emails)
        //         ->subject("Image Enlarge - Image Upscale API Limit Alert");
        // });

        $scale = $request->input('scale');
        $noise = $request->input('noise');
        $format = $request->input('format');
        $image = $request->file('image'); // Assuming 'file' is the name of your file input field.
        try {
            // Create a Guzzle HTTP client
            $client = new Client();
            $originalFilename = $image->getClientOriginalName();

            // Prepare the POST request to the Flask API
            $response = $client->request('POST', env('IMAGE_ENLARGE_API'), [
                'multipart' => [
                    [
                        'name' => 'scale',
                        'contents' => $scale,
                    ],
                    [
                        'name' => 'noise',
                        'contents' => $noise,
                    ],
                    [
                        'name' => 'format',
                        'contents' => $format,
                    ],
                    [
                        'name' => 'file',
                        'contents' => file_get_contents($image->getRealPath()),
                        'filename' => $originalFilename,
                    ],
                ],
            ]);

            // Get the response from the Flask API as binary content
            $imageContent = $response->getBody()->getContents();

            if ($imageContent) {
                $path = public_path('storage/images/');

                if (!File::isDirectory($path)) {
                    File::makeDirectory($path);
                }

                // Generate a random string to include in the filename (e.g., 10 characters)
                $randomString = Str::random(10);

                // Create a unique filename by combining the random string and a timestamp
                $filename = $scale . 'x_' . $randomString . '_' . time() . '.' . strtolower($format);
                $fullPath = $path . '/' . $filename;

                // Save the received image content to a file with the unique filename
                file_put_contents($fullPath, $imageContent);

                // Return the download URL of the saved image to the front end
                $downloadUrl = asset('storage/images/' . $filename);
                $image = EnlargeImage::create(
                    [
                        'user_id' => $user->id ?? null,
                        'user_ip' => request()->ip(),
                        'image' => $downloadUrl,
                        'subscription_id'=> $payment->id ?? null,
                    ]
                );
                return response()->json(['download_url' => $downloadUrl]);
            }
        } catch (\Exception $e) {
            // Handle exceptions here
            return response()->json(['error' => 'Something went wrong, please contact our support team.']);
        }
    }
    public function apiKey() {
        $pageTitle = "API Keys";
        $secretKey=null;
        $apiKey=null;
        $submenu=['link'=>route('image.index'), 'title'=>"Image Enlarger"];
        $user = Auth::user();
        if($user->apiKeySecret()->count() > 0){
            $apiSecrets = UserApiSecret::where('user_id', $user->id)->first();
        }
        else{
            $api_key = Str::random(32);
            $secret_key = Str::random(64);
            $apiSecrets = $user->apiKeySecret()->create([
                'api_key' => 'pk_'.$api_key,
                'secret_key' => 'sk_'.$secret_key,
            ]);
        }
        if($apiSecrets){
            $secretKey = $apiSecrets->secret_key;
            $apiKey=$apiSecrets->api_key;
        }
        return view('image.api-keys',compact('apiKey','secretKey','pageTitle','submenu'));
    }
    public function apiDocumentation(){
        $pageTitle = "API Documentation";
        $submenu=['link'=>route('image.index'), 'title'=>"Image Enlarger"];
        return view('image.api-documentation',compact('pageTitle','submenu'));
    }
    public function generateKeys(){
        $user = Auth::user();
        $api_key = Str::random(32);
        $secret_key = Str::random(64);
        $user->apiKeySecret()->create([
            'api_key' => 'pk_'.$api_key,
            'secret_key' => 'sk_'.$secret_key,
        ]);
        return redirect()->back()->with(['success'=>"Your API keys generated successfully."]);
    }
}
