@if ($item->ID == 0)
<img title="{{ $item->CodeName128 }}" width="56px" height="56px" src="{{ Theme::url('images/silkroad/inventory/' . $item->Slot . '.png') }}" />
Boş
@else
<img title="{{ $item->CodeName128 }}" width="56px" height="56px"
    src="@if ($slot == 'xxx') {{ Theme::url('images/silkroad/no_item.png') }} @else {{ Theme::url('images/silkroad/' . Str::lower(Str::replaceFirst('.ddj', '.png', $item->AssocFileIcon128))) }} @endif" />

{{ $item->CodeName128 }} (+{{ $item->OptLevel }}) - {{ $item->Rarity }}
@endif
