@extends('layout')

@section('pagetitle', 'User: ' . $user->getName())

@section('content')
<div class="card mb-3">
    <div class="card-body position-relative">
        <div class="row">
            <div class="col-lg-9">
                @isset($user->gravatar)
                <div class="avatar avatar-5xl">
                    <img class="rounded-circle img-thumbnail shadow-sm" src="{{ $user->gravatar }}?s=256" alt="">
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
                        Silk <span>{{ number_format($user->silk->silk_own) }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Silk (Gift) <span>{{ number_format($user->silk->silk_gift) }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Silk (Point) <span>{{ number_format($user->silk->silk_point) }}</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="row no-gutters">
    <div class="col-lg-9">
        {{-- order related informations --}}
        <div class="card-deck  mb-3">
            <div class="card">
                <div class="card-body position-relative">
                    <h6>Orders</h6>
                    <div class="display-4 fs-4 mb-2 font-weight-normal text-sans-serif text-success" v-text="orders"></div>
                    <a class="font-weight-semi-bold fs--1 text-nowrap" href="{{ route('admin.itemmall.index', ['user_id' => $user]) }}">
                        See all<span class="fas fa-angle-right ml-1" data-fa-transform="down-1"></span>
                    </a>
                </div>
            </div>
            <div class="card">
                <div class="bg-holder bg-card" style="background-image:url({{ Theme::url('img/illustrations/corner-1.png') }});"></div>
                <div class="card-body position-relative">
                    <h6>Item Groups by Orders</h6>
                    <canvas id="ordersByItemGroups"></canvas>
                </div>
            </div>
            <div class="card">
                <div class="bg-holder bg-card" style="background-image:url({{ Theme::url('img/illustrations/corner-1.png') }});"></div>
                <div class="card-body position-relative">
                    <h6>Item Categories by Orders</h6>
                    <canvas id="ordersByItemCategories"></canvas>
                </div>
            </div>
        </div>
        {{-- end: order related informations --}}

        {{-- vote related informations --}}
        <div class="card-deck mb-3">
            <div class="card">
                <div class="bg-holder bg-card" style="background-image:url({{ Theme::url('img/illustrations/corner-1.png') }});"></div>
                <div class="card-body position-relative">
                    <h6>Votes</h6>
                    <div class="display-4 fs-4 mb-2 font-weight-normal text-sans-serif text-success" v-text="votes"></div>
                    <a class="font-weight-semi-bold fs--1 text-nowrap" href="{{ route('admin.itemmall.index', ['user_id' => $user]) }}">
                        See all<span class="fas fa-angle-right ml-1" data-fa-transform="down-1"></span>
                    </a>
                </div>
            </div>
            <div class="card">
                <div class="bg-holder bg-card" style="background-image:url({{ Theme::url('img/illustrations/corner-2.png') }});"></div>
                <div class="card-body position-relative">
                    <h6>Vote Info</h6>
                    <chart type="pie" source="{{ route('admin.ajax.users.get_voteinfo', $user) }}" totals="votes"></chart>
                </div>
            </div>
            <div class="card">
                <div class="bg-holder bg-card" style="background-image:url({{ Theme::url('img/illustrations/corner-1.png') }});"></div>
                <div class="card-body position-relative">
                    <h6>Rewards by Completed Votes</h6>
                    <chart type="doughnut" source="{{ route('admin.ajax.users.get_voteinfobyrewards', $user) }}"></chart>
                </div>
            </div>
            <div class="card">
                <div class="bg-holder bg-card" style="background-image:url({{ Theme::url('img/illustrations/corner-1.png') }});"></div>
                <div class="card-body position-relative">
                    <h6>Providers by Completed Votes</h6>
                    <chart type="doughnut" source="{{ route('admin.ajax.users.get_voteinfobyproviders', $user) }}"></chart>
                </div>
            </div>
        </div>
        {{-- end: vote related informations --}}

        <div class="card-deck">
            <div class="card mb-3">
                <div class="bg-holder bg-card" style="background-image:url({{ Theme::url('img/illustrations/corner-3.png') }});"></div>
                <div class="card-body position-relative">
                    <h6>Referrals</h6>
                    <div class="display-4 fs-4 mb-2 font-weight-normal text-sans-serif text-info" v-text="referrals"></div>
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
                    <div class="display-4 fs-4 mb-2 font-weight-normal text-sans-serif text-warning" v-text="epins"></div>
                    <a class="font-weight-semi-bold fs--1 text-nowrap" href="{{ route('admin.epins.index', ['user_id' => $user]) }}">
                        See all<span class="fas fa-angle-right ml-1" data-fa-transform="down-1"></span>
                    </a>
                </div>
            </div>
            <div class="card mb-3">
                <div class="bg-holder bg-card" style="background-image:url({{ Theme::url('img/illustrations/corner-4.png') }});"></div>
                <div class="card-body position-relative">
                    <h6>Article Comments</h6>
                    <div class="display-4 fs-4 mb-2 font-weight-normal text-sans-serif text-warning" v-text="articlecomments"></div>
                    <a class="font-weight-semi-bold fs--1 text-nowrap" href="{{ route('admin.articles.comments.index', ['user_id' => $user]) }}">
                        See all<span class="fas fa-angle-right ml-1" data-fa-transform="down-1"></span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 pl-lg-3">
        <div class="card mb-3">
            <div class="card-header d-flex flex-between-center">
                <h6>Latest Orders</h6>
                <span class="position-static">
                    <select class="custom-select custom-select-sm" v-model.number="orderInfo.show_limit">
                        <option>3</option>
                        <option>5</option>
                        <option>10</option>
                        <option>20</option>
                        <option>40</option>
                    </select>
                </span>
            </div>
            <div class="card-body position-relative p-0">
                <div class="table-responsive">
                    <table class="table table-sm table-borderless fs--1">
                        <thead class="bg-dark text-900">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Items</th>
                                <th scope="col">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="order in filteredOrders" class="border-bottom border-200">
                                <th scope="row" class="align-middle">@{{ order.id }}</th>
                                <td class="fs--2 align-middle">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item d-flex justify-content-between align-content-center" v-for="item in order.items">
                                            <span class="badge badge-soft-primary">@{{ item.quantity }}</span>
                                            @{{ item.itemgroup.name }}
                                            <span class="badge badge-soft-primary">@{{ item.total_paid }} @{{ item.type_name }}</span>
                                        </li>
                                    </ul>
                                </td>
                                <td class="white-space-nowrap align-middle">@{{ order.created_at }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="card mb-3">
            <div class="card-header d-flex justify-content-between">
                <h6>Latest Votes</h6>
                <span>
                    <select class="custom-select custom-select-sm" v-model.number="voteInfo.show_limit">
                        <option>3</option>
                        <option>5</option>
                        <option>10</option>
                        <option>20</option>
                        <option>40</option>
                    </select>
                </span>
            </div>
            <div class="card-body position-relative p-0">
                <div class="table-responsive">
                    <table class="table table-sm table-borderless fs--1">
                        <thead class="bg-dark text-900">
                            <tr>
                                <th class="align-middle" scope="col">#</th>
                                <th class="align-middle" scope="col">Provider</th>
                                <th class="align-middle" scope="col">Reward</th>
                                <th class="align-middle" scope="col">Voted</th>
                                <th class="align-middle" scope="col">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="vote in filteredVotes" class="border-bottom border-200">
                                <th class="align-middle" scope="row" v-text="vote.id"></th>
                                <td class="align-middle"><a :href="getVoteProviderUrl(vote.vote_provider_id)" v-text="vote.vote_provider.name"></a></td>
                                <td class="align-middle"><a :href="getVoteRewardGroupUrl(vote.selected_reward_group_id)" v-text="vote.rewardgroup.name"></a></td>
                                <td class="align-middle"><template v-if="vote.voted"><label class="badge badge-soft-primary">Yes</label></template><template v-else><label class="badge badge-soft-warning">No</label></template></td>
                                <td class="white-space-nowrap align-middle" v-text="vote.created_at"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="card mb-3">
            <div class="card-header d-flex justify-content-between">
                Latest Referrals
                <span>
                    <select class="custom-select custom-select-sm" v-model.number="referralInfo.show_limit">
                        <option>3</option>
                        <option>5</option>
                        <option>10</option>
                        <option>20</option>
                        <option>40</option>
                    </select>
                </span>
            </div>
            <div class="card-body position-relative p-0">
                <div class="table-responsive">
                    <table class="table table-sm table-borderless fs--1">
                        <thead class="bg-dark text-900">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="referral in filteredReferrals" class="border-bottom border-200">
                                <th class="align-middle" scope="row" v-text="referral.id"></th>
                                <td class="align-middle"><a :href="getUserUrl(referral.user.JID)">@{{ referral.user.Name || referral.user.StrUserID }}</a></td>
                                <td class="white-space-nowrap align-middle" v-text="referral.created_at"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
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
{!! Theme::js('lib/chart.js/Chart.min.js') !!}
{!! Theme::js('lib/chart.js/chartjs-plugin-labels.min.js') !!}

<script>
    Vue.component('chart', {
        props: ['type', 'source', 'totals'],
        data() {
            return {
                canvas: null
            }
        },
        template: `<div><canvas ref="canvas"></canvas></div>`,
        mounted() {
            axios.get(this.source)
            .then((response) => {
                if (this.totals && response.data.total) {
                    main[this.totals] = response.data.total;
                }
                this.canvas = new Chart(this.$refs.canvas, {
                    type: this.type,
                    data: {
                        labels: response.data.labels,
                        datasets: [{
                            backgroundColor: utils.rgbaColors(),
                            borderColor: utils.grays.white,
                            borderwidth: 2,
                            data: response.data.values
                        }]
                    },
                    options: {
                        responsive: true,
                        legend: {
                            display: true,
                            position: 'right',
                            align: 'start',
                            labels: {
                                fontColor: utils.colors.dark,
                                usePointStyle: true
                            }
                        },
                        plugins: {
                            labels: {
                                render: 'percentage',
                                fontColor: utils.colors.dark,
                                position: 'outside',
                                arc: true,
                            }
                        }
                    }
                });
            })
            .catch(error => {
                console.log(error);
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

            });
        },
    });
</script>

<script>
    var main = new Vue({
        el: '.content',
        data: {
            votes: 0,
            orders: 0,
            referrals: 0,
            epins: 0,
            total_order_count: 0,
            articlecomments: 0,
            orderInfo: {
                orders: '',
                show_limit: 3
            },
            referralInfo: {
                referrals: '',
                show_limit: 3
            },
            voteInfo: {
                votes: '',
                show_limit: 3
            }
        },
        computed: {
            filteredOrders() {
                return _.take(this.orderInfo.orders, this.orderInfo.show_limit);
            },
            filteredReferrals() {
                return _.take(this.referralInfo.referrals, this.referralInfo.show_limit);
            },
            filteredVotes() {
                return _.take(this.voteInfo.votes, this.voteInfo.show_limit);
            }
        },
        mounted() {
            this.orderInfo.orders = @json($user->orders);
            this.referralInfo.referrals = @json($user->referrals);
            this.voteInfo.votes = @json($user->voteLogs);

            axios.get(route('admin.ajax.users.get_counts', @json($user->JID)))
            .then((response) => {
                _.merge(this.$data, response.data);
            })
            .catch(error => {
                console.log(error);
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

            });
        },
        methods: {
            getUserUrl(userJID) {
                return route('admin.users.show', userJID);
            },
            getVoteProviderUrl(providerId) {
                return route('admin.votes.providers.show', providerId);
            },
            getVoteRewardGroupUrl(rewardGroupId) {
                return route('admin.votes.rewardgroups.show', rewardGroupId);
            }
        }
    });
</script>

<script>
    // TODO: order var mı yokmu kontrolü?
    new Chart(document.getElementById('ordersByItemGroups'), {
        type: 'doughnut',
        data: {
            labels: @json($ordersDetailedInfo->itemgroup_names),
            datasets: [{
                backgroundColor: utils.rgbaColors(),
                borderColor: utils.grays.white,
                borderwidth: 2,
                data: @json($ordersDetailedInfo->itemgroup_orders)
            }]
        },
        options: {
            responsive: true,
            legend: {
                display: true,
                position: 'right',
                align: 'start',
                labels: {
                    fontColor: utils.colors.dark,
                    usePointStyle: true
                }
            },
            plugins: {
                labels: {
                    render: 'percentage',
                    fontColor: utils.colors.dark,
                    position: 'outside',
                    arc: true,
                }
            }
        }
    });

    new Chart(document.getElementById('ordersByItemCategories'), {
        type: 'doughnut',
        data: {
            labels: @json($ordersDetailedInfo->category_names),
            datasets: [{
                backgroundColor: utils.rgbaColors(),
                borderColor: utils.grays.white,
                borderwidth: 2,
                data: @json($ordersDetailedInfo->category_orders)
            }]
        },
        options: {
            responsive: true,
            legend: {
                display: true,
                position: 'right',
                align: 'start',
                labels: {
                    fontColor: utils.colors.dark,
                    usePointStyle: true
                }
            },
            plugins: {
                labels: {
                    render: 'percentage',
                    fontColor: utils.colors.dark,
                    position: 'outside',
                    arc: true,
                    // precision: 2
                }
            }
        }
    });
</script>
@endsection
