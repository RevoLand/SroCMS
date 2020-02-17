<div class="container text-monospace tooltip-item-info">
    <div class="row row-cols-1">
        <h6 class="col mb-4 @if($item->objCommon->Rarity) text-warning @endif">
            {{ $item->name }} (+{{ $item->OptLevel }})
        </h6>
        @if ($item->objCommon->Rarity)
            <h6 class="col text-warning">
                {{ $item->objCommon->objItem->rarity }}
            </h6>
            @if ($item->objCommon->Rarity == 6)
                <div class="col text-warning">
                    {{ $item->objCommon->objItem->setItem->getName() }}
                </div>
            @endif
        @endif
        <div class="col">
            Sort of Item: {{ $item->objCommon->sortOfItem }}
        </div>
        <div class="col">
            Mounting part: {{ $item->objCommon->mountingPart }}
        </div>
        <div class="col mb-4">
            Degree: {{ $item->objCommon->objItem->degree }} degrees
        </div>
        @switch($item->type)
            @case('weapon')
                @if ($item->physicalMaxDamage)
                <div class="col">
                    Phy. atk. pwr. {{ $item->physicalMinDamage }} ~ {{ $item->physicalMaxDamage }} (+{{ intval($item->stats->PhyAttack) }}%)
                </div>
                @endif
                @if ($item->magicalMaxDamage)
                <div class="col">
                    Mag. atk. pwr. {{ $item->magicalMinDamage }} ~ {{ $item->magicalMaxDamage }} (+{{ intval($item->stats->MagAttack) }}%)
                </div>
                @endif
                <div class="col">
                    Durability {{ $item->Data }}/{{ $item->durability }} (+{{ intval($item->stats->Durability) }}%)
                </div>
                <div class="col">
                    Attack distance {{ $item->range }}m
                </div>
                <div class="col">
                    Attack rate {{ $item->attackRate }} (+{{ intval($item->stats->HitRatio) }}%)
                </div>
                <div class="col">
                    Critical {{ $item->critical }} (+{{ intval($item->stats->CriticalRatio) }}%)
                </div>
                @if ($item->physicalMaxReinforcement)
                <div class="col">
                    Phy. reinforce {{ $item->physicalMinReinforcement }} % ~ {{ $item->physicalMaxReinforcement }} (+{{ intval($item->stats->PhyReinforce) }}%)
                </div>
                @endif
                @if ($item->magicalMaxReinforcement)
                <div class="col">
                    Mag. reinforce {{ $item->magicalMinReinforcement }} % ~ {{ $item->magicalMaxReinforcement }} (+{{ intval($item->stats->MagReinforce) }}%)
                </div>
                @endif
            @break
            @case('equipment')
            @case('shield')
                <div class="col">
                    Phy. def. pwr {{ $item->physicalDefensePower }} (+{{ intval($item->stats->PhyDefense) }}%)
                </div>
                <div class="col">
                    Mag. def. pwr. {{ $item->magicalDefensePower }} (+{{ intval($item->stats->MagDefense) }}%)
                </div>
                <div class="col">
                    Durability {{ $item->Data }}/{{ $item->durability }} (+{{ intval($item->stats->Durability) }}%)
                </div>

                @if ($item->type == 'equipment')
                <div class="col">
                    Parry rate {{ $item->parryRate }} (+{{ intval($item->stats->ParryRatio) }}%)
                </div>
                @elseif ($item->type == 'shield')
                <div class="col">
                    Blocking rate {{ $item->blockingRate }} (+{{ intval($item->stats->BlockRatio) }}%)
                </div>
                @endif

                <div class="col">
                    Phy. reinforce {{ $item->physicalReinforcement }} % (+{{ intval($item->stats->PhyReinforce) }}%)
                </div>
                <div class="col">
                    Mag. reinforce {{ $item->magicalReinforcement }} % (+{{ intval($item->stats->MagReinforce) }}%)
                </div>
            @break
            @case('accessory')
                <div class="col">
                    Phy. absorption {{ $item->physicalAbsorption }} (+{{ intval($item->stats->PhyAbsorption) }}%)
                </div>
                <div class="col">
                    Mag. absorption {{ $item->magicalAbsorption }} (+{{ intval($item->stats->MagAbsorption) }}%)
                </div>
            @break
        @endswitch
        <div class="col mt-4">
            Required Level: {{ $item->objCommon->ReqLevel1 }}
        </div>
        <div class="col">
            {{ config('constants.item.country.' . $item->objCommon->Country) }}
        </div>
        <div class="col">
            Max. no. of magic options: {{ $item->objCommon->objItem->MaxMagicOptCount }}Unit
        </div>
        @foreach($item->magicParams as $blue)
            <h6 class="col text-primary @if($loop->first) mt-4 @endif">{{ sprintf($blue->name, $blue->value) }}</h6>
        @endforeach
    </div>
</div>
