@if ($errors->any())
    <div class="alert alert-danger" role="alert">
        @foreach ($errors->all() as $error)
            {{ $error }} @if (!$loop->last) <br/> @endif
        @endforeach
    </div>
@endif
