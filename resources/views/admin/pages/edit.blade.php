@extends('layout')

@section('pagetitle', 'Edit Page: ' . $page->title)

@section('content')
<div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
    <!-- begin:: Subheader -->
    <div class="kt-subheader   kt-grid__item" id="kt_subheader">
        <div class="kt-container  kt-container--fluid ">
            <div class="kt-subheader__main">
                <h3 class="kt-subheader__title">Edit Page</h3>
                <span class="kt-subheader__separator kt-hidden"></span>
                <div class="kt-subheader__breadcrumbs">
                    <a href="{{ route('admin.dashboard.index') }}" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
                    <span class="kt-subheader__breadcrumbs-separator"></span>
                    <a href="{{ route('admin.pages.index') }}" class="kt-subheader__breadcrumbs-link">Pages</a>
                    <span class="kt-subheader__breadcrumbs-separator"></span>
                    <a href="{{ route('admin.pages.edit', $page) }}" class="kt-subheader__breadcrumbs-link kt-subheader__breadcrumbs-link--active">Edit Page</a>
                </div>
            </div>

            <div class="kt-subheader__toolbar">
                <div class="kt-subheader__wrapper">
                    <a href="{{ route('pages.show_page', $page) }}" class="btn btn-icon btn btn-label btn-label-brand btn-bold" data-toggle="kt-tooltip" title="View Page" data-placement="top"><i class="la la-eye"></i></a>
                    <a href="{{ route('admin.pages.create') }}" class="btn btn-icon btn btn-label btn-label-brand btn-bold" data-toggle="kt-tooltip" title="Create Page" data-placement="top"><i class="la la-edit"></i></a>
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

        <div class="kt-portlet kt-portlet--mobile">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title">
                        {{ $page->title }}
                    </h3>
                </div>
            </div>
            <div class="kt-portlet__body">
                {{ Form::open(['route' => ['admin.pages.update', $page], 'class' => 'kt-form', 'method' => 'patch']) }}
                    <div class="form-group">
                        <label>Title</label>
                        {{ Form::text('title', $page->title, ['class' => 'form-control', 'required']) }}
                        <label class="kt-checkbox mt-2">
                            <input type="checkbox" name="generate-slug" value="true" checked> Auto Generate Slug from Title
                            <span></span>
                        </label>
                    </div>
                    <div class="form-group">
                        <label>Slug</label>
                        {{ Form::text('slug', $page->slug, ['class' => 'form-control']) }}
                    </div>
                    <div class="form-group">
                        <label>Content (HTML)</label>
                        <textarea id="content" name="content" class="tox-target">{!! $page->content !!}</textarea>
                    </div>
                    <div class="form-group">
                        <label>View</label>
                        {{ Form::text('view', $page->view, ['class' => 'form-control']) }}
                        <span class="form-text text-muted">View will be showed rather than the content set.</span>
                    </div>
                    <div class="form-group">
                        <label>Middleware</label>
                        {{ Form::text('middleware', $page->middleware, ['class' => 'form-control']) }}
                        <span class="form-text text-muted">Middleware required to access page.</span>
                    </div>
                    <div class="form-group">
                        <label>Sidebar</label>
                        <div class="kt-radio-inline">
                            <label class="kt-radio">
                                <input type="radio" name="showsidebar" value="1" @if ($page->showsidebar) checked @endif> Show
                                <span></span>
                            </label>
                            <label class="kt-radio">
                                <input type="radio" name="showsidebar" value="0" @if (!$page->showsidebar) checked @endif> Hide
                                <span></span>
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>State</label>
                        <div class="kt-radio-inline">
                            <label class="kt-radio">
                                <input type="radio" name="enabled" value="1" @if ($page->enabled) checked @endif> Enabled
                                <span></span>
                            </label>
                            <label class="kt-radio">
                                <input type="radio" name="enabled" value="0" @if (!$page->enabled) checked @endif> Disabled
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
{!! Theme::js('plugins/custom/tinymce/tinymce.bundle.js') !!}
<script>
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
</script>
@endsection
