@extends('layout')

@section('pagetitle', 'Create Article')

@section('content')
<div class="card mb-3">
    <div class="card-header">
      <h5 class="mb-0">Create Article</h5>
    </div>
    <div class="card-body bg-light">
        <div class="row">
            <div class="col-12">
                {{ Form::open(['route' => ['admin.articles.store'], 'method' => 'post', '@submit.prevent' => 'submitForm']) }}
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
<script src="{{ asset('vendor/vue/vue.js') }}"></script>
<script src="{{ asset('vendor/vue/components/ckeditor.js') }}"></script>
<script src="{{ asset('vendor/vue/ext/flatpickr.js') }}"></script>
<script src="{{ asset('vendor/vue/ext/select2.js') }}"></script>
<script src="{{ asset('vendor/axios.min.js') }}"></script>

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
                    type: 'error',
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
