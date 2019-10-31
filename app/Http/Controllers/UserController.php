<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{
    public function index()
    {
        return view('user.index');
    }

    public function create()
    {
        return view('user.register');
    }

    public function store(Request $request)
    {
        // TODO: Dinamik ayarlar doğrultusunda aynı eposta adresi ile 1 den fazla hesap açılıp açılmaması
        $request->validate([
            'name' => ['bail', 'required', 'string', 'max:255'],
            'username' => ['bail', 'required', 'string', 'max:255', 'unique:account.TB_User,StrUserID'],
            'email' => ['bail', 'required', 'string', 'email', 'max:255', 'unique:account.TB_User,Email'],
            'password' => ['bail', 'required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = new User();
        $user->StrUserID = $request->username;
        $user->Name = $request->name;
        $user->password = Hash::make($request->password);
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

            return redirect()->route('users.current_user');
        }

        Alert::error('Error!', 'An unknown error happened while registering.');

        return redirect()->route('registerPage');
    }

    public function edit()
    {
        return view('user.edit', ['user' => Auth::user()]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => ['bail', 'required', 'string', 'min:3', 'max:255'],
        ]);

        Auth::user()->Name = $request->name;
        Auth::user()->save();

        Alert::success('Bilgileriniz güncellendi.');

        return redirect()->route('users.edit_form');
    }

    public function updateEmail(Request $request)
    {
        $request->validate([
            'new_email' => ['bail', 'required', 'string', 'email', 'max:255', 'confirmed', 'unique:account.TB_User,Email'],
        ]);

        Auth::user()->updateEmail($request->new_email);

        return redirect()->route('users.edit_form');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'password' => ['bail', 'required', 'string'],
            'new_password' => ['bail', 'required', 'string',  'confirmed'],
        ]);

        $user = User::where('StrUserID', Auth::user()->StrUserID)->where('password', Hash::make($request->password))->first();

        if ($user)
        {
            Auth::user()->updatePassword($request->new_password);
            Alert::success('Şifreniz başarıyla değiştirildi, otomatik olarak çıkış yaptınız.');

            Auth::logout();

            return redirect()->route('users.login_form');
        }

        Alert::error('Mevcut şifreniz hatalı.');

        return redirect()->back();
    }
}
