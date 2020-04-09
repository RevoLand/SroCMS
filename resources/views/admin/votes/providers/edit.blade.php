@extends('layout')

@section('pagetitle', 'Edit Vote Provider')

@section('content')
<div class="card mb-3">
    <div class="card-header">
        <h5 class="mb-0">Edit Vote Provider</h5>
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
<script>
    new Vue({
        el: '.content',
        data: {
            name: @json($provider->name),
            url: @json($provider->url),
            url_user_name: @json($provider->url_user_name),
            callback_secret: @json($provider->callback_secret),
            generate_callback_secret: '0',
            callback_user_name: @json($provider->callback_user_name),
            callback_success_name: @json($provider->callback_success_name),
            minutes_between_votes: @json($provider->minutes_between_votes),
            enabled: @json($provider->enabled)
        },
        methods: {
            submitForm(event) {
                $('.content').block();
                axios.patch(event.target.action, this.$data)
                .then(response => {
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
                })
                .finally(() => {
                    $('.content').unblock();
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
                            window.location.href = '{{ route('admin.votes.providers.index') }}'
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
</script>
@endsection
