{{ Form::open(['route' => 'epin.use']) }}
    <div class="form-group">
        <label for="epin">E-Pin Code:</label>
        <input id="epin" class="form-control" type="text" name="epin" required>
    </div>
    <button type="submit" class="btn btn-primary btn-block">Use</button>
{{ Form::close() }}
