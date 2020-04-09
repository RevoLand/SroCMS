@extends('layout')

@section('pagetitle', 'Edit Article')

@section('content')
<div class="card mb-3">
    <div class="card-header">
      <h5 class="mb-0">Edit Article</h5>
    </div>
    <div class="card-body bg-light">
        <div class="row">
            <div class="col-12">
                {{ Form::open(['route' => ['admin.articles.update', $article], 'method' => 'patch', '@submit.prevent' => 'submitForm']) }}
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
        title: @json($article->title),
        slug: @json($article->slug),
        generate_slug: '0',
        categories: @json($selectedCategories),
        excerpt: @json($article->excerpt),
        content: @json($article->content),
        is_visible: @json($article->is_visible),
        can_comment_on: @json($article->can_comment_on),
        published_at: @json($article->published_at)
    },
    components: {
        // Use the <ckeditor> component in this view.
        ckeditor: CKEditor.component
    },
    methods: {
        submitForm(event) {
            $('.content').block();
            axios.patch(event.target.action, this.$data)
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
        },
        deleteForm(event) {
            swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (!result.value) {
                    return;
                }

                $('.content').block();

                axios.delete(event.target.action)
                .then(response => {
                    swal.fire({
                        title: response.data.title,
                        html: response.data.message,
                        icon: response.data.icon
                    }).then((result) => {
                        window.location.href = '{{ route('admin.articles.index') }}'
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
            });
        }
    }
});
</script>
@endsection
