@extends ('layout')

@section ('content')
<article>
    <h1 class="top">Guild: {{ $guild->Name }} ({{ $guild->Lvl }} Level)</h1>
    <section class="body">
        @foreach ($guild->members as $guildMember)
            İsim: {{ $guildMember->CharName }} <br />
            Takma ad: {{ $guildMember->Nickname }} <br />
            Level : {{ $guildMember->CharLevel }} <br />
            Guild'e katkısı (GP): {{ $guildMember->GP_Donation }} <br />
            Katılım tarihi: {{ $guildMember->JoinDate }}

            @unless ($loop->last)
                <hr />
            @endunless
        @endforeach

        <div class="ucp_divider"></div>
</article>
@endsection
