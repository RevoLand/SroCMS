<ul class="list-group">
@foreach ($model->items as $item)
<li class="list-group-item border-0 d-flex justify-content-between align-items-center">
    <span class="badge badge-primary">{{ $item->quantity }} adet</span>
    {{ $item->itemgroup->name }}
    <a data-toggle="tooltip" title="{{ $item->item_price }} * {{ $item->quantity }}">
        <span class="badge badge-secondary">{{ $item->total_paid }} {{ config('constants.payment_types.' . $item->payment_type) }}</span>
    </a>
</li>
@endforeach
</ul>
