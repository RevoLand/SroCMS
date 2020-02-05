@foreach (\App\Http\Controllers\MenuController::getMenus('header') as $menuItem)
<li class="nav-item hs-has-sub-menu u-header__nav-item"
data-event="hover"
data-animation-in="slideInUp"
data-animation-out="fadeOut">
    <a id="pagesMenu_{{ $menuItem->id }}" class="nav-link u-header__nav-link @if ($menuItem->child_menus_count > 0)u-header__nav-link-toggle @endif" href="{{ $menuItem->getHref() }}" aria-haspopup="true" aria-expanded="false" aria-labelledby="pagesSubMenu_{{ $menuItem->id }}">
        {{ $menuItem->getTitle() }}
    </a>
    @if ($menuItem->child_menus_count > 0)
    <ul id="pagesSubMenu_{{ $menuItem->id }}" class="hs-sub-menu u-header__sub-menu" aria-labelledby="pagesMenu_{{ $menuItem->id }}" style="min-width: 230px;">
        @foreach ($menuItem->childMenus as $childMenu)
            @include('components/navbar/child_menu', ['childMenu' => $childMenu])
        @endforeach
    </ul>
    @endif
<!-- End Pages - Submenu -->
</li>
@endforeach
