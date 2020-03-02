<div class="container pt-1">
    <div class="d-flex align-items-center">
        Deneme
        <ul class="list-inline ml-auto mb-0">
            <li class="list-inline-item">
                <a class="btn" role="button" href="{{ route('itemmall.cart.index') }}">
                    <span class="fas fa-shopping-cart"></span>
                </a>
            </li>
        </ul>
    </div>
</div>
<nav class="navbar navbar-expand-md navbar-dark bg-dark shadow-sm rounded">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggler"
        aria-controls="navbarToggler" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarToggler">
        <a class="navbar-brand lead" href="{{ route('home') }}">SroCMS</a>
        @include('components/navbar/menus')

        @auth
        <div class="btn-group" role="group">
            <a type="button" class="btn btn-secondary btn-block text-left text-nowrap" href="{{ route('users.current_user') }}">
                @isset(Auth::user()->gravatar)
                    <img src="{{ Auth::user()->gravatar }}?s=32" class="img-fluid" />
                @endisset
                {{ Auth::user()->getName() }}
            </a>
            <button id="headerUserDropdownMenu" type="button" class="btn btn-secondary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" data-display="static" aria-haspopup="true" aria-expanded="false">
                <span class="sr-only">Toggle Dropdown</span>
            </button>
            <div class="dropdown-menu shadow-sm" aria-labelledby="headerUserDropdownMenu">
                <a class="dropdown-item align-items-center" href="{{ route('users.current_user') }}">
                    <i class="fas fa-user-circle fa-fw text-light mr-2"></i>
                    Profile
                </a>
                <a class="dropdown-item align-items-center" href="{{ route('users.edit_form') }}">
                    <i class="fas fa-user-cog fa-fw text-light mr-2"></i>
                    Settings
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item align-items-center" href="{{ route('users.do_logout') }}">
                    <i class="fas fa-sign-out-alt fa-fw text-light mr-2"></i>
                    Logout
                </a>
            </div>
        </div>
        @endauth
    </div>
</nav>
