<div class="container pt-1">
    <div class="d-flex align-items-center">
        Deneme
        <ul class="list-inline ml-auto mb-0">
            <li class="list-inline-item">
                <button class="btn" role="button">
                    <span class="fas fa-shopping-cart"></span>
                </button>
            </li>
        </ul>
    </div>
</div>
<nav class="navbar navbar-expand-md navbar-dark bg-dark shadow-sm rounded-sm">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggler"
        aria-controls="navbarToggler" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarToggler">
        <a class="navbar-brand" href="{{ route('home') }}">SroCMS</a>
        @include ('components/navbar/menus')

        @auth
        <div class="btn-group" role="group">
            <a type="button" class="btn btn-sm btn-primary" href="{{ route('users.current_user') }}">
                @if (Auth::user()->gravatar)
                    <img src="{{ Auth::user()->gravatar }}?s=32" class="img-fluid rounded" width="32" height="32" />
                @endif
                {{ Auth::user()->getName() }}
            </a>
            <button id="headerUserDropdownMenu" type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" data-display="static" aria-haspopup="true" aria-expanded="false">
                <span class="sr-only">Toggle Dropdown</span>
            </button>
            <div class="dropdown-menu shadow-sm" aria-labelledby="headerUserDropdownMenu">
                <a class="dropdown-item" href="{{ route('users.current_user') }}">
                    <span class="fas fa-user-circle"></span>
                    Profile
                </a>
                <a class="dropdown-item" href="{{ route('users.edit_form') }}">
                    <span class="fas fa-user-cog"></span>
                    Settings
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="{{ route('users.do_logout') }}">
                    <span class="fas fa-sign-out-alt"></span>
                    Logout
                </a>
            </div>
        </div>
        @endauth
    </div>
</nav>
