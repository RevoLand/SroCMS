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
                                            <div class="col-md" v-show="itemCount != 0">
                                                @forelse($cart as $key => $cartItem)
                                                <table class="table table-borderless table-responsive-md table-hover shadow-sm" id="cartitem-{{ $key }}">
                                                    <thead class="table-secondary shadow-sm">
                                                        <tr>
                                                            <th class="col-6 col-md-9 align-middle">{{ $cartItem['group']->name }} @if($cartItem['group']->description) <small><i class="text-muted">- {{ $cartItem['group']->description }}</i></small>@endif</th>
                                                            <th class="col-6 col-md-3">
                                                                <div class="">
                                                                    {{ Form::open(['route' => ['itemmall.cart.delete', $key], 'name' => 'deleteItem-' . $key,'method' => 'delete', '@submit.prevent' => 'onDeleteCartItem(\''. $key .'\')']) }}
                                                                        <item-quantity @ondeletecartitem="onDeleteCartItem" qty="{{ $cartItem['quantity'] }}" groupid="{{ $key }}"></item-quantity>
                                                                    {{ Form::close() }}
                                                                </div>
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="border border-secondary border-left-0 border-right-0 shadow-sm">
                                                        @forelse($cartItem['group']->items as $item)
                                                            <tr>
                                                                @switch($item->type)
                                                                    @case(1)
                                                                    @case(2)
                                                                    <td class="align-middle">
                                                                        @if ($item->image)
                                                                            <img class="img-fluid mr-2" src="{{ $item->image }}">
                                                                        @endif
                                                                        {{ $item->name }}
                                                                        @if ($item->description)<small class="text-muted"><i>- {{ $item->description }}</i></small>@endif
                                                                    </td>
                                                                    <td class="align-middle text-right">
                                                                        {{ $item->balance }} {{ setting('balance.currency', 'TL') }}
                                                                    </td>
                                                                    @break
                                                                    @case(3)
                                                                    @case(4)
                                                                    @case(5)
                                                                    <td class="align-middle">
                                                                        @if ($item->image)
                                                                            <img class="img-fluid mr-2" src="{{ $item->image }}">
                                                                        @endif
                                                                        {{ $item->name }}
                                                                        @if ($item->description)<small class="text-muted"><i>- {{ $item->description }}</i></small>@endif
                                                                    </td>
                                                                    <td class="align-middle text-right">
                                                                        {{ $item->amount }} {{ config('constants.payment_types.' . $item->type) }}
                                                                    </td>
                                                                    @break
                                                                    @case(6)
                                                                    <td class="align-middle">
                                                                        @if('' !== $item->getImage())
                                                                        <img class="img-fluid mr-2" src="{{ $item->getImage() }}"/>
                                                                        @endif
                                                                        {{ $item->getName() }} @if($item->plus) (+{{ $item->plus }}) @endif
                                                                        @if ($item->description)<small class="text-muted"><i>- {{ $item->description }}</i></small>@endif
                                                                    </td>
                                                                    <td class="align-middle text-right">
                                                                        {{ $item->amount }} adet
                                                                    </td>
                                                                    @break
                                                                @endswitch
                                                            </tr>
                                                            @empty
                                                            <tr>
                                                                <td colspan="2">Bu grupta herhangi bir ürün tanımlanmamış!</td>
                                                            </tr>
                                                        @endforelse
                                                    </tbody>
                                                    <tfoot  class="table-secondary shadow-sm">
                                                        <tr>
                                                            <td colspan="2" class="text-right h6">
                                                                {{ config('constants.payment_types.' . $cartItem['group']->payment_type) }}:
                                                                {{ $cartItem['group']->price }}
                                                                @if ($cartItem['group']->on_sale && $cartItem['group']->price_before)
                                                                    <small class="text-muted"><s>{{ $cartItem['group']->price_before }}</s></small>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                                @empty
                                                    Sepetinizde herhangi bir ürün bulunmamaktadır.
                                                @endforelse
                                            </div>
                                            <div class="col-md" v-show="itemCount == 0">
                                                Sepetinizde herhangi bir ürün bulunmamaktadır.
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
                                <table class="table table-sm table-responsive-md">
                                    <tr>
                                        <td>{{ __('Ürün Sayısı') }}:</td>
                                        <td :bind="itemCount">@{{ itemCount }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="lead text-center">Toplam</td>
                                    </tr>
                                    <tr v-for="total in totals">
                                        <td>@{{ total.name }}</td>
                                        <td>@{{ total.price }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="lead text-right">
                                            {{ Form::open(['route' => 'itemmall.cart.checkout']) }}
                                                <button type="submit" class="btn btn-primary">Satın Al</button>
                                            {{ Form::close() }}
                                        </td>
                                    </tr>
                                </table>
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



@section ('js')
<script src="{{ asset('vendor/vue/vue.js') }}"></script>
<script src="{{ asset('vendor/axios.min.js') }}"></script>
<script>
    Vue.component('item-quantity', {
        props: ['groupid', 'qty'],
        data: function() {
            return {
                quantity: 1,
                groupId: 0,
                IsUpdating: false
            }
        },
        mounted() {
            this.quantity = this.qty,
            this.groupId = this.groupid
        },
        template: `
            <div>
                <div class="btn-group" role="group">
                    <input type="number" class="form-control w-50" v-model.number="quantity" />
                    <button type="button" class="btn btn-primary shadow-sm border border-dark" @click="onUpdateQty" :disabled="IsUpdating"><i class="las la-sync"></i></button>
                    <button type="submit" class="btn btn-danger shadow-sm border border-dark"><i class="las la-trash"></i></button>
                </div>
            </div>
        `,
        methods: {
            onUpdateQty(event) {
                this.IsUpdating = true;

                if (this.quantity <= 0) {
                    return this.$emit('ondeletecartitem', this.groupId);
                }

                axios.patch('{{ route('itemmall.cart.update') }}', {
                    groupid: this.groupId,
                    quantity: this.quantity
                }).then(response => {
                    this.quantity = response.data.quantity;
                    this.$root.totals = response.data.totals;
                    this.$root.itemCount = response.data.itemCount;
                })
                .catch(error => {
                    alert(error.response.data.message);
                })
                .finally(() => {
                    this.IsUpdating = false;
                });

            },
        }
    });
    new Vue({
        el: '.cart',

        data: {
            totals: [],
            itemCount: 0,
        },

        mounted() {
            this.totals = @json($totals),
            this.itemCount = @json($itemCount)
        },

        methods: {
            onDeleteCartItem: function (groupId) {
                axios.delete(document.getElementsByName('deleteItem-' + groupId)[0].action)
                .then(response => {
                    // Remove item
                    document.querySelector('#cartitem-' + groupId).remove();

                    // Update totals
                    this.totals = response.data.totals;

                    // Update item count
                    this.itemCount = response.data.itemCount;
                })
                .catch(error => {
                    alert(error.response.data.message);
                });
            }

        },
    });
</script>
@endsection
