@extends('layout')

@section('pagetitle', 'Edit Item Group')

@section('content')
<div class="card mb-3" id="content">
    <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="mb-0">Edit Item Group</h5>
        <div>
            <a class="btn btn-falcon-primary mr-2" href="{{ route('admin.itemmall.itemgroups.create') }}">Create</a>
            <a class="btn btn-falcon-info" href="{{ route('admin.itemmall.itemgroups.index') }}">Item Groups</a>
        </div>
    </div>
    <div class="card-body bg-light">
        <div class="row">
            <div class="col-12">
                {{ Form::open(['route' => ['admin.itemmall.itemgroups.update', $itemgroup], 'method' => 'patch', '@submit.prevent' => 'onSubmit']) }}
                @include('itemmall.itemgroups.forms.itemgroups')
                <div class="btn-group">
                    <button type="submit" class="btn btn-falcon-primary">Save</button>
                    {{ Form::close() }}
                    {!! Form::open([ 'route' => ['admin.itemmall.itemgroups.destroy', $itemgroup], 'method' => 'delete', '@submit.prevent' => 'onDelete']) !!}
                    <button type="submit" class="btn btn-falcon-danger">Delete</button>
                    {!! Form::close() !!}
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>

<div class="card-deck" id="itemgroup_items">
    <div class="card">
        <div class="card-header">Items</div>
        <div class="card-body">
            <select class="custom-select" size="10" v-model="selecteditem">
                <option value="" v-show="false"></option>
                <option :value="{
                    item_mall_item_group_id: {{ $itemgroup->id }},
                    type: 6,
                    enabled: 1
                }">Create New Item</option>
                <optgroup label="Existing Items">
                    <option v-for="item in items" :value="item" v-bind:class="{'alert-danger' : item.enabled == 0}">
                        <template v-if="item.type == 6">
                            [@{{ item.amount }}] @{{ item.codename }} (+@{{ item.plus }})
                        </template>
                        <template v-else-if="item.type < 6 && item.type > 2">
                            [@{{ item.type_name }}] @{{ item.name }} (@{{ item.amount }})
                        </template>
                        <template v-else>
                            [@{{ item.type_name }}] @{{ item.name }} (@{{ item.balance }})
                        </template>
                    </option>
                </optgroup>
            </select>
        </div>
    </div>
    <div class="card" v-show="selecteditem">
        <div class="card-header">
            <template v-if="selecteditem.id">
                Edit Item
            </template>
            <template v-else>
                Create Item
            </template>
        </div>
        <div class="card-body">
            <item_form v-bind:item="selecteditem"></item_form>
        </div>
    </div>
</div>
@endsection

@section('js')
{!! Theme::js('lib/select2/select2.min.js') !!}
{!! Theme::js('lib/flatpickr/flatpickr.min.js') !!}
<script src="{{ asset('vendor/vue/ext/flatpickr.js') }}"></script>
<script src="{{ asset('vendor/vue/ext/select2.js') }}"></script>

