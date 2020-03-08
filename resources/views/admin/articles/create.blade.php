@extends('layout')

@section('pagetitle', 'Create Article')

@section('content')
<div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
    <!-- begin:: Subheader -->
    <div class="kt-subheader   kt-grid__item" id="kt_subheader">
        <div class="kt-container  kt-container--fluid ">
            <div class="kt-subheader__main">
                <h3 class="kt-subheader__title">Create Article</h3>
                <span class="kt-subheader__separator kt-hidden"></span>
                <div class="kt-subheader__breadcrumbs">
                    <a href="{{ route('admin.dashboard.index') }}" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
                    <span class="kt-subheader__breadcrumbs-separator"></span>
                    <a href="{{ route('admin.articles.index') }}" class="kt-subheader__breadcrumbs-link">Articles</a>
                    <span class="kt-subheader__breadcrumbs-separator"></span>
                    <a href="{{ route('admin.articles.create') }}" class="kt-subheader__breadcrumbs-link kt-subheader__breadcrumbs-link--active">Create Article</a>
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
                        Create Article
                    </h3>
                </div>
                <div class="kt-portlet__head-toolbar">
                    <div class="kt-portlet__head-actions">
                        <a href="{{ route('admin.articles.index') }}" class="btn btn-primary btn-upper btn-sm btn-bold">
                            <i class="la la-edit"></i> List Articles
                        </a>
                    </div>
                </div>
            </div>
            <div class="kt-portlet__body">
                {{ Form::open(['route' => ['admin.articles.store'], 'class' => 'kt-form', 'method' => 'post']) }}
                    <div class="form-group">
                        <label>Title</label>
                        {{ Form::text('title', old('title'), ['class' => 'form-control', 'srequired']) }}
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
                        <label>Category</label>
                        <select class="form-control category-selector" name="categories[]" multiple="multiple">
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" @if(in_array($category->id, old('categories', []))) selected @endif>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Excerpt (HTML)</label>
                        <textarea name="excerpt" class="tox-tinymce">{!! old('excerpt') !!}</textarea>
                    </div>
                    <div class="form-group">
                        <label>Content (HTML)</label>
                        <textarea name="content" class="tox-tinymce">{!! old('content') !!}</textarea>
                    </div>
                    <div class="form-group">
                        <label>Visibility</label>
                        <div class="kt-radio-inline">
                            <label class="kt-radio">
                                {!! Form::radio('is_visible', 1, old('is_visible', true)) !!} Visible
                                <span></span>
                            </label>
                            <label class="kt-radio">
                                {!! Form::radio('is_visible', 0, !old('is_visible', true)) !!} Hidden
                                <span></span>
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Comments</label>
                        <div class="kt-radio-inline">
                            <label class="kt-radio">
                                {!! Form::radio('can_comment_on', 1, old('can_comment_on', true)) !!} Enabled
                                <span></span>
                            </label>
                            <label class="kt-radio">
                                {!! Form::radio('can_comment_on', 0, !old('can_comment_on', true)) !!} Disabled
                                <span></span>
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Published On</label>
                        <input class="form-control" type="datetime" name="published_at" id="published_at" value="{{ old('published_at', date('Y-m-d H:i')) }}">
                        <span class="form-text text-muted">When article will be published on? If set, article won't be accessable by users until the given time.</span>
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
<script type="text/javascript">
$(document).ready(function() {
    $( ".category-selector" ).select2({
        placeholder: "Select a category"
    });

    $( "#published_at" ).datetimepicker({
        format: 'yyyy-mm-dd hh:ii',
        autoclose: true,
        todayBtn: true,
        pickerPosition: 'top-right'
    });
});
</script>
@endsection
