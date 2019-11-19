<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('show');

        if (setting('users.email_must_be_verified', 0))
        {
            $this->middleware('verified')->except('updateEmail');
        }

        if (setting('users.show_user_requires_auth', 0))
        {
            $this->middleware('auth')->only('show');
        }
    }

    public function index()
    {
        return view('user.index');
    }

    public function show(User $user)
    {
        return view('user.show', compact('user'));
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
            'new_email' => ['bail', 'required', 'string', 'email', 'max:255', 'confirmed'],
        ]);

        if (setting('register.email.must_be_unique', 1))
        {
            $request->validate([
                'new_email' => ['unique:account.TB_User,Email'],
            ]);
        }
        elseif (setting('register.email.max_registrations_per_email', 2) > 0 && User::where('Email', '=', $request->new_email)->count() >= setting('register.email.max_registrations_per_email', 2))
        {
            Alert::error('Error!', 'Belirtmiş olduğunuz E-posta adresi daha fazla üyelik ile kullanılamaz.');

            return redirect()->back();
        }

        Auth::user()->updateEmail($request->new_email);

        Alert::success('E-posta adresiniz başarıyla değiştirildi.');

        return redirect()->route('users.edit_form');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'password' => ['bail', 'required', 'string', 'password'],
            'new_password' => ['bail', 'required', 'string', 'min:8', 'confirmed'],
        ]);

        Auth::user()->updatePassword($request->new_password);
        Alert::success('Şifreniz başarıyla değiştirildi, otomatik olarak çıkış yaptınız.');

        Auth::logout();

        return redirect()->route('users.login_form');
    }
}
