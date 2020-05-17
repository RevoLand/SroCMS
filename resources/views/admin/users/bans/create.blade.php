@extends('layout')

@section('pagetitle', 'New User Ban')

@section('content')
<div class="card mb-3">
    <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="mb-0">New User Ban</h5>
        <div>
            <a class="btn btn-falcon-info " href="{{ route('admin.users.bans.index') }}">User Bans</a>
        </div>
    </div>
    <div class="card-body bg-light">
        <div class="row">
            <div class="col-12">
                @if($user !== '')
                    <div class="media align-items-center">
                        @isset($user->gravatar)
                        <img class="d-flex align-self-center mr-2" src="{{ $user->gravatar }}" alt="{{ $user->StrUserID }}" width="30">
                        @endisset
                        <div class="media-body">
                            <h6 class="mb-0"><a href="{{ route('admin.users.show', $user) }}">{{ $user->StrUserID }}</a></h6>
                            @isset($user->Name) <small class="text-muted font-italic">{{ $user->Name }}</small> @endisset
                        </div>
                    </div>
                    @isset($user->regtime) <small>User since: {{ $user->regtime }}</small> @endisset
                @else
                <div class="form-group">
                    <label>User</label>
                    <select class="select2 user_select2" v-model="form.user" required><option value="" selected></option></select>
                </div>
                @endif
                @include('users.bans.forms.ban')
                <button type="submit" @click="saveChanges" :disabled="form.user == '' || form.timeEnd == ''" class="btn btn-falcon-primary">Submit</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
{!! Theme::js('lib/flatpickr/flatpickr.min.js') !!}
{!! Theme::js('lib/select2/select2.min.js') !!}
<script src="{{ asset('vendor/vue/ext/flatpickr.js') }}"></script>
<script src="{{ asset('vendor/vue/ext/select2.js') }}"></script>
<script>
    new Vue({
        el: '.content',
        data: {
            id: 0,
            form: new Form({
                type: '1',
                reason: '',
                user: @json($user->JID ?? ''),
                timeBegin: @json(now()),
                timeEnd: '',
            }),
            punishment_type: @json(config('constants.punishment_type')),
            active_blocks: []
        },
        mounted() {
            @if($user !== '')
                this.active_blocks = @json($user->activeUserBlocks);
            @endisset
        },
        watch: {
            'form.user': function(newValue, oldValue) {
                if (is.empty(newValue)) {
                    return;
                }

                $(".content").block();
                axios.get(route('admin.ajax.users.get_activeblocks', newValue).url(), {
                    user: newValue
                })
                .then(response => {
                    if (is.existy(response.data.active_blocks)) {
                        this.active_blocks = response.data.active_blocks;
                    }
                })
                .finally(() => {
                    $(".content").unblock();
                });
            }
        },
        computed: {
            active_login_blocks() {
                return this.active_blocks.filter(block => {
                    return is.equal(block.Type, '1');
                });
            },
            active_login_ins_blocks() {
                return this.active_blocks.filter(block => {
                    return is.equal(block.Type, '2');
                });
            },
            active_p2p_trade_blocks() {
                return this.active_blocks.filter(block => {
                    return is.equal(block.Type, '3');
                });
            },
            active_chat_blocks() {
                return this.active_blocks.filter(block => {
                    return is.equal(block.Type, '4');
                });
            }
        },
        methods: {
            saveChanges() {
                this.form.post(route('admin.users.bans.store').url())
                .then(response => {
                    swal.fire({
                        toast: true,
                        position: 'top-end',
                        title: 'Success! Redirecting you in 2 seconds...',
                        icon: 'success',
                        showConfirmButton: false
                    });
                    setTimeout(function(){ window.location = route('admin.users.bans.index').url(); }, 2000);
                });
            }
        }
    });

    $(document).ready(function() {
        $('.user_select2').select2({
            placeholder: 'Search for User',
            minimumInputLength: 2,
            allowClear: false,
            dropdownAutoWidth: true,
            ajax: {
                url: route('admin.ajax.users.get_usernames').url(),
                dataType: 'json',
                delay: 300,
                cache: true,
                data: function(params) {
                    return {
                        search: params.term || '',
                        page: params.page || 1
                    }
                },
                processResults: function (response, params) {
                    return {
                        results: response.data,
                        pagination: {
                            more: ((params.page || 1) < response.last_page)
                        }
                    };
            },
            }
        });
    });
</script>
@endsection
