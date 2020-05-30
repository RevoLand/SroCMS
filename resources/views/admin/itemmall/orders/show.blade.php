@extends('layout')

@section('pagetitle', 'Order Details')

@section('content')
<div class="card mb-3">
    <div class="bg-holder d-none d-lg-block bg-card" style="background-image:url({{ Theme::url('img/illustrations/corner-4.png') }});opacity: 0.7;"></div><!--/.bg-holder-->

    <div class="card-body">
        <div class="row">
            <div class="col">
                <h5>Order Details: #{{ $order->id }}</h5>
                <p class="fs--1">{{ $order->created_at }}</p>
                <div class="media align-items-center">
                    @isset($order->user->gravatar)
                    <img class="d-flex align-self-center mr-2" src="{{ $order->user->gravatar }}" alt="{{ $order->user->StrUserID }}" width="30">
                    @endisset
                    <div class="media-body">
                      <h6 class="mb-0"><a href="{{ route('admin.users.show', $order->user) }}">{{ $order->user->StrUserID }}</a></h6>
                      @isset($order->user->Name) <small class="text-muted font-italic">{{ $order->user->Name }}</small> @endisset
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card mb-3">
    <div class="card-body">
        <div class="table-responsive fs--1">
            <table class="table table-striped border-bottom">
                <thead class="bg-200 text-900">
                    <tr>
                        <th class="border-0">Item Groups</th>
                        <th class="border-0 text-center">Quantity</th>
                        <th class="border-0 text-right">Price</th>
                        <th class="border-0 text-right">Points Earned</th>
                        <th class="border-0 text-right">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $orderItem)
                        <tr>
                            <td class="align-middle">
                                <h6 class="mb-0 text-nowrap"><a class="text-decoration-none text-reset" href="{{ route('admin.itemmall.itemgroups.show', $orderItem->itemgroup) }}">{{ $orderItem->itemgroup->name }}</a></h6>
                                @isset($orderItem->itemgroup->description)<p class="mb-0">{{ $orderItem->itemgroup->description }}</p>@endisset
                            </td>
                            <td class="align-middle text-center">{{ $orderItem->quantity }}</td>
                            <td class="align-middle text-right">{{ $orderItem->item_price }} {{ config('constants.payment_types.' . $orderItem->payment_type) }}</td>
                            <td class="align-middle text-right">{{ number_format($orderItem->points_earned, 2) }} {{ config('constants.payment_types.' . $orderItem->payment_type) }}</td>
                            <td class="align-middle text-right">{{ $orderItem->total_paid }} {{ config('constants.payment_types.' . $orderItem->payment_type) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div> {{-- /table-responsive --}}
        <div class="row no-gutters justify-content-end">
            <div class="col-auto">
                <table class="table table-sm table-borderless fs-11 text-right">
                    <tr>
                        <th class="text-900">Totals</th>
                    </tr>
                    @foreach($order->getTotals() as $key => $total)
                    <tr>
                        <td class="font-weight-semi-bold">{{ $total }} {{ config('constants.payment_types.' . $key) }}</td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
