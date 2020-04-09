@extends('layout')

@section('pagetitle', 'Create Reward Group')

@section('content')
<div class="card mb-3" id="content">
    <div class="card-header">
      <h5 class="mb-0">Create Reward Group</h5>
    </div>
    <div class="card-body bg-light">
        <div class="row">
            <div class="col-12">
                {{ Form::open(['route' => ['admin.votes.rewardgroups.store'], 'method' => 'post', '@submit.prevent' => 'onFormSubmit']) }}
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" v-model="name" required>
                    </div>
                    <div class="form-group">
                        <label for="vote_providers">Vote Providers</label>
                        <select id="vote_providers" class="form-control select2" required multiple="multiple" v-model="vote_providers">
                            @foreach($voteProviders as $voteProvider)
                                <option value="{{ $voteProvider->id }}" >{{ $voteProvider->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>State</label>
                        <div class="row col-12">
                            <div class="custom-control custom-radio custom-control-inline">
                                <input id="enabled_true" class="custom-control-input" type="radio" v-model="enabled" value="1">
                                <label for="enabled_true" class="custom-control-label">Enabled</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input id="enabled_false" class="custom-control-input" type="radio" v-model="enabled" value="0">
                                <label for="enabled_false" class="custom-control-label">Disabled</label>
                            </div>
                        </div>
                    </div>
                    <div class="btn-group" role="group">
                        <button type="submit" class="btn btn-falcon-primary mr-2">Create</button>
                    </div>
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
