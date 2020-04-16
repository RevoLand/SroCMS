@extends('layout')

@section('pagetitle', 'Create Category')

@section('content')
<div class="card mb-3">
    <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="mb-0">Create Item Mall Category</h5>
        <div>
            <a class="btn btn-falcon-info" href="{{ route('admin.itemmall.categories.index') }}">Categories</a>
        </div>
    </div>
    <div class="card-body bg-light">
        <div class="row">
            <div class="col-12">
                {{ Form::open(['route' => ['admin.itemmall.categories.store'], 'method' => 'post', '@submit.prevent' => 'onSubmit']) }}
                    @include('itemmall.categories.forms.category')
                    <button type="submit" class="btn btn-falcon-primary">Submit</button>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script type="text/javascript">
    new Vue({
        el: '.content',
        data: {
            form: new Form({
                name: '',
                order: 1,
                enabled: '1'
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
