@extends('layout')

@section('pagetitle', 'Add Callback IP')

@section('content')
<div class="card mb-3">
    <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="mb-0">Add Callback IP</h5>
        <div>
            <a class="btn btn-falcon-info" href="{{ route('admin.votes.providers.ips.index') }}">Vote Callback Allowed IPs</a>
        </div>
    </div>
    <div class="card-body bg-light">
        @include('components.message')
        @include('components.errors')
        <div class="row">
            <div class="col-12">
                {{ Form::open(['route' => ['admin.votes.providers.ips.store'], 'method' => 'post']) }}
                <div class="form-group">
                    <label for="ip">IP</label>
                    {{ Form::text('ip', old('ip'), ['class' => 'form-control', 'required', 'id' => 'ip']) }}
                </div>
                <div class="btn-group">
                    <button type="submit" class="btn btn-falcon-primary">Submit</button>
                    <button type="reset" class="btn btn-falcon-info">Cancel</button>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>
@endsection
