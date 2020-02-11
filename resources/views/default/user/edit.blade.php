@extends('layout')

@section('pagetitle', 'Profili Düzenle')
@section('contenttitle', 'Profili Düzenle')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="user-profile-edit bg-dark px-3 py-3 shadow-sm rounded-sm">
            @if ($errors->any())
            <ul class="alert alert-danger">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
            @endif
            {{-- Temel profil bilgileri --}}
            <div class="row">
                <div class="col">
                    <div class="info pb-3">
                        @include ('components.forms.user.update_profile')
                    </div>
                </div>
            </div>
            {{-- Refere eden kullanıcı bilgisi --}}
            @if (setting('referrals.enabled', 1) && setting('referrals.can_set_later', 0) && empty($user->referrer))
            <div class="row">
                <div class="col">
                    <div class="referral border-top border-secondary py-2">
                        @include ('components.forms.user.set_referral')
                    </div>
                </div>
            </div>
            @endif
            {{-- E-posta adresi --}}
            <div class="row">
                <div class="col">
                    <div class="email border-top border-secondary py-2">
                        @include ('components.forms.user.change_email', ['currentEmail' => $user->Email])
                    </div>
                </div>
            </div>
            {{-- Şifre --}}
            <div class="row">
                <div class="col">
                    <div class="password border-top border-secondary pt-2">
                        @include ('components.forms.user.change_password')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
