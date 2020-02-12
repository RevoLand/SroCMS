@extends('layout')

@section('pagetitle', ' - Karakter Görüntüle: ' . $character->CharName16)

@section('content')
<article>
    <h1 class="top">Karakter: {{ $character->CharName16 }}</h1>
    <section class="body">
        <!-- Top part -->
        <section id="armory_top">

            <section id="armory_bars">
                <div id="armory_health">Health: <b>{{ number_format($character->HP) }}</b></div>
                <div id="armory_mana">Mana: <b>{{ number_format($character->MP) }}</b></div>
                <div id="armory_energy">Strength: <b>{{ number_format($character->Strength) }}</b></div>
                <div id="armory_runic">Intellect: <b>{{ number_format($character->Intellect) }}</b></div>
            </section>

            <img class="avatar" src="@component('components.character.image', ['refObjId' => $character->RefObjID])@endcomponent" />

            <section id="armory_name">
                <h1>
                    {{ $character->CharName16 }} @isset($character->guild) <a class="color-tooltip-alliance" href="{{ route('users.guilds.show', $character->guild) }}">{{ $character->guild->Name }}</a>@endisset
                </h1>
                <h2 class="color-c1"><b>{{ $character->CurLevel }} Level</b></h2>
            </section>

            <div class="clear"></div>
        </section>

        <div class="ucp_divider"></div>

        <section id="armory_mid_info">
            <div class="recent-activity">
                <h3>Son 5 Giriş/Çıkış</h3>
                <ul class="achievements">
                    @foreach ($character->logEventChar->whereIn('EventID', ['4', '6'])->take(5) as $login)
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
                                @if ($login->EventID == 4)
                                Giriş yapıldı.
                                @else
                                Çıkış yapıldı.
                                @endif
                            </span>
                            <br />
                            <span id="date">{{ $login->EventTime }}</span>
                        </div>
                        <div class="clear"></div>
                    </li>
                    @endforeach
                </ul>
            </div>

            <div class="professions">
                <h3>Skill Mastery</h3>
                <ul>
                    @foreach ($character->skillMastery as $mastery)
                    <li class="profession">
                        <div class="profile-progress border-3 @if((round($mastery->Level * 100 / setting('skillmastery.maxlevel', 110)) == 100))completed @endif">
                            <div class="bar border-3 hover" style="width: {{ round($mastery->Level * 100 / setting('skillmastery.maxlevel', 110)) }}%"></div>
                            <div class="bar-contents">
                                <div class="profession-details">
                                    <span class="icon">
                                        <span class="icon-frame frame-12">
                                            <img src="{{ Theme::url('images/silkroad/skills/masteries/' . $mastery->MasteryID . '.png') }}"
                                                alt="" width="16" height="16">
                                        </span>
                                    </span>
                                    <span class="name">{{ config('constants.skillmastery.names.' . $mastery->MasteryID) }}</span>
                                    <span class="value">{{ $mastery->Level }}/{{ setting('skillmastery.maxlevel', 110) }}</span>
                                </div>
                            </div>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>

            <div class="clear"></div><br />
        </section>

        <div class="ucp_divider"></div>

        <section>
            <table width="100%" border="0">
                <tr>
                    <td>
                        @component ('components.inventory.item', ['item' => $character->inventory->firstWhere('Slot', config('constants.inventory.slots.weapon'))]) @endcomponent
                    </td>
                    <td>
                        @component ('components.inventory.item', ['item' => $character->inventory->firstWhere('Slot', config('constants.inventory.slots.shield'))]) @endcomponent
                    </td>
                </tr>
                <tr>
                    <td>@component ('components.inventory.item', ['item' => $character->inventory->firstWhere('Slot', config('constants.inventory.slots.helm'))]) @endcomponent</td>
                    <td>@component ('components.inventory.item', ['item' => $character->inventory->firstWhere('Slot', config('constants.inventory.slots.shoulders'))]) @endcomponent</td>
                </tr>
                <tr>
                    <td>@component ('components.inventory.item', ['item' => $character->inventory->firstWhere('Slot', config('constants.inventory.slots.chest'))]) @endcomponent</td>
                    <td>@component ('components.inventory.item', ['item' => $character->inventory->firstWhere('Slot', config('constants.inventory.slots.gauntlet'))]) @endcomponent</td>
                </tr>
                <tr>
                    <td>@component ('components.inventory.item', ['item' => $character->inventory->firstWhere('Slot', config('constants.inventory.slots.pants'))]) @endcomponent</td>
                    <td>@component ('components.inventory.item', ['item' => $character->inventory->firstWhere('Slot', config('constants.inventory.slots.boots'))]) @endcomponent</td>
                </tr>
                <tr>
                    <td>@component ('components.inventory.item', ['item' => $character->inventory->firstWhere('Slot', config('constants.inventory.slots.earring'))]) @endcomponent</td>
                    <td>@component ('components.inventory.item', ['item' => $character->inventory->firstWhere('Slot', config('constants.inventory.slots.necklace'))]) @endcomponent</td>
                </tr>
                <tr>
                    <td>@component ('components.inventory.item', ['item' => $character->inventory->firstWhere('Slot', config('constants.inventory.slots.lring'))]) @endcomponent</td>
                    <td>@component ('components.inventory.item', ['item' => $character->inventory->firstWhere('Slot', config('constants.inventory.slots.rring'))]) @endcomponent</td>
                </tr>
            </table>
            <div class="clear"></div>
        </section>
</article>
@endsection
