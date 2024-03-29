<?php

namespace App\Http\Controllers;

use App\DataTables\ItemMallUserOrdersDataTable;
use App\User;
use Hash;
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

        if (setting('users.show_user_requires_auth', 1))
        {
            $this->middleware('auth')->only('show');
        }

        $this->middleware('throttle:60,1')->only('orders');
    }

    public function index()
    {
        // Eager load latest referred users, if referral system is enabled
        if (setting('referrals.enabled', 1))
        {
            auth()->user()->load(['referrals' => function ($query)
            {
                $query->limit(5)->with('user')->latest();
            }, 'referrer.user', ]);
        }

        return view('user.index');
    }

    public function show(User $user)
    {
        return view('user.show', compact('user'));
    }

    public function edit()
    {
        return view('user.edit', ['user' => auth()->user()]);
    }

    public function update()
    {
        auth()->user()->update(request()->validate([
            'name' => ['bail', 'required', 'string', 'min:3', 'max:100'],
        ]));

        Alert::success('Bilgileriniz güncellendi.');

        return redirect()->route('users.edit_form');
    }

    public function updateEmail(Request $request)
    {
        $request->validate([
            'new_email' => ['bail', 'required', 'string', 'email:rfc,dns,spoof', 'max:255', 'confirmed'],
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

        auth()->user()->update([
            'Email' => $request->new_email,
            'email_verified_at' => null,
        ]);

        Alert::success('E-posta adresiniz başarıyla değiştirildi.');

        return redirect()->route('users.edit_form');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'password' => ['bail', 'required', 'string', 'password'],
            'new_password' => ['bail', 'required', 'string', 'min:8', 'confirmed'],
        ]);

        auth()->user()->update([
            'password' => Hash::make($request->new_password),
            'email_verified_at' => null,
        ]);

        Alert::success('Şifreniz başarıyla değiştirildi, otomatik olarak çıkış yaptınız.');

        auth()->logout();

        return redirect()->route('users.login_form');
    }

    public function balance()
    {
        $balanceLogs = auth()->user()->balance->logs()->latest()->with('sourceUser')->paginate(20);

        return view('user.balance.show', compact('balanceLogs'));
    }

    public function orders(ItemMallUserOrdersDataTable $dataTable)
    {
        return $dataTable->render('user.orders.index');
    }
}
