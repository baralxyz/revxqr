<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\Config;
use App\Models\Setting;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    // User authentication
    public function authenticated()
    {
        if (Auth::check() && Auth::user()->role_id == 1) {
            return redirect('/admin/dashboard');
        }

        return redirect('/user/dashboard');
    }

    // Show login form
    public function showLoginForm()
    {
        $config = Config::get();
        $settings = Setting::first();

        // Recaptcha Configuration
        $recaptcha_configuration = [
            'RECAPTCHA_ENABLE' => env('RECAPTCHA_ENABLE', ''),
            'RECAPTCHA_SITE_KEY' => env('RECAPTCHA_SITE_KEY', ''),
            'RECAPTCHA_SECRET_KEY' => env('RECAPTCHA_SECRET_KEY', ''),
            'RECAPTCHA_SKIP_IP' => env('RECAPTCHA_SKIP_IP', '[]'),
        ];

        $settings['recaptcha_configuration'] = $recaptcha_configuration;

        return view('auth.login', compact('config', 'settings'));
    }

    // Login redirect
    public function redirectToProvider()
    {
        return Socialite::driver('google')->redirect();
    }

    // Google login callback
    public function handleProviderCallback()
    {
        try {
            $user = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            return redirect('/login');
        }

        // check if they're an existing user
        $existingUser = User::where('email', $user->email)->first();
        if($existingUser){
            if($existingUser->status == 1){
                // log them in
                auth()->login($existingUser, true);
            }else{
                  return redirect('/login');
            }

        } else {
        // create a new user
            $newUser = new User;
            $newUser->name = $user->name;
            $newUser->email = $user->email;
            $newUser->profile_image = $user->avatar;
            $newUser->password = bcrypt($newUser->user_id);
            $newUser->auth_type = "Google";
            $newUser->role_id = 2;
            $newUser->save();
            auth()->login($newUser, true);
        }
        return redirect()->to('/user/dashboard');
    }
}
