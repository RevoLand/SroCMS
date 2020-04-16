@extends('layout')

@section('pagetitle', 'Edit Article')

@section('content')
<div class="card mb-3">
    <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="mb-0">Edit Article</h5>
        <div>
            <a class="btn btn-falcon-primary mr-2" href="{{ route('admin.articles.create') }}">Create</a>
            <a class="btn btn-falcon-info" href="{{ route('admin.articles.index') }}">Article List</a>
        </div>
    </div>
    <div class="card-body bg-light">
        <div class="row">
            <div class="col-12">
                {{ Form::open(['route' => ['admin.articles.update', $article], 'method' => 'patch', '@submit.prevent' => 'onSubmit', '@change' => 'form.errors.clear($event.target.name)', 'class' => 'form-validation']) }}
                    @include('articles.forms.article')
                    <div class="btn-group" role="group">
                        <button type="submit" class="btn mr-2 btn-falcon-primary">Submit</button>
                        {!! Form::close() !!}
                        {!! Form::open([ 'route' => ['admin.articles.destroy', $article], 'method' => 'delete', '@submit.prevent' => 'deleteForm']) !!}
                        <button type="submit" class="btn btn-falcon-danger">Delete</button>
                        {!! Form::close() !!}
                    </div>
                {{ Form::close() }}
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
        form: new Form({
            title: @json($article->title),
            slug: @json($article->slug),
            generate_slug: '0',
            categories: @json($selectedCategories),
            excerpt: @json($article->excerpt),
            content: @json($article->content),
            is_visible: @json($article->is_visible),
            can_comment_on: @json($article->can_comment_on),
            published_at: @json($article->published_at)
        })
    },
    components: {
        ckeditor: CKEditor.component
    },
    methods: {
        onSubmit() {
            this.form.patch(event.target.action);
        },
        deleteForm() {
            this.form.delete(event.target.action)
            .then(response => {
                window.location.href = '{{ route('admin.articles.index') }}'
            });
        }
    }
});
</script>
@endsection
