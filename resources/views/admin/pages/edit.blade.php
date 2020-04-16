@extends('layout')

@section('pagetitle', 'Edit Page: ' . $page->title)

@section('content')
<div class="card mb-3">
    <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="mb-0">Edit Page</h5>
        <div>
            <a class="btn btn-falcon-primary mr-2" href="{{ route('admin.pages.create') }}">Create</a>
            <a class="btn btn-falcon-info" href="{{ route('admin.pages.index') }}">Pages</a>
        </div>
    </div>
    <div class="card-body bg-light">
        <div class="row">
            <div class="col-12">
                {{ Form::open(['route' => ['admin.pages.update', $page], 'method' => 'patch', '@submit.prevent' => 'submitForm']) }}
                    @include('pages.forms.page')
                    <div class="btn-group" role="group">
                        <button type="submit" class="btn btn-falcon-primary mr-2">Save</button>
                        {!! Form::close() !!}
                        {!! Form::open([ 'route' => ['admin.pages.destroy', $page], 'method' => 'delete', '@submit.prevent' => 'deleteForm']) !!}
                            <button type="submit" class="btn btn-falcon-danger">Delete</button>
                        {!! Form::close() !!}
                    </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
{!! Theme::js('lib/ckeditor/ckeditor.js') !!}
<script src="{{ asset('vendor/vue/components/ckeditor.js') }}"></script>
<script src="{{ asset('vendor/vue/vue.js') }}"></script>
<script src="{{ asset('vendor/axios.min.js') }}"></script>
<script src="{{ asset('vendor/srocms.js') }}"></script>
<script>
    new Vue({
        el: '.content',
        data: {
            form: new Form({
                title: @json($page->title),
                slug: @json($page->slug),
                content: @json($page->content),
                view: @json($page->view),
                middleware: @json($page->middleware),
                showsidebar: @json($page->showsidebar),
                enabled: @json($page->enabled),
                generate_slug: '0',
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
                this.form.patch(event.target.action);
            },
            deleteForm(event) {
                this.form.delete(event.target.action)
                .then(response => {
                    window.location.href = '{{ route('admin.pages.index') }}'
                });
            }
        }
    });
</script>
@endsection
