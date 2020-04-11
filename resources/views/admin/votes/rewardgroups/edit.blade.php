@extends('layout')

@section('pagetitle', 'Edit Reward Group')

@section('content')
<div class="card mb-3" id="content">
    <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="mb-0">Edit Reward Group</h5>
        <div>
            <a class="btn btn-falcon-primary mr-2" href="{{ route('admin.votes.rewardgroups.create') }}">Create</a>
            <a class="btn btn-falcon-info" href="{{ route('admin.votes.rewardgroups.index') }}">Reward Groups</a>
        </div>
    </div>
    <div class="card-body bg-light">
        <div class="row">
            <div class="col-12">
                {{ Form::open(['route' => ['admin.votes.rewardgroups.update', $rewardgroup], 'method' => 'patch', '@submit.prevent' => 'onFormSubmit']) }}
                @include('votes.rewardgroups.forms.rewardgroup')
                <div class="btn-group" role="group">
                    <button type="submit" class="btn btn-falcon-primary mr-2">Save</button>
                    {!! Form::close() !!}
                    {!! Form::open([ 'route' => ['admin.votes.rewardgroups.destroy', $rewardgroup], 'method' => 'delete', '@submit.prevent' => 'deleteForm']) !!}
                        <button type="submit" class="btn btn-falcon-danger">Delete</button>
                    {!! Form::close() !!}
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>

<div class="card-deck" id="rewardgroup_rewards">
    <div class="card mb-3">
        <div class="card-header">
            <h5 class="mb-0">Rewards</h5>
        </div>
        <div class="card-body bg-light">
            <div class="row">
                <div class="col-12">
                    <select class="custom-select" id="type" name="type" size="10" v-model="selectedreward">
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
    </div>

    <div class="card mb-3" v-show="selectedreward">
        <div class="card-header">
            <h5 class="mb-0">
                <template v-if="selectedreward.id">
                    Edit Reward
                </template>
                <template v-else>
                    Create Reward
                </template>
            </h5>
        </div>
        <div class="card-body bg-light">
            <div class="row">
                <div class="col-12">
                    <reward_form v-bind:reward="selectedreward"></reward_form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
{!! Theme::js('lib/select2/select2.min.js') !!}
<script src="{{ asset('vendor/vue/vue.js') }}"></script>
<script src="{{ asset('vendor/vue/ext/select2.js') }}"></script>
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
                        <label for="reward_type">Reward Type</label>
                        <select class="custom-select" v-model.number.trim="reward.type" id="reward_type" required>
                            <option value="1">Balance</option>
                            <option value="2">Balance (Point)</option>
                            <option value="3">Silk</option>
                            <option value="4">Silk (Gift)</option>
                            <option value="5">Silk (Point)</option>
                            <option value="6">Item</option>
                        </select>
                    </div>
                    <div class="form-group" v-show="IsItItem">
                        <label for="reward_codename">Codename</label>
                        <input class="form-control" id="reward_codename" v-model.number.trim="reward.codename">
                    </div>
                    <div class="form-group" v-show="!IsItBalance">
                        <label for="reward_amount">Amount</label>
                        <input class="form-control" id="reward_amount" v-model.number.trim="reward.amount">
                    </div>
                    <div class="form-group" v-show="!IsItBalance && IsItItem">
                        <label for="reward_plus">Plus</label>
                        <input class="form-control" id="reward_plus" v-model.number.trim="reward.plus">
                    </div>
                    <div class="form-group" v-show="IsItBalance">
                        <label for="reward_balance">Balance</label>
                        <input class="form-control" id="reward_balance" v-model.number.trim="reward.balance">
                    </div>
                    <div class="form-group">
                        <label>State</label>
                        <div class="row col-12">
                            <div class="custom-control custom-radio custom-control-inline">
                                <input id="reward_enabled_true" class="custom-control-input" type="radio" v-model="reward.enabled" value="1">
                                <label for="reward_enabled_true" class="custom-control-label">Enabled</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input id="reward_enabled_false" class="custom-control-input" type="radio" v-model="reward.enabled" value="0">
                                <label for="reward_enabled_false" class="custom-control-label">Disabled</label>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-falcon-primary mr-2">
                        <template v-if="IsItCreateForm">
                        Create
                        </template>
                        <template v-else>
                        Update
                        </template>
                    </button>
                    <button type="button" class="btn btn-falcon-danger" @click="deleteReward(reward)" v-show="!IsItCreateForm">Delete</button>
                </form>
            </div>
        `,
        methods: {
            createEditForm(event) {
                $('.content').block();
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
                });
            },

            deleteReward(rewardToDelete) {
                $('.content').unblock();

                axios.post(this.$root.destroy_action, {
                    id: this.reward.id
                }).then(response => {
                    this.$root.rewards.splice(this.$root.rewards.indexOf(rewardToDelete), 1);
                    this.$root.selectedreward = '';

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
                });
            }
        }
    });

    new Vue({
        el: '#content',
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
                        icon: response.data.icon
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
                        icon: 'error',
                        title: error.response.data.message,
                        html: errors
                    });
                });
            },
            deleteForm(event) {
                swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (!result.value) {
                        return;
                    }

                    $('.content').block();

                    axios.delete(event.target.action)
                    .then(response => {
                        swal.fire({
                            title: response.data.title,
                            html: response.data.message,
                            icon: response.data.icon
                        }).then((result) => {
                            window.location.href = @json(route('admin.votes.rewardgroups.index'))
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
                            icon: 'error',
                            title: error.response.data.message,
                            html: errors
                        });
                    })
                    .finally(() => {
                        $('.content').unblock();
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
            update_action: @json(route('admin.votes.rewards.update')),
            destroy_action: @json(route('admin.votes.rewards.destroy'))
        },

        mounted() {
            this.rewards = @json($rewardgroup->rewards)
        }
    });
</script>
@endsection
