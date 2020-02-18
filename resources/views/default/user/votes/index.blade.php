@extends('layout')

@section('pagetitle', 'Vote 4 Reward')
@section('contenttitle', 'Vote 4 Reward')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="user-vote4 bg-dark px-3 py-3 shadow-sm rounded-sm">
            <div class="row">
                <div class="col">
                    @error('reward')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <table class="table table-responsive-md">
                        <thead>
                            <tr>
                                <th scope="col">Servis İsmi</th>
                                <th scope="col" data-toggle="tooltip" title="Başarılı bir oy işlemi sonrasında yeniden oy kullanabilmek için geçmesi gereken süre.">Oylama Aralığı</th>
                                <th scope="col">İşlemler</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($voteProviders as $voteProvider)
                                <tr>
                                    <th scope="row">{{ $voteProvider->name }}</th>
                                    <td>{{ $voteProvider->minutes_between_votes }} <small class="text-muted">(dakika)</small></td>
                                    @if ($voteProvider->canUserVote())
                                        <td>
                                            {{ Form::open(['route' => ['votes.do_vote', $voteProvider]]) }}
                                            <div class="input-group">
                                                <select class="custom-select" name="reward" required>
                                                    @foreach ($voteProvider->rewardGroups as $rewardGroup)
                                                        <option value="{{ $rewardGroup->id }}">{{ $rewardGroup->name }}</option>
                                                    @endforeach
                                                </select>
                                                <div class="input-group-append">
                                                    <button type="submit" class="btn btn-sm btn-primary">Oy ver!</button>
                                                </div>
                                            </div>
                                            {{ Form::close() }}
                                        </td>
                                    @else
                                        <td>
                                            {{ $voteProvider->lastVoteLogForAuthUser()->updated_at->addMinutes($voteProvider->minutes_between_votes)->locale(env('APP_LOCALE', 'tr_TR'))->diffForHumans(['parts' => 3,'short' => true,]) }} oy kullanılabilir.
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
