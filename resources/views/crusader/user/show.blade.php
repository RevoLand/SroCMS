@extends ('layout')

@section ('content')
<article>
    <h1 class="top">Profil: {{ $user->getName() }}</h1>
    <section class="body">
        <section id="ucp_top">
            @if ($user->gravatar)
            <img id="ucp_avatar" src="{{ $user->gravatar }}?s=120" />
            @endif

            <section id="ucp_info">
                <aside>
                    <table width="100%">
                        <tbody>
                            <tr>
                                <td width="10%"><img src="{{ Theme::url('images/icons/user.png') }}"></td>
                                <td width="40%">İsim</td>
                                <td width="50%">
                                    <a href="{{ route('users.show_user', $user) }}"
                                        data-tip="View profile">{{ $user->getName() }}</a>
                                </td>
                            </tr>
                            <tr>
                                <td width="10%"><img src="{{ Theme::url('images/icons/world.png') }}"></td>
                                <td width="40%">Localización</td>
                                <td width="50%">
                                    Unknown
                                </td>
                            </tr>
                            <tr>
                                <td width="10%"><img src="{{ Theme::url('images/icons/plugin.png') }}"></td>
                                <td width="40%">Expansion</td>
                                <td width="50%">
                                    WotLK
                                </td>
                            </tr>
                            <tr>
                                <td width="10%"><img src="{{ Theme::url('images/icons/award_star_bronze_1.png') }}">
                                </td>
                                <td width="40%">Üye Yetki Grupları</td>
                                <td width="50%">
                                    @forelse ($user->getRoleNames() as $userRole)
                                    {{ $userRole }}
                                    @empty
                                    Yok
                                    @endforelse
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </aside>

                <aside>
                    <table width="100%">
                        <tbody>
                            <tr>
                                <td width="10%"><img src="{{ Theme::url('images/icons/lightning.png') }}"></td>
                                <td width="40%">{{ setting('silk.silk_own_name', 'Silk') }}</td>
                                <td width="50%">{{ $user->Silk->silk_own }}</td>
                            </tr>
                            <tr>
                                <td width="10%"><img src="{{ Theme::url('images/icons/coins.png') }}"></td>
                                <td width="40%">{{ setting('silk.silk_gift_name', 'Silk (Gift)') }}</td>
                                <td width="50%">{{ $user->Silk->silk_gift }}</td>
                            </tr>
                            <tr>
                                <td width="10%"><img src="{{ Theme::url('images/icons/shield.png') }}"></td>
                                <td width="40%">Ban durumu</td>
                                <!-- TODO: Ban durumu yapılacak -->
                                <td width="50%">todo(!)</td>
                            </tr>
                            <tr>
                                <td width="10%"><img src="{{ Theme::url('images/icons/date.png') }}"></td>
                                <td width="40%">Üyelik tarihi:</td>
                                <td width="50%">{{ $user->regtime }}</td>
                            </tr>
                        </tbody>
                    </table>
                </aside>
            </section>
            <div class="clear"></div>
        </section><!-- ucp top -->
        <div class="ucp_divider"></div>

        <section id="ucp_characters">
            <h1>Karakterleri</h1>
            @foreach ($user->characters as $character)
            <a href="{{ route('users.characters.show', $character) }}">
                <img src="{{ Theme::url('images/characters/' . $character->RefObjID . '.gif') }}" />
            </a>
            @endforeach
            <div class="clear"></div>
        </section>
    </section>
</article>
@endsection
