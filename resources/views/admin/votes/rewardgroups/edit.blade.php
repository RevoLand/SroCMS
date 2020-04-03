@extends('layout')

@section('pagetitle', 'Edit Reward Group')

@section('content')
<div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
    <!-- begin:: Subheader -->
    <div class="kt-subheader   kt-grid__item" id="kt_subheader">
        <div class="kt-container  kt-container--fluid ">
            <div class="kt-subheader__main">
                <h3 class="kt-subheader__title">Edit Reward Group</h3>
                <span class="kt-subheader__separator kt-hidden"></span>
                <div class="kt-subheader__breadcrumbs">
                    <a href="{{ route('admin.dashboard.index') }}" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
                    <span class="kt-subheader__breadcrumbs-separator"></span>
                    <a href="{{ route('admin.votes.index') }}" class="kt-subheader__breadcrumbs-link">Vote System</a>
                    <span class="kt-subheader__breadcrumbs-separator"></span>
                    <a href="{{ route('admin.votes.providers.index') }}" class="kt-subheader__breadcrumbs-link">Vote Providers</a>
                    <span class="kt-subheader__breadcrumbs-separator"></span>
                    <a href="{{ route('admin.votes.rewardgroups.index') }}" class="kt-subheader__breadcrumbs-link">Reward Groups</a>
                    <span class="kt-subheader__breadcrumbs-separator"></span>
                    <a href="{{ route('admin.votes.rewardgroups.edit', $rewardgroup) }}" class="kt-subheader__breadcrumbs-link kt-subheader__breadcrumbs-link--active">Edit</a>
                </div>
            </div>
        </div>
    </div>
    <!-- end:: Subheader -->

    <!-- begin:: Content -->
    <div class="kt-container kt-container--fluid  kt-grid__item kt-grid__item--fluid">
        <div class="kt-portlet kt-portlet--mobile" id="rewardgroup">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title">
                        Vote Provider Reward Group: {{ $rewardgroup->name }}
                    </h3>
                </div>
                <div class="kt-portlet__head-toolbar">
                    <div class="kt-portlet__head-actions">
                        <a href="{{ route('admin.votes.rewardgroups.create') }}" class="btn btn-primary btn-upper btn-sm btn-bold">
                            <i class="la la-copy"></i> Create Reward Group
                        </a>
                        <a href="{{ route('admin.votes.rewardgroups.index') }}" class="btn btn-primary btn-upper btn-sm btn-bold">
                            <i class="la la-copy"></i> List Reward Groups
                        </a>
                    </div>
                </div>
            </div>
            <div class="kt-portlet__body">
                {{ Form::open(['route' => ['admin.votes.rewardgroups.update', $rewardgroup], 'class' => 'kt-form', 'method' => 'patch', '@submit.prevent' => 'onFormSubmit']) }}
                    <div class="form-group">
                        <label>Vote Providers</label>
                        <select class="form-control select2" multiple="multiple" v-model="vote_providers">
                            @foreach($voteProviders as $voteProvider)
                                <option value="{{ $voteProvider->id }}" >{{ $voteProvider->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" v-model="name" required>
                    </div>
                    <div class="form-group">
                        <label>State</label>
                        <div class="kt-radio-inline">
                            <label class="kt-radio">
                                <input type="radio" v-model="enabled" value="1"> Enabled
                                <span></span>
                            </label>
                            <label class="kt-radio">
                                <input type="radio" v-model="enabled" value="0"> Disabled
                                <span></span>
                            </label>
                        </div>
                    </div>
                    <div class="kt-portlet__foot">
                        <div class="kt-form__actions kt-form__actions--right">
                            <div class="row">
                                <div class="col kt-align-left">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                    {!! Form::close() !!}
                                </div>
                                <div class="col kt-align-right">
                                    {!! Form::open([ 'route' => ['admin.votes.rewardgroups.destroy', $rewardgroup], 'method' => 'delete']) !!}
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    {!! Form::close() !!}
                                </div>
                            </div>
                        </div>
                    </div>
                {{ Form::close() }}
            </div>
        </div>

        <div class="row" id="rewardgroup_rewards">
            <div class="col-xl-6">
                <!--begin::Portlet-->
                <div class="kt-portlet kt-portlet--height-fluid">
                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                            <span class="kt-portlet__head-icon"><i class="flaticon-stopwatch"></i></span>
                            <h3 class="kt-portlet__head-title">Rewards</h3>
                        </div>
                    </div>
                    <div class="kt-portlet__body">
                        <div class="kt-portlet__content">
                            <select class="form-control" id="type" name="type" size="10" v-model="selectedreward">
                                <option value="" v-show="false"></option>
                                <option :value="{
                                    vote_provider_reward_group_id: @json($rewardgroup->id),
                                    type: 3,
                                    enabled: 1
                                }">Create New Reward</option>
                                <optgroup label="Existing Rewards">
                                    <option v-for="reward in rewards" :value="reward" v-bind:class="{'alert-danger' : reward.enabled == 0}">
                                        <template v-if="reward.type == 6">
                                            [@{{ reward.amount }}] @{{ reward.codename }} (+@{{ reward.plus }})
                                        </template>
                                        <template v-else-if="reward.type < 6 && reward.type > 2">
                                            [@{{ reward.type_name }}] @{{ reward.amount }}
                                        </template>
                                        <template v-else>
                                            [@{{ reward.type_name }}] @{{ reward.balance }}
                                        </template>
                                    </option>
                                </optgroup>
                            </select>
                        </div>
                    </div>
                </div>

                <!--end::Portlet-->
            </div>
            <div class="col-xl-6" v-show="selectedreward">
                <!--begin::Portlet-->
                <div class="kt-portlet kt-portlet--height-fluid">
                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                            <h3 class="kt-portlet__head-title">
                                <template v-if="selectedreward.id">
                                    Edit Reward
                                </template>
                                <template v-else>
                                    Create Reward
                                </template>
                            </h3>
                        </div>
                    </div>
                    <div class="kt-portlet__body">
                        <div class="kt-portlet__content">
                            <reward_form v-bind:reward="selectedreward"></reward_form>
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
    Vue.component('reward_form', {
        props: ['reward'],
        computed: {
            IsItCreateForm: function () {
                return !(this.reward.id);
            },
            IsItBalance: function () {
                return this.reward.type < 3;
            },
            IsItItem: function() {
                return this.reward.type == 6;
            }
        },
        template: `
            <div>
                <form method="post" v-bind:action="this.$root.update_action" @submit.prevent="createEditForm">
                    <div class="form-group">
                        <label>Reward Type</label>
                        <select class="form-control" v-model.number.trim="reward.type" required>
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
                        <input class="form-control" v-model.number.trim="reward.codename">
                    </div>
                    <div class="form-group" v-show="!IsItBalance">
                        <label>Amount</label>
                        <input class="form-control" v-model.number.trim="reward.amount">
                    </div>
                    <div class="form-group" v-show="!IsItBalance && IsItItem">
                        <label>Plus</label>
                        <input class="form-control" v-model.number.trim="reward.plus">
                    </div>
                    <div class="form-group" v-show="IsItBalance">
                        <label>Balance</label>
                        <input class="form-control" v-model.number.trim="reward.balance">
                    </div>
                    <div class="form-group">
                        <label>State</label>
                        <div class="kt-radio-inline">
                            <label class="kt-radio">
                                <input type="radio" name="enabled" v-model="reward.enabled" value="1"> Enabled
                                <span></span>
                            </label>
                            <label class="kt-radio">
                                <input type="radio" name="enabled" v-model="reward.enabled" value="0"> Disabled
                                <span></span>
                            </label>
                        </div>
                    </div>
                    <div class="kt-portlet__foot">
                        <div class="kt-form__actions">
                            <div class="row">
                                <div class="col kt-align-left">
                                    <button type="submit" class="btn btn-primary">
                                        <template v-if="IsItCreateForm">
                                        Create
                                        </template>
                                        <template v-else>
                                        Update
                                        </template>
                                    </button>
                                    <button type="button" class="btn btn-danger" @click="deleteReward(reward)" v-show="!IsItCreateForm">Delete</button>
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
                axios.post(event.target.action, this.reward)
                .then(response => {
                    if (this.IsItCreateForm) {
                        this.$root.rewards.push(response.data.reward);
                    } else {
                        this.reward.type_name = response.data.type_name;
                    }

                    swal.fire({
                        title: response.data.title,
                        html: response.data.message,
                        type: response.data.type
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
                        type: 'error',
                        title: error.response.data.message,
                        html: errors
                    });
                })
                .finally(() => {
                    KTApp.unblock('body');
                });
            },

            deleteReward(rewardToDelete) {
                KTApp.block('body');

                axios.post(this.$root.destroy_action, {
                    id: this.reward.id
                }).then(response => {
                    this.$root.rewards.splice(this.$root.rewards.indexOf(rewardToDelete), 1);
                    this.$root.selectedreward = '';

                    swal.fire({
                        title: response.data.title,
                        html: response.data.message,
                        type: response.data.type
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
                        type: 'error',
                        title: error.response.data.message,
                        html: errors
                    });
                })
                .finally(() => {
                    KTApp.unblock('body');
                });
            }
        }
    });

    new Vue({
        el: '#rewardgroup',
        data: {
            name: @json($rewardgroup->name),
            enabled: @json($rewardgroup->enabled),
            vote_providers: @json($selectedVoteProviders)
        },

        methods: {
            onFormSubmit: function(event) {
                axios.patch(event.target.action, this.$data)
                .then(function (response) {
                    swal.fire({
                        title: response.data.title,
                        html: response.data.message,
                        type: response.data.type
                    });
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
        el: '#rewardgroup_rewards',
        data: {
            rewards: [],
            selectedreward: '',
            update_action: '{{ route('admin.votes.rewards.update') }}',
            destroy_action: '{{ route('admin.votes.rewards.destroy') }}'
        },

        mounted() {
            this.rewards = @json($rewardgroup->rewards)
        }
    });
</script>
<script src="{{ asset('vendor/vue/ext/select2.js') }}"></script>
@endsection
