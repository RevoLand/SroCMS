<div class="row">
    <div class="col">
        <div class="media mt-2 border p-2">
            @if ($articleComment->user->gravatar)
                <img src="{{ $articleComment->user->gravatar }}" class="mr-3">
            @endif
            <div class="media-body">
                <div class="float-right text-muted small">
                    <a data-toggle="tooltip" title="{{ $article->created_at }}"> {{ $articleComment->created_at->locale(env('APP_LOCALE', 'tr_TR'))->diffForHumans()   }}</a>
                </div>
                <h5 class="mt-0 text-muted">
                    <a href="{{ route('users.show_user', $articleComment->user) }}">
                        {{ $articleComment->user->getName() }}
                    </a>
                </h5>
                <p class="text-wrap">{{ $articleComment->content }}</p>
            </div>
        </div>
    </div>
</div>
