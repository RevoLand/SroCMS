<a class="badge badge-primary" href="{{ route('admin.votes.index', ['user_id' => request('user_id'), 'vote_provider_id' => $vote_provider_id, 'reward_group_id' => request('reward_group_id')]) }}">
    {{ $model->voteProvider->name }}
</a>
