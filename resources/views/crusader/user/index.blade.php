@extends ('layout')

@section ('content')
<article>
    <h1 class="top">Kontrol Paneli</h1>
    <section class="body">
        <section id="ucp_top">
            @if (Auth::user()->gravatar)
            <a href="https://gravatar.com/support/what-is-gravatar/" target="_blank" id="ucp_avatar">
                <div>Gravatar</div>
                <img src="{{ Auth::user()->gravatar }}?s=120" />
            </a>
            @endif

            <section id="ucp_info">
                <aside>
                    <table width="100%">
                        <tbody>
                            <tr>
                                <td width="10%"><img src="{{ Theme::url('images/icons/user.png') }}"></td>
                                <td width="40%">İsim</td>
                                <td width="50%">
                                    <a href="{{ route('users.show_user', Auth::user()) }}"
                                        data-tip="View profile">{{ Auth::user()->getName() }}</a>
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
                                    @forelse (Auth::user()->getRoleNames() as $userRole)
                                    {{ $userRole }}
                                    @empty
                                    Yok
                                    @endforelse
                                </td>
                            </tr>
                            <tr>
                                <td width="10%"><img src="{{ Theme::url('images/icons/date.png') }}"></td>
                                <td width="40%">Üyelik tarihi:</td>
                                <td width="50%">{{ Auth::user()->regtime }}</td>
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
                                <td width="50%">{{ number_format(Auth::user()->silk->silk_own) }}</td>
                            </tr>
                            <tr>
                                <td width="10%"><img src="{{ Theme::url('images/icons/giftsilk.png') }}"></td>
                                <td width="40%">{{ setting('silk.silk_gift_name', 'Silk (Gift)') }}</td>
                                <td width="50%">{{ number_format(Auth::user()->silk->silk_gift) }}</td>
                            </tr>
                            <tr>
                                <td width="10%"><img src="{{ Theme::url('images/icons/plugin.png') }}"></td>
                                <td width="40%">{{ setting('silk.silk_point_name', 'Silk (Point)') }}</td>
                                <td width="50%">{{ number_format(Auth::user()->silk->silk_point) }}</td>
                            </tr>
                            <tr>
                                <td width="10%"><img src="{{ Theme::url('images/icons/user.png') }}"></td>
                                <td width="40%">{{ setting('referrals.name', 'Referanslar') }}</td>
                                <td width="50%">{{ number_format(Auth::user()->referrals->count()) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </aside>
            </section>
            <div class="clear"></div>
        </section><!-- ucp top -->

        <section id="armory_mid_info">
            <div class="recent-activity">
                <h4>Son 5 giriş denemesi</h4>
                <ul class="achievements">
                    @foreach (Auth::user()->loginAttempts->take(5) as $loginAttempt)
                    <li class="achievement">
                        <div id="icon">
                            <span class="icon">
                                <span class="icon-frame frame-12">
                                    <img src="{{ Theme::url('images/icons/achievement_bg_winab_underxminutes.jpg') }}" alt="" height="16" width="16">
                                </span>
                            </span>
                        </div>
                        <div id="info">
                            <span id="descr">
                                @if ($loginAttempt->success)
                                Başarıyla giriş yapıldı.
                                @else
                                Giriş denemesi başarısız oldu.
                                @endif
                            </span>
                            <br />
                            <span id="date">{{ $loginAttempt->created_at }} - IP: {{ $loginAttempt->ip }}</span>
                        </div>
                        <div class="clear"></div>
                    </li>
                    @endforeach
                </ul>
            </div>

            <div class="clear"></div><br />
        </section>

        <div class="ucp_divider"></div>

        <section id="ucp_buttons">
            {{-- {if hasPermission('canUpdateAccountSettings', 'ucp') && $config['settings']} --}}
            <a href="{{ route('users.edit_form') }}"
                style="background-image:url({{ Theme::url('images/ucp/account_settings.jpg') }})"></a>
            {{-- {/if} --}}

            {{-- {if hasPermission('view', "vote") && $config['vote']} --}}
            <a href="#" style="background-image:url({{ Theme::url('images/ucp/vote_panel.jpg') }})"></a>
            {{-- {/if} --}}

            {{-- {if hasPermission('view', "donate") && $config['donate']} --}}
            <a href="#" style="background-image:url({{ Theme::url('images/ucp/donate_panel.jpg') }})"></a>
            {{-- {/if} --}}

            {{-- {if hasPermission('view', "store") && $config['store']} --}}
            <a href="#" style="background-image:url({{ Theme::url('images/ucp/item_store.jpg') }})"></a>
            {{-- {/if} --}}

            {{-- {if hasPermission('canChangeExpansion', "ucp") && $config['expansion']} --}}
            <a href="#" style="background-image:url({{ Theme::url('images/ucp/change_expansion.jpg') }})"></a>
            {{-- {/if} --}}

            {{-- {if hasPermission('view', "teleport") && $config['teleport']} --}}
            <a href="#" style="background-image:url({{ Theme::url('images/ucp/teleport_hub.jpg') }})"></a>
            {{-- {/if} --}}

            {{-- {if hasPermission('view', "gm") && $config['gm']} --}}
            <a href="#" style="background-image:url({{ Theme::url('images/ucp/gm_panel.jpg') }})"></a>
            {{-- {/if} --}}

            {{-- {if hasPermission('view', "admin") && $config['admin']} --}}
            <a href="#" style="background-image:url({{ Theme::url('images/ucp/admin_panel.jpg') }})"></a>
            {{-- {/if} --}}

            <div class="clear"></div>
        </section>

        <div class="ucp_divider"></div>

        <section id="ucp_characters">
            <h1>Karakterlerim</h1>
            @foreach (Auth::user()->characters as $character)
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
