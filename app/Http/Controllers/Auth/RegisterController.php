<?php

namespace App\Http\Controllers\Auth;

use Exception;
use App\Models\User;
use App\Models\Config;
use App\Models\Setting;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        if (env('RECAPTCHA_ENABLE') == 'on') {
            return Validator::make($data, [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:5', 'confirmed'],
                'g-recaptcha-response' => ['recaptcha', 'required']
            ]);
        } else {
            return Validator::make($data, [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:5', 'confirmed']
            ]);
        }
    }

    // Redirect to dashboard
    protected function redirectTo()
    {
        return '/user/dashboard';
    }


    // Show register page
    public function showRegistrationForm()
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

        return view('auth.register', compact('config', 'settings'));
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        // User saved
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'auth_type' => 'Email',
            'password' => Hash::make($data['password']),
        ]);


        // Email Message
        $message = [
            'name' => $data['name'],
            'email' => $data['email'],
        ];

        try {
            // Send Welcome email
            Mail::to($data['email'])->send(new \App\Mail\WelcomeMail($message));
            // Send email verification
            // $user->newEmail($data['email']);
        } catch (Exception $e) {
            // Return send user details
            return $user;
        }

        // Return user details
        return $user;
    }
}
