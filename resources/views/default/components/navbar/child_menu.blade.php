<li @if ($childMenu->menus->count() > 0) class="dropdown-submenu" @endif>
    <a id="navMenu_{{ $childMenu->id }}" class="dropdown-item @if ($childMenu->menus->count() > 0) dropdown-toggle @endif" href="{{ $childMenu->getHref() }}"
            @if ($childMenu->menus->count() > 0) role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" @endif aria-labelledby="navSubMenu_{{ $childMenu->id }}">
        {{ $childMenu->getTitle() }}
    </a>
    @if ($childMenu->menus->count() > 0)
        <ul class="dropdown-menu shadow" aria-labelledby="navSubMenu_{{ $childMenu->id }}">
            @foreach ($childMenu->menus as $childMenu)
                @include('components/navbar/child_menu', ['childMenu' => $childMenu])
            @endforeach
        </ul>
    @endif
</li>
