@extends('layout')

@section('pagetitle', 'Edit Article')

@section('content')
<div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
    <!-- begin:: Subheader -->
    <div class="kt-subheader   kt-grid__item" id="kt_subheader">
        <div class="kt-container  kt-container--fluid ">
            <div class="kt-subheader__main">
                <h3 class="kt-subheader__title">Edit Article</h3>
                <span class="kt-subheader__separator kt-hidden"></span>
                <div class="kt-subheader__breadcrumbs">
                    <a href="{{ route('admin.dashboard.index') }}" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
                    <span class="kt-subheader__breadcrumbs-separator"></span>
                    <a href="{{ route('admin.articles.index') }}" class="kt-subheader__breadcrumbs-link">Articles</a>
                    <span class="kt-subheader__breadcrumbs-separator"></span>
                    <a href="{{ route('admin.articles.edit', $article) }}" class="kt-subheader__breadcrumbs-link kt-subheader__breadcrumbs-link--active">Edit Article</a>
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
                        Edit Article
                    </h3>
                </div>
                <div class="kt-portlet__head-toolbar">
                    <div class="kt-portlet__head-actions">
                        <a href="{{ route('articles.show_article', $article) }}" class="btn btn-accent btn-upper btn-sm btn-bold"><i class="la la-eye"></i> View Article</a>
                        <a href="{{ route('admin.articles.index') }}" class="btn btn-info btn-upper btn-sm btn-bold"><i class="la la-copy"></i> List Articles</a>
                        <a href="{{ route('admin.articles.create') }}" class="btn btn-primary btn-upper btn-sm btn-bold">
                            <i class="la la-edit"></i> Create Article
                        </a>
                    </div>
                </div>
            </div>
            <div class="kt-portlet__body">
                {{ Form::open(['route' => ['admin.articles.update', $article], 'class' => 'kt-form', 'method' => 'patch']) }}
                    <div class="form-group">
                        <label>Title</label>
                        {{ Form::text('title', $article->title, ['class' => 'form-control', 'required']) }}
                        <label class="kt-checkbox mt-2">
                            <input type="checkbox" name="generate-slug" value="true" checked> Auto Generate Slug from Title
                            <span></span>
                        </label>
                    </div>
                    <div class="form-group">
                        <label>Slug</label>
                        {{ Form::text('slug', $article->slug, ['class' => 'form-control']) }}
                    </div>
                    <div class="form-group">
                        <label>Category</label>
                        <select class="form-control category-selector" name="categories[]" multiple="multiple">
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" @if(in_array($category->id, $selectedCategories)) selected @endif>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Content (HTML)</label>
                        <textarea id="content" name="content" class="tox-target">{!! $article->content !!}</textarea>
                    </div>
                    <div class="form-group">
                        <label>Visibility</label>
                        <div class="kt-radio-inline">
                            <label class="kt-radio">
                                <input type="radio" name="is_visible" value="1" @if($article->is_visible) checked @endif> Visible
                                <span></span>
                            </label>
                            <label class="kt-radio">
                                <input type="radio" name="is_visible" value="0" @if(!$article->is_visible) checked @endif> Hidden
                                <span></span>
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Comments</label>
                        <div class="kt-radio-inline">
                            <label class="kt-radio">
                                <input type="radio" name="can_comment_on" value="1" @if($article->can_comment_on) checked @endif> Enabled
                                <span></span>
                            </label>
                            <label class="kt-radio">
                                <input type="radio" name="can_comment_on" value="0" @if(!$article->can_comment_on) checked @endif> Disabled
                                <span></span>
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Published At</label>
                        <input class="form-control" type="datetime" name="published_at" id="published_at" readonly value="{{ $article->published_at }}">
                        <span class="form-text text-muted">When article will be published at? If set, article won't be accessable by users until the given time.</span>
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
{!! Theme::js('plugins/custom/tinymce/tinymce.bundle.js') !!}
<script type="text/javascript">
$(document).ready(function() {
    $( ".category-selector" ).select2({
        placeholder: "Select a category"
    });

    $( "#published_at" ).datetimepicker({
        format: 'yyyy-mm-dd hh:ii',
        autoclose: true,
        todayBtn: true,
        clearBtn: true,
        pickerPosition: 'top-right'
    });

    tinymce.init({
    selector: 'textarea#content',
    plugins: 'print preview paste searchreplace autolink directionality code visualblocks visualchars fullscreen image link media codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists wordcount imagetools textpattern noneditable help charmap quickbars emoticons',
    imagetools_cors_hosts: ['picsum.photos'],
    menubar: 'file edit view insert format tools table help',
    toolbar: 'undo redo | bold italic underline strikethrough | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor removeformat | pagebreak | charmap emoticons | fullscreen  preview print | insertfile image media template link anchor codesample | ltr rtl',
    toolbar_sticky: true,
    image_advtab: true,
    importcss_append: true,
    template_cdate_format: '[Date Created (CDATE): %m/%d/%Y : %H:%M:%S]',
    template_mdate_format: '[Date Modified (MDATE): %m/%d/%Y : %H:%M:%S]',
    height: 600,
    image_caption: true,
    quickbars_selection_toolbar: 'bold italic | quicklink h2 h3 blockquote quickimage quicktable',
    noneditable_noneditable_class: "mceNonEditable",
    toolbar_drawer: 'sliding',
    contextmenu: "link image imagetools table",
    });
});
</script>
@endsection
