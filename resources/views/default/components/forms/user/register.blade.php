{{ Form::open(['route' => 'users.do_register']) }}
    <div class="form-group">
        <label for="username">Kullanıcı adı:</label>
        <input id="username" class="form-control" type="text" name="username" value="{{ old('username') }}" minlength="3" required>
    </div>
    <div class="form-group">
        <label for="password">Şifre:</label>
        <input id="password" class="form-control" type="password" name="password" minlength="8" required>
    </div>
    <div class="form-group">
        <label for="password_confirmation">Şifre Tekrarı:</label>
        <input id="password_confirmation" class="form-control" type="password" name="password_confirmation"  minlength="8" required>
    </div>
    <div class="form-group">
        <label for="email">E-Posta Adresi:</label>
        <input id="email" class="form-control" type="email" name="email" value="{{ old('email') }}" required>
    </div>
    <div class="form-group">
        <label for="name">İsim:</label>
        <input id="name" class="form-control" type="text" name="name" value="{{ old('name') }}" required>
    </div>
    <div class="form-group">
        <label for="referrer_name">Tavsiye eden Kullanıcı adı:</label>
        <input id="referrer_name" class="form-control" type="text" value="{{ old('referrer_name') }}" name="referrer_name">
    </div>
    <button type="submit" class="btn btn-block btn-lg btn-primary">Kayıt ol</button>
{{ Form::close() }}
