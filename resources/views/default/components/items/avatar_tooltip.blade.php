<div class="container text-monospace tooltip-item-info">
    <div class="row row-cols-1">
        <h6 class="col mb-4 @if($item->objCommon->Rarity) text-warning @endif">
            {{ $item->name }} @if($item->OptLevel) (+{{ $item->OptLevel }}) @endif
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
        <div class="col mb-4">
            Mounting part: {{ $item->objCommon->mountingPart }}
        </div>
        @if ($item->objCommon->Country)
        <div class="col">
            {{ config('constants.item.country.' . $item->objCommon->Country) }}
        </div>
        @endif
        <div class="col">
            Max. no. of magic options: {{ $item->objCommon->objItem->MaxMagicOptCount }}Unit
        </div>
        @foreach($item->magicParams as $blue)
            <h6 class="col text-primary @if($loop->first) mt-4 @endif">{{ sprintf($blue->name, $blue->value) }}</h6>
        @endforeach
    </div>
</div>
