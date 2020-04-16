@extends('layout')

@section('pagetitle', 'Edit Callback IP')

@section('content')
<div class="card mb-3">
    <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="mb-0">Edit Callback IP</h5>
        <div>
            <a class="btn btn-falcon-primary mr-2" href="{{ route('admin.votes.providers.ips.create') }}">Create</a>
            <a class="btn btn-falcon-info" href="{{ route('admin.votes.providers.ips.index') }}">Callback Allowed IPs</a>
        </div>
    </div>
    <div class="card-body bg-light">
        <div class="row">
            <div class="col-12">
                {{ Form::open(['route' => ['admin.votes.providers.ips.update', $ip], 'method' => 'patch', '@submit.prevent' => 'onSubmit']) }}
                    <div class="form-group">
                        <label for="ip">IP</label>
                        <input type="text" class="form-control" id="ip" v-model="form.ip" required>
                    </div>
                    <div class="btn-group" role="group">
                        <button type="submit" class="btn btn-falcon-primary mr-2">Save</button>
                        {!! Form::close() !!}
                        {!! Form::open([ 'route' => ['admin.votes.providers.ips.destroy', $ip], 'method' => 'delete', '@submit.prevent' => 'onDelete']) !!}
                            <button type="submit" class="btn btn-falcon-danger">Delete</button>
                        {!! Form::close() !!}
                    </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="{{ asset('vendor/vue/vue.js') }}"></script>
<script src="{{ asset('vendor/axios.min.js') }}"></script>
<script src="{{ asset('vendor/srocms.js') }}"></script>
<script>
    new Vue({
        el: '.content',
        data: {
            form: new Form({
                ip: @json($ip->ip)
            })
        },
        methods: {
            onSubmit() {
                this.form.patch(event.target.action);
            },
            onDelete() {
                this.form.delete(event.target.action)
                .then(response => {
                    window.location = @json(route('admin.votes.providers.ips.index'))
                });
            }
        }
    });
</script>
@endsection
