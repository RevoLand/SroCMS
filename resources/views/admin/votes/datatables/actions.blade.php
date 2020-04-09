@if(!$voted)
<div class="dropdown text-sans-serif">
	<button class="btn btn-link text-600 btn-sm dropdown-toggle btn-reveal mr-3" type="button" id="dt_dropdown-{{ $id }}" data-toggle="dropdown" data-boundary="viewport" aria-haspopup="true" aria-expanded="false">
		<span class="fas fa-ellipsis-h fs--1"></span>
	</button>
	<div class="dropdown-menu dropdown-menu-right border py-0" aria-labelledby="dt_dropdown-{{ $id }}">
		<div class="bg-white py-2">
            {!! Form::open([ 'route' => ['admin.votes.reward', $id], 'method' => 'patch', 'data-action' => 'reward', 'data-id' => $id ]) !!}
            <button class="dropdown-item text-success" type="submit">Reward</button>
            {!! Form::close() !!}
            {!! Form::open([ 'route' => ['admin.votes.toggle_active', $id], 'method' => 'patch', 'data-action' => 'toggle-enabled', 'data-id' => $id ]) !!}
            <button class="dropdown-item text-warning" type="submit">Toggle Active State</button>
            {!! Form::close() !!}
		</div>
	</div>
</div>
@endif
