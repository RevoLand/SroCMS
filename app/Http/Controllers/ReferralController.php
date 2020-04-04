<?php

namespace App\Http\Controllers;

use Alert;
use App\DataTables\UserReferralsDataTable;
use App\User;
use Illuminate\Http\Request;

class ReferralController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(UserReferralsDataTable $dataTable)
    {
        return $dataTable->render('user.referrals.index');
    }

    public function update()
    {
        request()->validate([
            'referrer_name' => ['bail', 'required', 'alpha_dash', 'exists:\App\User,StrUserID'],
            'referrer_agree_change' => ['required', 'accepted'],
        ]);

        if (!setting('referrals.enabled', 1) || !setting('referrals.can_set_later', 0))
        {
            Alert::error('Başarısız!', 'Referans sistemi aktive edilmemiş!');

            return redirect()->back();
        }

        if (strcasecmp(auth()->user()->StrUserID, request('referrer_name')) == 0)
        {
            Alert::error('Başarısız!', 'Kendi kendinizi tavsiye edemezsiniz!');

            return redirect()->back();
        }

        if (auth()->user()->referrer)
        {
            Alert::error('Başarısız!', 'Zaten sizi tavsiye eden kullanıcıyı belirtmişsiniz!');

            return redirect()->back();
        }

        auth()->user()->referrer()->create([
            'referrer_user_id' => User::firstWhere('StrUserID', request('referrer_name'))->JID,
        ]);

        Alert::success('Tavsiye eden kullanıcınız başarıyla sisteme kaydedildi.');

        return redirect()->route('users.edit_form');
    }
}
