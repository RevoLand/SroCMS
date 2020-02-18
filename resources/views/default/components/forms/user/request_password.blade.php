{{ Form::open(['route' => 'password.email']) }}
    <div class="form-group">
        <label for="StrUserID">Kullanıcı adınız</label>
        <input id="StrUserID" class="form-control" type="text" name="StrUserID" required>
    </div>
    <div class="form-group">
        <label for="email">E-Posta Adresiniz</label>
        <input id="email" class="form-control" type="email" name="email" required>
    </div>
    <button type="submit" class="btn btn-block btn-lg btn-primary">Şifre Sıfırlama</button>
{{ Form::close() }}
