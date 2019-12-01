@extends ('layout')

@section ('pagetitle', ' - Karakter Görüntüle: ' . $character->CharName16)

@section ('content')
<article>
    <h1 class="top">Karakter: {{ $character->CharName16 }}</h1>
    <section class="body">
        <!-- Top part -->
        <section id="armory_top">

            <img class="avatar" src="@component('components.character.image', ['refObjId' => $character->RefObjID])@endcomponent" />

            <section id="armory_name">
                <h1>
                    {{ $character->CharName16 }} @isset($character->guild) <a href="{{ route('users.guilds.show', $character->guild) }}">{{ $character->guild->Name }}</a>@endisset
                </h1>
                    <h2><b>{{ $character->CurLevel }} Level</b></h2>
                </section>

                <section id="armory_bars">
                    <div id="armory_health">Health: <b>{{ number_format($character->HP) }}</b></div>
                    <div id="armory_mana">Mana: <b>{{ number_format($character->MP) }}</b></div>
                    <div id="armory_energy">Strength: <b>{{ number_format($character->Strength) }}</b></div>
                    <div id="armory_runic">Intellect: <b>{{ number_format($character->Intellect) }}</b></div>
                </section>
            <div class="clear"></div>
        </section>
        <div class="ucp_divider"></div>
        <section id="armory_mid_info">
            <div class="recent-activity">
                <h3>Son 5 girişi</h3>
                <ul class="achievements">
                    @foreach ($character->logEventChar->where('EventID', '4')->take(5) as $logins)
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
                                Giriş yapıldı.
                            </span>
                            <br />
                            <span id="date">{{ $logins->EventTime }}</span>
                        </div>
                        <div class="clear"></div>
                    </li>
                    @endforeach
                </ul>
            </div>

            <div class="professions">
                    <h3>Skill Mastery</h3>
                    <ul class="profession">
                        @foreach ($characterMastery as $mastery)
                        <li class="achievement">
                            <div class="profile-progress border-3">
                                <div class="bar border-3 hover" style="width: {{ round($mastery->Level * 100 / setting('skillmastery.maxlevel', 110)) }}%"></div>
                                <div class="bar-contents">
                                    <div class="profession-details">
                                        <span class="icon">
                                            <span class="icon-frame frame-12">
                                                <img src="{{ Theme::url('images/silkroad/skills/masteries/' . $mastery->ID . '.png') }}" alt="" width="16" height="16">
                                            </span>
                                        </span>
                                        <span class="name">{{ $mastery->Code }}</span>
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
                        @component ('components.inventory.item', ['item' => $characterInventory->where('Slot', config('constants.inventory.slots.weapon'))->first()])@endcomponent
                    </td>
                    <td>
                        @component ('components.inventory.item', ['item' => $characterInventory->where('Slot', config('constants.inventory.slots.shield'))->first()]) @endcomponent
                    </td>
                </tr>
                <tr>
                    <td>@component ('components.inventory.item', ['item' => $characterInventory->where('Slot', config('constants.inventory.slots.helm'))->first()]) @endcomponent</td>
                    <td>@component ('components.inventory.item', ['item' => $characterInventory->where('Slot', config('constants.inventory.slots.shoulders'))->first()]) @endcomponent</td>
                </tr>
                <tr>
                    <td>@component ('components.inventory.item', ['item' => $characterInventory->where('Slot', config('constants.inventory.slots.chest'))->first()]) @endcomponent</td>
                    <td>@component ('components.inventory.item', ['item' => $characterInventory->where('Slot', config('constants.inventory.slots.gauntlet'))->first()]) @endcomponent</td>
                </tr>
                <tr>
                    <td>@component ('components.inventory.item', ['item' => $characterInventory->where('Slot', config('constants.inventory.slots.pants'))->first()]) @endcomponent</td>
                    <td>@component ('components.inventory.item', ['item' => $characterInventory->where('Slot', config('constants.inventory.slots.boots'))->first()]) @endcomponent</td>
                </tr>
                <tr>
                    <td>@component ('components.inventory.item', ['item' => $characterInventory->where('Slot', config('constants.inventory.slots.earring'))->first()]) @endcomponent</td>
                    <td>@component ('components.inventory.item', ['item' => $characterInventory->where('Slot', config('constants.inventory.slots.necklace'))->first()]) @endcomponent</td>
                </tr>
                <tr>
                    <td>@component ('components.inventory.item', ['item' => $characterInventory->where('Slot', config('constants.inventory.slots.lring'))->first()]) @endcomponent</td>
                    <td>@component ('components.inventory.item', ['item' => $characterInventory->where('Slot', config('constants.inventory.slots.rring'))->first()]) @endcomponent</td>
                </tr>
            </table>
            <div class="clear"></div>
        </section>
</article>
@endsection
