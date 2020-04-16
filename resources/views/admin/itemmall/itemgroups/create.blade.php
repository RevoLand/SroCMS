@extends('layout')

@section('pagetitle', 'Create Item Group')

@section('content')
<div class="card mb-3">
    <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="mb-0">Create Item Group</h5>
        <div>
            <a class="btn btn-falcon-info" href="{{ route('admin.itemmall.itemgroups.index') }}">Item Groups</a>
        </div>
    </div>
    <div class="card-body bg-light">
        <div class="row">
            <div class="col-12">
                {{ Form::open(['route' => ['admin.itemmall.itemgroups.store'], 'method' => 'post', '@submit.prevent' => 'onSubmit']) }}
                @include('itemmall.itemgroups.forms.itemgroups')
                <button type="submit" class="btn btn-falcon-primary">Create</button>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
{!! Theme::js('lib/select2/select2.min.js') !!}
{!! Theme::js('lib/flatpickr/flatpickr.min.js') !!}
<script src="{{ asset('vendor/vue/vue.js') }}"></script>
<script src="{{ asset('vendor/vue/ext/flatpickr.js') }}"></script>
<script src="{{ asset('vendor/vue/ext/select2.js') }}"></script>
<script src="{{ asset('vendor/axios.min.js') }}"></script>
<script src="{{ asset('vendor/srocms.js') }}"></script>
<script type="text/javascript">
new Vue({
    el: '.content',
    data: {
        form: new Form({
            name: '',
            categories: [],
            description: '',
            image: '',
            payment_type: '1',
            on_sale: '0',
            price: '',
            price_before: '',
            limit_total_purchases: '0',
            total_purchase_limit: '',
            limit_user_purchases: '0',
            user_purchase_limit: '',
            use_customized_referral_options: '0',
            referral_commission_enabled: @json(setting('referrals.commissions_enabled', 0)),
            referral_commission_reward_type: @json(setting('referrals.commission_reward_type', 2)),
            referral_commission_percentage: @json(setting('referrals.commission_earned_percentage', 2)),
            use_customized_point_options: '0',
            reward_point_enabled: '1',
            reward_point_type: '2',
            reward_point_percentage: @json(setting('itemmall.pointrewards.percentage', 2)),
            featured: '0',
            order: '1',
            enabled: '1',
            available_after: '',
            available_until: ''
        }),
        mode: '1'
    },

    methods: {
        onSubmit() {
            this.form.post(event.target.action)
            .then(response => {
                this.form.reset();
            });
        }
    }
});
</script>
@endsection
