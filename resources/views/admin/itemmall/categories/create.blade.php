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
        @include('components.message')
        @include('components.errors')
        <div class="row">
            <div class="col-12">
                {{ Form::open(['route' => ['admin.itemmall.categories.store'], 'method' => 'post']) }}
                    <div class="form-group">
                        <label for="name">Name</label>
                        {{ Form::text('name', old('name'), ['class' => 'form-control', 'id' => 'name', 'required']) }}
                    </div>
                    <div class="form-group balance-selector">
                        <label for="order">Sort Order</label>
                        {{ Form::text('order', old('order') ?? 1, ['class' => 'form-control', 'id' => 'order', 'required']) }}
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <div class="row col-12">
                            <div class="custom-control custom-radio custom-control-inline">
                                {!! Form::radio('enabled', 1, old('enabled', true), ['class' => 'custom-control-input', 'id' => 'enabled_true']) !!}
                                <label for="enabled_true" class="custom-control-label">Enabled</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                {!! Form::radio('enabled', 0, !old('enabled', true), ['class' => 'custom-control-input', 'id' => 'enabled_false']) !!}
                                <label for="enabled_false" class="custom-control-label">Disabled</label>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-falcon-primary">Submit</button>
                    <button type="reset" class="btn btn-falcon-info">Cancel</button>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>
@endsection
