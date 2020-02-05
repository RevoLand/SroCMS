<!doctype html>
<html lang="en">

    <head>
        <!-- Title -->
        <title>{{ setting('site.title', 'SroCMS') }}@yield ('pagetitle')</title>


        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <meta name="description" content="{{ setting('site.metadesc') }}" />
        <meta name="keywords" content="{{ setting('site.metakeys') }}" />

        <!-- Favicon -->
        <link rel="shortcut icon" href="{{ Theme::url('srocms/img/favicon.png') }}">

        <!-- Google Fonts -->
        <link href="//fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet">

        <!-- CSS Front Template -->
        {!! Theme::css('css/theme.css') !!}

        <!-- CSS Implementing Plugins -->
        {!! Theme::css('vendor/font-awesome/css/fontawesome-all.min.css') !!}
        {!! Theme::css('vendor/animate.css/animate.min.css') !!}
        {!! Theme::css('vendor/hs-megamenu/src/hs.megamenu.css') !!}
        {!! Theme::css('vendor/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.css') !!}
        <!-- CSS Custom -->
        @yield('css')
    </head>

    <body>
        @include ('header')

        <div class="container">
            <h1>Selam!</h1>
            <div class="row">
                <div class="col-8">
                    Content
                </div>
                <div class="col-4">
                    Sidebar
                </div>
            </div>
        </div>
        <!-- JS Global Compulsory -->
        {!! Theme::js('vendor/jquery/dist/jquery.min.js') !!}
        {!! Theme::js('vendor/jquery-migrate/dist/jquery-migrate.min.js') !!}
        {!! Theme::js('vendor/popper.js/dist/umd/popper.min.js') !!}
        {!! Theme::js('vendor/bootstrap/bootstrap.min.js') !!}


        <!-- JS Implementing Plugins -->
        {!! Theme::js('vendor/hs-megamenu/src/hs.megamenu.js') !!}
        {!! Theme::js('vendor/svg-injector/dist/svg-injector.min.js') !!}
        {!! Theme::js('vendor/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js') !!}
        {!! Theme::js('vendor/jquery-validation/dist/jquery.validate.min.js') !!}

        <!-- JS Front -->
        {!! Theme::js('js/hs.core.js') !!}
        {!! Theme::js('js/components/hs.header.js') !!}
        {!! Theme::js('js/components/hs.svg-injector.js') !!}
        {!! Theme::js('js/components/hs.malihu-scrollbar.js') !!}
        {!! Theme::js('js/components/hs.unfold.js') !!}
        {!! Theme::js('js/components/hs.focus-state.js') !!}
        {!! Theme::js('js/components/hs.validation.js') !!}
        {!! Theme::js('js/components/hs.show-animation.js') !!}

        <!-- JS Plugins Init. -->
        <script>
        $(window).on('load', function () {
            // initialization of HSMegaMenu component
            $('.js-mega-menu').HSMegaMenu({
            event: 'hover',
            pageContainer: $('.container'),
            breakpoint: 767.98,
            hideTimeOut: 0
            });

            // initialization of svg injector module
            $.HSCore.components.HSSVGIngector.init('.js-svg-injector');
        });

        $(document).on('ready', function () {
            // initialization of header
            $.HSCore.components.HSHeader.init($('#header'));

            // initialization of unfold component
            $.HSCore.components.HSUnfold.init($('[data-unfold-target]'), {
            afterOpen: function () {
                $(this).find('input[type="search"]').focus();
            }
            });

            // initialization of malihu scrollbar
            $.HSCore.components.HSMalihuScrollBar.init($('.js-scrollbar'));

            // initialization of forms
            $.HSCore.components.HSFocusState.init();

            // initialization of form validation
            $.HSCore.components.HSValidation.init('.js-validate', {
            rules: {
                confirmPassword: {
                equalTo: '#signupPassword'
                }
            }
            });

            // initialization of show animations
            $.HSCore.components.HSShowAnimation.init('.js-animation-link');
        });
        </script>
        @include('sweetalert::alert')
        @yield('js')
    </body>

</html>
