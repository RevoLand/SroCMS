@extends('layout')

@section('pagetitle', 'User: ' . $user->getName())

@section('content')
<div class="card mb-3">
    <div class="card-body position-relative">
        <div class="row">
            <div class="col-lg-9">
                @isset($user->gravatar)
                <div class="avatar avatar-5xl">
                    <img class="rounded-circle img-thumbnail shadow-sm" src="{{ $user->gravatar }}" alt="">
                </div>
                @endisset
                <h4 class="mb-1">
                    {{ $user->getName() }}
                </h4>
                <h5 class="fs-0 font-weight-normal">{{ $user->Email }}</h5>
                <p class="text-500">{{ $user->StrUserID }}</p>
                <a class="btn btn-falcon-primary btn-sm px-3" type="button" href="{{ route('users.show_user', $user) }}">Profile</a>
                <a class="btn btn-falcon-default btn-sm px-3 ml-2" type="button">Edit</a>
                {{-- TODO: Open a modal? --}}
                <a class="btn btn-falcon-danger btn-sm px-3 ml-2" type="button">Quick Ban</a>
                <hr class="border-dashed my-4 d-lg-none">
            </div>
            <div class="col-lg-3 pl-lg-3 fs--1 align-self-center">
                <ul class="list-group shadow-sm list-group-flush">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Balance <span>{{ number_format($user->balance->balance, 2) }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Balance (Point) <span>{{ number_format($user->balance->balance_point, 2) }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Silk <span>{{ $user->silk->silk_own }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Silk (Gift) <span>{{ $user->silk->silk_gift }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Silk (Point) <span>{{ $user->silk->silk_point }}</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
{{-- account totals? --}}
<div class="card-deck">
    <div class="card mb-3">
        <div class="bg-holder bg-card" style="background-image:url({{ Theme::url('img/illustrations/corner-1.png') }});"></div>
        <div class="card-body position-relative">
            <h6>Orders</h6>
            <div class="display-4 fs-4 mb-2 font-weight-normal text-sans-serif text-success">
                {{ $orderCount }}
            </div>
            <a class="font-weight-semi-bold fs--1 text-nowrap" href="{{ route('admin.itemmall.index', ['user_id' => $user]) }}">
                See all<span class="fas fa-angle-right ml-1" data-fa-transform="down-1"></span>
            </a>
        </div>
    </div>
    <div class="card mb-3">
        <div class="bg-holder bg-card" style="background-image:url({{ Theme::url('img/illustrations/corner-3.png') }});"></div>
        <div class="card-body position-relative">
            <h6>Referrals</h6>
            <div class="display-4 fs-4 mb-2 font-weight-normal text-sans-serif text-info">
                {{ $referralCount }}
            </div>
            {{-- TODO: Referrals index --}}
            <a class="font-weight-semi-bold fs--1 text-nowrap" href="#!">
                See all<span class="fas fa-angle-right ml-1" data-fa-transform="down-1"></span>
            </a>
        </div>
    </div>
    <div class="card mb-3">
        <div class="bg-holder bg-card" style="background-image:url({{ Theme::url('img/illustrations/corner-4.png') }});"></div>
        <div class="card-body position-relative">
            <h6>E-Pins Used</h6>
            <div class="display-4 fs-4 mb-2 font-weight-normal text-sans-serif text-warning">
                {{ $epinCount }}
            </div>
            <a class="font-weight-semi-bold fs--1 text-nowrap" href="{{ route('admin.epins.index', ['user_id' => $user]) }}">
                See all<span class="fas fa-angle-right ml-1" data-fa-transform="down-1"></span>
            </a>
        </div>
    </div>
    <div class="card mb-3">
        <div class="bg-holder bg-card" style="background-image:url({{ Theme::url('img/illustrations/corner-2.png') }});"></div>
        <div class="card-body position-relative">
            <div class="row h-100 justify-content-between no-gutters">
                <div class="col-5 col-sm-6 col-xxl pr-2">
                    <h6 class="mt-1">Vote Info</h6>
                    <div class="fs--2 mt-3">
                        <div class="d-flex flex-between-center mb-1">
                            <div class="d-flex align-items-center">
                                <span class="dot bg-primary"></span><span class="font-weight-semi-bold">Completed Votes: {{ $voteInfo->completed }}</span>
                            </div>
                        </div>
                        <div class="d-flex flex-between-center mb-1">
                            <div class="d-flex align-items-center">
                                <span class="dot bg-success"></span><span class="font-weight-semi-bold">Uncompleted Votes: {{ $voteInfo->uncompleted }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-auto">
                    <div class="echart-doughnut"></div>
                    <div class="absolute-centered font-weight-medium text-dark fs-2">
                        {{ $voteInfo->total }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="card-deck">
    <div class="card mb-3" id="orders">
        <div class="card-header d-flex justify-content-between">
            Latest Orders
            <span>
                <select class="custom-select custom-select-sm" v-model.number="show_limit">
                    <option>3</option>
                    <option>5</option>
                    <option>10</option>
                    <option>20</option>
                    <option>40</option>
                </select>
            </span>
        </div>
        <div class="card-body position-relative">
            <div class="table-responsive">
                <table class="table table-hover table-sm fs--1">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Items</th>
                            <th scope="col" class="white-space-nowrap">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="order in filteredOrders">
                            <th scope="row">@{{ order.id }}</th>
                            <td class="fs--2">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item d-flex justify-content-between align-content-center" v-for="item in order.items">
                                        <span class="badge badge-soft-primary">@{{ item.quantity }}</span>
                                        @{{ item.itemgroup.name }}
                                        <span class="badge badge-soft-primary">@{{ item.total_paid }} @{{ item.type_name }}</span>
                                    </li>
                                </ul>
                            </td>
                            <td class="white-space-nowrap">@{{ order.created_at }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="card mb-3" id="votes">
        <div class="card-header d-flex justify-content-between">
            Latest Votes
            <span>
                <select class="custom-select custom-select-sm" v-model.number="show_limit">
                    <option>3</option>
                    <option>5</option>
                    <option>10</option>
                    <option>20</option>
                    <option>40</option>
                </select>
            </span>
        </div>
        <div class="card-body position-relative">
            <div class="table-responsive">
                <table class="table table-hover table-sm fs--1">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Provider</th>
                            <th scope="col">Reward</th>
                            <th scope="col">Voted</th>
                            <th scope="col" class="white-space-nowrap">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="vote in filteredVotes">
                            <th scope="row" v-text="vote.id"></th>
                            <td><a :href="getProviderUrl(vote.vote_provider_id)" v-text="vote.vote_provider.name"></a></td>
                            <td><a :href="getRewardGroupUrl(vote.selected_reward_group_id)" v-text="vote.rewardgroup.name"></a></td>
                            <td><template v-if="vote.voted"><label class="badge badge-soft-primary">Yes</label></template><template v-else><label class="badge badge-soft-warning">No</label></template></td>
                            <td class="white-space-nowrap" v-text="vote.created_at"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="card mb-3" id="referrals">
        <div class="card-header d-flex justify-content-between">
            Latest Referrals
            <span>
                <select class="custom-select custom-select-sm" v-model.number="show_limit">
                    <option>3</option>
                    <option>5</option>
                    <option>10</option>
                    <option>20</option>
                    <option>40</option>
                </select>
            </span>
        </div>
        <div class="card-body position-relative">
            <div class="table-responsive">
                <table class="table table-hover table-sm fs--1">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col" class="white-space-nowrap">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="referral in filteredReferrals">
                            <th scope="row" v-text="referral.id"></th>
                            <td><a :href="getUserUrl(referral.user.JID)">@{{ referral.user.Name || referral.user.StrUserID }}</a></td>
                            <td class="white-space-nowrap" v-text="referral.created_at"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="row no-gutters">
    <div class="col-lg-8 pr-lg-2">
        .a.
    </div>
    <div class="col-lg-4 pl-lg-2">
        .b.
    </div>
</div>
@endsection

@section('js')
<script src="{{ asset('vendor/vue/vue.js') }}"></script>
<script src="{{ asset('vendor/axios.min.js') }}"></script>
{!! Theme::js('lib/echarts/echarts.min.js') !!}

<script>
    var ordersVue = new Vue({
        el: '#orders',
        data: {
            orders: '',
            show_limit: 3
        },
        computed: {
            filteredOrders() {
                return _.take(this.orders, this.show_limit);
            }
        },
        mounted() {
            this.orders = @json($user->orders);
        }
    });

    var votesVue = new Vue({
        el: '#votes',
        data: {
            votes: '',
            show_limit: 3
        },
        mounted() {
            this.votes = @json($user->voteLogs);
        },
        computed: {
            filteredVotes() {
                return _.take(this.votes, this.show_limit);
            }
        },
        methods: {
            getProviderUrl(providerId) {
                return route('admin.votes.providers.show', providerId);
            },
            getRewardGroupUrl(rewardGroupId) {
                return route('admin.votes.rewardgroups.show', rewardGroupId);
            }
        },
    })

    var referralsVue = new Vue({
        el: '#referrals',
        data: {
            referrals: '',
            show_limit: 3
        },
        computed: {
            filteredReferrals(){
                return _.take(this.referrals, this.show_limit);
            }
        },
        mounted() {
            this.referrals = @json($user->referrals);
        },
        methods: {
            getUserUrl(userJID) {
                return route('admin.users.show', userJID);
            }
        },
    });
</script>

<script>
    var $voteInfoChart = document.querySelector('.echart-doughnut');
    if ($voteInfoChart) {
        var _voteinfochart = window.echarts.init($voteInfoChart);
        _voteinfochart.setOption({
            color: [utils.colors.primary, utils.colors.success],
            tooltip: {
                trigger: 'item',
                padding: [7, 10],
                backgroundColor: utils.grays.white,
                textStyle: {
                    color: utils.grays.black
                },
                transitionDuration: 0,
                borderColor: utils.grays['300'],
                borderWidth: 1,
                formatter: function formatter(params) {
                    return "<strong>" + params.data.name + ":</strong> " + params.percent + "%";
                }
            },
            position: function position(pos, params, dom, rect, size) {
                return getPosition(pos, params, dom, rect, size);
            },
            legend: {
                show: false
            },
            series: [{
                type: 'pie',
                radius: ['100%', '87%'],
                avoidLabelOverlap: false,
                hoverAnimation: false,
                itemStyle: {
                    borderWidth: 2,
                    borderColor: utils.grays.white
                },
                label: {
                    normal: {
                        show: false,
                        position: 'center',
                        textStyle: {
                            fontSize: '20',
                            fontWeight: '500',
                            color: utils.grays['700']
                        }
                    },
                    emphasis: {
                        show: false
                    }
                },
                labelLine: {
                    normal: {
                        show: false
                    }
                },
                data: [
                    {
                        value: @json($voteInfo->completed),
                        name: 'Completed Votes'
                    },
                    {
                        value: @json($voteInfo->uncompleted),
                        name: 'Uncompleted Votes'
                    }
                ]
            }]
        });
    };
</script>
@endsection
