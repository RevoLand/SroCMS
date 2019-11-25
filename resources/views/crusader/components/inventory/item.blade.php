@if ($slot == 'xxx')
    {{ Theme::url('images/media/no_item.png') }}
@else
    {{ Theme::url('images/media/' . Str::lower(Str::replaceFirst('.ddj', '.png', $slot))) }}
@endif
