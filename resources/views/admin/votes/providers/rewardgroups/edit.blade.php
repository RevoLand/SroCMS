@extends('layout')

@section('pagetitle', 'Edit Vote Provider Reward Group')

@section('content')
<div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
    <!-- begin:: Subheader -->
    <div class="kt-subheader   kt-grid__item" id="kt_subheader">
        <div class="kt-container  kt-container--fluid ">
            <div class="kt-subheader__main">
                <h3 class="kt-subheader__title">Edit Vote Provider Reward Group</h3>
                <span class="kt-subheader__separator kt-hidden"></span>
                <div class="kt-subheader__breadcrumbs">
                    <a href="{{ route('admin.dashboard.index') }}" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
                    <span class="kt-subheader__breadcrumbs-separator"></span>
                    <a href="{{ route('admin.votes.index') }}" class="kt-subheader__breadcrumbs-link">Vote System</a>
                    <span class="kt-subheader__breadcrumbs-separator"></span>
                    <a href="{{ route('admin.votes.providers.index') }}" class="kt-subheader__breadcrumbs-link">Vote Providers</a>
                    <span class="kt-subheader__breadcrumbs-separator"></span>
                    <a href="{{ route('admin.votes.providers.rewardgroups.index') }}" class="kt-subheader__breadcrumbs-link">Reward Groups</a>
                    <span class="kt-subheader__breadcrumbs-separator"></span>
                    <a href="{{ route('admin.votes.providers.rewardgroups.edit', $rewardgroup) }}" class="kt-subheader__breadcrumbs-link kt-subheader__breadcrumbs-link--active">Edit</a>
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
                        Vote Provider Reward Group: {{ $rewardgroup->name }}
                    </h3>
                </div>
                <div class="kt-portlet__head-toolbar">
                    <div class="kt-portlet__head-actions">
                        <a href="{{ route('admin.votes.providers.rewardgroups.create') }}" class="btn btn-primary btn-upper btn-sm btn-bold">
                            <i class="la la-copy"></i> Create Reward Group
                        </a>
                        <a href="{{ route('admin.votes.providers.rewardgroups.index') }}" class="btn btn-primary btn-upper btn-sm btn-bold">
                            <i class="la la-copy"></i> List Reward Groups
                        </a>
                    </div>
                </div>
            </div>
            <div class="kt-portlet__body">
                {{ Form::open(['route' => ['admin.votes.providers.rewardgroups.update', $rewardgroup], 'class' => 'kt-form', 'method' => 'patch']) }}
                    <div class="form-group">
                        <label>Vote Provider</label>
                        <select name="vote_provider_id" class="form-control" required>
                            @forelse ($voteProviders as $voteProvider)
                            <option value="{{ $voteProvider->id }}" @if($rewardgroup->vote_provider_id == $voteProvider->id) selected @endif>{{ $voteProvider->name }}</option>
                            @empty
                            <option>No Vote Provider set.</option>
                            @endforelse
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Name</label>
                        {{ Form::text('name', $rewardgroup->name, ['class' => 'form-control', 'required']) }}
                    </div>
                    <div class="form-group">
                        <label>State</label>
                        <div class="kt-radio-inline">
                            <label class="kt-radio">
                                {!! Form::radio('enabled', 1, $rewardgroup->enabled) !!} Enabled
                                <span></span>
                            </label>
                            <label class="kt-radio">
                                {!! Form::radio('enabled', 0, !$rewardgroup->enabled) !!} Disabled
                                <span></span>
                            </label>
                        </div>
                    </div>
                    <div class="kt-portlet__foot">
                        <div class="kt-form__actions kt-form__actions--right">
                            <div class="row">
                                <div class="col kt-align-left">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                    <button type="reset" class="btn btn-secondary">Cancel</button>
                                    {!! Form::close() !!}
                                </div>
                                <div class="col kt-align-right">
                                    {!! Form::open([ 'route' => ['admin.votes.providers.rewardgroups.destroy', $rewardgroup], 'method' => 'delete']) !!}
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    {!! Form::close() !!}
                                </div>
                            </div>
                        </div>
                    </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>

    <!-- end:: Content -->
</div>
@endsection
