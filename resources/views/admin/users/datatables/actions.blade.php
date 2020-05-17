<div class="dropdown text-sans-serif">
	<button class="btn btn-link text-600 btn-sm dropdown-toggle btn-reveal mr-3" type="button" id="dt_dropdown-{{ $JID }}" data-toggle="dropdown" data-boundary="viewport" aria-haspopup="true" aria-expanded="false">
		<span class="fas fa-ellipsis-h fs--1"></span>
	</button>
	<div class="dropdown-menu dropdown-menu-right border py-0" aria-labelledby="dt_dropdown-{{ $JID }}">
		<div class="bg-white py-2">
			<a class="dropdown-item" href="{{ route('admin.users.show', $JID) }}">View</a>
            <a class="dropdown-item" href="{{ route('admin.users.edit', $JID) }}">Edit</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="{{ route('admin.users.bans.create', ['user' => $JID]) }}">Ban</a>
            <div class="dropdown-divider"></div>
            {{-- {!! Form::open([ 'route' => ['admin.users.destroy', $id], 'method' => 'delete', 'data-action' => 'delete', 'data-id' => $id ]) !!} --}}
            <button class="dropdown-item text-danger" type="submit">Delete</button>
            {{-- {!! Form::close() !!} --}}
		</div>
	</div>
</div>
