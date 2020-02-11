@extends('layout')

@section('pagetitle')
 | Vote
@endsection

@section('content')
<article>
    <h1 class="top">Vote</h1>
    <section class="body">
        @error('reward')
            <p>{{ $message }}</p>
            <br />
        @enderror
        <table width="100%">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Time between Votes (minutes)</th>
                    <th>Can be Voted</th>
                    <th>Action</th>
                </tr>
                @foreach ($voteProviders as $voteProvider)
                <tr>
                    <td>{{ $voteProvider->name }}</td>
                    <td>{{ $voteProvider->minutes_between_votes }}</td>
                    <td>@if ($voteProvider->canUserVote()) Yes. @else No. @endif</td>
                    <td>
                        @if ($voteProvider->canUserVote())
                        {{ Form::open(['route' => ['votes.do_vote', $voteProvider], 'method' => 'POST']) }}
                        <select name="reward">
                            @foreach ($voteProvider->rewardGroups as $rewardGroup)
                                <option value="{{ $rewardGroup->id }}">{{ $rewardGroup->name }}</option>
                            @endforeach
                        </select>
                            <input type="submit" value="Vote!" />
                        {{ Form::close() }}
                        @endif
                    </td>
                </tr>
                @endforeach
            </thead>
        </table>
    </section>
</article>
@endsection
