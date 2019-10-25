<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use RealRashid\SweetAlert\Facades\Alert;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('throttle:5,1')->only('login');
    }

    public function authenticate(Request $request)
    {
        $this->validate($request, [
            'username' => 'required|string',
            'password' => 'required|string'
        ]);

        if (Auth::check())
        {
            return redirect()->back();
        }

        $user = User::where('StrUserID', $request->username)->where('password', md5($request->password))->first();

        if ($user)
        {
            Auth::login($user, $request->has('remember'));

            // Alert::success('Success!', 'Successfully logged in.');
            toast('Successfully logged in.','success');

            return redirect()->route('home');
        }
        else
        {
            // Alert::error('Error!', 'Failed to login with the given data');
            toast('Failed to login with the given data','error');

            return redirect()->back();
        }
    }

    public function logout()
    {
        if (!Auth::check())
        {
            return redirect()->back();
        }

        Auth::logout();
        return redirect()->back();
    }
}
