@extends ('layout')

@section ('content')
<article>
    <h1 class="top">Kayıt Ol<div></div></h1>
    <section class="body">
        <div id="registerResult">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
        {{ Form::open(['route' => 'users.do_register']) }}
            <table style="width:80%">
                <tbody>
                <tr>
                    <td><label for="username">Kullanıcı adı:</label></td>
                    <td><input type="text" name="username" value="{{ old('username') }}" /></td>
                </tr>
                <tr>
                    <td><label for="password">Şifre:</label></td>
                    <td><input type="password" name="password" /></td>
                </tr>
                <tr>
                    <td><label for="repassword">Şifre tekrarı:</label></td>
                    <td><input type="password" name="password_confirmation" /></td>
                </tr>
                <tr>
                    <td><label for="email">Eposta:</label></td>
                    <td><input type="text" name="email" value="{{ old('email') }}" /></td>
                </tr>
                <tr>
                    <td><label for="name">İsim:</label></td>
                    <td><input type="text" name="name" value="{{ old('name') }}" /></td>
                </tr>
            </tbody>
        </table>
        <center><input type="submit" name="registerSubmit" value="Kayıt ol" /></center>
        {{ Form::close() }}
    </section>
</article>
@endsection
