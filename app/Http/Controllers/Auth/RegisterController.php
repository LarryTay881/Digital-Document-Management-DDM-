<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use PragmaRX\Google2FAQRCode\Google2FA;
use Illuminate\Http\Request;

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

    use RegistersUsers{
        register as registration;
    }

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
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'role_name' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'confirmed', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/', ],
        ], ['password.regex' => 'The :attribute must be at least 8 characters long and contain at least one uppercase letter, one lowercase letter, and one digit.',
        ]);
    }


    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        // Check if there are already 2 admin users
        $adminCount = User::where('role_name', 'Admin')->count();
        if ($data['role_name'] === 'Admin' && $adminCount >= 2) {
            // Add a custom validation error message indicating the admin limit is reached.
            // You can customize the error message as needed.
            Validator::make($data, [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'role_name' => ['required', 'string', 'max:255', function ($attribute, $value, $fail) use ($adminCount) {
                    if ($value === 'Admin' && $adminCount >= 2) {
                        $fail('You cannot register more than 2 admin users.');
                    }
                }],
                'password' => ['required', 'string', 'min:8', 'confirmed', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/'],
            ])->validate();
        }

        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'role_name' => $data['role_name'],
            'password' => Hash::make($data['password']),
            'google2fa_secret' => $data['google2fa_secret'],
        ]);
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();    
        
        $google2fa = app('pragmarx.google2fa');
    
        $registration_data = $request->all(); 
        $registration_data['google2fa_secret'] = $google2fa->generateSecretKey();
    
        $request->session()->flash('registration_data',$registration_data);
 
        $twoFa = new Google2FA();
        $key = $twoFa->generateSecretKey();
        $QR_Image = $twoFa->getQRCodeInline(
                config('app.name'),
                $registration_data['email'],
                $registration_data['google2fa_secret']
            );
            $secret = $registration_data['google2fa_secret'];

            return view('google2fa.register',compact('QR_Image','secret'));
    }

    public function completeRegistration(Request $request)
    {
        $request->merge(session('registration_data'));
        $this->registration($request);

        return redirect()->route('complete.registration');
    }
}
