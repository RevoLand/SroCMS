@if (Auth::check())
Hoşgeldin, {{ Auth::user()->getName() }}
<table width="100%">
    <tbody>
        <tr>
            <td><img src="{{ Theme::url('images/icons/silk.png') }}" align="absmiddle"> {{ setting('silk.silk_own_name', 'Silk') }}</td>
            <td>{{ number_format(Auth::user()->silk->silk_own) }}</td>
        </tr>
        <tr>
            <td><img src="{{ Theme::url('images/icons/silk.png') }}" align="absmiddle"> {{ setting('silk.silk_gift_name', 'Silk (Gift)') }}</td>
            <td>{{ number_format(Auth::user()->silk->silk_gift) }}</td>
        </tr>
        <tr>
            <td><img src="{{ Theme::url('images/icons/giftsilk.png') }}" align="absmiddle"> {{ setting('silk.silk_point_name', 'Silk (Point)') }}</td>
            <td>{{ number_format(Auth::user()->silk->silk_point) }}</td>
        </tr>
        <tr>
            <td colspan="2">
                <hr />
            </td>
        </tr>
        <tr>
            <td>Bakiye:</td>
            <td>{{ Auth::user()->balance->balance }}</td>
        </tr>
        <tr>
            <td>Bakiye:</td>
            <td>{{ Auth::user()->balance->balance_point }}</td>
        </tr>
    </tbody>
</table>
<br />
<center>
    <a href="{{ route('users.current_user') }}" class="nice_button">User panel</a>
    <a href="{{ route('users.do_logout') }}" class="nice_button" data-hasevent="1">Log out</a>
</center>
@else
@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

{{ Form::open(['route' => 'users.do_login', 'class' => 'page_form']) }}
<center>
    <input type="text" name="username" value="" placeholder="{{ __('Kullanıcı Adı') }}">
    <input type="password" name="password" value="" placeholder="{{ __('Şifre') }}">
    <div id="remember_me">
        <label for="remember">{{ __('Beni Hatırla') }}</label>
        <input type="checkbox" name="remember" id="remember" />
    </div>

    <input type="submit" value="{{ __('Giriş Yap') }}" />
    <br /><br />
    <section id="forgot">
        <a href="{{ route('password.request') }}">{{ __('Şifrenizi mi unuttunuz?') }}</a>
    </section>
</center>
{{ Form::close() }}
@endif
