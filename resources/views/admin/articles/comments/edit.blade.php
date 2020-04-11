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
                {!! Form::open(['route'=>['admin.articles.comments.update', $comment], 'method' => 'patch']) !!}
                <div class="form-group">
                    <label>Article</label><br />
                    <span class="lead">
                        {{ $comment->article->title }}
                    </span>
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
                                    Approved Comments: {{ $comment->user->articleComments->count() }}
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>Comment</label>
                    {!! Form::textarea('content', $comment->content, ['class'=>'form-control']) !!}
                </div>
                <div class="form-group">
                    <label>Visibility</label>
                    <div class="row col-12">
                        <div class="custom-control custom-radio custom-control-inline">
                            {!! Form::radio('is_visible', 1, $comment->is_visible, ['class' => 'custom-control-input', 'id' => 'is_visible_true']) !!}
                            <label for="is_visible_true" class="custom-control-label">Visible</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            {!! Form::radio('is_visible', 0, !$comment->is_visible, ['class' => 'custom-control-input', 'id' => 'is_visible_false']) !!}
                            <label for="is_visible_false" class="custom-control-label">Hidden</label>
                        </div>
                    </div>
                    <span class="form-text text-muted">Comment won't be visible if visibility set to hidden.</span>
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <div class="row col-12">
                        <div class="custom-control custom-radio custom-control-inline">
                            {!! Form::radio('is_approved', 1, $comment->is_approved, ['class' => 'custom-control-input', 'id' => 'is_approved_true']) !!}
                            <label for="is_approved_true" class="custom-control-label">Approved</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            {!! Form::radio('is_approved', 0, !$comment->is_approved, ['class' => 'custom-control-input', 'id' => 'is_approved_false']) !!}
                            <label for="is_approved_false" class="custom-control-label">Not Approved</label>
                        </div>
                    </div>
                    <span class="form-text text-muted">Comment won't be visible until it is approved.</span>
                </div>
                <div class="btn-group" role="group">
                    <button type="submit" class="btn btn-falcon-primary">Save</button>
                    <button type="reset" class="btn btn-falcon-info mr-2">Cancel</button>
                    {!! Form::close() !!}
                    {!! Form::open([ 'route' => ['admin.articles.comments.destroy', $comment], 'method' => 'delete']) !!}
                        <button type="submit" class="btn btn-falcon-danger">Delete</button>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
