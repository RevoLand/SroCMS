<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\LoginAttempt;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

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
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view('user.login');
    }

    public function login(Request $request)
    {
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request))
        {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        $loginAttempt = new LoginAttempt();

        $loginAttempt->username = $request->username;
        $loginAttempt->ip = $request->ip();
        $loginAttempt->success = $this->attemptLogin($request);
        $loginAttempt->save();

        if ($loginAttempt->success)
        {
            toast('Successfully logged in.', 'success');

            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        toast('Failed to login with the given data', 'error');

        return $this->sendFailedLoginResponse($request);
    }

    protected function username()
    {
        return 'username';
    }

    protected function credentials(Request $request)
    {
        return ['StrUserID' => $request->input($this->username()), 'password' => $request->password];
    }

    protected function loggedOut(Request $request)
    {
        return redirect()->route('users.login_form');
    }

    protected function redirectTo()
    {
        return route('users.current_user');
    }
}
