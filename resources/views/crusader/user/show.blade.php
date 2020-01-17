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
                            <tr>
                                <td width="10%"><img src="{{ Theme::url('images/icons/date.png') }}"></td>
                                <td width="40%">Üyelik tarihi:</td>
                                <td width="50%">{{ $user->regtime }}</td>
                            </tr>
                        </tbody>
                    </table>
                </aside>

                <aside>
                    <table width="100%">
                        <tbody>
                            <tr>
                                <td width="10%"><img src="{{ Theme::url('images/icons/silk.png') }}"></td>
                                <td width="40%">{{ setting('silk.silk_own_name', 'Silk') }}</td>
                                <td width="50%">{{ number_format($user->silk->silk_own) }}</td>
                            </tr>
                            <tr>
                                <td width="10%"><img src="{{ Theme::url('images/icons/giftsilk.png') }}"></td>
                                <td width="40%">{{ setting('silk.silk_gift_name', 'Silk (Gift)') }}</td>
                                <td width="50%">{{ number_format($user->silk->silk_gift) }}</td>
                            </tr>
                            <tr>
                                <td width="10%"><img src="{{ Theme::url('images/icons/plugin.png') }}"></td>
                                <td width="40%">{{ setting('silk.silk_point_name', 'Silk (Point)') }}</td>
                                <td width="50%">{{ number_format($user->silk->silk_point) }}</td>
                            </tr>
                            @if (setting('referrals.enabled', 1))
                            <tr>
                                <td width="10%"><img src="{{ Theme::url('images/icons/user.png') }}"></td>
                                <td width="40%">{{ setting('referrals.name', 'Referanslar') }}</td>
                                <td width="50%">{{ number_format($user->referrals->count()) }}</td>
                            </tr>
                            @endif
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
            <div style="float:left">
                <a href="{{ route('users.characters.show', $character) }}">
                    <img src="@component('components.character.image', ['refObjId' => $character->RefObjID])@endcomponent" />
                </a>
                <p>{{ $character->CharName16 }}</p>
            </div>
            @endforeach
            <div class="clear"></div>
        </section>
    </section>
</article>
@endsection
