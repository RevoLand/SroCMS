{{ Form::open(['route' => 'password.update']) }}
<div class="form-group">
    <label for="token">Şifre Sıfırlama Anahtarı</label>
    <input id="token" class="form-control" type="text" name="token" value="{{ $token }}" required>
</div>
<div class="form-group">
    <label for="email">E-Posta Adresiniz</label>
    <input id="email" class="form-control" type="email" name="email" value="{{ $email }}" required>
</div>
<div class="form-group">
    <label for="password">Yeni Şifre</label>
    <input id="password" class="form-control" type="password" name="password" required>
</div>
<div class="form-group">
    <label for="password_confirmation">Yeni Şifre Onayı</label>
    <input id="password_confirmation" class="form-control" type="password" name="password_confirmation" required>
</div>
<button type="submit" class="btn btn-primary btn-block btn-lg">Şifremi Değiştir</button>
{{ Form::close() }}
