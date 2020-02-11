@extends('layout')

@section('pagetitle', 'E-Posta Adresinizi Onaylayın')
@section('contenttitle', 'E-Posta Adresinizi Onaylayın')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="user-verify-email bg-dark px-3 py-3 shadow-sm rounded-sm">
            @if ($errors->any())
            <ul class="alert alert-danger">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
            @endif
            <div class="row">
                <div class="col">
                    <div class="info pb-3">
                        @isset (Auth::user()->Email)
                            @if (session('resent'))
                            <div class="alert alert-success">
                                E-Posta adresinizi doğrulamanız için kullanabileceğiniz doğrulama bağlantısı sistemde kayıtlı olan e-posta adresinize gönderildi.
                            </div>
                            @endif
                            <div class="text-muted mb-2">
                                Doğrulama bağlantısını yeniden oluşturmadan önce lütfen e-posta adresinize giderek spam (gereksiz) klasörünü kontrol ediniz.
                            </div>

                            @include('components.forms.user.email_verification')
                        @else
                            <div class="text-muted mb-2">
                                Doğrulama bağlantısı oluşturabilmek için öncelikle hesabınıza bir E-Posta adresi eklemeniz gerekmektedir.
                            </div>
                            @include('components.forms.user.change_email')
                        @endisset
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
