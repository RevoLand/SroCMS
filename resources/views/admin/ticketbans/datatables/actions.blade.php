<div class="btn-group flex-wrap">
    <a href="{{ route('admin.ticketbans.edit', $id) }}" class="btn btn-sm btn-falcon-info">Edit</a>
    @if ($model->active)
    {!! Form::open([ 'route' => ['admin.ticketbans.cancel', $id], 'method' => 'patch', 'data-action' => 'cancel-ban' ]) !!}
    <button type="submit" class="btn btn-sm btn-falcon-info">Unban</button>
    {!! Form::close() !!}
    @endif
</div>
