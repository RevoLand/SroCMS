@extends('layout')

@section('pagetitle', 'Create Article')

@section('content')
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
                {{ Form::open(['route' => ['admin.articles.store'], 'class' => 'kt-form', 'method' => 'post', '@submit.prevent' => 'submitForm']) }}
                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" class="form-control" v-model="title" required>
                        <label class="kt-checkbox">
                            <input type="checkbox" true-value="1" false-value="0" class="form-control" v-model="generate_slug">
                            Auto Generate Slug from Title
                            <span></span>
                        </label>
                    </div>
                    <div class="form-group" v-show="generate_slug == 0">
                        <label>Slug</label>
                        <input type="text" class="form-control" v-model="slug">
                    </div>
                    <div class="form-group">
                        <label>Category</label>
                        <select class="form-control select2" v-model="categories" multiple="multiple" required>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Excerpt (HTML)</label>
                        <ckeditor :editor="editor" v-model="excerpt" :config="editorConfig"></ckeditor>
                    </div>
                    <div class="form-group">
                        <label>Content (HTML)</label>
                        <ckeditor :editor="editor" v-model="content" :config="editorConfig"></ckeditor>
                    </div>
                    <div class="form-group">
                        <label>Visibility</label>
                        <div class="kt-radio-inline">
                            <label class="kt-radio">
                                <input type="radio" v-model="is_visible" value="1"> Visible
                                <span></span>
                            </label>
                            <label class="kt-radio">
                                <input type="radio" v-model="is_visible" value="0"> Hidden
                                <span></span>
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Comments</label>
                        <div class="kt-radio-inline">
                            <label class="kt-radio">
                                <input type="radio" v-model="can_comment_on" value="1"> Enabled
                                <span></span>
                            </label>
                            <label class="kt-radio">
                                <input type="radio" v-model="can_comment_on" value="0"> Disabled
                                <span></span>
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Published On</label>
                        <input class="form-control dtpicker" type="datetime" v-model="published_at">
                        <span class="form-text text-muted">When article will be published on? If set, article won't be accessable by users until the given time.</span>
                    </div>
                    <div class="kt-portlet__foot">
                        <div class="kt-form__actions">
                            <button type="submit" class="btn btn-primary">Submit</button>
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
<script src="{{ asset('vendor/vue/ext/dtpicker.js') }}"></script>
<script src="{{ asset('vendor/vue/ext/select2.js') }}"></script>
<script src="{{ asset('vendor/axios.min.js') }}"></script>
<script type="text/javascript">
new Vue({
    el: '#kt_content',
    data: {
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
        },
        title: '',
        slug: '',
        generate_slug: '1',
        categories: [],
        excerpt: '',
        content: '',
        is_visible: '1',
        can_comment_on: '1',
        published_at: @json(date('Y-m-d H:i'))
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
