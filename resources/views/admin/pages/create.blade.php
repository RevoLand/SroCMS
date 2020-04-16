@extends('layout')

@section('pagetitle', 'Create Page')

@section('content')
<div class="card mb-3">
    <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="mb-0">Create Page</h5>
        <div>
            <a class="btn btn-falcon-info" href="{{ route('admin.pages.index') }}">Pages</a>
        </div>
    </div>
    <div class="card-body bg-light">
        <div class="row">
            <div class="col-12">
                {{ Form::open(['route' => ['admin.pages.store'], 'method' => 'post', '@submit.prevent' => 'submitForm']) }}
                    @include('pages.forms.page')
                    <button type="submit" class="btn btn-falcon-primary">Submit</button>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
{!! Theme::js('lib/ckeditor/ckeditor.js') !!}
<script src="{{ asset('vendor/vue/vue.js') }}"></script>
<script src="{{ asset('vendor/vue/components/ckeditor.js') }}"></script>
<script src="{{ asset('vendor/axios.min.js') }}"></script>
<script src="{{ asset('vendor/srocms.js') }}"></script>
<script>
    new Vue({
        el: '.content',
        data: {
            form: new Form({
                title: '',
                slug: '',
                content: '',
                view: '',
                middleware: '',
                showsidebar: '1',
                enabled: '1',
                generate_slug: '1',
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
            }
        },
        components: {
            ckeditor: CKEditor.component
        },
        methods: {
            submitForm() {
                this.form.post(event.target.action)
                .then(response => {
                    this.form.reset();
                });
            }
        }
    });
</script>
@endsection
