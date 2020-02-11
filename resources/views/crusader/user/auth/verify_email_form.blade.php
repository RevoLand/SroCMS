@extends('layout')

@section('content')

<article>
    <h1 class="top">E-Posta adresinizi doğrulayın<div></div>
    </h1>
    <section class="body">
        @isset (Auth::user()->Email)
            @if (session('resent'))
                <p>E-Posta adresinizi doğrulamanız için kullanabileceğiniz doğrulama bağlantısı e-posta adresinize gönderildi.</p>
                <div class="clear"></div>
                <div class="ucp_divider"></div>
            @endif

        {{ __('Before proceeding, please check your email for a verification link.') }}
        @if (Route::has('verification.resend'))
            {{ Form::open(['route' => 'verification.resend', 'class' => 'page_form']) }}
            <input type="submit" class="nice_button" value="{{ __('Doğrulama bağlantısını yeniden gönder.') }}" />
            {{ Form::close() }}
        @endif
        @else
            {{ Form::open(['route' => 'users.update_email', 'class' => 'page_form']) }}
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <h2>Öncelikle e-posta adresinizi güncellemeniz gerekmektedir.</h2>
            <br />
            <table style="width:100%">
                <tr>
                    <td>
                        <label>
                            Yeni E-posta Adresi
                        </label>
                    </td>
                    <td>
                        <input type="text" name="new_email" value="{{ old('new_email') }}" />
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>
                            Yeni E-posta Adresi Tekrar
                        </label>
                    </td>
                    <td>
                        <input type="text" name="new_email_confirmation" value="{{ old('new_email_confirmation') }}" />
                    </td>
                </tr>
            </table>

            <center style="margin-bottom:10px;">
                <input type="submit" value="E-posta Adresimi Güncelle" />
            </center>
            {{ Form::close() }}
        @endisset
    </section>
</article>
@endsection
