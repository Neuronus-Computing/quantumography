<?php

namespace App\Http\Middleware;
use App\Models\UserIp;
use GuzzleHttp\Client;

use Closure;
use Illuminate\Http\Request;

class VpnCheckMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
         $userIP = '101.188.67.134';
        //  185.216.34.0 vpn ip for test
         $knowIps = UserIp::get()->pluck('ip')->toArray();
         if (!in_array($userIP, $knowIps)) {
             $client = new Client(['verify' => false]);
             $apiKey = env('VPN_CHECK_API_KEY'); // Replace with your actual API key
             $response = $client->get("https://ipqualityscore.com/api/json/ip/$apiKey/$userIP");
             $jsonResponse = json_decode($response->getBody(), true);

             if ($jsonResponse['success'] === false) {
                return redirect()->route('vpn.warning')->with(["error" => "Something went wrong, please contact our support team."]);
            } else {
                if ($jsonResponse['vpn'] === true || $jsonResponse['active_vpn'] === true && $jsonResponse['success'] === true) {
                    // The user's IP address is associated with a VPN
                    return redirect()->route('vpn.warning')->with(["error" => "You are using VPN, please disable VPN to use our services."]);
                } else {
                    UserIp::create(['ip' => $userIP]);
                }
            }
        }
             return $next($request);
        }

}