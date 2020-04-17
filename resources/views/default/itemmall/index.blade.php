@extends('layout')

@section('pagetitle', 'Web Item Mall')
@section('contenttitle', 'Web Item Mall')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="item-mall bg-dark p-3 shadow-sm rounded-lg">
            <div class="row">
                <div class="col-md-3">
                    <div class="row row-cols-1">
                        <div class="col mb-2 pb-2">
                            <div class="card shadow-sm">
                                <div class="card-header">
                                    Bakiye Bilgileri
                                </div>
                                <div class="card-body">
                                    <p class="card-text">
                                        <ul class="list-group list-group-flush mb-n4 mt-n4">
                                            <li class="list-group-item">{{ setting('balance.name', 'Bakiye') }}: {{ number_format(Auth::user()->balance->balance, 2) }} {{ setting('balance.currency', 'TL') }}</li>
                                            <li class="list-group-item">{{ setting('balance.point_name', 'Bakiye (Puan)') }}: {{ number_format(Auth::user()->balance->balance_point, 2) }} {{ setting('balance.currency', 'TL') }}</li>
                                            <li class="list-group-item">{{ setting('silk.silk_own_name', 'Silk') }}: {{ number_format(Auth::user()->silk->silk_own) }}</li>
                                            <li class="list-group-item">{{ setting('silk.silk_gift_name', 'Silk (Gift)') }}: {{ number_format(Auth::user()->silk->silk_gift) }}</li>
                                            <li class="list-group-item border-bottom-0">{{ setting('silk.silk_point_name', 'Silk (Point)') }}: {{ number_format(Auth::user()->silk->silk_point) }}</li>
                                        </ul>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="nav flex-column nav-pills border-right border-secondary" id="categoryTabs" role="tablist" aria-orientation="vertical">
                                @foreach($itemMallCategories as $itemMallCategory)
                                    <a class="nav-link  @if($loop->first) active @endif" id="tab-{{ $itemMallCategory->id }}" data-toggle="tab" href="#category-{{ $itemMallCategory->id }}" role="tab" aria-controls="category-{{ $itemMallCategory->id }}" aria-selected="@if($loop->first) true @else false @endif">
                                        {{ $itemMallCategory->name }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                {{-- item groups --}}
                <div class="col-md-9">
                  <div class="tab-content">
                    @foreach($itemMallCategories as $itemMallCategory)
                        <div class="tab-pane @if($loop->first) show active @endif" id="category-{{ $itemMallCategory->id }}" role="tabpanel" aria-labelledby="tab-{{ $itemMallCategory->id }}">
                            <div class="row row-cols-md-2">
                                @foreach($itemMallCategory->itemGroups as $itemGroup)
                                    <div class="col-md">
                                        <div class="card shadow mb-4">
                                            <h5 class="card-header bg-dark border-secondary">
                                                {{ $itemGroup->name }}
                                            </h5>
                                            @if ($itemGroup->image)
                                                <img src="{{ $itemGroup->image }}" class="card-img-top img-fluid rounded-sm" alt="{{ $itemGroup->name }}">
                                            @endif
                                            <div class="card-body mx-2 py-3">
                                                @if ($itemGroup->description)
                                                    <p class="card-text">{{ $itemGroup->description }}</p>
                                                @endif
                                                <div class="row align-items-center bg-secondary" style="height: 3em">
                                                    <div class="col-md-5">
                                                        @if ($itemGroup->on_sale && $itemGroup->price_before)
                                                            <small class="text-muted"><s>{{ $itemGroup->price_before }}</s></small>
                                                        @endif
                                                        <div>{{ config('constants.payment_types.' . $itemGroup->payment_type) }} {{ $itemGroup->price }}</div>
                                                    </div>
                                                    <div class="col-md-7 text-right">
                                                        <div class="btn-group">
                                                            <a class="btn" data-toggle="collapse" href="#itemGroupContent_{{ $itemGroup->id }}" role="button" aria-expanded="false" aria-controls="itemGroupContent_{{ $itemGroup->id }}"><small class="text-muted">İçeriği Göster</small></a>

                                                            @if ((!$itemGroup->limit_total_purchases || $itemGroup->orders_count < $itemGroup->total_purchase_limit) && (!$itemGroup->limit_user_purchases || $itemGroup->user_orders_count < $itemGroup->user_purchase_limit))
                                                            {{ Form::open(['route' => ['itemmall.cart.add', $itemGroup]]) }}
                                                                <button class="btn btn-primary" type="submit" role="button">Ekle</button>
                                                            {{ Form::close() }}
                                                            @else
                                                                <button class="btn btn-warning btn-sm" type="button" role="button">limit</button>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="collapse mt-2" id="itemGroupContent_{{ $itemGroup->id }}">
                                                    <div class="card card-body">
                                                        <ul class="list-group">
                                                        @forelse($itemGroup->items as $item)
                                                            @switch($item->type)
                                                                @case(1)
                                                                @case(2)
                                                                    <li class="list-group-item">
                                                                        @if ($item->image)
                                                                            <img class="img-fluid" src="{{ $item->image }}">
                                                                        @endif
                                                                        {{ $item->name }}
                                                                        <span class="badge badge-pill bg-secondary float-right">
                                                                            {{ $item->balance }} {{ setting('balance.currency', 'TL') }}
                                                                        </span>
                                                                        <p>
                                                                            <small class="text-muted">{{ $item->description }}</small>
                                                                        </p>
                                                                    </li>
                                                                @break
                                                                @case(3)
                                                                @case(4)
                                                                @case(5)
                                                                    <li class="list-group-item">
                                                                        @if ($item->image)
                                                                            <img class="img-fluid" src="{{ $item->image }}">
                                                                        @endif
                                                                        {{ $item->name }}
                                                                        <span class="badge badge-pill bg-secondary float-right">
                                                                            {{ $item->amount }} {{ config('constants.payment_types.' . $item->type) }}
                                                                        </span>
                                                                        <p>
                                                                            <small class="text-muted">{{ $item->description }}</small>
                                                                        </p>
                                                                    </li>
                                                                @break
                                                                @case(6)
                                                                <li class="list-group-item">
                                                                    @if('' !== $item->getImage())
                                                                    <img class="img-fluid" src="{{ $item->getImage() }}"/>
                                                                    @endif
                                                                    {{ $item->getName() }} @if($item->plus) (+{{ $item->plus }}) @endif
                                                                    <span class="badge badge-pill bg-secondary float-right">
                                                                        {{ $item->amount }}
                                                                    </span>
                                                                    <div class="text-muted">
                                                                        <small>{{ $item->description }}</small>
                                                                    </div>
                                                                </li>
                                                                @break
                                                            @endswitch
                                                            @empty
                                                            <li class="list-group-item">
                                                                <h6>Bu grupta herhangi bir ürün tanımlanmamış!</h6>
                                                            </li>
                                                        @endforelse
                                                      </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                  </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
