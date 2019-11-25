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

        {{--
            config('constants.inventory.slots.helm'),           0
            config('constants.inventory.slots.chest'),          1
            config('constants.inventory.slots.shoulders'),      2
            config('constants.inventory.slots.gauntlet'),       3
            config('constants.inventory.slots.pants'),          4
            config('constants.inventory.slots.boots'),          5
            config('constants.inventory.slots.weapon'),         6
            config('constants.inventory.slots.shield'),         7
            config('constants.inventory.slots.earring'),        9
            config('constants.inventory.slots.necklace'),       10
            config('constants.inventory.slots.lring'),          11
            config('constants.inventory.slots.rring'),          12
        --}}

        <!-- Main part -->
        <section id="armory" style="background-image:url({{ Theme::url('images/misc/silvermoon.png') }})">
            <section id="armory_left">
                {{-- 0 - 1 - 4 - 9- 11 --}}
                <div class="item"><a></a><img title="{{ $characterInventory->where('Slot', config('constants.inventory.slots.helm'))->first()->CodeName128 }}" width="56px" height="56px" src="@component('components.inventory.item') {{ $characterInventory->where('Slot', config('constants.inventory.slots.helm'))->first()->AssocFileIcon128 }} @endcomponent" /></div>
                <div class="item"><a></a><img title="{{ $characterInventory->where('Slot', config('constants.inventory.slots.chest'))->first()->CodeName128 }}" width="56px" height="56px" src="@component('components.inventory.item') {{ $characterInventory->where('Slot', config('constants.inventory.slots.chest'))->first()->AssocFileIcon128 }} @endcomponent" /></div>
                <div class="item"><a></a><img title="{{ $characterInventory->where('Slot', config('constants.inventory.slots.pants'))->first()->CodeName128 }}" width="56px" height="56px" src="@component('components.inventory.item') {{ $characterInventory->where('Slot', config('constants.inventory.slots.pants'))->first()->AssocFileIcon128 }} @endcomponent" /></div>
                <div class="item"><a></a><img title="{{ $characterInventory->where('Slot', config('constants.inventory.slots.earring'))->first()->CodeName128 }}" width="56px" height="56px" src="@component('components.inventory.item') {{ $characterInventory->where('Slot', config('constants.inventory.slots.earring'))->first()->AssocFileIcon128 }} @endcomponent" /></div>
                <div class="item"><a></a><img title="{{ $characterInventory->where('Slot', config('constants.inventory.slots.lring'))->first()->CodeName128 }}" width="56px" height="56px" src="@component('components.inventory.item') {{ $characterInventory->where('Slot', config('constants.inventory.slots.lring'))->first()->AssocFileIcon128 }} @endcomponent" /></div>
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
                {{-- 2 - 3 - 5 - 10 - 12 --}}
                <div class="item"><a></a><img title="{{ $characterInventory->where('Slot', config('constants.inventory.slots.shoulders'))->first()->CodeName128 }}" width="56px" height="56px" src="@component('components.inventory.item') {{ $characterInventory->where('Slot', config('constants.inventory.slots.shoulders'))->first()->AssocFileIcon128 }} @endcomponent" /></div>
                <div class="item"><a></a><img title="{{ $characterInventory->where('Slot', config('constants.inventory.slots.gauntlet'))->first()->CodeName128 }}" width="56px" height="56px" src="@component('components.inventory.item') {{ $characterInventory->where('Slot', config('constants.inventory.slots.gauntlet'))->first()->AssocFileIcon128 }} @endcomponent" /></div>
                <div class="item"><a></a><img title="{{ $characterInventory->where('Slot', config('constants.inventory.slots.boots'))->first()->CodeName128 }}" width="56px" height="56px" src="@component('components.inventory.item') {{ $characterInventory->where('Slot', config('constants.inventory.slots.boots'))->first()->AssocFileIcon128 }} @endcomponent" /></div>
                <div class="item"><a></a><img title="{{ $characterInventory->where('Slot', config('constants.inventory.slots.necklace'))->first()->CodeName128 }}" width="56px" height="56px" src="@component('components.inventory.item') {{ $characterInventory->where('Slot', config('constants.inventory.slots.necklace'))->first()->AssocFileIcon128 }} @endcomponent" /></div>
                <div class="item"><a></a><img title="{{ $characterInventory->where('Slot', config('constants.inventory.slots.rring'))->first()->CodeName128 }}" width="56px" height="56px" src="@component('components.inventory.item') {{ $characterInventory->where('Slot', config('constants.inventory.slots.rring'))->first()->AssocFileIcon128 }} @endcomponent" /></div>
            </section>

            <section id="armory_bottom">
                <div class="item"><a></a><img title="{{ $characterInventory->where('Slot', config('constants.inventory.slots.weapon'))->first()->CodeName128 }}" width="56px" height="56px" src="@component('components.inventory.item') {{ $characterInventory->where('Slot', config('constants.inventory.slots.weapon'))->first()->AssocFileIcon128 }} @endcomponent" /></div>
                <div class="item"></div>
                <div class="item"><a></a><img title="{{ $characterInventory->where('Slot', config('constants.inventory.slots.shield'))->first()->CodeName128 }}" width="56px" height="56px" src="@component('components.inventory.item') {{ $characterInventory->where('Slot', config('constants.inventory.slots.shield'))->first()->AssocFileIcon128 }} @endcomponent" /></div>
            </section>
        </section>
</article>
@endsection
