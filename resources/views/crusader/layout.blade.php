<!DOCTYPE html>
<html>
    <head>
        <title>{{ setting('site.title', 'SroCMS') }}</title>
        <link rel="shortcut icon" href="{!! Theme::url('images/favicon.gif') !!}">

        <!-- Responsive meta tag -->
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Search engine related -->
        <meta name="description" content="{{ setting('site.metadesc') }}" />
        <meta name="keywords" content="{{ setting('site.metakeys') }}" />

        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>

        <!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame -->
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

        <!-- Load styles -->
        {!! Theme::css('css/cms.css') !!}
        {!! Theme::css('css/main.css') !!}
        @yield('css')
    </head>
	<body>
		<!--[if lte IE 8]>
			<style type="text/css">
				body {
					background-image:url({{ Theme::url('images/bg.jpg') }});
					background-position:top center;
				}
			</style>
		<![endif]-->
		<section id="wrapper">
            <div id="header">

                <div class="top_container">

                	<div class="login_box_top">
                    	<div class="actions_cont">

                        	@if (Auth::check())
                            	<div class="account_info">

                                    @if (Auth::user()->gravatar)
                                    <!-- Avatar -->
                                    	<div class="avatar_top">
                                            <img src="{{ Auth::user()->gravatar }}" width="50" height="50"/>
                                            <span></span>
                                        </div>
                                    <!-- Avatar . End -->
                                    @endif

                                    <!-- Welcome & VP/DP -->
                                	<div class="left">
                                        <p>Welcome back, <span>{{ Auth::user()->Name ?? Auth::user()->StrUserID }}</span>!</p>
                                        @if (Auth::user()->Silk)
                                        <div class="vpdp">
                                        	<div class="vp">
                                           		<img src="{{ Theme::url('images/icons/silk.png') }}" align="absmiddle" width="12" height="12" /> silk_own:
                                                <span>{{ Auth::user()->Silk->silk_own }}</span>
                                            </div>
                                            <div class="dp">
                                           		<img src="{{ Theme::url('images/icons/giftsilk.png') }}" align="absmiddle" width="12" height="12"  /> silk_gift
                                                <span>{{ Auth::user()->Silk->silk_gift }}</span>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                    <!-- Welcome & VP/DP . End-->
                                    	<div class="right">
                                            <a href="{{ route('users.current_user') }}" class="nice_button">User panel</a>
                                            <a href="{$url}vote" class="nice_button">Vote</a>
											<a href="{{ route('users.do_logout') }}" class="nice_button">Log out</a>
                                        </div>
                                    <!-- Account Panel & Logout -->

                                </div>
                            @else
                            	<div class="login_form_top">
                                    {{ Form::open(['route' => 'users.do_login']) }}
                                        <input type="text" name="username" id="username" value="" placeholder="Username">
                                        <input type="password" name="password" id="password" value="" placeholder="Password">
                                        <input type="submit" value="Login">
                                    {{ Form::close() }}
                            	</div>
                            @endif
                        </div>
                    </div>

                    <div class="top_menu">
                        <ul id="top_menu">
                            {foreach from=$menu_top item=menu_1}
                                <li><a {$menu_1.link}>{$menu_1.name}</a></li>
                            {/foreach}
                        </ul>
                    </div>
                </div>

                <a id="server_logo" href="{{ route('home') }}" title="{$serverName}"><p>{$serverName}</p></a>

                <!--<div class="accp_register">
                    {if $isOnline}
                        <a href="./ucp" id="accp_button"><h1>Account Panel</h1></a>
                        {else}
                        <a href="./register" id="register_button"><h1>Register</h1></a>
                    {/if}
                </div>-->

                <!--{$serverName}-->
           	</div>

            <div class="sword"></div>

            <div class="top_border"></div>
			<div id="main">
				<aside id="left">
                    @if (Auth::check())
                		<a href="{$url}vote" id="vote_banner"><p>Vote for us</p></a>
                    @else
                    	<a href="{{ route('users.register_form') }}" id="register_banner"><p>Create Account</p></a>
                    @endif

                    <article>
						<ul id="left_menu">
							{foreach from=$menu_side item=menu_2}
								<li><a {$menu_2.link}><img src="{$image_path}bullet.png">{$menu_2.name}</a><p></p></li>
							{/foreach}
                            <li class="bot_shadow"></li>
						</ul>
					</article>

                    @foreach (\App\Http\Controllers\SidebarController::getSidebars(5) as $sidebar)
                    <article class="sidebox">
                        <h1 class="top"><p>{{ $sidebar->title }}</p></h1>
                        <section class="body">
                            {!! $sidebar->getContent() !!}
                        </section>
                    </article>
                    @endforeach
				</aside>

				<aside id="right">
                    @yield ('content')
				</aside>

				<div class="clear"></div>
			</div>
			<footer>
            	<h3>{$serverName} &copy; Copyright 2019 </h3>
             	<a href="http://evil.duloclan.com" id="evil-logo" target="_blank" title="Design by EvilSystem"><span>Design by EvilSystem</span></a>
				<a href="https://github.com/RevoLand" id="fcms-logo" target="_blank"><span>Powered by SroCMS</span></a>
			</footer>
        </section>
        @include('sweetalert::alert')
        @yield('js')
	</body>
</html>
