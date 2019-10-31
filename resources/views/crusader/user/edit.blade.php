@extends ('layout')

@section ('content')
<article>
    <h1 class="top">Login<div></div>
    </h1>
    <section class="body">
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        {{ Form::open(['route' => 'users.update_settings', 'class' => 'page_form']) }}
        <table style="width:100%">
            <tr>
                <td style="width:25% !important">
                    <label for="name">
                        İsim
                    </label>
                </td>
                <td>
                    <input type="text" name="name" id="name" value="{{ $user->Name }}" />
                </td>
            </tr>
            <tr>
                <td style="width:25% !important">
                    <label for="location_field">
                        Location
                    </label>
                </td>
                <td>
                    <input type="text" name="location_field" id="location_field" placeholder="KULLANIMDA DEĞİL" />
                </td>
            </tr>
        </table>

        <center style="margin-bottom:10px;">
            <input type="submit" value="Bilgilerimi Güncelle" />
        </center>
        {{ Form::close() }}

        <div class="ucp_divider"></div>

        {{ Form::open(['route' => 'users.update_email', 'class' => 'page_form']) }}
        <table style="width:100%">
            <tr>
                <td style="width:25% !important">
                    <label for="current_email">
                        Mevcut E-posta Adresi
                    </label>
                </td>
                <td>
                    <input type="text" name="current_email" id="current_email" readonly value="{{ $user->Email }}" />
                </td>
            </tr>
            <tr>
                <td>
                    <label>
                        Yeni E-posta Adresi
                    </label>
                </td>
                <td>
                    <input type="text" name="new_email" />
                </td>
            </tr>
            <tr>
                <td>
                    <label>
                        Yeni E-posta Adresi Tekrar
                    </label>
                </td>
                <td>
                    <input type="text" name="new_email_confirmation" />
                </td>
            </tr>
        </table>

        <center style="margin-bottom:10px;">
            <input type="submit" value="E-posta Adresimi Güncelle" />
        </center>
        {{ Form::close() }}

        <div class="ucp_divider"></div>

        {{ Form::open(['route' => 'users.update_password', 'class' => 'page_form']) }}
        <table style="width:100%">
            <tr>
                <td style="width:25% !important">
                    <label>
                        Mevcut Şifreniz
                    </label>
                </td>
                <td>
                    <input type="password" name="password" />
                </td>
            </tr>
            <tr>
                <td>
                    <label>Yeni Şifreniz</label>
                </td>
                <td>
                    <input type="password" name="new_password" />
                </td>
            </tr>
            <tr>
                <td>
                    <label>Yeni Şifre Tekrarı</label>
                </td>
                <td>
                    <input type="password" name="new_password_confirmation" />
                </td>
            </tr>
        </table>

        <center style="margin-bottom:10px;">
            <input type="submit" value="Şifremi Güncelle" />
        </center>
        {{ Form::close() }}
    </section>
</article>
@endsection
