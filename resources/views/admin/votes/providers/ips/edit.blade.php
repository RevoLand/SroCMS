@extends('layout')

@section('pagetitle', 'Edit Callback IP')

@section('content')
<div class="card mb-3">
    <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="mb-0">Edit Callback IP</h5>
        <div>
            <a class="btn btn-falcon-primary mr-2" href="{{ route('admin.votes.providers.ips.create') }}">Create</a>
            <a class="btn btn-falcon-info" href="{{ route('admin.votes.providers.ips.index') }}">Callback Allowed IPs</a>
        </div>
    </div>
    <div class="card-body bg-light">
        @include('components.message')
        @include('components.errors')
        <div class="row">
            <div class="col-12">
                {{ Form::open(['route' => ['admin.votes.providers.ips.update', $ip], 'method' => 'patch']) }}
                    <div class="form-group">
                        <label for="ip">IP</label>
                        {{ Form::text('ip', $ip->ip, ['class' => 'form-control', 'required', 'id' => 'ip']) }}
                    </div>
                    <div class="btn-group" role="group">
                        <button type="submit" class="btn btn-falcon-primary mr-2">Save</button>
                        <button type="reset" class="btn btn-falcon-info">Cancel</button>
                        {!! Form::close() !!}
                        {!! Form::open([ 'route' => ['admin.votes.providers.ips.destroy', $ip], 'method' => 'delete']) !!}
                            <button type="submit" class="btn btn-falcon-danger">Delete</button>
                        {!! Form::close() !!}
                    </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>
@endsection
