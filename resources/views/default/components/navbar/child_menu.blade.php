<li @if (count($childmenu->children) > 0) class="dropdown-submenu" @endif>
    <a id="navMenu_{{ $children->id }}" class="dropdown-item @if (count($childmenu->children) > 0) dropdown-toggle @endif" href="{{ $children->url }}"
            @if (count($childmenu->children) > 0) role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" @endif aria-labelledby="navSubMenu_{{ $children->id }}">
        {{ $children->getTitle() }}
    </a>
    @if (count($childmenu->children) > 0)
        <ul class="dropdown-menu shadow" aria-labelledby="navSubMenu_{{ $children->id }}">
            @foreach ($children->childrens as $children)
                @include('components/navbar/child_menu', ['childmenu' => $children])
            @endforeach
        </ul>
    @endif
</li>
