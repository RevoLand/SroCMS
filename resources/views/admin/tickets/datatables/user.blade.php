@isset($model->user)
<div class="media align-items-center">
    @isset($model->user->gravatar)
    <img class="d-flex align-self-center mr-2" src="{{ $model->user->gravatar }}" alt="{{ $model->user->StrUserID }}" width="30">
    @endisset
    <div class="media-body">
        <h6 class="mb-0">{{ $model->user->StrUserID }}</h6>
        @isset($model->user->Name) <small class="text-muted font-italic">{{ $model->user->Name }}</small> @endisset
    </div>
</div>
@else
-
@endisset
