<a class="media align-items-center mb-2" href="{{ route('admin.itemmall.index', ['user_id' => $model->user->JID, 'item_group_id' => request('item_group_id'), 'payment_type' => request('payment_type')]) }}">
    @isset($model->user->gravatar)
    <img class="d-flex align-self-center mr-2" src="{{ $model->user->gravatar }}" alt="{{ $model->user->StrUserID }}" width="30">
    @endisset
    <div class="media-body">
      <h6 class="mb-0">{{ $model->user->getName() }}</h6>
    </div>
</a>
