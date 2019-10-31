<?php

namespace App\Http\Controllers;

use App\LoginAttempt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function show()
    {
        return view('user.login');
    }

    public function authenticate(Request $request)
    {
        $request->validate(
        [
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = Auth::attempt(['StrUserID' => $request->username, 'password' => $request->password], $request->has('remember'));
        $loginAttempt = new LoginAttempt();

        $loginAttempt->username = $request->username;
        $loginAttempt->ip = $request->ip();
        $loginAttempt->success = isset($user);
        $loginAttempt->save();

        if ($user)
        {
            toast('Successfully logged in.', 'success');
        }
        else
        {
            toast('Failed to login with the given data', 'error');

            return redirect()->back();
        }

        return redirect()->route('users.current_user');
    }

    public function logout()
    {
        Auth::logout();

        return redirect()->route('home');
    }
}
