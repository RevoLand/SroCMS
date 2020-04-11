@extends('layout')

@section('pagetitle', 'Create Reward Group')

@section('content')
<div class="card mb-3" id="content">
    <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="mb-0">Create Reward Group</h5>
        <div>
            <a class="btn btn-falcon-info" href="{{ route('admin.votes.rewardgroups.index') }}">Reward Groups</a>
        </div>
    </div>
    <div class="card-body bg-light">
        <div class="row">
            <div class="col-12">
                {{ Form::open(['route' => ['admin.votes.rewardgroups.store'], 'method' => 'post', '@submit.prevent' => 'onFormSubmit']) }}
                @include('votes.rewardgroups.forms.rewardgroup')
                <button type="submit" class="btn btn-falcon-primary mr-2">Create</button>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>
@endsection


@section('js')
{!! Theme::js('lib/select2/select2.min.js') !!}
<script src="{{ asset('vendor/vue/vue.js') }}"></script>
<script src="{{ asset('vendor/vue/ext/select2.js') }}"></script>
<script src="{{ asset('vendor/axios.min.js') }}"></script>

<script>
    new Vue({
        el: '#content',
        data: {
            name: '',
            enabled: 1,
            vote_providers: []
        },

        methods: {
            onFormSubmit: function(event) {
                axios.post(event.target.action, this.$data)
                .then(function (response) {
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
                });
            }
        }
    });
</script>
@endsection
