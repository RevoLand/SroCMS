@extends ('layout')

@section ('content')
<article>
    <h1 class="top">Karakter: {{ $character->CharName16 }}</h1>
    <section class="body">
        <!-- Top part -->
        <section id="armory_top">
            <section id="armory_bars">
                <div id="armory_health">Health: <b>{{ number_format($character->HP) }}</b></div>

                <div id="armory_mana">Mana: <b>{{ number_format($character->MP) }}</b></div>
            </section>

            <img class="avatar" src="{{ Theme::url('images/characters/' . $character->RefObjID . '.gif') }}" />

            <section id="armory_name">
                <h1>{{ $character->CharName16 }} @isset($character->guild) <a href="#">{{ $character->guild->Name }}</a>
                    @endisset</h1>
                <h2><b>{{ $character->CurLevel }}</b></h2>
            </section>

            <div class="clear"></div>
        </section>

        <div class="ucp_divider"></div>

        <!-- Main part -->
        <section id="armory" style="background-image:url({{ Theme::url('images/misc/silvermoon.png') }})">
            <section id="armory_left">
                <div class="item"><a></a><img src="http://lorempixel.com/56/56/" /></div>
                <div class="item"><a></a><img src="http://lorempixel.com/56/56/" /></div>
                <div class="item"><a></a><img src="http://lorempixel.com/56/56/" /></div>
                <div class="item"><a></a><img src="http://lorempixel.com/56/56/" /></div>
                <div class="item"><a></a><img src="http://lorempixel.com/56/56/" /></div>
            </section>

            <section id="armory_stats">
                <center id="armory_stats_top">
                    <a class="armory_current_tab">
                        Stats
                    </a>
                </center>
                <section id="tab_stats" style="display:block;">
                    <div id="attributes_wrapper">
                        <div style="float:left;">
                            <table width="367px" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td width="50%">Strength</td>
                                    <td>{{ number_format($character->Strength) }}</td>
                                </tr>
                                <tr>
                                    <td width="50%">Int</td>
                                    <td>{{ number_format($character->Intellect) }}</td>
                                </tr>
                                <tr>
                                    <td width="50%">Gold</td>
                                    <td>{{ number_format($character->RemainGold) }}</td>
                                </tr>
                                <tr>
                                    <td width="50%">Skill Points</td>
                                    <td>{{ number_format($character->RemainSkillPoint) }}</td>
                                </tr>
                                <tr>
                                    <td width="50%">Stat Points</td>
                                    <td>{{ number_format($character->RemainStatPoint) }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </section>
            </section>

            <section id="armory_right">
                <div class="item"><a></a><img src="http://lorempixel.com/56/56/" /></div>
                <div class="item"><a></a><img src="http://lorempixel.com/56/56/" /></div>
                <div class="item"><a></a><img src="http://lorempixel.com/56/56/" /></div>
                <div class="item"><a></a><img src="http://lorempixel.com/56/56/" /></div>
                <div class="item"><a></a><img src="http://lorempixel.com/56/56/" /></div>
            </section>

            <section id="armory_bottom">
                <div class="item"><a></a><img src="http://lorempixel.com/56/56/" /></div>
                <div class="item"></div>
                <div class="item"><a></a><img src="http://lorempixel.com/56/56/" /></div>
            </section>
        </section>
</article>
@endsection