<script type="text/javascript">
    Vue.component('item_form', {
        props: ['item'],
        data: function() {
            return {
                IsBeingUpdated: false,
                IsBeingDeleted: false
            }
        },
        computed: {
            IsItCreateForm: function () {
                return !(this.item.id);
            },
            IsItBalance: function () {
                return this.item.type < 3;
            },
            IsItItem: function() {
                return this.item.type == 6;
            }
        },
        template: `
            <div>
                <form method="post" v-bind:action="this.$root.update_action" @submit.prevent="createEditForm">
                    <div class="form-group">
                        <label>Name</label>
                        <input class="form-control" v-model="item.name">
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <input class="form-control" v-model="item.description">
                    </div>
                    <div class="form-group">
                        <label>Image</label>
                        <input class="form-control" v-model.trim="item.image">
                    </div>
                    <div class="form-group">
                        <label>Item Type</label>
                        <select class="custom-select" v-model.number.trim="item.type" required>
                            <option value="1">Balance</option>
                            <option value="2">Balance (Point)</option>
                            <option value="3">Silk</option>
                            <option value="4">Silk (Gift)</option>
                            <option value="5">Silk (Point)</option>
                            <option value="6">Item</option>
                        </select>
                    </div>
                    <div class="form-group" v-show="IsItItem">
                        <label>Codename</label>
                        <input class="form-control" v-model.number.trim="item.codename">
                    </div>
                    <div class="form-group" v-show="!IsItBalance">
                        <label>Amount</label>
                        <input class="form-control" v-model.number.trim="item.amount">
                    </div>
                    <div class="form-group" v-show="!IsItBalance && IsItItem">
                        <label>Plus</label>
                        <input class="form-control" v-model.number.trim="item.plus">
                    </div>
                    <div class="form-group" v-show="IsItBalance">
                        <label>Balance</label>
                        <input class="form-control" v-model.number.trim="item.balance">
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <div class="row col-12">
                            <div class="custom-control custom-radio custom-control-inline">
                                <input id="item_enabled_true" class="custom-control-input" type="radio" v-model="item.enabled" value="1">
                                <label for="item_enabled_true" class="custom-control-label">Enabled</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input id="item_enabled_false" class="custom-control-input" type="radio" v-model="item.enabled" value="0">
                                <label for="item_enabled_false" class="custom-control-label">Disabled</label>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-falcon-primary" :disabled="IsBeingUpdated">
                        <template v-if="IsItCreateForm">
                        Create
                        </template>
                        <template v-else>
                        Update
                        </template>
                    </button>
                    <button type="button" class="btn btn-falcon-danger" @click="deleteItem(item)" v-show="!IsItCreateForm" :disabled="IsBeingDeleted">Delete</button>
                </form>
            </div>
        `,
        methods: {
            createEditForm(event) {
                $('.content').block();
                this.IsBeingUpdated = true;

                axios.post(event.target.action, this.item)
                .then(response => {
                    if (this.IsItCreateForm) {
                        this.$root.items.push(response.data.item);
                    }

                    swal.fire({
                        title: response.data.title,
                        html: response.data.message,
                        icon: response.data.icon
                    });
                })
                .catch(error => {
                    var errors = '<ul class="list-unstyled">';
                    jQuery.each(error.response.data.errors, function (key, value) {
                        errors += '<li>';
                        errors += value;
                        errors += '</li>';
                    });
                    errors += '</ul>';
                    swal.fire({
                        icon: 'error',
                        title: error.response.data.message,
                        html: errors
                    });
                })
                .finally(() => {
                    $('.content').unblock();
                    this.IsBeingUpdated = false;
                });
            },

            deleteItem(itemToDelete) {
                $('.content').block();
                this.IsBeingDeleted = true;

                axios.post(this.$root.destroy_action, {
                    id: this.item.id
                }).then(response => {
                    this.$root.items.splice(this.$root.items.indexOf(itemToDelete), 1);
                    this.$root.selecteditem = '';
                    swal.fire({
                        title: response.data.title,
                        html: response.data.message,
                        icon: response.data.icon
                    });
                })
                .catch(error => {
                    var errors = '<ul class="list-unstyled">';
                    jQuery.each(error.response.data.errors, function (key, value) {
                        errors += '<li>';
                        errors += value;
                        errors += '</li>';
                    });
                    errors += '</ul>';
                    swal.fire({
                        icon: 'error',
                        title: error.response.data.message,
                        html: errors
                    });
                })
                .finally(() => {
                    $('.content').unblock();
                    this.IsBeingDeleted = false;
                });
            }
        }
    });

    new Vue({
        el: '#content',
        data: {
            form: new Form({
                name: @json($itemgroup->name),
                categories: @json($itemgroup->categories->map(function ($category) { return $category->id; })),
                description: @json($itemgroup->description),
                image: @json($itemgroup->image),
                payment_type: @json($itemgroup->payment_type ?? 1),
                on_sale: @json($itemgroup->on_sale ?? 0),
                price: @json($itemgroup->price),
                price_before: @json($itemgroup->price_before),
                limit_total_purchases: @json($itemgroup->limit_total_purchases ?? 0),
                total_purchase_limit: @json($itemgroup->total_purchase_limit),
                limit_user_purchases: @json($itemgroup->limit_user_purchases ?? 0),
                user_purchase_limit: @json($itemgroup->user_purchase_limit),
                use_customized_referral_options: @json($itemgroup->use_customized_referral_options ?? 0),
                referral_commission_enabled: @json($itemgroup->referral_commission_enabled ?? setting('referrals.commissions_enabled', 0)),
                referral_commission_reward_type: @json($itemgroup->referral_commission_reward_type ?? setting('referrals.commission_reward_type', 2)),
                referral_commission_percentage: @json($itemgroup->referral_commission_percentage ?? setting('referrals.commission_earned_percentage', 2)),
                use_customized_point_options: @json($itemgroup->use_customized_point_options ?? 0),
                reward_point_enabled: @json($itemgroup->reward_point_enabled ?? 1),
                reward_point_type: @json($itemgroup->reward_point_type ?? 2),
                reward_point_percentage: @json($itemgroup->reward_point_percentage ?? setting('itemmall.pointrewards.percentage', 2)),
                featured: @json($itemgroup->featured ?? 0),
                order: @json($itemgroup->order ?? 1),
                enabled: @json($itemgroup->enabled ?? 1),
                available_after: @json($itemgroup->available_after),
                available_until: @json($itemgroup->available_until),
            }),
            mode: '1'
        },

        methods: {
            onSubmit() {
                this.form.patch(event.target.action);
            },
            onDelete() {
                this.form.delete(event.target.action)
                .then(response => {
                    window.location = @json(route('admin.itemmall.itemgroups.index'))
                });
            }
        }
    });

    new Vue({
        el: '#itemgroup_items',
        data: {
            items: [],
            selecteditem: '',
            update_action: @json(route('admin.itemmall.itemgroups.items.update')),
            destroy_action: @json(route('admin.itemmall.itemgroups.items.destroy'))
        },

        mounted() {
            this.items = @json($itemgroup->items)
        }
    });
</script>
@endsection
