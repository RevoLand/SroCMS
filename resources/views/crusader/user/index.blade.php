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
                                <td width="40%">Kullanıcı adı</td>
                                <td width="50%">
                                    <a data-hasevent="1" href="{{ route('users.edit_form') }}" data-tip="Change nickname" style="float:right;margin-right:10px;">
                                        <img src="{{ Theme::url('images/icons/pencil.png') }}" align="absbottom"></a>
                                    <a href="#"
                                        data-tip="View profile">{{ Auth::user()->Name ?? Auth::user()->StrUserID }}</a>
                                </td>
                            </tr>
                            <tr>
                                <td width="10%"><img src="{{ Theme::url('images/icons/world.png') }}"></td>
                                <td width="40%">Localización</td>
                                <td width="50%">
                                    <a data-hasevent="1" href="{{ route('users.edit_form') }}" data-tip="Change location" style="float:right;margin-right:10px;">
                                        <img src="{{ Theme::url('images/icons/pencil.png') }}" align="absbottom"></a>
                                    Unknown
                                </td>
                            </tr>
                            <tr>
                                <td width="10%"><img src="{{ Theme::url('images/icons/plugin.png') }}"></td>
                                <td width="40%">Expansion</td>
                                <td width="50%">
                                    <a data-hasevent="1" href="http://armagedon-wow.com/ucp/expansion" data-tip="Change expansion" style="float:right;margin-right:10px;">
                                        <img src="{{ Theme::url('images/icons/cog.png') }}" align="absbottom"></a>
                                    WotLK
                                </td>
                            </tr>
                            <tr>
                                <td width="10%"><img src="{{ Theme::url('images/icons/award_star_bronze_1.png') }}">
                                </td>
                                <td width="40%">Yetki</td>
                                <td width="50%">#</td>
                            </tr>
                        </tbody>
                    </table>
                </aside>

                <aside>
                    <table width="100%">
                        <tbody>
                            <tr>
                                <td width="10%"><img src="{{ Theme::url('images/icons/lightning.png') }}"></td>
                                <td width="40%">Silk</td>
                                <td width="50%">{{ Auth::user()->Silk->silk_own }}</td>
                            </tr>
                            <tr>
                                <td width="10%"><img src="{{ Theme::url('images/icons/coins.png') }}"></td>
                                <td width="40%">Silk (Gift)</td>
                                <td width="50%">{{ Auth::user()->Silk->silk_gift }}</td>
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
                                <td width="50%">#</td>
                            </tr>
                        </tbody>
                    </table>
                </aside>
            </section>
            <div class="clear"></div>
        </section><!-- ucp top -->

        <section id="armory_mid_info">
            <div class="recent-activity">
                <h3>Son 5 giriş denemesi</h3>
                <ul class="achievements">
                    @foreach (Auth::user()->loginAttempts->take(5) as $loginAttempt)
                    <li class="achievement">
                        <div id="icon">
                            <span class="icon">
                                <span class="icon-frame frame-12">
                                    <img src="{{ Theme::url('images/icons/achievement_bg_winab_underxminutes.jpg') }}"
                                        alt="" height="16" width="16">
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
            {{-- {if hasPermission('view', "vote") && $config['vote']} --}}
                <a href="#" style="background-image:url({{ Theme::url('images/ucp/vote_panel.jpg') }})"></a>
            {{-- {/if} --}}

            {{-- {if hasPermission('view', "donate") && $config['donate']} --}}
                <a href="#" style="background-image:url({{ Theme::url('images/ucp/donate_panel.jpg') }})"></a>
            {{-- {/if} --}}

            {{-- {if hasPermission('view', "store") && $config['store']} --}}
                <a href="#" style="background-image:url({{ Theme::url('images/ucp/item_store.jpg') }})"></a>
            {{-- {/if} --}}

            {{-- {if hasPermission('canUpdateAccountSettings', 'ucp') && $config['settings']} --}}
                <a href="#" style="background-image:url({{ Theme::url('images/ucp/account_settings.jpg') }})"></a>
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
            {{-- {foreach from=$realms item=realm} --}}
                <h1>Server Ismi</h1>
                {{-- {foreach from=$realm->getCharacters()->getCharactersByAccount($id) item=character} --}}
                    <a href="#">
                        <img src="{$url}application/images/avatars/{$realmsObj->formatAvatarPath($character)}.gif" />
                    </a>
                {{-- {/foreach} --}}
            {{-- {/foreach} --}}
            <div class="clear"></div>
        </section>
    </section>
</article>

@endsection
