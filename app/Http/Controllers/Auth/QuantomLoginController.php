<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Events\UserLoggedIn;
use Illuminate\Http\Request;
use Auth;
use App\Services\ExternalAuthService; 
use App\Models\User; 
use Illuminate\Support\Str;
use App\Models\EnlargeImage;

class QuantomLoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = "/";

    protected $externalAuthService;

    // Inject the ExternalAuthService
    public function __construct(ExternalAuthService $externalAuthService)
    {
        $this->middleware('guest')->except('logout');
        $this->externalAuthService = $externalAuthService;
    }

    /**
     * Handle an authentication attempt with a seed.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        $request->validate([
           'seed' => ['required', 'string'],
        ]);
        $response = $this->externalAuthService->loginUserWithSeed($request->seed);
        
        if ($response->successful()) {
            $userData = $response->json();
            $token = $userData['token'];
            $user = User::where('seed', $request->seed)->first();
            if ($user) {
                session(['api_token' => $token]);
                session(['userData' => $userData]);
                Auth::guard('seed')->login($user);
                event(new UserLoggedIn($user));
                return $this->redirectAfterLogin();
            } else {
                return redirect()->back()->withErrors(['error' => 'User not found in our records.']);
            }
        } else {
            return redirect()->back()->withErrors(['error' => 'Login failed. Please check your seed and try again.']);
        }
    }
    public function LoginOrRegister(Request $request){
        $request->validate([
            'seed' => ['required', 'string'],
        ]);
        $user = User::where('seed', $request->seed)->first();
        if(!$user){
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
        }      
        $response = $this->externalAuthService->loginUserWithSeed($request->seed);
        if ($response->successful()) {
            $userData = $response->json();
            $token = $userData['token'];
            if ($user) {
                session(['api_token' => $token]);
                session(['userData' => $userData]);
                Auth::guard('seed')->login($user);
                event(new UserLoggedIn($user));
                return response()->json(['user'=>$user,'success'=>'Successfully logged in with seed.'],200);
            } else {
                response()->json(['error' => 'User not found in our records.'],400);
            }
        } else {
            return response()->json(['error' => 'Login failed. Please check your seed and try again.'],400);
        }
    }
    public function getUserByToken(Request $request)
    {
        $request->validate([
            'token' => ['required', 'string'],
        ]);
        try {
            $response = $this->externalAuthService->getAuthUser($request->token);
            if (!$response->successful()) {
                return response()->json(['error' => 'Login failed. Please check your seed and try again.'], 400);
            }
            $userData = $response->json();
            $seed = $userData['seed'] ?? null;
            if (!$seed) {
                return response()->json(['error' => 'Invalid seed data received.'], 400);
            }
            $user = User::where('seed', $seed)->first();
            $ip = $request->ip();
            if (!$user) {
                $api_key = 'pk_' . Str::random(32);
                $secret_key = 'sk_' . Str::random(64);

                $user = User::create([
                    'ip' => $ip,
                    'seed' => $seed,
                ]);

                $user->apiKeySecret()->create([
                    'api_key' => $api_key,
                    'secret_key' => $secret_key,
                ]);

                EnlargeImage::where('user_ip', $ip)->update(['user_id' => $user->id]);
            }
            session(['api_token' => $request->token, 'userData' => $userData]);
            Auth::guard('seed')->login($user);
            event(new UserLoggedIn($user));
            return response()->json(['user' => $user, 'success' => 'Successfully logged in with seed.'], 200);
        } catch (\Exception $e) {
            Log::error('Error during authentication: ' . $e->getMessage());
            return response()->json(['error' => 'An unexpected error occurred. Please try again.'], 500);
        }
    }
    /**
     * Handle redirection after successful login.
     * This method will check if there's an intended path,
     * otherwise, it will redirect to the default path.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function redirectAfterLogin()
    {
        if (session()->has('url.intended') && strpos(session()->get('url.intended'), '/quantumography') !== false){
            redirect()->intended($this->redirectTo);
        }
        else{
            session()->forget('url.intended');
            return redirect()->intended($this->redirectTo);
        }
    }

    /**
     * Show the login form.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        if (Auth::guard('seed')->check()) {
            return $this->redirectAfterLogin();
        }
        return view("auth.quantom-login");
    }
    public function importantNote(){
        if (Auth::guard('seed')->check()) {
            return $this->redirectAfterLogin();
        }
        return view('quantumography.important-note');
    }
    public function logout(Request $request)
    {
        Auth::guard('seed')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('quantumography.note');
    }
}
