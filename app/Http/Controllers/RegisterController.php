<?php

namespace App\Http\Controllers;

use App\RegisterAttempt;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class RegisterController extends Controller
{
    public function show()
    {
        if (Auth::check())
        {
            return redirect()->route('user');
        }

        return view('user.register');
    }

    public function register(Request $request)
    {
        if (Auth::check())
        {
            return redirect()->route('user');
        }

        // TODO: Dinamik ayarlar doğrultusunda aynı eposta adresi ile 1 den fazla hesap açılıp açılmaması
        $request->validate([
            'name' => ['bail', 'required', 'string', 'max:255'],
            'username' => ['bail', 'required', 'string', 'max:255', 'unique:account.TB_User,StrUserID'],
            'email' => ['bail', 'required', 'string', 'email', 'max:255', 'unique:account.TB_User,Email'],
            'password' => ['bail', 'required', 'string', 'min:8', 'confirmed']
        ]);

        $user = new User();
        $user->StrUserID = $request->username;
        $user->Name = $request->name;
        $user->password = md5($request->password);
        $user->Email = $request->email;

        $registerAttempt = new RegisterAttempt();
        $registerAttempt->username = $request->username;
        $registerAttempt->ip = $request->ip();
        $registerAttempt->success = $user->save();
        $registerAttempt->save();

        if ($registerAttempt->success)
        {
            Auth::login($user);

            toast('Registration is completed successfully.', 'success');

            return redirect()->route('user');
        }
        else
        {
            Alert::error('Error!', 'An unknown error happened while registering.');

            return redirect()->route('registerPage');
        }
    }
}
