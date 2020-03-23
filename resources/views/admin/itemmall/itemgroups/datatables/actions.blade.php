<a href="{{ route('admin.itemmall.itemgroups.edit', $id) }}" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Edit">
    <i class="la la-edit"></i>
</a>
<span class="dropdown">
    <a href="" class="btn btn-sm btn-clean btn-icon btn-icon-md" data-toggle="dropdown" aria-expanded="true">
        <i class="la la-ellipsis-h"></i>
    </a>
    <div class="dropdown-menu dropdown-menu-right">
        {!! Form::open([ 'route' => ['admin.itemmall.itemgroups.toggle_enabled', $id], 'method' => 'patch', 'data-action' => 'toggle-enabled', 'data-id' => $id ]) !!}
        <button class="dropdown-item btn" role="button" type="submit">
            <i class="la la-eye-slash"></i> Toggle Enabled
        </button>
        {!! Form::close() !!}
        {!! Form::open([ 'route' => ['admin.itemmall.itemgroups.destroy', $id], 'method' => 'delete', 'data-action' => 'delete', 'data-id' => $id ]) !!}
        <button class="dropdown-item btn" role="button" type="submit">
            <i class="la la-remove"></i> Delete
        </button>
        {!! Form::close() !!}
    </div>
</span>
