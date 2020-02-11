{{ Form::open(['route' => 'users.update_settings']) }}
    <div class="form-group">
        <label for="name">İsim:</label>
        <input id="name" class="form-control" type="text" name="name" value="{{ $user->Name }}" required>
    </div>
    <button type="submit" class="btn btn-danger btn-block">Kaydet</button>
{{ Form::close() }}
