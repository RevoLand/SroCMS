@isset($model->assignedUser)
<div class="media align-items-center">
    @isset($model->assignedUser->gravatar)
    <img class="d-flex align-self-center mr-2" src="{{ $model->assignedUser->gravatar }}" alt="{{ $model->assignedUser->StrUserID }}" width="30">
    @endisset
    <div class="media-body">
      <h6 class="mb-0"><a href="{{ route('admin.users.show', $model->assignedUser) }}">{{ $model->assignedUser->StrUserID }}</a></h6>
      @isset($model->assignedUser->Name) <small class="text-muted font-italic">{{ $model->assignedUser->Name }}</small> @endisset
    </div>
</div>
@else
-
@endisset
