@extends ('layout')

@section ('content')
<article>
    <h1 class="top">
        Şifrenizi mi unuttunuz?<div></div>
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

        {{ Form::open(['route' => 'password.email', 'class' => 'page_form']) }}
        <table style="width:100%">
            <tr>
                <td style="width:25% !important">
                    <label for="name">
                        E-posta adresiniz
                    </label>
                </td>
                <td>
                    <input type="text" name="email" value="" />
                </td>
            </tr>
        </table>

        <center style="margin-bottom:10px;">
            <input type="submit" value="Şifre Sıfırlama Bağlantısı Oluştur" />
        </center>
        {{ Form::close() }}
    </section>
</article>
@endsection
