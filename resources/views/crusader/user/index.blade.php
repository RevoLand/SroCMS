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
                                    <a data-hasevent="1" href="http://armagedon-wow.com/ucp/settings" data-tip="Change nickname" style="float:right;margin-right:10px;">
                                        <img src="{{ Theme::url('images/icons/pencil.png') }}" align="absbottom"></a>
                                    <a href="#"
                                        data-tip="View profile">{{ Auth::user()->Name ?? Auth::user()->StrUserID }}</a>
                                </td>
                            </tr>
                            <tr>
                                <td width="10%"><img src="{{ Theme::url('images/icons/world.png') }}"></td>
                                <td width="40%">Localización</td>
                                <td width="50%">
                                    <a data-hasevent="1" href="http://armagedon-wow.com/ucp/settings" data-tip="Change location" style="float:right;margin-right:10px;">
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
                    {{-- {% for loginAttempt in loginAttempts %} --}}
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
                                {{-- {% if loginAttempt.Success %} --}}
                                Başarıyla giriş yapıldı.
                                {{-- {% else %} --}}
                                Giriş denemesi başarısız oldu.
                                {{-- {% endif %} --}}
                            </span>
                            <br />
                            <span id="date"># - IP: #</span>
                        </div>
                        <div class="clear"></div>
                    </li>
                    {{-- {% endfor %} --}}
                </ul>
            </div>

            <div class="clear"></div>
        </section>
    </section>
</article>

@endsection
