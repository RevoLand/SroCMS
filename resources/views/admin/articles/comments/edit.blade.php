@extends('layout')

@section('pagetitle', 'Edit Comment')

@section('content')
<div class="card mb-3">
    <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="mb-0">Edit Comment</h5>
        <div>
            <a class="btn btn-falcon-info" href="{{ route('admin.articles.comments.index') }}">Comments</a>
        </div>
    </div>
    <div class="card-body bg-light">
        @include('components.message')
        @include('components.errors')
        <div class="row">
            <div class="col-12">
                {!! Form::open(['route'=>['admin.articles.comments.update', $comment], 'method' => 'patch', '@submit.prevent' => 'onSubmit', '@change' => 'form.errors.clear($event.target.name)', 'class' => 'form-validation']) !!}
                <div class="form-group">
                    <label>Article</label><br />
                    <span class="lead">{{ $comment->article->title }}</span>
                </div>
                <div class="form-group">
                    <label>User</label><br />
                    <div class="media">
                        @isset($comment->user->gravatar)
                        <a class="align-self-center mb-2" href="{{ route('admin.users.show', $comment->user) }}">
                            <img class="img-fluid" src="{{ $comment->user->gravatar }}" alt="{{ $comment->user->StrUserID }}">
                        </a>
                        @endisset
                        <div class="media-body position-relative pl-2 fs--1">
                            <h6 class="fs-0 mb-0">
                                <a class="align-self-center mb-2" href="{{ route('admin.users.show', $comment->user) }}">
                                    {{ $comment->user->StrUserID }}
                                </a>
                            </h6>
                            @isset($comment->user->Name)<p class="mb-1">{{ $comment->user->Name }}</p>@endisset
                            <p class="text-1000">
                                <a class="text-reset" href="{{ route('admin.articles.comments.index', ['user_id' => $comment->user_id]) }}" title="View User Comments">
                                    Total Comments: {{ $comment->total_comments }}<br/>
                                    Approved & Visible Comments: {{ $comment->approved_comments }}
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>Comment</label>
                    <textarea class="form-control" v-text="form.content"></textarea>
                </div>
                <div class="form-group">
                    <label>Visibility</label>
                    <div class="row col-12">
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" id="is_visible_true" v-model="form.is_visible" value="1"/>
                            <label for="is_visible_true" class="custom-control-label">Visible</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" id="is_visible_false" v-model="form.is_visible" value="0"/>
                            <label for="is_visible_false" class="custom-control-label">Hidden</label>
                        </div>
                    </div>
                    <span class="form-text text-muted">Comment won't be visible if visibility set to hidden.</span>
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <div class="row col-12">
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" id="is_approved_true" v-model="form.is_approved" value="1"/>
                            <label for="is_approved_true" class="custom-control-label">Approved</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" id="is_approved_false" v-model="form.is_approved" value="0"/>
                            <label for="is_approved_false" class="custom-control-label">Not Approved</label>
                        </div>
                    </div>
                    <span class="form-text text-muted">Comment won't be visible until it is approved.</span>
                </div>
                <div class="btn-group" role="group">
                    <button type="submit" class="btn btn-falcon-primary">Save</button>
                    {!! Form::close() !!}
                    {!! Form::open([ 'route' => ['admin.articles.comments.destroy', $comment], 'method' => 'delete', '@submit.prevent' => 'deleteForm']) !!}
                        <button type="submit" class="btn btn-falcon-danger">Delete</button>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="{{ asset('vendor/vue/vue.js') }}"></script>
<script src="{{ asset('vendor/axios.min.js') }}"></script>
<script src="{{ asset('vendor/srocms.js') }}"></script>
<script>
    new Vue({
        el: '.content',
        data: {
            form: new Form({
                content: @json($comment->content),
                is_visible: @json($comment->is_visible),
                is_approved: @json($comment->is_approved)
            })
        },
        methods: {
            onSubmit() {
                this.form.patch(event.target.action);
            },
            deleteForm() {
                this.form.delete(event.target.action)
                .then(response => {
                    window.location.href = '{{ route('admin.articles.comments.index') }}'
                });
            }
        }
    });
</script>
@endsection
