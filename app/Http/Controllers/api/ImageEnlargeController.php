<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use GuzzleHttp\Client;
use App\Models\User;
use App\Models\Subscription;
use App\Models\EnlargeImage;
use App\Models\Plan;
use App\Models\UserApiSecret;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class ImageEnlargeController extends Controller{
    public function imageEnlarge(Request $request){
        
        $api_key = $request->header('X-Neurnous-Api-Key');
        $secret_key = $request->header('X-Neurnous-Secret-Key');
        // return response()->json(['api'=>$api_key , 'secret'=>$secret_key]);
        $secrets = UserApiSecret::where('api_key', $api_key)->where('secret_key', $secret_key)->first();

        if (!$secrets) {
            return response()->json([
                "message"=>"false.",
                "success"=>false,
                'message' => 'Invalid API key or secret key'
            ], 401);
        }
        else{
            $user = User::where("id",$secrets->user_id)->first();
            $payment ='';
            if ($user) {
                $validator = Validator::make($request->all(), [
                    'image' => 'required|image|mimes:jpeg,png,jpg|max:3072',
                    'noise' => 'required|in:-1,0,1,2,3',
                    'scale' => 'required|in:1,2,3,4,8',
                    'format' => 'required|in:png,webp,jpg,jpeg',
                ]);
                
                if ($validator->fails()) {
                    return response()->json([
                        "message"=>"false.",
                        "success"=>false, 
                        'errors' => $validator->errors()], 422);
                }

                $count = 0;
                $allowed = env('IMAGE_REQUESTS_ALLOWED_PER_MONTH');
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

                    if($allowed != "Unlimited"){
                        if ($count >= $allowed) {
                            return response()->json([
                                "message"=>"false.",
                                "success"=>false,
                                'message' => 'You already used allowed image requests, please upgrade your subscription for more requests.'
                            ],429);
                        }
                    }
                $scale = $request->input('scale');
                $noise = $request->input('noise');
                $format = $request->input('format');
                $image = $request->file('image');
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
                                'user_id' => $user->id,
                                'user_ip' => $user->ip,
                                'image' => $downloadUrl,
                                'subscription_id'=> $payment->id ?? null,
                            ]
                        );
                        if ($allowed == "Unlimited") {
                            $remaining = "Unlimited";
                        } else {
                            $remaining = $allowed - ($count+1);
                        }
                        return response()->json([
                            "message"=>"Success.",
	                        "success"=>true,
                            'download_url' => $downloadUrl,
                            'total_requests'=>$allowed,
                            'used_request'=>$count+1,
                            'remaining_requests'=>$remaining
                        ],200);
                    }
                } catch (\Exception $e) {
                    // Handle exceptions here
                    return response()->json([
                        "message"=>"false.",
                        "success"=>false,
                        'message' => 'Something went wrong, please contact our support team.'],500);
                }
            }
            else{
                return response()->json([
                    "message"=>"false.",
	                "success"=>false,
                    'message' => 'Invalid API key or secret key'
                ], 401);
            }
        }
    }
    public function getRquestDetails(Request $request){
        
        $api_key = $request->header('X-Neurnous-Api-Key');
        $secret_key = $request->header('X-Neurnous-Secret-Key');
        // return response()->json(['api'=>$api_key , 'secret'=>$secret_key]);
        $secrets = UserApiSecret::where('api_key', $api_key)->where('secret_key', $secret_key)->first();
        $remaining =0;
        if (!$secrets) {
            return response()->json([
                "message"=>"false.",
                "success"=>false,
                'message' => 'Invalid API key or secret key'
            ], 401);
        }
        else{
            $user = User::where("id",$secrets->user_id)->first();
            if ($user) {
                $count = 0;
                $allowed = env('IMAGE_REQUESTS_ALLOWED_PER_MONTH');
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
                    if ($allowed == "Unlimited") {
                        $remaining = "Unlimited";
                    } else {
                        $remaining = $allowed - $count;
                    }
                    return response()->json([
                        "message"=>"Success.",
	                    "success"=>true,
                        'total_requests'=>$allowed,
                        'used_request'=>$count,
                        'remaining_requests'=>$remaining
                    ],200);
            }
            else{
                return response()->json([
                    "message"=>"false.",
	                "success"=>false,
                    'message' => 'Invalid API key or secret key'
                ], 401);
            }
        }
    }
}