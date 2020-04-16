@extends('layout')

@section('pagetitle', 'Add Callback IP')

@section('content')
<div class="card mb-3">
    <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="mb-0">Add Callback IP</h5>
        <div>
            <a class="btn btn-falcon-info" href="{{ route('admin.votes.providers.ips.index') }}">Vote Callback Allowed IPs</a>
        </div>
    </div>
    <div class="card-body bg-light">
        <div class="row">
            <div class="col-12">
                {{ Form::open(['route' => ['admin.votes.providers.ips.store'], 'method' => 'post', '@submit.prevent' => 'onSubmit']) }}
                <div class="form-group">
                    <label for="ip">IP</label>
                    <input type="text" class="form-control" id="ip" v-model="form.ip" required>
                </div>
                <button type="submit" class="btn btn-falcon-primary">Submit</button>
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
                ip: ''
            })
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
