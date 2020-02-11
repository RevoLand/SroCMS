{{ Form::open(['route' => 'users.set_referrer']) }}
    <div class="form-group">
        <label for="referrer_name">Tavsiye eden kullanıcı adı:</label>
        <input id="referrer_name" class="form-control" type="text" name="referrer_name" required>
    </div>
    <div class="custom-control custom-checkbox mb-2">
        <input id="referrer_agree_change" class="custom-control-input" type="checkbox" name="referrer_agree_change" value="true" required>
        <label for="referrer_agree_change" class="custom-control-label">Bu işlemi sadece bir kez yapabileceğimi bildiğimi teyit ediyorum.</label>
    </div>
    <button type="submit" class="btn btn-danger btn-block">Kaydet</button>
{{ Form::close() }}
