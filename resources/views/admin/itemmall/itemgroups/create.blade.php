@extends('layout')

@section('pagetitle', 'Create Item Group')

@section('content')
<div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
    <!-- begin:: Subheader -->
    <div class="kt-subheader   kt-grid__item" id="kt_subheader">
        <div class="kt-container  kt-container--fluid ">
            <div class="kt-subheader__main">
                <h3 class="kt-subheader__title">Create Item Group</h3>
                <span class="kt-subheader__separator kt-hidden"></span>
                <div class="kt-subheader__breadcrumbs">
                    <a href="{{ route('admin.dashboard.index') }}" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
                    <span class="kt-subheader__breadcrumbs-separator"></span>
                    {{-- TODO: Index linki neresi olmalı? --}}
                    <a href="{{ route('admin.itemmall.categories.index') }}" class="kt-subheader__breadcrumbs-link">Web Item Mall</a>
                    <span class="kt-subheader__breadcrumbs-separator"></span>
                    <a href="{{ route('admin.itemmall.itemgroups.index') }}" class="kt-subheader__breadcrumbs-link">Item Groups</a>
                    <span class="kt-subheader__breadcrumbs-separator"></span>
                    <a href="{{ route('admin.itemmall.itemgroups.create') }}" class="kt-subheader__breadcrumbs-link kt-subheader__breadcrumbs-link--active">Create</a>
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

        <div class="kt-portlet kt-portlet--mobile">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title">
                        Create Item Group
                    </h3>
                </div>
                <div class="kt-portlet__head-toolbar">
                    <div class="kt-portlet__head-actions">
                        <a href="{{ route('admin.itemmall.itemgroups.index') }}" class="btn btn-primary btn-upper btn-sm btn-bold">
                            <i class="la la-copy"></i> List Item Groups
                        </a>
                    </div>
                </div>
            </div>
            <div class="kt-portlet__body">
                {{ Form::open(['route' => ['admin.itemmall.itemgroups.store'], 'class' => 'kt-form', 'method' => 'post']) }}
                    <div class="form-group">
                        <label>Name</label>
                        {{ Form::text('name', old('name'), ['class' => 'form-control', 'required']) }}
                    </div>
                    <div class="form-group">
                        <label>Categories</label>
                        <select class="form-control select2" name="categories[]" multiple="multiple" required>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" @if(in_array($category->id, old('categories', []))) selected @endif>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        {{ Form::text('description', old('description'), ['class' => 'form-control']) }}
                    </div>
                    <div class="form-group">
                        <label>Image URL</label>
                        {{ Form::text('image', old('image'), ['class' => 'form-control']) }}
                    </div>
                    <div class="form-group">
                        <label>Payment Type</label>
                        <select class="form-control select2" name="payment_type" data-placeholder="Select a reward type" required>
                            <option></option>
                            <option value="1" @if(old('payment_type') == 1) selected @endif>Balance</option>
                            <option value="2" @if(old('payment_type') == 2) selected @endif>Balance (Point)</option>
                            <option value="3" @if(old('payment_type') == 3) selected @endif>Silk</option>
                            <option value="4" @if(old('payment_type') == 4) selected @endif>Silk (Gift)</option>
                            <option value="5" @if(old('payment_type') == 5) selected @endif>Silk (Point)</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Price</label>
                        {{ Form::text('price', old('price'), ['class' => 'form-control']) }}
                    </div>
                    <div class="form-group">
                        <label>On Sale</label>
                        <div class="kt-radio-inline">
                            <label class="kt-radio">
                                {!! Form::radio('on_sale', 1, old('on_sale', false)) !!} Yes
                                <span></span>
                            </label>
                            <label class="kt-radio">
                                {!! Form::radio('on_sale', 0, !old('on_sale', false)) !!} No
                                <span></span>
                            </label>
                        </div>
                    </div>
                    <div class="form-group old-price">
                        <label>Old Price</label>
                        {{ Form::text('price_before', old('price_before'), ['class' => 'form-control']) }}
                        <span class="form-text text-muted">
                            Only effects visually.
                        </span>
                    </div>
                    <div class="form-group">
                        <label>Limit Total Purchases</label>
                        <div class="kt-radio-inline">
                            <label class="kt-radio">
                                {!! Form::radio('limit_total_purchases', 1, old('limit_total_purchases', false)) !!} Yes
                                <span></span>
                            </label>
                            <label class="kt-radio">
                                {!! Form::radio('limit_total_purchases', 0, !old('limit_total_purchases', false)) !!} No
                                <span></span>
                            </label>
                        </div>
                    </div>
                    <div class="form-group total-purchase-limit">
                        <label>Total Purchase Limit</label>
                        {{ Form::text('total_purchase_limit', old('total_purchase_limit'), ['class' => 'form-control']) }}
                    </div>
                    <div class="form-group">
                        <label>Limit User Purchases</label>
                        <div class="kt-radio-inline">
                            <label class="kt-radio">
                                {!! Form::radio('limit_user_purchases', 1, old('limit_user_purchases', false)) !!} Yes
                                <span></span>
                            </label>
                            <label class="kt-radio">
                                {!! Form::radio('limit_user_purchases', 0, !old('limit_user_purchases', false)) !!} No
                                <span></span>
                            </label>
                        </div>
                    </div>
                    <div class="form-group user-purchase-limit">
                        <label>User Purchase Limit</label>
                        {{ Form::text('user_purchase_limit', old('user_purchase_limit'), ['class' => 'form-control']) }}
                    </div>
                    <div class="form-group">
                        <label>Use Customized Referral Options</label>
                        <div class="kt-radio-inline">
                            <label class="kt-radio">
                                {!! Form::radio('use_customized_referral_options', 1, old('use_customized_referral_options', false), ['id' => 'use_customized_referral_options']) !!} Yes
                                <span></span>
                            </label>
                            <label class="kt-radio">
                                {!! Form::radio('use_customized_referral_options', 0, !old('use_customized_referral_options', false), ['id' => 'use_customized_referral_options']) !!} No
                                <span></span>
                            </label>
                        </div>
                    </div>
                    <div class="form-group referral-commission">
                        <label>Referral Commission</label>
                        <div class="kt-radio-inline">
                            <label class="kt-radio">
                                {!! Form::radio('referral_commission_enabled', 1, old('referral_commission_enabled', true)) !!} Enabled
                                <span></span>
                            </label>
                            <label class="kt-radio">
                                {!! Form::radio('referral_commission_enabled', 0, !old('referral_commission_enabled', true)) !!} Disabled
                                <span></span>
                            </label>
                        </div>
                    </div>
                    {{-- SELECT2 --}}
                    <div class="form-group referral-reward-type">
                        <label>Referral Commission Reward Type</label>
                        <select class="form-control select2" id="referral_commission_reward_type" name="referral_commission_reward_type" data-placeholder="Select a reward type">
                            <option></option>
                            <option value="1" @if(old('referral_commission_reward_type') == 1) selected @endif>Balance</option>
                            <option value="2" @if(old('referral_commission_reward_type') ?? 2 == 2) selected @endif>Balance (Point)</option>
                            <option value="3" @if(old('referral_commission_reward_type') == 3) selected @endif>Silk</option>
                            <option value="4" @if(old('referral_commission_reward_type') == 4) selected @endif>Silk (Gift)</option>
                            <option value="5" @if(old('referral_commission_reward_type') == 5) selected @endif>Silk (Point)</option>
                        </select>
                    </div>
                    <div class="form-group referral-reward-percentage">
                        <label>Referral Commission Reward Percentage</label>
                        {{ Form::text('referral_commission_percentage', old('referral_commission_percentage') ?? 1, ['class' => 'form-control']) }}
                    </div>
                    <div class="form-group">
                        <label>Use Customized Point Options</label>
                        <div class="kt-radio-inline">
                            <label class="kt-radio">
                                {!! Form::radio('use_customized_point_options', 1, old('use_customized_point_options', false), ['id' => 'use_customized_point_options']) !!} Yes
                                <span></span>
                            </label>
                            <label class="kt-radio">
                                {!! Form::radio('use_customized_point_options', 0, !old('use_customized_point_options', false), ['id' => 'use_customized_point_options']) !!} No
                                <span></span>
                            </label>
                        </div>
                    </div>
                    <div class="form-group reward-point">
                        <label>Reward for Purchase</label>
                        <div class="kt-radio-inline">
                            <label class="kt-radio">
                                {!! Form::radio('reward_point_enabled', 1, old('reward_point_enabled', true)) !!} Enabled
                                <span></span>
                            </label>
                            <label class="kt-radio">
                                {!! Form::radio('reward_point_enabled', 0, !old('reward_point_enabled', true)) !!} Disabled
                                <span></span>
                            </label>
                        </div>
                    </div>
                    {{-- SELECT2 --}}
                    <div class="form-group reward-point-type">
                        <label>Reward Type</label>
                        <select class="form-control select2" id="reward_point_type" name="reward_point_type" data-placeholder="Select a reward type">
                            <option></option>
                            <option value="1" @if(old('reward_point_type') == 1) selected @endif>Balance</option>
                            <option value="2" @if(old('reward_point_type') ?? 2 == 2) selected @endif>Balance (Point)</option>
                            <option value="3" @if(old('reward_point_type') == 3) selected @endif>Silk</option>
                            <option value="4" @if(old('reward_point_type') == 4) selected @endif>Silk (Gift)</option>
                            <option value="5" @if(old('reward_point_type') == 5) selected @endif>Silk (Point)</option>
                        </select>
                    </div>
                    <div class="form-group reward-point-percentage">
                        <label>Reward Percentage</label>
                        {{ Form::text('reward_point_percentage', old('reward_point_percentage') ?? 1, ['class' => 'form-control']) }}
                    </div>
                    <div class="form-group">
                        <label>Featured</label>
                        <div class="kt-radio-inline">
                            <label class="kt-radio">
                                {!! Form::radio('featured', 1, old('featured', false)) !!} Yes
                                <span></span>
                            </label>
                            <label class="kt-radio">
                                {!! Form::radio('featured', 0, !old('featured', false)) !!} No
                                <span></span>
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Sort Order</label>
                        {{ Form::text('order', old('order') ?? 1, ['class' => 'form-control']) }}
                    </div>
                    <div class="form-group">
                        <label>Available After</label>
                        {{ Form::text('available_after', old('available_after'), ['class' => 'form-control dtpicker']) }}
                    </div>
                    <div class="form-group">
                        <label>Available Until</label>
                        {{ Form::text('available_until', old('available_until'), ['class' => 'form-control dtpicker']) }}
                    </div>
                    <div class="form-group">
                        <label>State</label>
                        <div class="kt-radio-inline">
                            <label class="kt-radio">
                                {!! Form::radio('enabled', 1, old('enabled', true)) !!} Enabled
                                <span></span>
                            </label>
                            <label class="kt-radio">
                                {!! Form::radio('enabled', 0, !old('enabled', true)) !!} Disabled
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
    </div>

    <!-- end:: Content -->
