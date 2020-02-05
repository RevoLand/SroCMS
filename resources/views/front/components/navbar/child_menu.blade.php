<li class="hs-has-sub-menu">
    <a id="pagesMenu_{{ $childMenu->id }}" class="nav-link u-header__sub-menu-nav-link @if ($childMenu->menus->count() > 0)u-header__sub-menu-nav-link-toggle @endif" href="{{ $childMenu->getHref() }}" aria-haspopup="true" aria-expanded="false" aria-controls="pagesSubMenu_{{ $childMenu->id }}">
        {{ $childMenu->getTitle() }}
    </a>
    @if ($childMenu->menus->count() > 0)
    <ul id="pagesSubMenu_{{ $childMenu->id }}" class="hs-sub-menu u-header__sub-menu" aria-labelledby="pagesMenu_{{ $childMenu->id }}" style="min-width: 230px;">
        @foreach ($childMenu->menus as $childMenu)
            @include('components/navbar/child_menu', ['childMenu' => $childMenu])
        @endforeach
    </ul>
    @endif
</li>
