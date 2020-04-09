@extends('layout')

@section('pagetitle', 'Edit Category')

@section('content')
<div class="card mb-3">
    <div class="card-header">
      <h5 class="mb-0">Edit Item Mall Category</h5>
    </div>
    <div class="card-body bg-light">
        @include('components.message')
        @include('components.errors')
        <div class="row">
            <div class="col-12">
                {{ Form::open(['route' => ['admin.itemmall.categories.update', $category], 'method' => 'patch']) }}
                    <div class="form-group">
                        <label for="name">Name</label>
                        {{ Form::text('name', $category->name, ['class' => 'form-control', 'id' => 'name', 'required']) }}
                    </div>
                    <div class="form-group balance-selector">
                        <label for="order">Sort Order</label>
                        {{ Form::text('order', $category->order, ['class' => 'form-control', 'id' => 'order', 'required']) }}
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <div class="row col-12">
                            <div class="custom-control custom-radio custom-control-inline">
                                {!! Form::radio('enabled', 1, $category->enabled, ['class' => 'custom-control-input', 'id' => 'enabled_true']) !!}
                                <label for="enabled_true" class="custom-control-label">Enabled</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                {!! Form::radio('enabled', 0, !$category->enabled, ['class' => 'custom-control-input', 'id' => 'enabled_false']) !!}
                                <label for="enabled_false" class="custom-control-label">Disabled</label>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-falcon-primary">Submit</button>
                    <button type="reset" class="btn btn-falcon-info">Cancel</button>
                    {!! Form::open([ 'route' => ['admin.itemmall.categories.destroy', $category], 'method' => 'delete']) !!}
                        <button type="submit" class="btn btn-falcon-danger">Delete</button>
                    {!! Form::close() !!}
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>
@endsection
