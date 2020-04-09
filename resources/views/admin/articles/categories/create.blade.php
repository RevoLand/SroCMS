@extends('layout')

@section('pagetitle', 'Create Article Category')

@section('content')
<div class="card mb-3">
    <div class="card-header">
      <h5 class="mb-0">Create Article Category</h5>
    </div>
    <div class="card-body bg-light">
        <div class="row">
            <div class="col-12">
                {{ Form::open(['route' => ['admin.articles.categories.store'], 'method' => 'post', '@submit.prevent' => 'submitForm']) }}
                    @include('articles.categories.forms.category')
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
<script>
    new Vue({
        el: '.content',
        data: {
            name: '',
            slug: '',
            enabled: '1',
            generate_slug: '1',
        },
        methods: {
            submitForm(event) {
                $('.content').block();
                axios.post(event.target.action, this.$data)
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
            }
        }
    });
</script>
@endsection
