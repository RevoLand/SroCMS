<!--begin: User Bar -->
<div class="kt-header__topbar-item kt-header__topbar-item--user">
	<div class="kt-header__topbar-wrapper" data-toggle="dropdown" data-offset="0px,0px">
		<div class="kt-header__topbar-user kt-rounded-">
			<span class="kt-header__topbar-welcome kt-hidden-mobile">Hi,</span>
            <span class="kt-header__topbar-username kt-hidden-mobile">{{ auth()->user()->getName() }}</span>
            @isset(auth()->user()->gravatar)
                <img alt="{{ auth()->user()->getName() }}" src="{{ auth()->user()->gravatar }}" class="kt-rounded-" />
            @else
                <span class="kt-badge kt-badge--username kt-badge--lg kt-badge--brand kt-badge--bold">{{ substr(auth()->user()->getName(), 0, 1) }}</span>
            @endisset
		</div>
	</div>
	<div class="dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim dropdown-menu-top-unround dropdown-menu-sm">
        <div class="kt-user-card kt-margin-b-40 kt-margin-b-30-tablet-and-mobile" style="background-image: url({{ Theme::url('media/misc/head_bg_sm.jpg') }})">
            <div class="kt-user-card__wrapper">
                <div class="kt-user-card__pic">
                    @isset(auth()->user()->gravatar)
                        <img alt="{{ auth()->user()->getName() }}" src="{{ auth()->user()->gravatar }}" class="kt-rounded-" />
                    @else
                        <span class="kt-badge kt-badge--username kt-badge--lg kt-badge--brand kt-badge--bold">{{ substr(auth()->user()->getName(), 0, 1) }}</span>
                    @endisset
                </div>
                <div class="kt-user-card__details">
                    <div class="kt-user-card__name">{{ auth()->user()->getName() }}</div>
                    <div class="kt-user-card__position">@foreach(auth()->user()->getRoleNames() as $userRole) {{ $userRole }} @endforeach</div>
                </div>
            </div>
        </div>
        <ul class="kt-nav kt-margin-b-10">
            <li class="kt-nav__item">
                <a href="custom/profile/personal-information.html" class="kt-nav__link">
                    <span class="kt-nav__link-icon"><i class="flaticon2-calendar-3"></i></span>
                    <span class="kt-nav__link-text">My Profile</span>
                </a>
            </li>
            <li class="kt-nav__item">
                <a href="custom/profile/overview-1.html" class="kt-nav__link">
                    <span class="kt-nav__link-icon"><i class="flaticon2-browser-2"></i></span>
                    <span class="kt-nav__link-text">My Tasks</span>
                </a>
            </li>
            <li class="kt-nav__item">
                <a href="custom/profile/overview-2.html" class="kt-nav__link">
                    <span class="kt-nav__link-icon"><i class="flaticon2-mail"></i></span>
                    <span class="kt-nav__link-text">Messages</span>
                </a>
            </li>
            <li class="kt-nav__item">
                <a href="custom/profile/account-settings.html" class="kt-nav__link">
                    <span class="kt-nav__link-icon"><i class="flaticon2-gear"></i></span>
                    <span class="kt-nav__link-text">Settings</span>
                </a>
            </li>
            <li class="kt-nav__separator kt-nav__separator--fit"></li>
            <li class="kt-nav__custom kt-space-between">
                {!! Form::open(['route'=>'users.do_logout']) !!}
                    <button type="submit" class="btn btn-label-brand btn-upper btn-sm btn-bold">Sign Out</button>
                {!! Form::close() !!}
            </li>
        </ul>
	</div>
</div>
<!--end: User Bar -->
