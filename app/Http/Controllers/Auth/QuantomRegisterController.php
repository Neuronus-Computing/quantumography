<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\EnlargeImage;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http; 
use App\Services\ExternalAuthService;
use Auth;
class QuantomRegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users based on a seed
    | provided by an external API. The user's seed is saved along with the
    | generated API and secret keys.
    |
    */

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = "/vangonography";
    protected $externalAuthService;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ExternalAuthService $externalAuthService)
    {
        $this->middleware('guest');
        $this->middleware(function ($request, $next) {
            if (Auth::guard('seed')->check()) {
                return $this->redirectIfAlreadyLogin();
            }
            return $next($request);
        });
        $this->externalAuthService = $externalAuthService; 
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'seed' => ['required', 'string', 'min:12', 'unique:users,seed'], // Validate the seed field
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    public function register(Request $request)
    {
        $request->validate([
            'seed' => ['required', 'string', 'min:12', 'unique:users,seed'],
        ]);
        $response = $this->externalAuthService->registerUserWithSeed($request->seed);
        if ($response->successful()) {
            $api_key = Str::random(32);
            $secret_key = Str::random(64);
            $ip = request()->ip();
            $user = User::create([
                "ip"=>request()->ip(),
                'seed' => $request->seed,
            ]);
            $user->apiKeySecret()->create([
                'api_key' => 'pk_'.$api_key,
                'secret_key' => 'sk_'.$secret_key,
            ]);
            EnlargeImage::where('user_ip', request()->ip())->update(['user_id' => $user->id]);
            return redirect()->route('quantom.login')->with('success', 'Successfully registered with seed.');
        } else {
            return redirect()->route('quantom.register')->with('error' ,'External registration failed.');
        }
    }
    public function showRegistrationForm()
    {
        $response = $this->externalAuthService->getSeed();
        $getWordPool = $this->externalAuthService->getWordPool();
        $seed =  null;
        $wordPool=[];
        if ($response->successful()) {
            $seed = $response->json()['seed'];
        }
        if ($getWordPool->successful()) {
            $wordPool = $getWordPool->json();
        } 
        return view('auth.quantom-register', compact('seed','wordPool'));
    }
    protected function redirectIfAlreadyLogin()
    {
        if (session()->has('url.intended') && strpos(session()->get('url.intended'), '/vangonography') !== false){
            redirect()->intended($this->redirectTo);
        }
        else{
            session()->forget('url.intended');
            return redirect()->intended($this->redirectTo);
        }
    }
}
