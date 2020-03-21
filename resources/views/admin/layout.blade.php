<!DOCTYPE html>
<html lang="en">
	<!-- begin::Head -->
	<head>
		<base href="">
		<meta charset="utf-8" />
		<title>@setting('site.title', 'SroCMS') @hasSection('pagetitle') ~ @yield('pagetitle')@endif</title>
		<meta name="description" content="@setting('site.metadesc')">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />

		<!--begin::Fonts -->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700">
		<!--end::Fonts -->

		<!--begin::Page Vendors Styles(used by this page) -->
        {!! Theme::css('plugins/custom/fullcalendar/fullcalendar.bundle.css') !!}
        @yield('css')
		<!--end::Page Vendors Styles -->

		<!--begin::Global Theme Styles(used by all pages) -->
        {!! Theme::css('plugins/global/plugins.bundle.css') !!}
        {!! Theme::css('css/style.bundle.css') !!}
		<!--end::Global Theme Styles -->

        <!--begin::Layout Skins(used by all pages) -->
        {!! Theme::css('css/skins/header/base/brand.css') !!}
        {!! Theme::css('css/skins/header/menu/light.css') !!}
        {!! Theme::css('css/skins/brand/navy.css') !!}
        {!! Theme::css('css/skins/aside/navy.css') !!}

		<!--end::Layout Skins -->
        <link rel="shortcut icon" href="{{ Theme::url('media/logos/favicon.ico') }}" />
	</head>
	<!-- end::Head -->

	<!-- begin::Body -->
	<body class="kt-quick-panel--right kt-offcanvas-panel--right kt-header--fixed kt-header-mobile--fixed kt-subheader--fixed kt-subheader--enabled kt-subheader--solid kt-aside--enabled kt-aside--fixed kt-page--loading">
        <!-- content -->
        @include('layout.header.mobile-base')

        <!-- begin:: Root -->
        <div class="kt-grid kt-grid--hor kt-grid--root">
            <!-- begin:: Page -->
            <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--ver kt-page">
                <!-- begin:: Aside -->
                <button class="kt-aside-close " id="kt_aside_close_btn"><i class="la la-close"></i></button>
                <div class="kt-aside  kt-aside--fixed  kt-grid__item kt-grid kt-grid--desktop kt-grid--hor-desktop" id="kt_aside">
                    @include('layout.aside.brand')
                    @include('layout.aside.menu')
                    @include('layout.aside.footer')
                </div>
                <!-- end:: Aside -->

                <!-- begin:: Wrapper -->
                <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-wrapper" id="kt_wrapper">
                    @include('layout.header.base')
                    <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
                        @yield('content')
                    </div>
                    @include('layout.footer')
                </div>
                <!-- end:: Wrapper -->
            </div>
            <!-- end:: Page -->
        </div>
        <!-- end:: Root -->

        <!-- begin::Scrolltop -->
        <div id="kt_scrolltop" class="kt-scrolltop">
            <i class="fa fa-arrow-up"></i>
        </div>
        <!-- end::Scrolltop -->

        <!-- end::content -->

		<!-- begin::Global Config(global config for global JS sciprts) -->
		<script>
			var KTAppOptions = {
				"colors": {
					"state": {
						"brand": "#5d78ff",
						"metal": "#c4c5d6",
						"light": "#ffffff",
						"accent": "#00c5dc",
						"primary": "#5867dd",
						"success": "#34bfa3",
						"info": "#36a3f7",
						"warning": "#ffb822",
						"danger": "#fd3995",
						"focus": "#9816f4"
					},
					"base": {
						"label": [
							"#c5cbe3",
							"#a1a8c3",
							"#3d4465",
							"#3e4466"
						],
						"shape": [
							"#f0f3ff",
							"#d9dffa",
							"#afb4d4",
							"#646c9a"
						]
					}
				}
			};
		</script>
		<!-- end::Global Config -->

		<!--begin::Global Theme Bundle(used by all pages) -->
        <script src="{{ asset('vendor/jquery-3.4.1.min.js') }}"></script>
        {!! Theme::js('plugins/global/plugins.bundle.js') !!}
        {!! Theme::js('js/scripts.bundle.js') !!}
        {!! Theme::js('js/pages/components/extended/sweetalert2.js') !!}
		<!--end::Global Theme Bundle -->
        @yield('js')
	</body>

	<!-- end::Body -->
</html>
