@isset($model->creater)
<div class="kt-user-card-v2">
    <div class="kt-user-card-v2__details">
        <a class="kt-user-card-v2__name" href="{{ route('admin.epins.index', ['creater_user_id' => $model->creater, 'filter' => request('filter')]) }}">{{ $model->creater->StrUserID }}</a>
    </div>
</div>
@else
-
@endisset
