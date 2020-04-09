@isset($model->user)
<a class="media align-items-center mb-2" href="{{ route('admin.epins.index', ['creater_user_id' => request('creater_user_id'), 'user_id' => $model->user, 'filter' => request('filter')]) }}">
    @isset($model->user->gravatar)
    <img class="d-flex align-self-center mr-2" src="{{ $model->user->gravatar }}" alt="{{ $model->user->StrUserID }}" width="30">
    @endisset
    <div class="media-body">
      <h6 class="mb-0">{{ $model->user->getName() }}</h6>
    </div>
</a>
@else
-
@endisset
