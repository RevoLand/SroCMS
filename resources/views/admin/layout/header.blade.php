<nav class="navbar navbar-light navbar-glass navbar-top sticky-kit navbar-expand-lg">
    <button class="btn navbar-toggler-humburger-icon navbar-toggler mr-1 mr-sm-3" type="button" data-toggle="collapse" data-target="#navbarVerticalCollapse" aria-controls="navbarVerticalCollapse" aria-expanded="false" aria-label="Toggle Navigation">
        <span class="navbar-toggle-icon"><span class="toggle-line"></span></span>
    </button>
    <a class="navbar-brand mr-1 mr-sm-3" href="{{ route('admin.dashboard.index') }}">
        <div class="d-flex align-items-center"><img class="mr-2" src="{{ Theme::url('img/illustrations/falcon.png') }}" alt="" width="40" /><span class="text-sans-serif">SroCMS</span>
        </div>
    </a>
    <ul class="navbar-nav align-items-center d-none d-lg-block">
        <li class="nav-item">
            {{-- TODO: Search system? --}}
            {{-- <form class="form-inline search-box">
                <input class="form-control rounded-pill search-input" type="search" placeholder="Search..." aria-label="Search" /><span class="position-absolute fas fa-search text-400 search-box-icon"></span>
            </form> --}}
        </li>
    </ul>
    <ul class="navbar-nav navbar-nav-icons ml-auto flex-row align-items-center">
        <li class="nav-item dropdown dropdown-on-hover">
            <a class="nav-link notification-indicator notification-indicator-primary px-2" id="navbarDropdownNotification" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="fad fa-bell fs-2"></span>
            </a>
            <div class="dropdown-menu dropdown-menu-right dropdown-menu-card" aria-labelledby="navbarDropdownNotification">
                <div class="card card-notification shadow-none" style="max-width: 20rem">
                <div class="card-header">
                    <div class="row justify-content-between align-items-center">
                    <div class="col-auto">
                        {{-- TODO: Notifications system? --}}
                        <h6 class="card-header-title mb-0">Notifications</h6>
                    </div>
                    <div class="col-auto"><a class="card-link font-weight-normal" href="#">Mark all as read</a></div>
                    </div>
                </div>
                <div class="list-group list-group-flush font-weight-normal fs--1">
                    <div class="list-group-title">NEW</div>
                    <div class="list-group-item">
                        <a class="notification notification-flush bg-200" href="#!">
                            <div class="notification-avatar">
                            <div class="avatar avatar-2xl mr-3">
                                <div class="avatar-name rounded-circle"><span>AB</span></div>
                            </div>
                            </div>
                            <div class="notification-body">
                            <p class="mb-1"><strong>Albert Brooks</strong> placed an order.</p>
                            <span class="notification-time"><span class="mr-1 fab fa-gratipay text-danger"></span>9hr</span>

                            </div>
                        </a>
                    </div>
                    <div class="list-group-title">EARLIER</div>
                    <div class="list-group-item">
                        <a class="notification notification-flush" href="#!">
                            <div class="notification-avatar">
                            <div class="avatar avatar-2xl mr-3">
                                <img class="rounded-circle" src="{{ Theme::url('img/icons/weather-sm.jpg') }}" alt="" />
                            </div>
                            </div>
                            <div class="notification-body">
                            <p class="mb-1">The forecast today shows a low of 20&#8451; in California. See today's weather.</p>
                            <span class="notification-time"><span class="mr-1" role="img" aria-label="Emoji">🌤️</span>1d</span>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="card-footer text-center border-top-0"><a class="card-link d-block" href="#!">View all</a></div>
                </div>
            </div>
        </li>
        <li class="nav-item dropdown dropdown-on-hover">
            <a class="nav-link pr-0 d-flex align-items-center" id="navbarDropdownUser" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                @isset(auth()->user()->gravatar)
                <div class="avatar avatar-xl mr-1">
                    <img class="rounded-circle" src="{{ auth()->user()->gravatar }}" alt="" />
                </div>
                @endisset
                {{ auth()->user()->getName() }}
            </a>
            <div class="dropdown-menu dropdown-menu-right py-0" aria-labelledby="navbarDropdownUser">
                <div class="bg-white rounded-soft py-2">
                    <a class="dropdown-item" href="{{ route('admin.users.show', auth()->user()->JID) }}">Profile &amp; Account</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{ route('users.edit_form') }}">Settings</a>
                    {!! Form::open(['route'=>'users.do_logout']) !!}
                    <button type="submit" class="dropdown-item">
                        Logout
                    </button>
                    {!! Form::close() !!}
                </div>
            </div>
        </li>
    </ul>
</nav>
