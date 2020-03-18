<a href="{{ route('articles.show_article', $slug) }}" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="View">
    <i class="la la-eye"></i>
</a>
<a href="{{ route('admin.articles.edit', $slug) }}" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Edit">
    <i class="la la-edit"></i>
</a>
<span class="dropdown">
    <a href="" class="btn btn-sm btn-clean btn-icon btn-icon-md" data-toggle="dropdown" aria-expanded="true">
        <i class="la la-ellipsis-h"></i>
    </a>
    <div class="dropdown-menu dropdown-menu-right">
        {!! Form::open([ 'route' => ['admin.articles.toggle_visibility', $slug], 'method' => 'patch', 'data-action' => 'toggle-visibility', 'data-id' => $id ]) !!}
        <button class="dropdown-item btn" role="button" type="submit">
            <i class="la la-eye-slash"></i> Toggle Visibility
        </button>
        {!! Form::close() !!}
        {!! Form::open([ 'route' => ['admin.articles.toggle_comments', $slug], 'method' => 'patch', 'data-action' => 'toggle-comments', 'data-id' => $id ]) !!}
        <button class="dropdown-item btn" role="button" type="submit">
            <i class="la la-comments"></i> Toggle Comments
        </button>
        {!! Form::close() !!}
        {!! Form::open([ 'route' => ['admin.articles.destroy_ajax', $slug], 'method' => 'delete', 'data-action' => 'delete', 'data-id' => $id ]) !!}
        <button class="dropdown-item btn" role="button" type="submit">
            <i class="la la-remove"></i> Delete
        </button>
        {!! Form::close() !!}
    </div>
</span>
