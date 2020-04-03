@extends('layout')

@section('pagetitle', 'Edit Comment')

@section('content')
<div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
    <!-- begin:: Subheader -->
    <div class="kt-subheader   kt-grid__item" id="kt_subheader">
        <div class="kt-container  kt-container--fluid ">
            <div class="kt-subheader__main">
                <h3 class="kt-subheader__title">Edit Comment</h3>
                <span class="kt-subheader__separator kt-hidden"></span>
                <div class="kt-subheader__breadcrumbs">
                    <a href="{{ route('admin.dashboard.index') }}" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
                    <span class="kt-subheader__breadcrumbs-separator"></span>
                    <a href="{{ route('admin.articles.index') }}" class="kt-subheader__breadcrumbs-link">Articles</a>
                    <span class="kt-subheader__breadcrumbs-separator"></span>
                    <a href="{{ route('admin.articles.comments.index') }}" class="kt-subheader__breadcrumbs-link">Comments</a>
                    <span class="kt-subheader__breadcrumbs-separator"></span>
                    <a href="{{ route('admin.articles.comments.edit', $comment) }}" class="kt-subheader__breadcrumbs-link kt-subheader__breadcrumbs-link--active">Edit Comment</a>
                </div>
            </div>
        </div>
    </div>
    <!-- end:: Subheader -->

    <!-- begin:: Content -->
    <div class="kt-container kt-container--fluid  kt-grid__item kt-grid__item--fluid">
        @if (session('message'))
        <div class="row">
            <div class="col">
                <div class="alert alert-light alert-elevate fade show" role="alert">
                    <div class="alert-icon"><i class="la la-check-square kt-font-brand"></i></div>
                    <div class="alert-text">
                        {{ session('message') }}
                    </div>
                </div>
            </div>
        </div>
        @endif
        @if ($errors->any())
        <div class="row">
            <div class="col">
                <div class="alert alert-danger alert-elevate fade show" role="alert">
                    <div class="alert-icon"><i class="la la-warning kt-font-brand"></i></div>
                    <div class="alert-text">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        @endif

        <div class="kt-portlet kt-portlet--mobile">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title">
                        Edit Comment
                    </h3>
                </div>
                <div class="kt-portlet__head-toolbar">
                    <div class="kt-portlet__head-actions">
                        <a href="{{ route('articles.show_article', $comment->article->slug) }}" class="btn btn-accent btn-upper btn-sm btn-bold">
                            <i class="la la-eye"></i> View Article
                        </a>
                        <a href="{{ route('admin.articles.edit', $comment->article) }}" class="btn btn-info btn-upper btn-sm btn-bold">
                            <i class="la la-edit"></i> Edit Article
                        </a>
                        <a href="{{ route('admin.articles.comments.index') }}" class="btn btn-primary btn-upper btn-sm btn-bold">
                            <i class="la la-copy"></i> List Comment
                        </a>
                    </div>
                </div>
            </div>
            <div class="kt-portlet__body">
                {!! Form::open(['route'=>['admin.articles.comments.update',$comment],'class'=>'kt-form','method'=>'patch']) !!}
                    <div class="form-group">
                        <label>Article</label><br />
                        <span class="lead">
                            {{ $comment->article->title }}
                        </span>
                    </div>
                    <div class="form-group">
                        <label>User</label><br />
                        <span class="lead">
                            <a class="page-link" href="{{ route('admin.users.edit', $comment->user) }}" title="Edit User">
                                {{ $comment->user->getName() }}
                            </a>
                        </span>
                        <span class="form-text">
                            <a href="{{ route('admin.articles.comments.index', ['user_id' => $comment->user_id]) }}" title="View User Comments">
                                Approved Comments: {{ $comment->user->articleComments->count() }}
                            </a>
                        </span>
                    </div>
                    <div class="form-group">
                        <label>Comment</label>
                        {!! Form::textarea('content',$comment->content,['class'=>'form-control']) !!}
                    </div>
                    <div class="form-group">
                        <label>Visibility</label>
                        <div class="kt-radio-inline">
                            <label class="kt-radio">
                                {!! Form::radio('is_visible', 1, $comment->is_visible) !!} Visible
                                <span></span>
                            </label>
                            <label class="kt-radio">
                                {!! Form::radio('is_visible', 0, !$comment->is_visible) !!} Hidden
                                <span></span>
                            </label>
                        </div>
                        <span class="form-text text-muted">Comment won't be visible if visibility set to hidden.</span>
                    </div>
                    <div class="form-group">
                        <label>Approval</label>
                        <div class="kt-radio-inline">
                            <label class="kt-radio">
                                {!! Form::radio('is_approved', 1, $comment->is_approved) !!} Approved
                                <span></span>
                            </label>
                            <label class="kt-radio">
                                {!! Form::radio('is_approved', 0, !$comment->is_approved) !!} Not Approved
                                <span></span>
                            </label>
                        </div>
                        <span class="form-text text-muted">Comment won't be visible until it is approved.</span>
                    </div>
                    <div class="kt-portlet__foot">
                        <div class="kt-form__actions kt-form__actions--right">
                            <div class="row">
                                <div class="col kt-align-left">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                    <button type="reset" class="btn btn-secondary">Cancel</button>
                                    {!! Form::close() !!}
                                </div>
                                <div class="col kt-align-right">
                                    {!! Form::open([ 'route' => ['admin.articles.comments.destroy', $comment], 'method' => 'delete']) !!}
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    {!! Form::close() !!}
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>

    <!-- end:: Content -->
</div>
@endsection

@section('js')
<script>
    $(function() {
        var slugCheckboxSelector = $( "input[name='generate-slug']");

        if (!slugCheckboxSelector[0].checked) {
            $('.slug-field').show({});
        }

        slugCheckboxSelector.click(function() {
            if (this.checked){
                $('.slug-field').hide({});
            } else {
                $('.slug-field').show({});
            }
        });
    });
</script>
@endsection
