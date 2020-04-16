@extends('layout')

@section('pagetitle', 'Create Article Category')

@section('content')
<div class="card mb-3">
    <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="mb-0">Create Article Category</h5>
        <div>
            <a class="btn btn-falcon-info" href="{{ route('admin.articles.categories.index') }}">Category List</a>
        </div>
    </div>
    <div class="card-body bg-light">
        <div class="row">
            <div class="col-12">
                {{ Form::open(['route' => ['admin.articles.categories.store'], 'method' => 'post', '@submit.prevent' => 'onSubmit', '@change' => 'form.errors.clear($event.target.name)', 'class' => 'form-validation']) }}
                    @include('articles.categories.forms.category')
                    <button type="submit" :disabled="form.errors.any()" class="btn btn-falcon-primary">Submit</button>
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
                slug: '',
                enabled: '1',
                generate_slug: '1',
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
