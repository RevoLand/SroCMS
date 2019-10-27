<?php

namespace App\Http\Controllers;

use App\LoginAttempt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;

class LoginController extends Controller
{
    public function authenticate(Request $request)
    {
        $request->validate(
        [
            'username' => 'required|string',
            'password' => 'required|string'
        ]);

        if (Auth::check())
        {
            return redirect()->route('user');
        }

        $user = User::where('StrUserID', $request->username)->where('password', md5($request->password))->first();
        $loginAttempt = new LoginAttempt();

        $loginAttempt->username = $request->username;
        $loginAttempt->ip = $request->ip();
        $loginAttempt->success = isset($user);
        $loginAttempt->save();

        if ($user)
        {
            Auth::login($user, $request->has('remember'));

            toast('Successfully logged in.','success');

            return redirect()->route('user');
        }
        else
        {
            toast('Failed to login with the given data','error');

            return redirect()->back();
        }
    }

    public function show()
    {
        if (Auth::check())
        {
            return redirect()->route('user');
        }

        return view('user.login');
    }

    public function logout()
    {
        if (Auth::check())
        {
            Auth::logout();
        }

        return redirect()->route('home');
    }
}
