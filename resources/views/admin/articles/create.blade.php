@extends('layout')

@section('pagetitle', 'Create Article')

@section('content')
<div class="card mb-3">
    <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="mb-0">Create Article</h5>
        <div>
            <a class="btn btn-falcon-info" href="{{ route('admin.articles.index') }}">Article List</a>
        </div>
    </div>
    <div class="card-body bg-light">
        <div class="row">
            <div class="col-12">
                {{ Form::open(['route' => ['admin.articles.store'], 'method' => 'post', '@submit.prevent' => 'onSubmit', '@change' => 'form.errors.clear($event.target.name)', 'class' => 'form-validation']) }}
                    @include('articles.forms.article')
                    <button type="submit" class="btn btn-falcon-primary">Submit</button>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
{!! Theme::js('lib/ckeditor/ckeditor.js') !!}
{!! Theme::js('lib/select2/select2.min.js') !!}
{!! Theme::js('lib/flatpickr/flatpickr.min.js') !!}
<script src="{{ asset('vendor/vue/components/ckeditor.js') }}"></script>
<script src="{{ asset('vendor/vue/ext/flatpickr.js') }}"></script>
<script src="{{ asset('vendor/vue/ext/select2.js') }}"></script>

<script type="text/javascript">
new Vue({
    el: '.content',
    data: {
        form: new Form({
            title: '',
            slug: '',
            generate_slug: '1',
            categories: [],
            excerpt: '',
            content: '',
            is_visible: '1',
            can_comment_on: '1',
            published_at: @json(date('Y-m-d H:i'))
        }),
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
    },
    components: {
        ckeditor: CKEditor.component
    },
    methods: {
        onSubmit() {
            this.form.post(event.target.action)
            .then(response => {
                this.form.reset();
            });
        }
    }
});
</script>
@endsection
