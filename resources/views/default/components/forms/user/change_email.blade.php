{{ Form::open(['route' => 'users.update_email']) }}
    @isset ($currentEmail)
    <div class="form-group">
        <label for="current_email">Mevcut E-posta adresi:</label>
        <input id="current_email" class="form-control-plaintext" type="email" name="current_email" readonly value="{{ $currentEmail }}">
    </div>
    @endisset
    <div class="form-group">
        <label for="new_email">Yeni E-posta Adresi:</label>
        <input id="new_email" class="form-control" type="email" name="new_email" required>
    </div>
    <div class="form-group">
        <label for="new_email_confirmation">Yeni E-posta Adresi Tekrar</label>
        <input id="new_email_confirmation" class="form-control" type="email" name="new_email_confirmation" required>
    </div>
    <button type="submit" class="btn btn-block btn-primary btn-lg">Kaydet</button>
{{ Form::close() }}
