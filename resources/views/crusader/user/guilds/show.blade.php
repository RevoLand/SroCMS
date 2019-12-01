@extends ('layout')

@section ('content')
<article>
    <h1 class="top">Guild: {{ $guild->Name }} ({{ $guild->Lvl }} Level)</h1>
    <section class="body">
        @isset ($guild->siegeFortress)
            <img src="{{ $guild->siegeFortress->image }}" /> <b>{{ $guild->siegeFortress->Name }}</b> Kalesinin sahibi.

            <br />
            <div class="ucp_divider"></div>
        @endisset
        <table class="nice_table" style="width: 100%">
            <thead>
                <tr>
                    <th>Karakter</th>
                    <th>Level</th>
                    <th>Bağışlanan GP</th>
                    <th>Guild War K/D</th>
                    <th>Katılım Tarihi</th>
                </tr>
            </thead>
            @foreach ($sortedGuildMembers as $guildMember)
            <tr>
                <td><a href="{{ route('users.characters.show', $guildMember->CharID) }}">{{ $guildMember->CharName }}</a></td>
                <td>{{ $guildMember->CharLevel }}</td>
                <td>{{ number_format($guildMember->GP_Donation) }}</td>
                <td>{{ number_format($guildMember->GuildWarKill - $guildMember->GuildWarKilled) }} ({{ number_format($guildMember->GuildWarKill) }} - {{ number_format($guildMember->GuildWarKille) }})</td>
                <td>{{ $guildMember->JoinDate }}</td>
            </tr>
            @endforeach
        </table>
</article>
@endsection
