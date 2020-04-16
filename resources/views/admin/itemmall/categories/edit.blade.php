@extends('layout')

@section('pagetitle', 'Edit Item Mall Category')

@section('content')
<div class="card mb-3">
    <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="mb-0">Edit Item Mall Category</h5>
        <div>
            <a class="btn btn-falcon-primary mr-2" href="{{ route('admin.itemmall.categories.create') }}">Create</a>
            <a class="btn btn-falcon-info" href="{{ route('admin.itemmall.categories.index') }}">Categories</a>
        </div>
    </div>
    <div class="card-body bg-light">
        <div class="row">
            <div class="col-12">
                {{ Form::open(['route' => ['admin.itemmall.categories.update', $category], 'method' => 'patch', ]) }}
                    @include('itemmall.categories.forms.category')
                    <div class="btn-group">
                        <button type="submit" class="btn btn-falcon-primary">Submit</button>
                        {{ Form::close() }}
                        {!! Form::open([ 'route' => ['admin.itemmall.categories.destroy', $category], 'method' => 'delete', '@submit.prevent' => 'onDelete']) !!}
                        <button type="submit" class="btn btn-falcon-danger">Delete</button>
                        {!! Form::close() !!}
                    </div>
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
                name: @json($category->name),
                order: @json($category->order),
                enabled: @json($category->enabled)
            })
        },
        methods: {
            onSubmit() {
                this.form.patch(event.target.action);
            },
            onDelete() {
                this.form.delete(event.target.action)
                .then(response => {
                    window.location = @json(route('admin.itemmall.categories.index'))
                });
            }
        }
    });
</script>
@endsection
