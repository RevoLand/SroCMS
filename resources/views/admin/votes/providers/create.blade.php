@extends('layout')

@section('pagetitle', 'Create Vote Provider')

@section('content')
<div class="card mb-3">
    <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="mb-0">Create Vote Provider</h5>
        <div>
            <a class="btn btn-falcon-info" href="{{ route('admin.votes.providers.index') }}">Vote Providers</a>
        </div>
    </div>
    <div class="card-body bg-light">
        <div class="row">
            <div class="col-12">
                {{ Form::open(['route' => ['admin.votes.providers.store'], 'method' => 'post', '@submit.prevent' => 'submitForm']) }}
                @include('votes.providers.forms.provider')
                <div class="btn-group" role="group">
                    <button type="submit" class="btn btn-falcon-primary">Submit</button>
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
                name: '',
                url: '',
                url_user_name: '',
                callback_secret: '',
                generate_callback_secret: '1',
                callback_user_name: '',
                callback_success_name: '',
                minutes_between_votes: '',
                enabled: 1
            })
        },
        methods: {
            submitForm() {
                this.form.post(event.target.action)
                .then(response => {
                    this.form.reset();
                })
            }
        }
    });
</script>
@endsection
