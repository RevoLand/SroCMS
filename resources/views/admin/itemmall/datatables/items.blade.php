<ul class="list-group">
    @foreach ($model->items as $item)
    <li class="list-group-item border-0 d-flex justify-content-between align-items-center bg-100 shadow-sm">
        <span class="badge badge-soft-primary">{{ $item->quantity }} adet</span>
        <a href="{{ route('admin.itemmall.index', ['user_id' => request('user_id'), 'item_group_id' => $item->itemgroup, 'payment_type' => request('payment_type')]) }}">{{ $item->itemgroup->name }}</a>
        <a data-toggle="tooltip" title="{{ $item->item_price }} * {{ $item->quantity }}">
            <a href="{{ route('admin.itemmall.index', ['user_id' => request('user_id'), 'item_group_id' => request('item_group_id'), 'payment_type' => $item->payment_type]) }}">
                <span class="badge badge-soft-secondary">{{ $item->total_paid }} {{ config('constants.payment_types.' . $item->payment_type) }}</span>
            </a>
        </a>
    </li>
    @endforeach
</ul>
