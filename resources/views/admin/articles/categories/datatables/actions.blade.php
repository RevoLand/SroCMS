<a href="{{ route('articles.get_category', $slug) }}" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="View Category">
    <i class="la la-eye"></i>
</a>
<a href="{{ route('admin.articles.index', ['category_id' => $id]) }}" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="View Articles">
    <i class="la la-copy"></i>
</a>
<a href="{{ route('admin.articles.categories.edit', $slug) }}" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Edit">
    <i class="la la-edit"></i>
</a>
<span class="dropdown">
    <a href="" class="btn btn-sm btn-clean btn-icon btn-icon-md" data-toggle="dropdown" aria-expanded="true">
        <i class="la la-ellipsis-h"></i>
    </a>
    <div class="dropdown-menu dropdown-menu-right">
        {!! Form::open([ 'route' => ['admin.articles.categories.toggle_enabled', $slug], 'method' => 'patch', 'data-action' => 'toggle-enabled', 'data-id' => $id ]) !!}
        <button class="dropdown-item btn" role="button" type="submit">
            <i class="la la-eye-slash"></i> Toggle Enabled
        </button>
        {!! Form::close() !!}
        {!! Form::open([ 'route' => ['admin.articles.categories.destroy', $slug], 'method' => 'delete', 'data-action' => 'delete', 'data-id' => $id ]) !!}
        <button class="dropdown-item btn" role="button" type="submit">
            <i class="la la-remove"></i> Delete
        </button>
        {!! Form::close() !!}
    </div>
</span>
