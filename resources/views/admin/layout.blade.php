<!DOCTYPE html>
<html lang="en-US" dir="ltr">
	<head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- ===============================================-->
        <!--    Document Title-->
        <!-- ===============================================-->
		<title>@setting('site.title', 'SroCMS') @hasSection('pagetitle') ~ @yield('pagetitle')@endif</title>
        <meta name="description" content="@setting('site.metadesc')">

        <!-- ===============================================-->
        <!--    Favicons-->
        <!-- ===============================================-->
        <link rel="apple-touch-icon" sizes="180x180" href="{{ Theme::url('img/favicons/apple-touch-icon.png') }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ Theme::url('img/favicons/favicon-32x32.png') }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ Theme::url('img/favicons/favicon-16x16.png') }}">
        <link rel="shortcut icon" type="image/x-icon" href="{{ Theme::url('img/favicons/favicon.ico') }}">
        <link rel="manifest" href="{{ Theme::url('img/favicons/manifest.json') }}">
        <meta name="msapplication-TileImage" content="{{ Theme::url('img/favicons/mstile-150x150.png') }}">
        <meta name="theme-color" content="#ffffff">

        <!-- ===============================================-->
        <!--    Stylesheets-->
        <!-- ===============================================-->
        <script src="{{ Theme::url('js/config.navbar-vertical.js') }}"></script>
        <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin="">
        {!! Theme::css('css/theme-dark.css') !!}
        {!! Theme::css('lib/@fortawesome/css/all.min.css') !!}

        @yield('css')
	</head>
    <!-- ===============================================-->
    <!--    Main Content-->
    <!-- ===============================================-->
    <body>
        <main class="main" id="top">
            <div class="container-fluid" data-layout="container">
                <!-- navbar -->
                @include('layout.navmenu')
                <!-- navbar ends -->

                <div class="content">
                    @include('layout.header')

                    @yield('content')

                    @include('layout.footer')
                </div>
            </div>
        </main>
        <script src="{{ mix('js/manifest.js') }}"></script>
        <script src="{{ mix('js/vendor.js') }}"></script>
        <script src="{{ mix('js/app.js') }}"></script>
        {!! Theme::js('js/popper.min.js') !!}
        {!! Theme::js('js/bootstrap.min.js') !!}
        {!! Theme::js('js/theme.js') !!}
        <script src="{{ asset('vendor/lib/blockui/jquery.blockUI.min.js') }}"></script>
        {!! Theme::js('lib/stickyfilljs/stickyfill.min.js') !!}
        {!! Theme::js('lib/sticky-kit/sticky-kit.min.js') !!}
        <script>
        $(function() {
            "use strict";
                var url = window.location + "";
                var path = url.replace(window.location.protocol + "//" + window.location.host + "/", "");
                var element = $('ul.navbar-nav a').filter(function() {
                    return this.href === url || this.href === path;// || url.href.indexOf(this.href) === 0;
                });

                element.parentsUntil(".navbar-nav").each(function (index)
                {
                    if($(this).is("li") && $(this).children("a").length !== 0)
                    {
                        $(this).children("a").addClass("active");
                        $(this).parent("ul.navbar-nav").length === 0
                            ? $(this).addClass("active")
                            : $(this).addClass("active");

                        if ($(this).children("a").hasClass('dropdown-indicator')) {
                            $(this).children("a").click();
                        }
                    }
                    else if(!$(this).is("ul") && $(this).children("a").length === 0)
                    {
                        // console.log('burası geldi - 1');
                        // console.log($(this));
                        $(this).addClass("active");

                    }
                    else if($(this).is("ul")){
                        // console.log('burası geldi - 2');
                        // console.log($(this));
                    }

                });

            element.addClass("active");
        });
        Vue.mixin({
            methods: {
                route: (name, params, absolute) => route(name, params, absolute, Ziggy),
            },
        });
        </script>

        @routes

        @yield('js')
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,500,600,700%7cPoppins:100,200,300,400,500,600,700,800,900&amp;display=swap" rel="stylesheet">
	</body>
</html>
