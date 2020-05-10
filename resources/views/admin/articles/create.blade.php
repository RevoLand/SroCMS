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
            this.form.post(event.target.action)
            .then(response => {
                this.form.reset();
            });
        }
    }
});
</script>
@endsection
