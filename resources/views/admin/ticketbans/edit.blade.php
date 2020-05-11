@extends('layout')

@section('pagetitle', 'Update Ticket Ban')

@section('content')
<div class="card mb-3">
    <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="mb-0">Update Ticket Ban</h5>
        <a class="btn btn-falcon-info" href="{{ route('admin.ticketbans.index') }}">All Ticket Bans</a>
    </div>
    <div class="card-body bg-light">
        <div class="row">
            <div class="col-12">
                {{ Form::open(['route' => ['admin.ticketbans.update', $ticketban], 'method' => 'patch', '@submit.prevent' => 'submitForm']) }}
                    <div class="form-group">
                        <label for="reason">Ban Reason</label>
                        <textarea id="reason" type="text" class="form-control" v-model="form.reason" maxlength="500"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="ban_start">Ban Start</label>
                        <input class="form-control flatpickr" type="datetime" id="ban_start" v-model="form.ban_start">
                    </div>
                    <div class="form-group">
                        <label for="ban_end">Ban End</label>
                        <input class="form-control flatpickr" type="datetime" id="ban_end" v-model="form.ban_end">
                    </div>
                    <div class="btn-group" role="group">
                        <button type="submit" class="btn btn-falcon-primary mr-2">Save</button>
                        {!! Form::close() !!}
                        {!! Form::open([ 'route' => ['admin.ticketbans.cancel', $ticketban], 'method' => 'patch', '@submit.prevent' => 'cancelForm']) !!}
                            <button type="submit" class="btn btn-falcon-danger">Unban</button>
                        {!! Form::close() !!}
                    </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
{!! Theme::js('lib/flatpickr/flatpickr.min.js') !!}
<script src="{{ asset('vendor/vue/ext/flatpickr.js') }}"></script>
<script>
    new Vue({
        el: '.content',
        data: {
            form: new Form({
                reason: @json($ticketban->reason),
                ban_start: @json($ticketban->ban_start),
                ban_end: @json($ticketban->ban_end)
            })
        },
        methods: {
            submitForm() {
                this.form.patch(event.target.action);
            },
            cancelForm() {
                this.form.patch(event.target.action)
                .then(response => {
                    window.location.href = route('admin.ticketbans.index').url();
                });
            }
        }
    });
</script>
@endsection
