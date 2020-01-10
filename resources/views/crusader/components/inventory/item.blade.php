@if ($item->ItemID == 0)
<img width="56px" height="56px" src="{{ Theme::url('images/silkroad/inventory/' . $item->Slot . '.png') }}" />
Boş
@else
<img title="{{ $item->item->objCommon->CodeName128 }}" width="56px" height="56px"
    src="@if ($slot == 'xxx') {{ Theme::url('images/silkroad/no_item.png') }} @else {{ Theme::url('images/silkroad/' . Str::lower(Str::replaceFirst('.ddj', '.png', $item->item->objCommon->AssocFileIcon128))) }} @endif" />

{{ $item->item->objCommon->CodeName128 }} (+{{ $item->item->objCommon->OptLevel }}) - {{ $item->item->objCommon->Rarity }}
@endif
