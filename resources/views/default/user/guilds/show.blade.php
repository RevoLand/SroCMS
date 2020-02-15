@extends('layout')

@section('pagetitle', 'Guild: ' . $guild->Name)
@section('contenttitle', 'Guild: ' . $guild->Name)

@section('content')
<div class="guild-info bg-dark px-3 py-3 shadow-sm rounded-sm">
    <div class="row">
        <div class="col-12">
            <div class="siege-info mb-2">
                <h5 class="text-monospace">
                    @if ($guild->siegeFortress)
                        <img class="img-fluid" src="{{ $guild->siegeFortress->image }}"> {{  $guild->siegeFortress->name  }} kalesinin sahibi.
                    @else
                        Bu guild herhangi bir kaleyi elinde tutmuyor.
                    @endif
                </h5>
            </div>
            <table class="table table-responsive-md">
                <thead>
                    <tr>
                        <th scope="col">Rütbe</th>
                        <th scope="col">Karakter</th>
                        <th scope="col">Seviye</th>
                        <th scope="col">Bağışlanan GP</th>
                        <th scope="col">Katılma Tarihi</th>
                        <th scope="col">Kale Yetkisi</th>
                        <th scope="col">Join</th>
                        <th scope="col">Withdraw</th>
                        <th scope="col">Union</th>
                        <th scope="col">Storage</th>
                        <th scope="col">Notice</th>
                    </tr>
                </thead>
                <tbody>
                    {{--
                        "GuildID" => "872"
                        "CharID" => "6697"
                        "CharName" => "Revolution"
                        "MemberClass" => "0"
                        "CharLevel" => "110"
                        "GP_Donation" => "4500"
                        "JoinDate" => "2018-04-09 02:28:00"
                        "Permission" => "-1"
                        "Contribution" => "0"
                        "GuildWarKill" => "0"
                        "GuildWarKilled" => "0"
                        "Nickname" => "Mert"
                        "RefObjID" => "1907"
                        "SiegeAuthority" => "1"
                    --}}
                    @foreach($guild->members as $guildMember)
                    <tr>

                            <td>{{ $guildMember->MemberClass }}</td>
                            <td scope="row">
                                <a data-toggle="tooltip" data-html="true" title="<img class='img-fluid rounded' src='{{ Theme::url('img/silkroad/characters/' . $guildMember->RefObjID . '.gif') }}'>" href="{{ route('users.characters.show', $guildMember->CharID) }}">
                                    {{ $guildMember->CharName }}
                                </a>
                                @if ($guildMember->Nickname)<small class="text-muted">* {{ $guildMember->Nickname }}</small>@endif
                            </td>
                            <td>{{ $guildMember->CharLevel }}</td>
                            <td>{{ $guildMember->GP_Donation }}</td>
                            <td data-toggle="tooltip" title="{{ $guildMember->JoinDate }}">{{ $guildMember->JoinDate->locale(env('APP_LOCALE', 'tr_TR'))->diffForHumans(['parts' => 3, 'short' => true]) }}</td>
                            <td>{{ config('constants.guild.siege.' . $guildMember->SiegeAuthority) }}</td>
                            <td>@if ($guildMember->hasPermission(config('constants.guild.permission.join'))) Evet @endif</td>
                            <td>@if ($guildMember->hasPermission(config('constants.guild.permission.withdraw'))) Evet @endif</td>
                            <td>@if ($guildMember->hasPermission(config('constants.guild.permission.union'))) Evet @endif</td>
                            <td>@if ($guildMember->hasPermission(config('constants.guild.permission.storage'))) Evet @endif</td>
                            <td>@if ($guildMember->hasPermission(config('constants.guild.permission.notice'))) Evet @endif</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
