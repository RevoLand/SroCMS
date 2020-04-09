@extends('layout')

@section('pagetitle', 'Create Page')

@section('content')
<div class="card mb-3">
    <div class="card-header">
      <h5 class="mb-0">Create Page</h5>
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
<script>
    new Vue({
        el: '.content',
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
                $('.content').block();
                axios.post(event.target.action, this.$data)
                .then(response => {
                    swal.fire({
                        title: response.data.title,
                        html: response.data.message,
                        icon: response.data.icon
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
                        icon: 'error',
                        title: error.response.data.message,
                        html: errors
                    });
                })
                .finally(() => {
                    $('.content').unblock();
                });
            }
        }
    });
</script>
@endsection
