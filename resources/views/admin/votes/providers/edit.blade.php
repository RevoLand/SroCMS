@extends('layout')

@section('pagetitle', 'Edit Vote Provider')

@section('content')
<div class="card mb-3">
    <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="mb-0">Edit Vote Provider</h5>
        <div>
            <a class="btn btn-falcon-primary mr-2" href="{{ route('admin.votes.providers.create') }}">Create</a>
            <a class="btn btn-falcon-info" href="{{ route('admin.votes.providers.index') }}">Vote Providers</a>
        </div>
    </div>
    <div class="card-body bg-light">
        <div class="row">
            <div class="col-12">
                {{ Form::open(['route' => ['admin.votes.providers.update', $provider], 'method' => 'patch', '@submit.prevent' => 'submitForm']) }}
                @include('votes.providers.forms.provider')
                <div class="btn-group" role="group">
                    <button type="submit" class="btn btn-falcon-primary mr-2">Save</button>
                    {!! Form::close() !!}
                    {!! Form::open([ 'route' => ['admin.votes.providers.destroy', $provider], 'method' => 'delete', '@submit.prevent' => 'deleteForm']) !!}
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
                name: @json($provider->name),
                url: @json($provider->url),
                url_user_name: @json($provider->url_user_name),
                callback_secret: @json($provider->callback_secret),
                generate_callback_secret: '0',
                callback_user_name: @json($provider->callback_user_name),
                callback_success_name: @json($provider->callback_success_name),
                minutes_between_votes: @json($provider->minutes_between_votes),
                enabled: @json($provider->enabled)
            })
        },
        methods: {
            submitForm() {
                this.form.patch(event.target.action);
            },
            deleteForm() {
                this.form.delete(event.target.action)
                .then(response => {
                    window.location.href = '{{ route('admin.votes.providers.index') }}'
                });
            }
        }
    });
</script>
@endsection
