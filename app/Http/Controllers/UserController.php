<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Plan;
use App\Models\EnlargeImage;
use Auth;

class UserController extends Controller
{
    public function profile()
    {
        $pagetitle = 'Profile';
        $user = Auth::user();
        $imagecounts = 0;
        $allowedImages = env('IMAGE_REQUESTS_ALLOWED_PER_MONTH');
        $remaining = 0;
        $plan = '';
        $subscription='';
        $imagecounts = EnlargeImage::where('user_id', $user->id)->currentMonth()->count();
        if ($user->subscriptions()->count()) {
            $subscription = $user->subscriptions()->latest()->first();
            $payId= $subscription->stripe_price;
            if($payId){
                    $plan = Plan::where('price_id', $payId)->first();
                    $allowedImages += $plan->total_images_allowed;
            }
        }      
        $remaining = $allowedImages - $imagecounts;

        return view('user.profile', compact('user', 'pagetitle', 'plan', 'remaining', 'allowedImages', 'imagecounts','subscription'));
    }
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $this->validate($request, [
            'name' => 'required|string|max:255',
            'password' => 'nullable|string|min:8|confirmed',
            'avatar' => 'nullable|image|mimes:jpeg,jpg|max:2048', 
        ]);
        if ($request->file('avatar')) {
            $avatarPath = $request->file('avatar');
            $filename = $avatarPath->store('avatars','public'); 
            $user->avatar = $filename; 
        }
        $user->name = $request->name;
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->back()->with('success', 'Profile updated successfully!');
    }
}
