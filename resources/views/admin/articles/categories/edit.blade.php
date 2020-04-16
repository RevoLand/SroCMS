@extends('layout')

@section('pagetitle', 'Edit Category')

@section('content')
<div class="card mb-3">
    <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="mb-0">Edit Article Category</h5>
        <div>
            <a class="btn btn-falcon-primary mr-2" href="{{ route('admin.articles.categories.create') }}">Create</a>
            <a class="btn btn-falcon-info" href="{{ route('admin.articles.categories.index') }}">Category List</a>
        </div>
    </div>
    <div class="card-body bg-light">
        <div class="row">
            <div class="col-12">
                {{ Form::open(['route' => ['admin.articles.categories.update', $category], 'method' => 'patch', '@submit.prevent' => 'onSubmit', '@change' => 'form.errors.clear($event.target.name)', 'class' => 'form-validation']) }}
                    @include('articles.categories.forms.category')
                    <div class="btn-group" role="group">
                        <button type="submit" class="btn btn-falcon-primary mr-2">Save</button>
                        {!! Form::close() !!}
                        {!! Form::open([ 'route' => ['admin.articles.categories.destroy', $category], 'method' => 'delete', '@submit.prevent' => 'deleteForm']) !!}
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
<script>
    new Vue({
        el: '.content',
        data: {
            form: new Form({
                name: @json($category->name),
                slug: @json($category->slug),
                enabled: @json($category->enabled),
                generate_slug: '0',
            })
        },
        methods: {
            onSubmit() {
                this.form.patch(event.target.action);
            },
            deleteForm() {
                this.form.delete(event.target.action)
                .then(response => {
                    window.location.href = '{{ route('admin.articles.categories.index') }}'
                });
            }
        }
    });
</script>
@endsection
