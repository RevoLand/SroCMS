<a href="{{ route('admin.votes.providers.edit', $id) }}" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Edit">
    <i class="la la-edit"></i>
</a>
{!! Form::open([ 'route' => ['admin.votes.providers.ips.destroy', $id], 'method' => 'delete', 'data-action' => 'delete', 'data-id' => $id ]) !!}
<button class="btn btn-sm btn-clean btn-icon btn-icon-md" role="button" type="submit">
    <i class="la la-trash"></i>
</button>
{!! Form::close() !!}
