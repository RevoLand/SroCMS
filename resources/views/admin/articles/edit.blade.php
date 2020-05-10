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
{!! Theme::js('lib/select2/select2.min.js') !!}
{!! Theme::js('lib/flatpickr/flatpickr.min.js') !!}
{!! Theme::js('lib/tinymce/tinymce.min.js') !!}
<script src="{{ asset('vendor/vue/components/tinymce.js') }}"></script>
<script src="{{ asset('vendor/vue/ext/flatpickr.js') }}"></script>
<script src="{{ asset('vendor/vue/ext/select2.js') }}"></script>

<script type="text/javascript">
new Vue({
    el: '.content',
    data: {
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
        }),
        editorConfig: {
            skin: 'oxide-dark',
            content_style: '.mce-content-body {color: #fff}',
            plugins: 'link,image,lists,table,media,autoresize',
            toolbar: 'styleselect | bold italic link bullist numlist image blockquote table media undo redo',
            statusbar: false,
            mobile: {
                menubar: true,
                toolbar_mode: 'floating'
            },
            menubar: true,
            menu: {
                file: { title: 'File', items: 'newdocument restoredraft | preview | print ' },
                edit: { title: 'Edit', items: 'undo redo | cut copy paste | selectall | searchreplace' },
                view: { title: 'View', items: 'code | visualaid visualchars visualblocks | spellchecker | preview fullscreen' },
                insert: { title: 'Insert', items: 'image link media template codesample inserttable | charmap emoticons hr | pagebreak nonbreaking anchor toc | insertdatetime' },
                format: { title: 'Format', items: 'bold italic underline strikethrough superscript subscript codeformat | formats blockformats fontformats fontsizes align | forecolor backcolor | removeformat' },
                tools: { title: 'Tools', items: 'spellchecker spellcheckerlanguage | code wordcount' },
                table: { title: 'Table', items: 'inserttable | cell row column | tableprops deletetable' },
                help: { title: 'Help', items: 'help' }
            }
        }
    },
    components: {
        editor: Editor
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
