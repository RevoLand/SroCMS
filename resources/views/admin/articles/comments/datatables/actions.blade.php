<a href="{{ route('articles.show_article', $model->article) }}" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="View Article">
    <i class="la la-eye"></i>
</a>
<a href="{{ route('admin.users.show', $model->user) }}" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="View User">
    <i class="la la-user"></i>
</a>
<a href="{{ route('admin.articles.comments.edit', $id) }}" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Edit Comment">
    <i class="la la-edit"></i>
</a>
<span class="dropdown">
    <a href="" class="btn btn-sm btn-clean btn-icon btn-icon-md" data-toggle="dropdown" aria-expanded="true">
        <i class="la la-ellipsis-h"></i>
    </a>
    <div class="dropdown-menu dropdown-menu-right">
        {!! Form::open([ 'route' => ['admin.articles.comments.toggle_visibility', $id], 'method' => 'patch', 'data-action' => 'toggle-visibility', 'data-id' => $id ]) !!}
        <button class="dropdown-item btn" role="button" type="submit">
            <i class="la la-eye-slash"></i> Toggle Visibility
        </button>
        {!! Form::close() !!}
        {!! Form::open([ 'route' => ['admin.articles.comments.toggle_approved', $id], 'method' => 'patch', 'data-action' => 'toggle-approved', 'data-id' => $id ]) !!}
        <button class="dropdown-item btn" role="button" type="submit">
            <i class="la la-comment-slash"></i> Toggle Approve State
        </button>
        {!! Form::close() !!}
        {!! Form::open([ 'route' => ['admin.articles.comments.destroy_ajax', $id], 'method' => 'delete', 'data-action' => 'delete', 'data-id' => $id ]) !!}
        <button class="dropdown-item btn" role="button" type="submit">
            <i class="la la-remove"></i> Delete
        </button>
        {!! Form::close() !!}
    </div>
</span>
