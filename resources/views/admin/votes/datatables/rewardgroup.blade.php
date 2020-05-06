<a class="badge badge-soft-info" href="{{ route('admin.votes.index', ['user_id' => request('user_id'), 'vote_provider_id' => request('vote_provider_id'), 'reward_group_id' => $selected_reward_group_id]) }}">
    {{ $model->rewardgroup->name }}
</a>
