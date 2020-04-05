@extends('layout')

@section('pagetitle', 'Create Page')

@section('content')
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
                {{ Form::open(['route' => ['admin.pages.store'], 'class' => 'kt-form', 'method' => 'post', '@submit.prevent' => 'submitForm']) }}
                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" class="form-control" v-model="title" required>
                        <label class="kt-checkbox mt-2">
                            <input type="checkbox" v-model="generate_slug" true-value="1" false-value="0"> Auto Generate Slug from Title
                            <span></span>
                        </label>
                    </div>
                    <div class="form-group" v-show="generate_slug == 0">
                        <label>Slug</label>
                        <input type="text" class="form-control" v-model="slug">
                    </div>
                    <div class="form-group">
                        <label>Content</label>
                        <ckeditor :editor="editor" v-model="content" :config="editorConfig"></ckeditor>
                    </div>
                    <div class="form-group">
                        <label>View</label>
                        <input type="text" class="form-control" v-model="view">
                        <span class="form-text text-muted">View will be showed rather than the content set.</span>
                    </div>
                    <div class="form-group">
                        <label>Middleware</label>
                        <input type="text" class="form-control" v-model="middleware">
                        <span class="form-text text-muted">Middleware required to access page.</span>
                    </div>
                    <div class="form-group">
                        <label>Sidebar</label>
                        <div class="kt-radio-inline">
                            <label class="kt-radio">
                                <input type="radio" v-model="showsidebar" name="showsidebar" value="1"> Show
                                <span></span>
                            </label>
                            <label class="kt-radio">
                                <input type="radio" v-model="showsidebar" name="showsidebar" value="0"> Hide
                                <span></span>
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>State</label>
                        <div class="kt-radio-inline">
                            <label class="kt-radio">
                                <input type="radio" v-model="enabled" name="enabled" value="1"> Enabled
                                <span></span>
                            </label>
                            <label class="kt-radio">
                                <input type="radio" v-model="enabled" name="enabled" value="0"> Disabled
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
@endsection

@section('js')
{!! Theme::js('js/plugins/ckeditor/ckeditor.js') !!}
<script src="{{ asset('vendor/vue/components/ckeditor.js') }}"></script>
<script src="{{ asset('vendor/vue/vue.js') }}"></script>
<script src="{{ asset('vendor/axios.min.js') }}"></script>
<script>
    new Vue({
        el: '#kt_content',
        data: {
            title: '',
            slug: '',
            content: '',
            view: '',
            middleware: '',
            showsidebar: '1',
            enabled: '1',
            generate_slug: '1',
            editor: ClassicEditor,
            editorConfig: {
                toolbar: {
                    items: [
                        'bold',
                        'italic',
                        'underline',
                        'heading',
                        'fontFamily',
                        '|',
                        'fontSize',
                        'fontColor',
                        'fontBackgroundColor',
                        'highlight',
                        'removeFormat',
                        '|',
                        'link',
                        'code',
                        'codeBlock',
                        'comment',
                        'blockQuote',
                        'imageUpload',
                        '|',
                        'bulletedList',
                        'numberedList',
                        '|',
                        'alignment',
                        'indent',
                        'outdent',
                        '|',
                        'insertTable',
                        'todoList',
                        'mediaEmbed',
                        'undo',
                        'redo',
                        'horizontalLine'
                    ]
                },
                language: 'en',
                image: {
                    toolbar: [
                        'imageTextAlternative',
                        'imageStyle:full',
                        'imageStyle:side'
                    ]
                },
                table: {
                    contentToolbar: [
                        'tableColumn',
                        'tableRow',
                        'mergeTableCells',
                        'tableCellProperties',
                        'tableProperties'
                    ]
                }
            }
        },
        components: {
            ckeditor: CKEditor.component
        },
        methods: {
            submitForm(event) {
                KTApp.block('body');
                axios.post(event.target.action, this.$data)
                .then(response => {
                    swal.fire({
                        title: response.data.title,
                        html: response.data.message,
                        type: response.data.type
                    });
                })
                .catch(function (error) {
                    var errors = '<ul class="list-unstyled">';
                    jQuery.each(error.response.data.errors, function (key, value) {
                        errors += '<li>';
                        errors += value;
                        errors += '</li>';
                    });
                    errors += '</ul>';

                    swal.fire({
                        type: 'error',
                        title: error.response.data.message,
                        html: errors
                    });
                })
                .finally(() => {
                    KTApp.unblock('body');
                });
            }
        }
    });
</script>
@endsection
