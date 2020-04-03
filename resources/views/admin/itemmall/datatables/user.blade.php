<div class="kt-user-card-v2">
    <div class="kt-user-card-v2__details">
        <a class="kt-user-card-v2__name" href="{{ route('admin.itemmall.index', ['user_id' => $model->user->JID, 'item_group_id' => request('item_group_id'), 'payment_type' => request('payment_type')]) }}">{{ $model->user->StrUserID }}</a>
    </div>
</div>
