@extends('layout')

@section('pagetitle', 'Edit Item Group')

@section('content')
<div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
    <!-- begin:: Subheader -->
    <div class="kt-subheader   kt-grid__item" id="kt_subheader">
        <div class="kt-container  kt-container--fluid ">
            <div class="kt-subheader__main">
                <h3 class="kt-subheader__title">Edit Item Group</h3>
                <span class="kt-subheader__separator kt-hidden"></span>
                <div class="kt-subheader__breadcrumbs">
                    <a href="{{ route('admin.dashboard.index') }}" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
                    <span class="kt-subheader__breadcrumbs-separator"></span>
                    {{-- TODO: Index linki neresi olmalı? --}}
                    <a href="{{ route('admin.itemmall.categories.index') }}" class="kt-subheader__breadcrumbs-link">Web Item Mall</a>
                    <span class="kt-subheader__breadcrumbs-separator"></span>
                    <a href="{{ route('admin.itemmall.itemgroups.index') }}" class="kt-subheader__breadcrumbs-link">Item Groups</a>
                    <span class="kt-subheader__breadcrumbs-separator"></span>
                    <a href="{{ route('admin.itemmall.itemgroups.edit', $itemgroup) }}" class="kt-subheader__breadcrumbs-link kt-subheader__breadcrumbs-link--active">Edit</a>
                </div>
            </div>
        </div>
    </div>
    <!-- end:: Subheader -->

    <!-- begin:: Content -->
    <div class="kt-container kt-container--fluid  kt-grid__item kt-grid__item--fluid">
        @if (session('message'))
        <div class="row">
            <div class="col">
                <div class="alert alert-light alert-elevate fade show" role="alert">
                    <div class="alert-icon"><i class="la la-check-square kt-font-brand"></i></div>
                    <div class="alert-text">
                        {{ session('message') }}
                    </div>
                </div>
            </div>
        </div>
        @endif
        @if ($errors->any())
        <div class="row">
            <div class="col">
                <div class="alert alert-danger alert-elevate fade show" role="alert">
                    <div class="alert-icon"><i class="la la-warning kt-font-brand"></i></div>
                    <div class="alert-text">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- edit form -->
        <div class="kt-portlet kt-portlet--mobile editform">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title">
                        Edit Item Group: <template v-model="name">@{{ name }}</template>
                    </h3>
                </div>
                <div class="kt-portlet__head-toolbar">
                    <div class="kt-portlet__head-actions">
                        <a href="{{ route('admin.itemmall.itemgroups.create') }}" class="btn btn-primary btn-upper btn-sm btn-bold">
                            <i class="la la-copy"></i> Create Item Group
                        </a>
                        <a href="{{ route('admin.itemmall.itemgroups.index') }}" class="btn btn-accent btn-upper btn-sm btn-bold">
                            <i class="la la-copy"></i> List Item Groups
                        </a>
                    </div>
                </div>
            </div>
            <div class="kt-portlet__body">
                {{ Form::open(['route' => ['admin.itemmall.itemgroups.update', $itemgroup], 'class' => 'kt-form', 'method' => 'patch', '@submit.prevent' => 'onFormSubmit']) }}
                    <div class="form-group">
                        <label>Mode</label>
                        <div class="kt-radio-inline">
                            <label class="kt-radio">
                                {!! Form::radio('mode', 1, null, ['v-model' => 'mode']) !!} Simple
                                <span></span>
                            </label>
                            <label class="kt-radio">
                                {!! Form::radio('mode', 0, null, ['v-model' => 'mode']) !!} Advanced
                                <span></span>
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Name</label>
                        {{ Form::text('name', null, ['class' => 'form-control', 'required', 'v-model' => 'name']) }}
                    </div>
                    <div class="form-group">
                        <label>Categories</label>
                        <select class="form-control select2" name="categories[]" multiple="multiple" v-model="categories" required>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group" v-show="mode == 0">
                        <label>Description</label>
                        {{ Form::text('description', null, ['class' => 'form-control', 'v-model' => 'description']) }}
                    </div>
                    <div class="form-group" v-show="mode == 0">
                        <label>Image URL</label>
                        {{ Form::text('image', null, ['class' => 'form-control', 'v-model.trim' => 'image']) }}
                    </div>
                    <div class="form-group">
                        <label>Payment Type</label>
                        <select class="form-control select2" name="payment_type" v-model="payment_type" required>
                            <option value="1">Balance</option>
                            <option value="2">Balance (Point)</option>
                            <option value="3">Silk</option>
                            <option value="4">Silk (Gift)</option>
                            <option value="5">Silk (Point)</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Price</label>
                        {{ Form::text('price', null, ['class' => 'form-control', 'required', 'v-model.trim' => 'price']) }}
                    </div>
                    <div class="form-group" v-show="mode == 0">
                        <label>On Sale</label>
                        <div class="kt-radio-inline">
                            <label class="kt-radio">
                                {!! Form::radio('on_sale', 1, null, ['v-model' => 'on_sale']) !!} Yes
                                <span></span>
                            </label>
                            <label class="kt-radio">
                                {!! Form::radio('on_sale', 0, null, ['v-model' => 'on_sale']) !!} No
                                <span></span>
                            </label>
                        </div>
                    </div>
                    <div class="form-group" v-show="on_sale == 1 && mode == 0">
                        <label>Old Price</label>
                        {{ Form::text('price_before', null, ['class' => 'form-control', 'v-model.trim' => 'price_before']) }}
                        <span class="form-text text-muted">
                            Only effects visually.
                        </span>
                    </div>
                    <div class="form-group" v-show="mode == 0">
                        <label>Limit Total Purchases</label>
                        <div class="kt-radio-inline">
                            <label class="kt-radio">
                                {!! Form::radio('limit_total_purchases', 1, null, ['v-model' => 'limit_total_purchases']) !!} Yes
                                <span></span>
                            </label>
                            <label class="kt-radio">
                                {!! Form::radio('limit_total_purchases', 0, null, ['v-model' => 'limit_total_purchases']) !!} No
                                <span></span>
                            </label>
                        </div>
                    </div>
                    <div class="form-group" v-show="limit_total_purchases == 1 && mode == 0">
                        <label>Total Purchase Limit</label>
                        {{ Form::text('total_purchase_limit', null, ['class' => 'form-control', 'v-model.trim' => 'total_purchase_limit']) }}
                    </div>
                    <div class="form-group" v-show="mode == 0">
                        <label>Limit User Purchases</label>
                        <div class="kt-radio-inline">
                            <label class="kt-radio">
                                {!! Form::radio('limit_user_purchases', 1, null, ['v-model' => 'limit_user_purchases']) !!} Yes
                                <span></span>
                            </label>
                            <label class="kt-radio">
                                {!! Form::radio('limit_user_purchases', 0, null, ['v-model' => 'limit_user_purchases']) !!} No
                                <span></span>
                            </label>
                        </div>
                    </div>
                    <div class="form-group" v-show="limit_user_purchases == 1 && mode == 0">
                        <label>User Purchase Limit</label>
                        {{ Form::text('user_purchase_limit', null, ['class' => 'form-control', 'v-model.trim' => 'user_purchase_limit']) }}
                    </div>
                    <div class="form-group" v-show="mode == 0">
                        <label>Use Customized Referral Options</label>
                        <div class="kt-radio-inline">
                            <label class="kt-radio">
                                {!! Form::radio('use_customized_referral_options', 1, null, ['v-model' => 'use_customized_referral_options']) !!} Yes
                                <span></span>
                            </label>
                            <label class="kt-radio">
                                {!! Form::radio('use_customized_referral_options', 0, null, ['v-model' => 'use_customized_referral_options']) !!} No
                                <span></span>
                            </label>
                        </div>
                    </div>
                    <div class="form-group" v-show="use_customized_referral_options == 1 && mode == 0">
                        <label>Referral Commission</label>
                        <div class="kt-radio-inline">
                            <label class="kt-radio">
                                {!! Form::radio('referral_commission_enabled', 1, null, ['v-model' => 'referral_commission_enabled']) !!} Enabled
                                <span></span>
                            </label>
                            <label class="kt-radio">
                                {!! Form::radio('referral_commission_enabled', 0, null, ['v-model' => 'referral_commission_enabled']) !!} Disabled
                                <span></span>
                            </label>
                        </div>
                    </div>
                    <div class="form-group" v-show="use_customized_referral_options == 1 && referral_commission_enabled == 1 && mode == 0">
                        <label>Referral Commission Reward Type</label>
                        <select class="form-control select2" name="referral_commission_reward_type" data-placeholder="Select a reward type" v-model="referral_commission_reward_type">
                            <option value="1">Balance</option>
                            <option value="2">Balance (Point)</option>
                            <option value="3">Silk</option>
                            <option value="4">Silk (Gift)</option>
                            <option value="5">Silk (Point)</option>
                        </select>
                    </div>
                    <div class="form-group" v-show="use_customized_referral_options == 1 && referral_commission_enabled == 1 && mode == 0">
                        <label>Referral Commission Reward Percentage</label>
                        {{ Form::text('referral_commission_percentage', null, ['class' => 'form-control', 'v-model.trim' => 'referral_commission_percentage']) }}
                    </div>
                    <div class="form-group" v-show="mode == 0">
                        <label>Use Customized Point Options</label>
                        <div class="kt-radio-inline">
                            <label class="kt-radio">
                                {!! Form::radio('use_customized_point_options', 1, null, ['v-model' => 'use_customized_point_options']) !!} Yes
                                <span></span>
                            </label>
                            <label class="kt-radio">
                                {!! Form::radio('use_customized_point_options', 0, null, ['v-model' => 'use_customized_point_options']) !!} No
                                <span></span>
                            </label>
                        </div>
                    </div>
                    <div class="form-group" v-show="use_customized_point_options == 1 && mode == 0">
                        <label>Reward for Purchase</label>
                        <div class="kt-radio-inline">
                            <label class="kt-radio">
                                {!! Form::radio('reward_point_enabled', 1, null, ['v-model' => 'reward_point_enabled']) !!} Enabled
                                <span></span>
                            </label>
                            <label class="kt-radio">
                                {!! Form::radio('reward_point_enabled', 0, null, ['v-model' => 'reward_point_enabled']) !!} Disabled
                                <span></span>
                            </label>
                        </div>
                    </div>
                    <div class="form-group" v-show="use_customized_point_options == 1 && reward_point_enabled == 1 && mode == 0">
                        <label>Reward Type</label>
                        <select class="form-control select2" name="reward_point_type" data-placeholder="Select a reward type" v-model="reward_point_type">
                            <option value="1">Balance</option>
                            <option value="2">Balance (Point)</option>
                            <option value="3">Silk</option>
                            <option value="4">Silk (Gift)</option>
                            <option value="5">Silk (Point)</option>
                        </select>
                    </div>
                    <div class="form-group" v-show="use_customized_point_options == 1 && reward_point_enabled == 1 && mode == 0">
                        <label>Reward Percentage</label>
                        {{ Form::text('reward_point_percentage', null, ['class' => 'form-control', 'v-model.trim' => 'reward_point_percentage']) }}
                    </div>
                    <div class="form-group" v-show="mode == 0">
                        <label>Featured</label>
                        <div class="kt-radio-inline">
                            <label class="kt-radio">
                                {!! Form::radio('featured', 1, null, ['v-model' => 'featured']) !!} Yes
                                <span></span>
                            </label>
                            <label class="kt-radio">
                                {!! Form::radio('featured', 0, null, ['v-model' => 'featured']) !!} No
                                <span></span>
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Sort Order</label>
                        {{ Form::text('order', null, ['class' => 'form-control', 'v-model.trim' => 'order']) }}
                    </div>
                    <div class="form-group" v-show="mode == 0">
                        <label>Available After</label>
                        {{ Form::text('available_after', null, ['class' => 'form-control dtpicker', 'v-model' => 'available_after']) }}
                    </div>
                    <div class="form-group" v-show="mode == 0">
                        <label>Available Until</label>
                        {{ Form::text('available_until', null, ['class' => 'form-control dtpicker', 'v-model' => 'available_until']) }}
                    </div>
                    <div class="form-group">
                        <label>State</label>
                        <div class="kt-radio-inline">
                            <label class="kt-radio">
                                {!! Form::radio('enabled', 1, null, ['v-model'=> 'enabled']) !!} Enabled
                                <span></span>
                            </label>
                            <label class="kt-radio">
                                {!! Form::radio('enabled', 0, null, ['v-model'=> 'enabled']) !!} Disabled
                                <span></span>
                            </label>
                        </div>
                    </div>
                    <div class="kt-portlet__foot">
                        <div class="kt-form__actions">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <button type="reset" class="btn btn-secondary">Cancel</button>
                        </div>
                    </div>
                {{ Form::close() }}
            </div>
        </div>
        <!-- /edit form -->

        <div class="row itemgroup_items">
            <div class="col-xl-6">
                <!--begin::Portlet-->
                <div class="kt-portlet kt-portlet--height-fluid">
                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                            <span class="kt-portlet__head-icon"><i class="flaticon-stopwatch"></i></span>
                            <h3 class="kt-portlet__head-title">Items</h3>
                        </div>
                    </div>
                    <div class="kt-portlet__body">
                        <div class="kt-portlet__content">
                            <select class="form-control" id="type" name="type" size="10" v-model="selecteditem">
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
                </div>

                <!--end::Portlet-->
            </div>
            <div class="col-xl-6" v-show="selecteditem">
                <!--begin::Portlet-->
                <div class="kt-portlet kt-portlet--height-fluid">
                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                            <h3 class="kt-portlet__head-title">
                                <template v-if="selecteditem.id">
                                    Edit Item
                                </template>
                                <template v-else>
                                    Create Item
                                </template>
                            </h3>
                        </div>
                    </div>
                    <div class="kt-portlet__body">
                        <div class="kt-portlet__content">
                            <item_form v-bind:item="selecteditem"></item_form>
                        </div>
                    </div>
                </div>

                <!--end::Portlet-->
            </div>
        </div>
    </div>

    <!-- end:: Content -->
