<div class="media align-items-center">
    @isset($model->punishment->executor->gravatar)
    <img class="d-flex align-self-center mr-2" src="{{ $model->punishment->executor->gravatar }}" alt="{{ $model->punishment->executor->StrUserID }}" width="30">
    @endisset
    <div class="media-body">
        <h6 class="mb-0"><a href="{{ route('admin.users.show', $model->punishment->executor) }}">{{ $model->punishment->executor->StrUserID }}</a></h6>
        @isset($model->punishment->executor->Name) <small class="text-muted font-italic">{{ $model->punishment->executor->Name }}</small> @endisset
    </div>
</div>
