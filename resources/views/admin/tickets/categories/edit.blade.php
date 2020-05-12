@extends('layout')

@section('pagetitle', 'Update Ticket Category')

@section('content')
<div class="card mb-3">
    <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="mb-0">Update Ticket Category</h5>
        <div>
            <a class="btn btn-falcon-primary mr-2" href="{{ route('admin.tickets.categories.create') }}">Create</a>
            <a class="btn btn-falcon-info" href="{{ route('admin.tickets.categories.index') }}">Category List</a>
        </div>
    </div>
    <div class="card-body bg-light">
        <div class="row">
            <div class="col-12">
                {{ Form::open(['route' => ['admin.tickets.categories.update', $category], 'method' => 'patch', '@submit.prevent' => 'onSubmit', '@change' => 'form.errors.clear($event.target.name)', 'class' => 'form-validation']) }}
                    @include('tickets.categories.forms.category')
                    <button type="submit" :disabled="form.errors.any()" class="btn btn-falcon-primary">Submit</button>
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
                enabled: @json($category->enabled),
            })
        },
        methods: {
            onSubmit() {
                this.form.patch(event.target.action)
                .then(response => {
                    this.form.reset();
                });
            }
        }
    });
</script>
@endsection
