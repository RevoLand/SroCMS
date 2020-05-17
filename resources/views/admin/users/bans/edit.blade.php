@extends('layout')

@section('pagetitle', 'Update User Ban')

@section('content')
<div class="card mb-3">
    <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="mb-0">Update User Ban</h5>
        <div>
            <a class="btn btn-falcon-primary mr-2" href="{{ route('admin.users.bans.create') }}">Create</a>
            <a class="btn btn-falcon-info " href="{{ route('admin.users.bans.index') }}">User Bans</a>
        </div>
    </div>
    <div class="card-body bg-light">
        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <div class="media align-items-center">
                        @isset($ban->user->gravatar)
                        <img class="d-flex align-self-center mr-2" src="{{ $ban->user->gravatar }}" alt="{{ $ban->user->StrUserID }}" width="30">
                        @endisset
                        <div class="media-body">
                            <h6 class="mb-0"><a href="{{ route('admin.users.show', $ban->user) }}">{{ $ban->user->StrUserID }}</a></h6>
                            @isset($ban->user->Name) <small class="text-muted font-italic">{{ $ban->user->Name }}</small> @endisset
                        </div>
                    </div>
                    @isset($ban->user->regtime) <small>User since: {{ $ban->user->regtime }}</small> @endisset
                </div>
                @include('users.bans.forms.ban')
                <div class="btn-group">
                    <button type="submit" @click="saveChanges" class="btn btn-falcon-primary">Submit</button>
                    <button type="submit" class="btn btn-falcon-danger" @click="deleteBan">Delete</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
{!! Theme::js('lib/flatpickr/flatpickr.min.js') !!}
<script src="{{ asset('vendor/vue/ext/flatpickr.js') }}"></script>
<script>
    var vm = new Vue({
        el: '.content',
        data: {
            id: @json($ban->id),
            form: new Form({
                type: @json($ban->Type),
                timeBegin: @json($ban->timeBegin),
                timeEnd: @json($ban->timeEnd),
                reason: @json($ban->punishment->Description)
            }),
            punishment_type: @json(config('constants.punishment_type')),
            active_blocks: @json($ban->user->activeUserBlocks)
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
                this.form.patch(route('admin.users.bans.update', this.id).url())
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
            },
            deleteBan() {
                this.form.delete(route('admin.users.bans.destroy', this.id).url())
                .then(response => {
                    window.location = route('admin.users.bans.index').url()
                });
            }
        }
    });
</script>
@endsection
