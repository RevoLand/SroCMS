@extends('layout')

@section('pagetitle', 'Web Item Mall: Sepet')
@section('contenttitle', 'Web Item Mall: Sepet')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="cart bg-dark px-3 py-3 shadow-sm rounded-sm">
            <div class="row">
                {{-- cart content --}}
                <div class="col-md-9">
                    @if (session('status'))
                        <div class="alert alert-danger">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="card-text">
                                        <div class="row">
                                            <div class="col-md">
                                                @forelse($cart as $cartItem)
                                                <table class="table table-bordered table-responsive-md">
                                                    <thead>
                                                        <tr>
                                                            <th class="col-10">{{ $cartItem['group']->name }} @if($cartItem['group']->description) <small><i class="text-muted">- {{ $cartItem['group']->description }}</i></small>@endif</th>
                                                            <th class="col-2">
                                                                <div class="input-group input-group-sm">
                                                                    <input type="number" maxlength="3" max="999" min="1" minlength="1" class="form-control" name="quantity" value="{{ $cartItem['quantity'] }}">
                                                                    <div class="input-group-append">
                                                                        <button type="submit" class="btn btn-danger">Sil</button>
                                                                    </div>
                                                                </div>
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @forelse($cartItem['group']->items as $item)
                                                            <tr>
                                                                @switch($item->type)
                                                                    @case(1)
                                                                    @case(2)
                                                                    <td>
                                                                        @if ($item->image)
                                                                            <img class="img-fluid" src="{{ $item->image }}">
                                                                        @endif
                                                                        {{ $item->name }}
                                                                        @if ($item->description)<small class="text-muted"><i>- {{ $item->description }}</i></small>@endif
                                                                    </td>
                                                                    <td>
                                                                        {{ $item->balance }} {{ setting('balance.currency', 'TL') }}
                                                                    </td>
                                                                    @break
                                                                    @case(3)
                                                                    @case(4)
                                                                    @case(5)
                                                                    <td>
                                                                        @if ($item->image)
                                                                            <img class="img-fluid" src="{{ $item->image }}">
                                                                        @endif
                                                                        {{ $item->name }}
                                                                        @if ($item->description)<small class="text-muted"><i>- {{ $item->description }}</i></small>@endif
                                                                    </td>
                                                                    <td>
                                                                        {{ $item->amount }} {{ config('constants.payment_types.' . $item->type) }}
                                                                    </td>
                                                                    @break
                                                                    @case(6)
                                                                    <td>
                                                                        <img class="img-fluid" src="{{ $item->image ?? $item->objCommon->image }}"/>
                                                                        {{ $item->getName() }} @if($item->plus) (+{{ $item->plus }}) @endif
                                                                        @if ($item->description)<small class="text-muted"><i>- {{ $item->description }}</i></small>@endif
                                                                    </td>
                                                                    <td>
                                                                        {{ $item->amount }} adet
                                                                    </td>
                                                                    @break
                                                                @endswitch
                                                            </tr>
                                                            @empty
                                                            <tr>
                                                                <td colspan="3">Bu grupta herhangi bir ürün tanımlanmamış!</td>
                                                            </tr>
                                                        @endforelse
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td colspan="3" class="text-right">
                                                                @if ($cartItem['group']->on_sale && $cartItem['group']->price_before)
                                                                <small class="text-muted"><s>{{ $cartItem['group']->price_before }}</s></small>
                                                                @endif
                                                                {{ $cartItem['group']->price }} {{ config('constants.payment_types.' . $cartItem['group']->payment_type) }}
                                                            </td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                                @empty
                                                <tr>
                                                    <td colspan="3">
                                                        Sepetinizde herhangi bir ürün bulunmamaktadır.
                                                    </td>
                                                </tr>
                                                @endforelse
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </div>
                        </div>
                    </div>
                </div>

                {{-- cart overview --}}
                <div class="col-md-3">
                    <div class="row row-cols-1">
                        <div class="col mb-2 pb-2">
                            <div class="card shadow-sm">
                                <div class="card-header">
                                    Sepet Özeti
                                </div>
                                <div class="card-body">
                                    <p class="card-text">
                                        <table class="table-responsive-md">
                                            <tr>
                                                <td>{{ __('Ürün Sayısı') }}:</td>
                                                <td>{{ count($cart) }}</td>
                                            </tr>
                                        </table>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col mb-2 pb-2">
                            <div class="card shadow-sm">
                                <div class="card-header">
                                    Bakiye Bilgileri
                                </div>
                                <div class="card-body">
                                    <p class="card-text">
                                        <ul class="list-group mb-n4 mt-n4">
                                            <li class="list-group-item">{{ setting('balance.name', 'Bakiye') }}: {{ number_format(Auth::user()->balance->balance, 2) }} {{ setting('balance.currency', 'TL') }}</li>
                                            <li class="list-group-item">{{ setting('balance.point_name', 'Bakiye (Puan)') }}: {{ number_format(Auth::user()->balance->balance_point, 2) }} {{ setting('balance.currency', 'TL') }}</li>
                                            <li class="list-group-item">{{ setting('silk.silk_own_name', 'Silk') }}: {{ number_format(Auth::user()->silk->silk_own) }}</li>
                                            <li class="list-group-item">{{ setting('silk.silk_gift_name', 'Silk (Gift)') }}: {{ number_format(Auth::user()->silk->silk_gift) }}</li>
                                            <li class="list-group-item">{{ setting('silk.silk_point_name', 'Silk (Point)') }}: {{ number_format(Auth::user()->silk->silk_point) }}</li>
                                        </ul>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
