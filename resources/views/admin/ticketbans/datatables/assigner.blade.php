@isset($model->assigner)
<div class="media align-items-center">
    @isset($model->assigner->gravatar)
    <img class="d-flex align-self-center mr-2" src="{{ $model->assigner->gravatar }}" alt="{{ $model->assigner->StrUserID }}" width="30">
    @endisset
    <div class="media-body">
      <h6 class="mb-0"><a href="{{ route('admin.users.show', $model->assigner) }}">{{ $model->assigner->StrUserID }}</a></h6>
      @isset($model->assigner->Name) <small class="text-muted font-italic">{{ $model->assigner->Name }}</small> @endisset
    </div>
</div>
@else
-
@endisset
