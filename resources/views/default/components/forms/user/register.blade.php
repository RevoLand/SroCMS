{{ Form::open(['route' => 'users.do_register']) }}
    <div class="form-group">
        <label for="username">Username:</label>
        <input id="username" class="form-control" type="text" name="username" value="{{ old('username') }}" minlength="3" required>
    </div>
    <div class="form-group">
        <label for="password">Password:</label>
        <input id="password" class="form-control" type="password" name="password" minlength="8" required>
    </div>
    <div class="form-group">
        <label for="password_confirmation">Password Confirmation:</label>
        <input id="password_confirmation" class="form-control" type="password" name="password_confirmation"  minlength="8" required>
    </div>
    <div class="form-group">
        <label for="email">E-mail:</label>
        <input id="email" class="form-control" type="email" name="email" value="{{ old('email') }}" required>
    </div>
    <div class="form-group">
        <label for="name">Name: <small class="text-muted">Optional</small></label>
        <input id="name" class="form-control" type="text" name="name" value="{{ old('name') }}">
    </div>
    @if (setting('referrals.enabled', 1))
    <div class="form-group">
        <label for="referrer_name">Referrer Username: <small class="text-muted">Optional</small></label>
        <input id="referrer_name" class="form-control" type="text" value="{{ old('referrer_name') }}" name="referrer_name">
    </div>
    @endif
    <button type="submit" class="btn btn-block btn-lg btn-primary">Register</button>
{{ Form::close() }}