</div>
@endsection

@section('js')
<script type="text/javascript">
    $(document).ready(function() {
        $( ".select2" ).select2({allowClear: true});

        $( ".dtpicker" ).datetimepicker({
            format: 'yyyy-mm-dd hh:ii',
            autoclose: true,
            todayBtn: true,
            pickerPosition: 'top-right'
        });

        function toggleSaleStatus(newStatus) {
            if (newStatus == 1) {
                $( ".old-price" ).show({});
            } else {
                $( ".old-price" ).hide({});
            }
        };

        function toggleTotalPurchaseLimit(newStatus) {
            if (newStatus == 1) {
                $( ".total-purchase-limit" ).show({});
            } else {
                $( ".total-purchase-limit" ).hide({});
            }
        };

        function toggleUserPurchaseLimit(newStatus) {
            if (newStatus == 1) {
                $( ".user-purchase-limit" ).show({});
            } else {
                $( ".user-purchase-limit" ).hide({});
            }
        };

        function toggleCustomizedReferralOptions(newStatus) {
            if (newStatus == 1) {
                $( ".referral-commission" ).show({});
                $( ".referral-reward-type" ).show({});
                $( ".referral-reward-percentage" ).show({});
            } else {
                $( ".referral-commission" ).hide({});
                $( ".referral-reward-type" ).hide({});
                $( ".referral-reward-percentage" ).hide({});
            }
        };

        function toggleReferralOptions(newStatus) {
            if (newStatus == 1) {
                $( ".referral-reward-type" ).show({});
                $( ".referral-reward-percentage" ).show({});
            } else {
                $( ".referral-reward-type" ).hide({});
                $( ".referral-reward-percentage" ).hide({});
            }
        };

        function toggleCustomizedPointOptions(newStatus) {
            if (newStatus == 1) {
                $( ".reward-point" ).show({});
                $( ".reward-point-type" ).show({});
                $( ".reward-point-percentage" ).show({});
            } else {
                $( ".reward-point" ).hide({});
                $( ".reward-point-type" ).hide({});
                $( ".reward-point-percentage" ).hide({});
            }
        };
        function togglePointOptions(newStatus) {
            if (newStatus == 1) {
                $( ".reward-point-type" ).show({});
                $( ".reward-point-percentage" ).show({});
            } else {
                $( ".reward-point-type" ).hide({});
                $( ".reward-point-percentage" ).hide({});
            }
        };

        $( "input[name='on_sale']" ).change(function() {
            toggleSaleStatus(this.value);
        });

        $( "input[name='limit_total_purchases']" ).change(function() {
            toggleTotalPurchaseLimit(this.value);
        });

        $( "input[name='limit_user_purchases']" ).change(function() {
            toggleUserPurchaseLimit(this.value);
        });

        $( "input[name='use_customized_referral_options']" ).change(function() {
            toggleCustomizedReferralOptions(this.value);
        });

        $( "input[name='referral_commission_enabled']" ).change(function() {
            toggleReferralOptions(this.value);
        });

        $( "input[name='use_customized_point_options']" ).change(function() {
            toggleCustomizedPointOptions(this.value);
        });

        $( "input[name='reward_point_enabled']" ).change(function() {
            togglePointOptions(this.value);
        });

        toggleSaleStatus('{{ old('on_sale') }}');
        toggleTotalPurchaseLimit('{{ old('limit_total_purchases') }}');
        toggleUserPurchaseLimit('{{ old('limit_user_purchases') }}');
        toggleCustomizedReferralOptions('{{ old('use_customized_referral_options') }}');
        toggleReferralOptions('{{ old('referral_commission_enabled') }}');
        toggleCustomizedPointOptions('{{ old('use_customized_point_options') }}');
        togglePointOptions('{{ old('reward_point_enabled') }}');
    });
    </script>
@endsection
