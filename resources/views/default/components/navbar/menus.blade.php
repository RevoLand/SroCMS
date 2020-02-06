<ul class="navbar-nav mr-auto mt-2 mt-lg-0">
@foreach (\App\Http\Controllers\MenuController::getMenus('header') as $menuItem)
<li class="nav-item @if ($menuItem->child_menus_count > 0) dropdown @endif">
    <a id="navMenu_{{ $menuItem->id }}" class="nav-link @if ($menuItem->child_menus_count > 0) dropdown-toggle @endif"
        href="{{ $menuItem->getHref() }}" @if ($menuItem->child_menus_count > 0) role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" @endif aria-labelledby="navSubMenu_{{ $menuItem->id }}">
        {{ $menuItem->getTitle() }}
    </a>
    @if ($menuItem->child_menus_count > 0)
    <ul class="dropdown-menu shadow" aria-labelledby="navMenu_{{ $menuItem->id }}">
        @foreach ($menuItem->childMenus as $childMenu)
            @include('components/navbar/child_menu', ['childMenu' => $childMenu])
        @endforeach
    </ul>
    @endif
</li>
@endforeach
</ul>