</div>
@endsection


@section('js')
<script src="{{ asset('vendor/vue/vue.js') }}"></script>
<script src="{{ asset('vendor/axios.min.js') }}"></script>
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
                        <select class="form-control" v-model.number.trim="item.type" required>
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
                        <label>State</label>
                        <div class="kt-radio-inline">
                            <label class="kt-radio">
                                <input type="radio" name="enabled" v-model="item.enabled" value="1"> Enabled
                                <span></span>
                            </label>
                            <label class="kt-radio">
                                <input type="radio" name="enabled" v-model="item.enabled" value="0"> Disabled
                                <span></span>
                            </label>
                        </div>
                    </div>
                    <div class="kt-portlet__foot">
                        <div class="kt-form__actions">
                            <div class="row">
                                <div class="col kt-align-left">
                                    <button type="submit" class="btn btn-primary" :disabled="IsBeingUpdated">
                                        <template v-if="IsItCreateForm">
                                        Create
                                        </template>
                                        <template v-else>
                                        Update
                                        </template>
                                    </button>
                                    <button type="button" class="btn btn-danger" @click="deleteItem(item)" v-show="!IsItCreateForm" :disabled="IsBeingDeleted">Delete</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        `,
        methods: {
            createEditForm(event) {
                KTApp.block('body');
                this.IsBeingUpdated = true;

                axios.post(event.target.action, this.item)
                .then(response => {
                    if (this.IsItCreateForm) {
                        swal.fire( 'Created!', response.data.message, 'success');
                        this.$root.items.push(response.data.item);
                    } else {
                        swal.fire( 'Updated!', response.data.message, 'success');
                    }
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
                        type: 'error',
                        title: error.response.data.message,
                        html: errors
                    });
                })
                .finally(() => {
                    KTApp.unblock('body');
                    this.IsBeingUpdated = false;
                });
            },

            deleteItem(itemToDelete) {
                KTApp.block('body');
                this.IsBeingDeleted = true;

                axios.post(this.$root.destroy_action, {
                    id: this.item.id
                }).then(response => {
                    this.$root.items.splice(this.$root.items.indexOf(itemToDelete), 1);
                    this.$root.selecteditem = '';
                    swal.fire( 'Deleted!', response.data.message, 'success');
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
                        type: 'error',
                        title: error.response.data.message,
                        html: errors
                    });
                })
                .finally(() => {
                    KTApp.unblock('body');
                    this.IsBeingDeleted = false;
                });
            }
        }
    });

    new Vue({
        el: '.editform',
        data: {
            name: '{{ $itemgroup->name }}',
            categories: @json($itemgroup->categories->map(function ($category){ return $category->id; })),
            description: '{{ $itemgroup->description }}',
            image: '{{ $itemgroup->image }}',
            payment_type: '{{ $itemgroup->payment_type ?? 1 }}',
            on_sale: '{{ $itemgroup->on_sale ?? 0 }}',
            price: '{{ $itemgroup->price }}',
            price_before: '{{ $itemgroup->price_before }}',
            limit_total_purchases: '{{ $itemgroup->limit_total_purchases ?? 0 }}',
            total_purchase_limit: '{{ $itemgroup->total_purchase_limit }}',
            limit_user_purchases: '{{ $itemgroup->limit_user_purchases ?? 0 }}',
            user_purchase_limit: '{{ $itemgroup->user_purchase_limit }}',
            use_customized_referral_options: '{{ $itemgroup->use_customized_referral_options ?? 0 }}',
            referral_commission_enabled: '{{ $itemgroup->referral_commission_enabled ?? setting('referrals.commissions_enabled', 0) }}',
            referral_commission_reward_type: '{{ $itemgroup->referral_commission_reward_type ?? setting('referrals.commission_reward_type', 2) }}',
            referral_commission_percentage: '{{ $itemgroup->referral_commission_percentage ?? setting('referrals.commission_earned_percentage', 2) }}',
            use_customized_point_options: '{{ $itemgroup->use_customized_point_options ?? 0 }}',
            reward_point_enabled: '{{ $itemgroup->reward_point_enabled ?? 1 }}',
            reward_point_type: '{{ $itemgroup->reward_point_type ?? 2 }}',
            reward_point_percentage: '{{ $itemgroup->reward_point_percentage ?? setting('itemmall.pointrewards.percentage', 2) }}',
            featured: '{{ $itemgroup->featured ?? 0 }}',
            order: '{{ $itemgroup->order ?? 1 }}',
            enabled: '{{ $itemgroup->enabled ?? 1 }}',
            available_after: '{{ $itemgroup->available_after }}',
            available_until: '{{ $itemgroup->available_until }}',
            mode: '{{ old('mode') ?? 1 }}'
        },

        methods: {
            onFormSubmit: function(event) {
                axios.patch(event.target.action, this.$data)
                .then(function (response) {
                    swal.fire( 'Created!', response.data.message, 'success');
                })
                .catch(function (error) {
                    var errors = '<ul class="list-unstyled">';
                    jQuery.each(error.response.data.errors, function (key, value) {
                        errors += '<li>';
                        errors += value;
                        errors += '</li>';
                    });
                    errors += '</ul>';

                    swal.fire({
                        type: 'error',
                        title: error.response.data.message,
                        html: errors
                    });
                });
            }
        }
    });

    new Vue({
        el: '.itemgroup_items',
        data: {
            items: [],
            selecteditem: '',
            update_action: '{{ route('admin.itemmall.itemgroups.items.update') }}',
            destroy_action: '{{ route('admin.itemmall.itemgroups.items.destroy') }}'
        },

        mounted() {
            this.items = @json($itemgroup->items)
        }
    });
</script>
<script src="{{ asset('vendor/vue/ext/dtpicker.js') }}"></script>
<script src="{{ asset('vendor/vue/ext/select2.js') }}"></script>
@endsection
