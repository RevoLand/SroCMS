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

{{--
    "id" => 6
    "item_mall_item_group_id" => "5"
    "item_mall_order_id" => "2"
    "user_id" => "1"
    "quantity" => "1"
    "payment_type" => "1"
    "item_price" => "4.99"
    "total_paid" => "4.99"
    "points_earned" => ".09"
    "created_at" => "2020-03-15T10:59:40.203000Z"
    "updated_at" => "2020-03-15T10:59:40.203000Z"
    "itemgroup" => null
  --}}
