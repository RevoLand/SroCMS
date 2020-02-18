<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showResetForm(Request $request, $token = null)
    {
        return view('user.auth.reset_password')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

    public function rules()
    {
        return [
            'token' => 'required',
            'StrUserID' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ];
    }

    public function credentials(Request $request)
    {
        return $request->only(
            'email', 'StrUserID', 'password', 'password_confirmation', 'token'
        );
    }

    protected function redirectTo()
    {
        Alert::success('Başarılı!', 'Şifreniz başarıyla güncellendi.');

        return route('users.current_user');
    }
}
