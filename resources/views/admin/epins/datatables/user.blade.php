@isset($model->user)
<div class="kt-user-card-v2">
    <div class="kt-user-card-v2__details">
        <a class="kt-user-card-v2__name" href="{{ route('admin.articles.index', ['author_id' => $model->user]) }}">{{ $model->user->StrUserID }}</a>
    </div>
</div>
@else
-
@endisset
