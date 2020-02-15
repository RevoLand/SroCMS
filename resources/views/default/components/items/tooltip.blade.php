<div class="container text-monospace tooltip-item-info">
    <div class="row row-cols-1">
        <div class="col mb-4 @if($item->objCommon->Rarity) text-warning @endif">
            {{ $item->objCommon->CodeName128 }} (+{{ $item->OptLevel }})
        </div>
        @if ($item->objCommon->Rarity)
            <h6 class="col text-warning">
                {{ $item->objCommon->objItem->rarity }}
            </h6>
            @if ($item->objCommon->Rarity == 6)
                <div class="col text-warning">
                    {{ $item->objCommon->objItem->setItem->NameStrID128 }}
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
            @break
            @case('shield')

            @break
            @case('accessory')

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
    </div>
</div>
