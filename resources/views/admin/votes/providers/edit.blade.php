@extends('layout')

@section('pagetitle', 'Edit Vote Provider')

@section('content')
    <!-- begin:: Subheader -->
    <div class="kt-subheader   kt-grid__item" id="kt_subheader">
        <div class="kt-container  kt-container--fluid ">
            <div class="kt-subheader__main">
                <h3 class="kt-subheader__title">Edit Vote Provider</h3>
                <span class="kt-subheader__separator kt-hidden"></span>
                <div class="kt-subheader__breadcrumbs">
                    <a href="{{ route('admin.dashboard.index') }}" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
                    <span class="kt-subheader__breadcrumbs-separator"></span>
                    <a href="{{ route('admin.votes.index') }}" class="kt-subheader__breadcrumbs-link">Vote System</a>
                    <span class="kt-subheader__breadcrumbs-separator"></span>
                    <a href="{{ route('admin.votes.providers.index') }}" class="kt-subheader__breadcrumbs-link">Vote Providers</a>
                    <span class="kt-subheader__breadcrumbs-separator"></span>
                    <a href="{{ route('admin.votes.providers.edit', $provider) }}" class="kt-subheader__breadcrumbs-link kt-subheader__breadcrumbs-link--active">Edit</a>
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
                        {!! session('message') !!}
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
                        Edit Vote Provider: {{ $provider->name }}
                    </h3>
                </div>
                <div class="kt-portlet__head-toolbar">
                    <div class="kt-portlet__head-actions">
                        <a href="{{ route('admin.votes.providers.create') }}" class="btn btn-primary btn-upper btn-sm btn-bold">
                            <i class="la la-pen"></i> Create Provider
                        </a>
                        <a href="{{ route('admin.votes.providers.index') }}" class="btn btn-primary btn-upper btn-sm btn-bold">
                            <i class="la la-copy"></i> List Providers
                        </a>
                    </div>
                </div>
            </div>
            <div class="kt-portlet__body">
                {{ Form::open(['route' => ['admin.votes.providers.update', $provider], 'class' => 'kt-form', 'method' => 'patch']) }}
                    <div class="form-group">
                        <label>Name</label>
                        {{ Form::text('name', $provider->name, ['class' => 'form-control', 'required']) }}
                    </div>
                    <div class="form-group">
                        <label>URL</label>
                        {{ Form::text('url', $provider->url, ['class' => 'form-control', 'required']) }}
                        <span class="form-text text-muted">
                            The URL which user will be redirected to, <mark>https://silkroad-servers.com/index.php?a=in&u=sroland</mark> for example.<br />
                            <strong>DO NOT INCLUDE USER PART IN THE URL!</strong>
                        </span>
                    </div>
                    <div class="form-group">
                        <label>URL Username Attribute</label>
                        {{ Form::text('url_user_name', $provider->url_user_name, ['class' => 'form-control', 'required']) }}
                        <span class="form-text text-muted">
                            The Username attribute that vote provider is asking for; setting this option as '<mark>id</mark>' will result as: <mark>https://silkroad-servers.com/index.php?a=in&u=sroland<b>&id=GENERATED_USER_VOTE_SECRET</b></mark>
                        </span>
                    </div>
                    <div class="form-group">
                        <label>Callback Secret</label>
                        {{ Form::text('callback_secret', $provider->callback_secret, ['class' => 'form-control']) }}
                        <label class="kt-checkbox mt-2">
                            {!! Form::checkbox('generate-callback_secret', 1, false) !!} Re-Generate Secret
                            <span></span>
                        </label>
                    </div>
                    <div class="form-group">
                        <label>Callback Username Attribute</label>
                        {{ Form::text('callback_user_name', $provider->callback_user_name, ['class' => 'form-control', 'required']) }}
                        <span class="form-text text-muted">The attribute name vote provider will be sent for callback which should represent what we have sent to the provider. For example if it is set to <mark>userid</mark>, we will try to get the <mark>GENERATED_USER_VOTE_SECRET</mark> from <mark>userid</mark> request.</span>
                    </div>
                    <div class="form-group">
                        <label>Callback Success Attribute <i>*nullable</i></label>
                        {{ Form::text('callback_success_name', $provider->callback_success_name, ['class' => 'form-control']) }}
                        <span class="form-text text-muted">
                            The attribute name vote provider will be sent for callback which should represent if the vote succeed or not. For example if it is set to <mark>voted</mark>, we will use <mark>voted</mark> attribute from the request to detect if user has been voted or not.<br />
                            * This is not required by all vote providers so it can be left empty.
                        </span>
                    </div>
                    <div class="form-group">
                        <label>Time Interval for Voting (minutes)</label>
                        {{ Form::text('minutes_between_votes', $provider->minutes_between_votes, ['class' => 'form-control', 'type' => 'number', 'required']) }}
                        <span class="form-text text-muted">Time needs to be passed after a successful vote before voting again.</span>
                    </div>
                    <div class="form-group">
                        <label>State</label>
                        <div class="kt-radio-inline">
                            <label class="kt-radio">
                                {!! Form::radio('enabled', 1, $provider->enabled) !!} Enabled
                                <span></span>
                            </label>
                            <label class="kt-radio">
                                {!! Form::radio('enabled', 0, !$provider->enabled) !!} Disabled
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
                                    {!! Form::open([ 'route' => ['admin.votes.providers.destroy', $provider], 'method' => 'delete']) !!}
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
@endsection
