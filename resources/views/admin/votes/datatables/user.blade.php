<a class="media align-items-center mb-2" href="{{ route('admin.votes.index', ['user_id' => $user_id, 'vote_provider_id' => request('vote_provider_id'), 'reward_group_id' => request('reward_group_id')]) }}">
    @isset($model->user->gravatar)
    <img class="d-flex align-self-center mr-2" src="{{ $model->user->gravatar }}" alt="{{ $model->user->StrUserID }}" width="30">
    @endisset
    <div class="media-body">
      <h6 class="mb-0">{{ $model->user->getName() }}</h6>
    </div>
</a>
