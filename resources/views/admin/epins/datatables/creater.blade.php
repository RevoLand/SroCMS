@isset($model->creater)
<a class="media align-items-center mb-2" href="{{ route('admin.epins.index', ['creater_user_id' => $model->creater, 'user_id' => request('user_id'), 'filter' => request('filter')]) }}">
    @isset($model->creater->gravatar)
    <img class="d-flex align-self-center mr-2" src="{{ $model->creater->gravatar }}" alt="{{ $model->creater->StrUserID }}" width="30">
    @endisset
    <div class="media-body">
      <h6 class="mb-0">{{ $model->creater->getName() }}</h6>
    </div>
</a>
@else
-
@endisset
