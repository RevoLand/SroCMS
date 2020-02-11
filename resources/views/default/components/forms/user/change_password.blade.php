{{ Form::open(['route' => 'users.update_password']) }}
    <div class="form-group">
        <label for="password">Mevcut Şifre</label>
        <input id="password" class="form-control" type="password" name="password" required>
    </div>
    <div class="form-group">
        <label for="new_password">Yeni Şifre</label>
        <input id="new_password" class="form-control" type="password" name="new_password" required>
    </div>
    <div class="form-group">
        <label for="new_password_confirmation">Yeni Şifre Tekrar</label>
        <input id="new_password_confirmation" class="form-control" type="password" name="new_password_confirmation" required>
    </div>
    <button type="submit" class="btn btn-danger btn-block">Değiştir</button>
{{ Form::close() }}
