@extends('layout')

@section('pagetitle', 'Create Page')

@section('content')
<div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
    <!-- begin:: Subheader -->
    <div class="kt-subheader   kt-grid__item" id="kt_subheader">
        <div class="kt-container  kt-container--fluid ">
            <div class="kt-subheader__main">
                <h3 class="kt-subheader__title">Create Page</h3>
                <span class="kt-subheader__separator kt-hidden"></span>
                <div class="kt-subheader__breadcrumbs">
                    <a href="{{ route('admin.dashboard.index') }}" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
                    <span class="kt-subheader__breadcrumbs-separator"></span>
                    <a href="{{ route('admin.pages.index') }}" class="kt-subheader__breadcrumbs-link">Pages</a>
                    <span class="kt-subheader__breadcrumbs-separator"></span>
                    <a href="{{ route('admin.pages.create') }}" class="kt-subheader__breadcrumbs-link kt-subheader__breadcrumbs-link--active">Create Page</a>
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
                        Create Page
                    </h3>
                </div>
                <div class="kt-portlet__head-toolbar">
                    <div class="kt-portlet__head-actions">
                        <a href="{{ route('admin.pages.index') }}" class="btn btn-primary btn-upper btn-sm btn-bold">
                            <i class="la la-copy"></i> List Pages
                        </a>
                    </div>
                </div>
            </div>
            <div class="kt-portlet__body">
                {{ Form::open(['route' => ['admin.pages.store'], 'class' => 'kt-form', 'method' => 'post']) }}
                    <div class="form-group">
                        <label>Title</label>
                        {{ Form::text('title', old('title'), ['class' => 'form-control', 'required']) }}
                        <label class="kt-checkbox mt-2">
                            <input type="checkbox" name="generate-slug" value="true" checked> Auto Generate Slug from Title
                            <span></span>
                        </label>
                    </div>
                    <div class="form-group">
                        <label>Slug</label>
                        {{ Form::text('slug', old('slug'), ['class' => 'form-control']) }}
                    </div>
                    <div class="form-group">
                        <label>Content (HTML)</label>
                        <textarea name="content" class="tox-tinymce">{!! old('content') !!}</textarea>
                    </div>
                    <div class="form-group">
                        <label>View</label>
                        {{ Form::text('view', old('view'), ['class' => 'form-control']) }}
                        <span class="form-text text-muted">View will be showed rather than the content set.</span>
                    </div>
                    <div class="form-group">
                        <label>Middleware</label>
                        {{ Form::text('middleware', old('middleware'), ['class' => 'form-control']) }}
                        <span class="form-text text-muted">Middleware required to access page.</span>
                    </div>
                    <div class="form-group">
                        <label>Sidebar</label>
                        <div class="kt-radio-inline">
                            <label class="kt-radio">
                                {!! Form::radio('showsidebar', 1, old('showsidebar', true)) !!} Show
                                <span></span>
                            </label>
                            <label class="kt-radio">
                                {!! Form::radio('showsidebar', 0, !old('showsidebar', true)) !!} Hide
                                <span></span>
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>State</label>
                        <div class="kt-radio-inline">
                            <label class="kt-radio">
                                {!! Form::radio('enabled', 1, old('enabled', true)) !!} Enabled
                                <span></span>
                            </label>
                            <label class="kt-radio">
                                {!! Form::radio('enabled', 0, !old('enabled', true)) !!} Disabled
                                <span></span>
                            </label>
                        </div>
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

@section('js')
{!! Theme::js('plugins/tinymce/tinymce.min.js') !!}
{!! Theme::js('js/pages/tinymce-editor.js') !!}
@endsection
