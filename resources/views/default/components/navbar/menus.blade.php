<ul class="navbar-nav mr-auto mt-2 mt-lg-0">
@foreach (Menu::getByName('navbar')->items as $menuItem)
<li class="nav-item @if (count($menuItem->childrens) > 0) dropdown @endif">
    <a id="navMenu_{{ $menuItem->id }}" class="nav-link @if (count($menuItem->childrens) > 0) dropdown-toggle @endif"
        href="{{ $menuItem->url }}" @if (count($menuItem->childrens) > 0) role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" @endif aria-labelledby="navSubMenu_{{ $menuItem->id }}">
        {{ $menuItem->getTitle() }}
    </a>
    @if (count($menuItem->childrens) > 0)
    <ul class="dropdown-menu shadow" aria-labelledby="navMenu_{{ $menuItem->id }}">
        @foreach ($menuItem->childrens as $children)
            @include('components/navbar/child_menu', ['childmenu' => $children])
        @endforeach
    </ul>
    @endif
</li>
@endforeach
</ul>
