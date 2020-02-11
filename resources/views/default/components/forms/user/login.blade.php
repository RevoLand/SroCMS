{{ Form::open(['route' => 'users.do_login']) }}
    <div class="form-group">
        <label for="sidebarLoginUsername">{{ __('Kullanıcı Adı') }}</label>
        <input id="sidebarLoginUsername" type="text" name="username" class="form-control" placeholder="{{ __('Kullanıcı Adı') }}" required>
    </div>
    <div class="form-group">
        <label for="sidebarLoginPassword">{{ __('Şifre') }}</label>
        <input id="sidebarLoginPassword" type="password" name="password" class="form-control" placeholder="{{ __('Şifre') }}" required>
    </div>
    <div class="custom-control custom-checkbox mb-2">
        <input type="checkbox" class="custom-control-input" name="remember" id="sidebarLoginRemember" />
        <label for="sidebarLoginRemember" class="custom-control-label">{{ __('Beni Hatırla') }}</label>
    </div>
    <button type="submit" class="btn btn-primary">{{ __('Giriş Yap') }}</button>

    <small class="form-text text-muted float-right">
        <a href="{{ route('password.request') }}">{{ __('Şifrenizi mi unuttunuz?') }}</a>
    </small>
{{ Form::close() }}
