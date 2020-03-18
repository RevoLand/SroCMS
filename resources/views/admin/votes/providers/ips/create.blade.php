@extends('layout')

@section('pagetitle', 'Add Callback IP')

@section('content')
<div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
    <!-- begin:: Subheader -->
    <div class="kt-subheader   kt-grid__item" id="kt_subheader">
        <div class="kt-container  kt-container--fluid ">
            <div class="kt-subheader__main">
                <h3 class="kt-subheader__title">Add Callback IP</h3>
                <span class="kt-subheader__separator kt-hidden"></span>
                <div class="kt-subheader__breadcrumbs">
                    <a href="{{ route('admin.dashboard.index') }}" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
                    <span class="kt-subheader__breadcrumbs-separator"></span>
                    <a href="{{ route('admin.votes.index') }}" class="kt-subheader__breadcrumbs-link">Vote System</a>
                    <span class="kt-subheader__breadcrumbs-separator"></span>
                    <a href="{{ route('admin.votes.providers.index') }}" class="kt-subheader__breadcrumbs-link">Vote Providers</a>
                    <span class="kt-subheader__breadcrumbs-separator"></span>
                    <a href="{{ route('admin.votes.providers.ips.index') }}" class="kt-subheader__breadcrumbs-link">Allowed Callback IPs</a>
                    <span class="kt-subheader__breadcrumbs-separator"></span>
                    <a href="{{ route('admin.votes.providers.ips.create') }}" class="kt-subheader__breadcrumbs-link kt-subheader__breadcrumbs-link--active">Add</a>
                </div>
            </div>
        </div>
    </div>
    <!-- end:: Subheader -->

    <!-- begin:: Content -->
    <div class="kt-container kt-container--fluid  kt-grid__item kt-grid__item--fluid">
        @if (session('message'))
        <div class="row">
            <div class="col">
                <div class="alert alert-light alert-elevate fade show" role="alert">
                    <div class="alert-icon"><i class="la la-check-square kt-font-brand"></i></div>
                    <div class="alert-text">
                        {{ session('message') }}
                    </div>
                </div>
            </div>
        </div>
        @endif
        @if ($errors->any())
        <div class="row">
            <div class="col">
                <div class="alert alert-danger alert-elevate fade show" role="alert">
                    <div class="alert-icon"><i class="la la-warning kt-font-brand"></i></div>
                    <div class="alert-text">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        @endif

        <div class="kt-portlet kt-portlet--mobile">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title">
                        Add Allowed Callback IP
                    </h3>
                </div>
                <div class="kt-portlet__head-toolbar">
                    <div class="kt-portlet__head-actions">
                        <a href="{{ route('admin.votes.providers.ips.index') }}" class="btn btn-primary btn-upper btn-sm btn-bold">
                            <i class="la la-copy"></i> List Allowed Callback IPs
                        </a>
                    </div>
                </div>
            </div>
            <div class="kt-portlet__body">
                {{ Form::open(['route' => ['admin.votes.providers.ips.store'], 'class' => 'kt-form', 'method' => 'post']) }}
                    <div class="form-group">
                        <label>IP</label>
                        {{ Form::text('ip', old('ip'), ['class' => 'form-control', 'required']) }}
                    </div>
                    <div class="kt-portlet__foot">
                        <div class="kt-form__actions">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <button type="reset" class="btn btn-secondary">Cancel</button>
                        </div>
                    </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>

    <!-- end:: Content -->
</div>
@endsection
