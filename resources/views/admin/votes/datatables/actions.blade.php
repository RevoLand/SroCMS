@if(!$voted)
{!! Form::open([ 'route' => ['admin.votes.reward', $id], 'method' => 'patch', 'data-action' => 'reward', 'data-id' => $id ]) !!}
<button class="btn btn-sm btn-clean" role="button" type="submit">
    <i class="la la-trophy"></i> Reward
</button>
{!! Form::close() !!}
{!! Form::open([ 'route' => ['admin.votes.toggle_active', $id], 'method' => 'patch', 'data-action' => 'toggle-enabled', 'data-id' => $id ]) !!}
<button class="btn btn-sm btn-clean" role="button" type="submit">
    <i class="la la-eye-slash"></i> Toggle Active State
</button>
{!! Form::close() !!}
@endif
