@extends('layout')

@section('pagetitle', 'Last Unique Kills')
@section('contenttitle', 'Last Unique Kills')

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
                                <th scope="col">Unique</th>
                                <th scope="col">Karakter</th>
                                <th scope="col" width="25%">Tarih</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($uniques as $unique)
                                <tr>
                                    <th scope="row">{{ $unique->unique->getName() }}</th>
                                    <td data-toggle="tooltip" data-html="true" title="<img class='img-fluid rounded' src='{{ Theme::url('img/silkroad/characters/' . $unique->character->RefObjID . '.gif') }}'>">
                                        <a href="{{ route('users.characters.show', $unique->CharacterID) }}">
                                            {{ $unique->CharacterName }}
                                        </a>
                                    </td>
                                    <td data-toggle="tooltip" title="{{ $unique->created_at }}">
                                        {{ $unique->created_at->locale(env('APP_LOCALE', 'tr_TR'))->diffForHumans(['parts' => 3, 'short' => false]) }}
                                    </td>
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
