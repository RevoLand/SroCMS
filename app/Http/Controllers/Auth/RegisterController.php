<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class RegisterController extends Controller
{
    use RegistersUsers;

    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showRegistrationForm()
    {
        return view('user.register');
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        if (setting('register.email.must_be_unique', '1'))
        {
            $request->validate([
                'email' => ['unique:account.TB_User,Email'],
            ]);
        }
        elseif (setting('register.email.max_registrations_per_email', '2') > 0 && User::where('Email', '=', $request->email)->count() >= setting('register.email.max_registrations_per_email', '2'))
        {
            Alert::error('Error!', 'Belirtmiş olduğunuz E-posta adresi ile daha fazla kayıt işlemi gerçekleştiremezsiniz.');

            return redirect()->route('users.register_form');
        }

        event(new Registered($user = $this->create($request->all())));

        $this->guard()->login($user);

        return $this->registered($request, $user) ?: redirect()->route('users.register_form');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['bail', 'required', 'string', 'max:255'],
            'username' => ['bail', 'required', 'string', 'max:255', 'unique:account.TB_User,StrUserID'],
            'email' => ['bail', 'required', 'string', 'email', 'max:255'],
            'password' => ['bail', 'required', 'string', 'min:8', 'max:255', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     *
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'StrUserID' => $data['username'],
            'Name' => $data['name'],
            'password' => Hash::make($data['password']),
            'Email' => $data['email'],
        ]);
    }

    protected function registered(Request $request, $user)
    {
        toast('Registration is completed successfully.', 'success');

        return redirect()->route('users.current_user');
    }
}
