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
                                            <div class="col-md" v-show="itemCount !== 0">
                                                @forelse($cart as $key => $cartItem)
                                                <table class="table table-bordered table-responsive-md" id="cartitem-{{ $key }}">
                                                    <thead>
                                                        <tr>
                                                            <th class="col-10">{{ $cartItem['group']->name }} @if($cartItem['group']->description) <small><i class="text-muted">- {{ $cartItem['group']->description }}</i></small>@endif</th>
                                                            <th class="col-2">
                                                                <div class="d-inline">
                                                                    {{ Form::open(['route' => ['itemmall.cart.delete', $key], 'method' => 'delete', '@submit.prevent' => 'onDeleteCartItem('. $key . ')']) }}
                                                                        <item-quantity qty="{{ $cartItem['quantity'] }}" groupid="{{ $key }}"></item-quantity>
                                                                    {{ Form::close() }}
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
                                            <div class="col-md" v-show="itemCount === 0">
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
                                        <td colspan="2" class="lead text-right"><button type="submit" class="btn btn-primary">Satın Al</button></td>
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
{!! Theme::js('vendor/vue/vue.js') !!}
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    window.Event = new Vue();

    Vue.component('item-quantity', {
        props: ['groupid', 'qty'],
        data: function() {
            return {
                quantity: 1,
                groupId: 0,
                updating: false
            }
        },
        mounted() {
            this.quantity = this.qty,
            this.groupId = this.groupid
        },
        template: `
            <div>
                <input type="number" class="form-control mb-2" v-model.number="quantity" />
                <div class="text-center">
                    <button type="button" class="btn btn-primary" @click="onUpdateQty" :disabled="updating"><i class="las la-sync"></i></button>
                    <button type="submit" @deleteitem="onDeleteCartItem" class="btn btn-danger"><i class="las la-trash"></i></button>
                </div>
            </div>
        `,
        methods: {
            onUpdateQty(event) {
                this.updating = true;

                if (this.quantity === 0) {
                    return this.onDeleteCartItem(this.groupId);
                }

                axios.patch('{{ route('itemmall.cart.update') }}', {
                    groupid: this.groupId,
                    quantity: this.quantity
                }).then(response => {
                    this.quantity = response.data.quantity;
                    this.$root.totals = response.data.totals;
                    this.$root.itemCount = response.data.itemCount;

                    //alert(response.data.message);
                })
                .catch(error => {
                    alert(error.message);
                });

                this.updating = false;
            },

            onDeleteCartItem($itemGroup) {
                Event.$emit('deleteitem', $itemGroup, event.target.form.action);
            }
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
            this.itemCount = {{ $itemCount }}
        },

        created() {
            Event.$on('deleteitem', (itemGroup, actionUrl) => {
                axios.delete(actionUrl)
                .then(response => {
                    // Remove item
                    document.querySelector('#cartitem-' + itemGroup).remove();

                    // Update totals
                    this.totals = response.data.totals;

                    // Update item count
                    this.itemCount = response.data.itemCount;
                })
                .catch(error => {
                    alert(error);
                    console.log(error);
                });
            });
        }
    });
</script>
@endsection
