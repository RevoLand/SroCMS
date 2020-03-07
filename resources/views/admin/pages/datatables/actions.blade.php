<a href="{{ route('pages.show_page', $slug) }}" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="View">
    <i class="la la-eye"></i>
</a>
<a href="{{ route('admin.pages.edit', $slug) }}" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Edit">
    <i class="la la-edit"></i>
</a>
<span class="dropdown">
    <a href="" class="btn btn-sm btn-clean btn-icon btn-icon-md" data-toggle="dropdown" aria-expanded="true">
        <i class="la la-ellipsis-h"></i>
    </a>
    <div class="dropdown-menu dropdown-menu-right">
        {!! Form::open(['route'=>['admin.pages.destroy', $slug], 'method' => 'delete']) !!}
        <button class="dropdown-item btn" role="button" type="submit">
            <i class="la la-remove"></i> Delete
        </button>
        {!! Form::close() !!}
    </div>
</span>
