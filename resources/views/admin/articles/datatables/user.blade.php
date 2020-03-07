<div class="kt-user-card-v2">
    @isset($model->user->gravatar)
    <div class="kt-user-card-v2__pic">
        <img alt="photo" src="{{ $model->user->gravatar }}">
    </div>
    @endisset
    <div class="kt-user-card-v2__details">
        <a class="kt-user-card-v2__name" href="{{ route('admin.articles.index', ['author_id' => $model->user]) }}">{{ $model->user->getName() }}</a>
    </div>
</div>
