@extends('layout')

@section('pagetitle', 'Web Item Mall')
@section('contenttitle', 'Web Item Mall')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="item-mall bg-dark px-3 py-3 shadow-sm rounded-sm">
            <div class="row">
                {{-- categories --}}
                <div class="col-md-3">
                  <div class="nav flex-column nav-pills border-right border-secondary" id="categoryTabs" role="tablist" aria-orientation="vertical">
                    @foreach($itemMallCategories as $itemMallCategory)
                        <a class="nav-link  @if($loop->first) active @endif" id="tab-{{ $itemMallCategory->id }}" data-toggle="tab" href="#category-{{ $itemMallCategory->id }}" role="tab" aria-controls="category-{{ $itemMallCategory->id }}" aria-selected="@if($loop->first) true @else false @endif">
                            {{ $itemMallCategory->name }}
                        </a>
                    @endforeach
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
                                            <img src="{{ $itemGroup->image }}?s=256" class="card-img-top img-fluid rounded-sm" alt="{{ $itemGroup->name }}">
                                            @endif
                                            <div class="card-body px-4 py-3">
                                                @if ($itemGroup->description)
                                                    <p class="card-text">{{ $itemGroup->description }}</p>
                                                @endif
                                                <div class="row align-items-center align-content-center bg-secondary" style="height: 3em">
                                                    <div class="col-md-4 text-left">
                                                        @if ($itemGroup->price_before && $itemGroup->on_sale)
                                                            <small class="text-muted"><s>{{ $itemGroup->price_before }} {{ config('constants.payment_types.' . $itemGroup->payment_type) }}</s></small>
                                                        @endif
                                                        <h6>{{ $itemGroup->price }} {{ config('constants.payment_types.' . $itemGroup->payment_type) }}</h6>
                                                    </div>
                                                    <div class="col-md-8 text-right">
                                                        <a class="btn btn-sm" data-toggle="collapse" href="#itemGroupContent_{{ $itemGroup->id }}" role="button" aria-expanded="false" aria-controls="itemGroupContent_{{ $itemGroup->id }}">İçeriği Göster</a>
                                                        <a href="#" class="btn btn-primary">Sepete Ekle</a>
                                                    </div>
                                                </div>
                                                <div class="collapse mt-2" id="itemGroupContent_{{ $itemGroup->id }}">
                                                    <div class="card card-body">
                                                        <ul class="list-group">
                                                        @foreach($itemGroup->items as $item)
                                                            @switch($item->type)
                                                                {{--
                                                                    'balance' => '1',
                                                                    'balance_point' => '2',
                                                                    'silk' => '3',
                                                                    'silk_gift' => '4',
                                                                    'silk_point' => '5',
                                                                    'item' => 6,
                                                                --}}
                                                                @case(1)
                                                                @case(2)
                                                                    <li class="list-group-item">
                                                                        @if ($item->image)
                                                                            <img class="img-fluid" src="{{ $item->image }}">
                                                                        @endif
                                                                        {{ $item->name }}
                                                                        <span class="badge badge-pill bg-secondary float-right">
                                                                            {{ $item->balance }} {{ config('constants.payment_types.' . $item->type) }}
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
                                                                <li class="list-group-item mb-0 pb-0">
                                                                    <img class="img-fluid" src="{{ $item->image ?? $item->objCommon->image }}"/>
                                                                    {{ $item->getName() }} @if($item->plus) (+{{ $item->plus }}) @endif
                                                                    <span class="badge badge-pill bg-secondary float-right">
                                                                        {{ $item->amount }}
                                                                    </span>
                                                                    <p>
                                                                        <small class="text-muted">{{ $item->description }}</small>
                                                                    </p>
                                                                </li>
                                                                @break
                                                            @endswitch
                                                        @endforeach
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
