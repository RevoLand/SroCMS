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
                <h1>{{ $character->CharName16 }} @isset($character->guild) <a href="{{ route('users.guilds.show', $character->guild) }}">{{ $character->guild->Name }}</a>
                    @endisset</h1>
                <h2><b>{{ $character->CurLevel }} Level</b></h2>
            </section>

            <div class="clear"></div>
        </section>

        <div class="ucp_divider"></div>

        <!-- Main part -->
        {{--
            0:  Head
            1:  Chest
            2:  Shoulder
            3:  Gauntlet
            4:  Pants
            5:  Boots
            6:  Weapon
            7:  Shield/Ammo

            9:  Earring
            10: Necklace
            11: L-Ring
            12: R-Ring


            Weapon   -  Shield / Ammo

            Head        Shoulder
            Chest       Gauntlet
            Pants       Boots
            Earring     Necklace
            L-Ring      R-Ring
            --}}

        <section id="armory" style="background-image:url({{ Theme::url('images/misc/silvermoon.png') }})">
            <section id="armory_left">
                <div class="item"><a></a><img title="{{ $character->inventory->where('Slot', 0)->first()->item->objCommon->CodeName128 }}" width="56px" height="56px" src="{{ $character->inventory->where('Slot', 0)->first()->item->objCommon->image }}" /></div>
                <div class="item"><a></a><img title="{{ $character->inventory->where('Slot', 1)->first()->item->objCommon->CodeName128 }}" width="56px" height="56px" src="{{ $character->inventory->where('Slot', 1)->first()->item->objCommon->image }}" /></div>
                <div class="item"><a></a><img title="{{ $character->inventory->where('Slot', 4)->first()->item->objCommon->CodeName128 }}" width="56px" height="56px" src="{{ $character->inventory->where('Slot', 4)->first()->item->objCommon->image }}" /></div>
                <div class="item"><a></a><img title="{{ $character->inventory->where('Slot', 9)->first()->item->objCommon->CodeName128 }}" width="56px" height="56px" src="{{ $character->inventory->where('Slot', 9)->first()->item->objCommon->image }}" /></div>
                <div class="item"><a></a><img title="{{ $character->inventory->where('Slot', 11)->first()->item->objCommon->CodeName128 }}" width="56px" height="56px" src="{{ $character->inventory->where('Slot', 11)->first()->item->objCommon->image }}" /></div>
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
                    <div class="item"><a></a><img title="{{ $character->inventory->where('Slot', 2)->first()->item->objCommon->CodeName128 }}" width="56px" height="56px" src="{{ $character->inventory->where('Slot', 2)->first()->item->objCommon->image }}" /></div>
                    <div class="item"><a></a><img title="{{ $character->inventory->where('Slot', 3)->first()->item->objCommon->CodeName128 }}" width="56px" height="56px" src="{{ $character->inventory->where('Slot', 3)->first()->item->objCommon->image }}" /></div>
                    <div class="item"><a></a><img title="{{ $character->inventory->where('Slot', 5)->first()->item->objCommon->CodeName128 }}" width="56px" height="56px" src="{{ $character->inventory->where('Slot', 5)->first()->item->objCommon->image }}" /></div>
                    <div class="item"><a></a><img title="{{ $character->inventory->where('Slot', 10)->first()->item->objCommon->CodeName128 }}" width="56px" height="56px" src="{{ $character->inventory->where('Slot', 10)->first()->item->objCommon->image }}" /></div>
                    <div class="item"><a></a><img title="{{ $character->inventory->where('Slot', 12)->first()->item->objCommon->CodeName128 }}" width="56px" height="56px" src="{{ $character->inventory->where('Slot', 12)->first()->item->objCommon->image }}" /></div>
            </section>

            <section id="armory_bottom">
                    <div class="item"><a></a><img title="{{ $character->inventory->where('Slot', 6)->first()->item->objCommon->CodeName128 }}" width="56px" height="56px" src="{{ $character->inventory->where('Slot', 6)->first()->item->objCommon->image }}" /></div>
                <div class="item"></div>
                <div class="item"><a></a><img title="{{ $character->inventory->where('Slot', 7)->first()->item->objCommon->CodeName128 }}" width="56px" height="56px" src="{{ $character->inventory->where('Slot', 7)->first()->item->objCommon->image }}" /></div>
            </section>
        </section>
</article>
@endsection
