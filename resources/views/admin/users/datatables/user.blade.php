<a class="media align-items-center mb-2" href="{{ route('admin.users.show', $model->JID) }}">
    @isset($model->gravatar)
    <img class="d-flex align-self-center mr-2" src="{{ $model->gravatar }}" alt="{{ $model->StrUserID }}" width="30">
    @endisset
    <div class="media-body">
      <h6 class="mb-0">{{ $model->getName() }}</h6>
    </div>
</a>
