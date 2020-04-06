@extends('layout')

@section('pagetitle', 'User: ' . $user->getName())

@section('content')
    <!-- begin:: Subheader -->
    <div class="kt-subheader  kt-grid__item" id="kt_subheader">
        <div class="kt-container  kt-container--fluid ">
            <div class="kt-subheader__main">
                <h3 class="kt-subheader__title">User Profile</h3>
                <span class="kt-subheader__separator kt-hidden"></span>
                <div class="kt-subheader__breadcrumbs">
                    <a href="{{ route('admin.dashboard.index') }}" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
                    <span class="kt-subheader__breadcrumbs-separator"></span>
                    <a href="{{ route('admin.users.index') }}" class="kt-subheader__breadcrumbs-link">Users</a>
                    <span class="kt-subheader__breadcrumbs-separator"></span>
                    <a href="{{ route('admin.users.show', $user) }}" class="kt-subheader__breadcrumbs-link kt-subheader__breadcrumbs-link--active">Profile</a>
                </div>
            </div>
        </div>
    </div>

    <!-- end:: Subheader -->

<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
    <div class="kt-grid kt-grid--desktop kt-grid--ver kt-grid--ver-desktop kt-app">

        <!--Begin:: App Aside Mobile Toggle-->
        <button class="kt-app__aside-close" id="kt_profile_aside_close">
            <i class="la la-close"></i>
        </button>

        <!--End:: App Aside Mobile Toggle-->

        <!--Begin:: App Aside-->
        <div class="kt-grid__item kt-app__toggle kt-app__aside kt-app__aside--sm kt-app__aside--fit" id="kt_profile_aside">

            <!--Begin:: Portlet-->
            <div class="kt-portlet">
                <div class="kt-portlet__body">
                    <div class="kt-widget kt-widget--general-1">
                        <div class="kt-media kt-media--brand kt-media--md kt-media--circle">
                            @isset($user->gravatar)<img src="{{ $user->gravatar }}" alt="image">@endisset
                        </div>
                        <div class="kt-widget__wrapper">
                            <div class="kt-widget__label">
                                <a href="#" class="kt-widget__title">
                                    {{ $user->StrUserID }}
                                </a>
                                <span class="kt-widget__desc">
                                    {{ $user->getName() }}
                                </span>
                            </div>
                            <div class="kt-widget__toolbar kt-widget__toolbar--top-">
                                <div class="btn-group">
                                    <div class="dropdown dropdown-inline">
                                        <button type="button" class="btn btn-clean btn-sm btn-icon btn-icon-md" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="flaticon-more-1"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-fit dropdown-menu-md dropdown-menu-right">
                                            <!--begin::Nav -- DROPDOWN -->
                                            <ul class="kt-nav">
                                                <li class="kt-nav__head">
                                                    Export Options
                                                    <i class="flaticon2-information" data-toggle="kt-tooltip" data-placement="right" title="Click to learn more..."></i>
                                                </li>
                                                <li class="kt-nav__separator"></li>
                                                <li class="kt-nav__item">
                                                    <a href="#" class="kt-nav__link">
                                                        <i class="kt-nav__link-icon flaticon2-drop"></i>
                                                        <span class="kt-nav__link-text">Users</span>
                                                    </a>
                                                </li>
                                                <li class="kt-nav__item">
                                                    <a href="#" class="kt-nav__link">
                                                        <i class="kt-nav__link-icon flaticon2-calendar-8"></i>
                                                        <span class="kt-nav__link-text">Reports</span>
                                                        <span class="kt-nav__link-badge">
                                                            <span class="kt-badge kt-badge--danger">9</span>
                                                        </span>
                                                    </a>
                                                </li>
                                                <li class="kt-nav__separator"></li>
                                                <li class="kt-nav__foot">
                                                    <a class="btn btn-label-brand btn-bold btn-sm" href="#">Proceed</a>
                                                    <a class="btn btn-clean btn-bold btn-sm" href="#" data-toggle="kt-tooltip" data-placement="right" title="Click to learn more...">Learn more</a>
                                                </li>
                                            </ul>

                                            <!--end::Nav-->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="kt-portlet__separator"></div>
                <div class="kt-portlet__body">
                    <ul class="kt-nav kt-nav--bolder kt-nav--fit-ver kt-nav--v4" role="tablist">
                        <li class="kt-nav__item  ">
                            <a class="kt-nav__link active" href="?page=custom/profile/personal-information" role="tab">
                                <span class="kt-nav__link-icon"><i class="flaticon2-user"></i></span>
                                <span class="kt-nav__link-text">Personal Information</span>
                            </a>
                        </li>
                        <li class="kt-nav__item  ">
                            <a class="kt-nav__link" href="?page=custom/profile/account-settings" role="tab">
                                <span class="kt-nav__link-icon"><i class="flaticon-feed"></i></span>
                                <span class="kt-nav__link-text">Account Settings</span>
                            </a>
                        </li>
                        <li class="kt-nav__item  ">
                            <a class="kt-nav__link" href="?page=custom/profile/change-password" role="tab">
                                <span class="kt-nav__link-icon"><i class="flaticon2-settings"></i></span>
                                <span class="kt-nav__link-text">Change Password</span>
                            </a>
                        </li>
                        <li class="kt-nav__item  ">
                            <a class="kt-nav__link" href="?page=custom/profile/user-settings" role="tab">
                                <span class="kt-nav__link-icon"><i class="flaticon2-chart2"></i></span>
                                <span class="kt-nav__link-text">User Settings</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="kt-portlet__separator"></div>
                <div class="kt-portlet__body">
                    <ul class="kt-nav kt-nav--bolder kt-nav--fit-ver kt-nav--v4" role="tablist">
                        <li class="kt-nav__item">
                            <a class="kt-nav__link" href="#" role="tab" data-toggle="kt-tooltip" data-placement="right" title="This feature is coming soon!">
                                <span class="kt-nav__link-icon"><i class="flaticon2-chart2"></i></span>
                                <span class="kt-nav__link-text">Email Settings</span>
                            </a>
                        </li>
                        <li class="kt-nav__item">
                            <a class="kt-nav__link" href="#" role="tab" data-toggle="kt-tooltip" data-placement="right" title="This feature is coming soon!">
                                <span class="kt-nav__link-icon"><i class="flaticon-safe-shield-protection"></i></span>
                                <span class="kt-nav__link-text">Saved Credit Cards</span>
                            </a>
                        </li>
                        <li class="kt-nav__item">
                            <a class="kt-nav__link" href="#" role="tab" data-toggle="kt-tooltip" data-placement="right" title="This feature is coming soon!">
                                <span class="kt-nav__link-icon"><i class="flaticon-download-1"></i></span>
                                <span class="kt-nav__link-text">Social Networks</span>
                            </a>
                        </li>
                        <li class="kt-nav__item">
                            <a class="kt-nav__link" href="#" role="tab" data-toggle="kt-tooltip" data-placement="right" title="This feature is coming soon!">
                                <span class="kt-nav__link-icon"><i class="flaticon-security"></i></span>
                                <span class="kt-nav__link-text">Tax Information</span>
                            </a>
                        </li>
                        <li class="kt-nav__space"></li>
                        <li class="kt-nav__custom">
                            <a href="#" class="btn btn-default btn-sm btn-upper btn-bold">
                                New Group
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!--End:: Portlet-->

            <!--Begin:: Portlet-->
            <div class="kt-portlet kt-portlet--head-noborder">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title  kt-font-danger">
                            Important Update
                        </h3>
                    </div>
                    <div class="kt-portlet__head-toolbar">
                        <span class="kt-badge kt-badge--bolder kt-badge kt-badge--inline kt-badge--danger">Now</span>
                    </div>
                </div>
                <div class="kt-portlet__body kt-portlet__body--fit-top">
                    <div class="kt-section kt-section--space-sm">
                        Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.
                    </div>
                    <div class="kt-section kt-section--last">
                        <a href="#" class="btn btn-brand btn-sm btn-bold"><i class=""></i> Take Action</a>&nbsp;
                        <a href="#" class="btn btn-clean btn-sm btn-bold">Dismiss</a>
                    </div>
                </div>
            </div>

            <!--End:: Portlet-->
        </div>
        <!--End:: App Aside-->

        <!--Begin:: App Content-->
        <div class="kt-grid__item kt-grid__item--fluid kt-app__content">
            <div class="row">
                <div class="col-lg-12 col-xl-6  order-lg-1 order-xl-1">
                    <!--begin::Portlet-->
                    <div class="kt-portlet kt-portlet--height-fluid">
                        <div class="kt-portlet__head">
                            <div class="kt-portlet__head-label">
                                <h3 class="kt-portlet__head-title">Son Siparişler</h3>
                            </div>
                            <div class="kt-portlet__head-toolbar">
                                <div class="kt-portlet__head-actions">
                                    <a href="#" class="btn btn-default btn-sm btn-bold btn-upper">CSV</a>
                                </div>
                            </div>
                        </div>
                        <div class="kt-portlet__body">
                            <div class="kt-portlet__body kt-portlet__body--fit">
                                <!--Doc: For the datatable initialization refer to "recentOrdersInit" function in "src\theme\app\scripts\custom\dashboard.js" -->
                                <div class="kt-datatable" id="kt_recent_orders"></div>
                            </div>
                        </div>
                    </div>
                    <!--end::Portlet-->
                </div>
                <div class="col-lg-12 col-xl-6 order-lg-2 order-xl-1">
                    <!--begin::Portlet-->
                    <div class="kt-portlet kt-portlet--height-fluid">
                        <div class="kt-portlet__head">
                            <div class="kt-portlet__head-label">
                                <h3 class="kt-portlet__head-title">Sales Statistics</h3>
                            </div>
                            <div class="kt-portlet__head-toolbar">
                                <div class="kt-portlet__head-wrapper">
                                    <div class="dropdown dropdown-inline">
                                        <button type="button" class="btn btn-label-brand btn-sm btn-bold dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Export
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <ul class="kt-nav">
                                                <li class="kt-nav__section kt-nav__section--first">
                                                    <span class="kt-nav__section-text">Export Tools</span>
                                                </li>
                                                <li class="kt-nav__item">
                                                    <a href="#" class="kt-nav__link">
                                                        <i class="kt-nav__link-icon la la-print"></i>
                                                        <span class="kt-nav__link-text">Print</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="kt-portlet__body kt-portlet__body--fluid">
                            <div class="kt-widget-9">
                                <div class="kt-widget-9__panel">
                                    <div class="kt-widget-9__legends">
                                        <div class="kt-widget-9__legend">
                                            <div class="kt-widget-9__legend-bullet kt-bg-brand"></div>
                                            <div class="kt-widget-9__legend-label">Author</div>
                                        </div>
                                        <div class="kt-widget-9__legend">
                                            <div class="kt-widget-9__legend-bullet kt-label-bg-color-1"></div>
                                            <div class="kt-widget-9__legend-label">Customer</div>
                                        </div>
                                    </div>
                                    <div class="kt-widget-9__toolbar">
                                        <div class="dropdown dropdown-inline">
                                            <button type="button" class="btn btn-default dropdown-toggle btn-font-sm btn-bold btn-upper" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                August
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <ul class="kt-nav">
                                                    <li class="kt-nav__section kt-nav__section--first">
                                                        <span class="kt-nav__section-text">Export Tools</span>
                                                    </li>
                                                    <li class="kt-nav__item">
                                                        <a href="#" class="kt-nav__link">
                                                            <i class="kt-nav__link-icon la la-print"></i>
                                                            <span class="kt-nav__link-text">Print</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="kt-widget-9__chart">

                                    <!--Doc: For the chart initialization refer to "widgetSalesStatisticsChart" function in "src\theme\app\scripts\custom\dashboard.js" -->
                                    <canvas id="kt_chart_sales_statistics" height="300"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--end::Portlet-->
                </div>
                <div class="col-lg-12 col-xl-4  order-lg-1 order-xl-1">

                    <!--begin::Portlet-->
                    <div class="kt-portlet kt-portlet--height-fluid">
                        <div class="kt-portlet__head">
                            <div class="kt-portlet__head-label">
                                <h3 class="kt-portlet__head-title">Top Products</h3>
                            </div>
                            <div class="kt-portlet__head-toolbar">
                                <div class="kt-portlet__head-toolbar-wrapper">
                                    <div class="dropdown dropdown-inline">
                                        <button type="button" class="btn btn-clean btn-sm btn-icon btn-icon-md" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="flaticon-more-1"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <ul class="kt-nav">
                                                <li class="kt-nav__section kt-nav__section--first">
                                                    <span class="kt-nav__section-text">Export Tools</span>
                                                </li>
                                                <li class="kt-nav__item">
                                                    <a href="#" class="kt-nav__link">
                                                        <i class="kt-nav__link-icon la la-print"></i>
                                                        <span class="kt-nav__link-text">Print</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="kt-portlet__body">
                            <div class="kt-widget-1">
                                <ul class="nav nav-pills nav-tabs-btn nav-pills-btn-brand" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="tab" href="#kt_tabs_19_15e310a3227b2b" role="tab">
                                            <span class="nav-link-icon"><i class="flaticon2-graphic"></i></span>
                                            <span class="nav-link-title">Settings</span>
                                        </a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane fade active show" id="kt_tabs_19_15e310a3227b2b" role="tabpanel">
                                        <div class="kt-widget-1__item">
                                            <div class="kt-widget-1__item-info">
                                                <a href="#" class="kt-widget-1__item-title">
                                                    HTML 5 Templates
                                                </a>
                                                <div class="kt-widget-1__item-desc">Font-end,Admin & Email</div>
                                            </div>
                                            <div class="kt-widget-1__item-stats">
                                                <div class="kt-widget-1__item-value">+79%</div>
                                                <div class="kt-widget-1__item-progress">
                                                    <div class="progress">
                                                        <div class="progress-bar bg-danger" role="progressbar" style="width: 79%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="kt-widget-1__item">
                                            <div class="kt-widget-1__item-info">
                                                <a href="#" class="kt-widget-1__item-title">
                                                    Wordpress Themes
                                                </a>
                                                <div class="kt-widget-1__item-desc">eCommerce Website, Plugin</div>
                                            </div>
                                            <div class="kt-widget-1__item-stats">
                                                <div class="kt-widget-1__item-value">+21%</div>
                                                <div class="kt-widget-1__item-progress">
                                                    <div class="progress">
                                                        <div class="progress-bar bg-brand" role="progressbar" style="width: 60%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="kt-widget-1__item">
                                            <div class="kt-widget-1__item-info">
                                                <a href="#" class="kt-widget-1__item-title">eCommerce Websites</a>
                                                <div class="kt-widget-1__item-desc">Shops, Fasion wep sites & atc</div>
                                            </div>
                                            <div class="kt-widget-1__item-stats">
                                                <div class="kt-widget-1__item-value">-16%</div>
                                                <div class="kt-widget-1__item-progress">
                                                    <div class="progress">
                                                        <div class="progress-bar  bg-success" role="progressbar" style="width: 80%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="kt-widget-1__item">
                                            <div class="kt-widget-1__item-info">
                                                <a href="#" class="kt-widget-1__item-title">UI/UX Design</a>
                                                <div class="kt-widget-1__item-desc">Evrything you ever imagine</div>
                                            </div>
                                            <div class="kt-widget-1__item-stats">
                                                <div class="kt-widget-1__item-value">+4%</div>
                                                <div class="kt-widget-1__item-progress">
                                                    <div class="progress">
                                                        <div class="progress-bar bg-focus" role="progressbar" style="width: 90%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="kt-widget-1__item">
                                            <div class="kt-widget-1__item-info">
                                                <a href="#" class="kt-widget-1__item-title">Freebie Themes</a>
                                                <div class="kt-widget-1__item-desc">Font-end & Admin</div>
                                            </div>
                                            <div class="kt-widget-1__item-stats">
                                                <div class="kt-widget-1__item-value">+34</div>
                                                <div class="kt-widget-1__item-progress">
                                                    <div class="progress">
                                                        <div class="progress-bar bg-warning" role="progressbar" style="width: 40%;" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--end::Portlet-->
                </div>
                <div class="col-lg-12 col-xl-4  order-lg-1 order-xl-1">

                    <!--begin::Portlet-->
                    <div class="kt-portlet kt-portlet--tabs kt-portlet--height-fluid">
                        <div class="kt-portlet__head">
                            <div class="kt-portlet__head-label">
                                <h3 class="kt-portlet__head-title">
                                    Work Progress
                                </h3>
                            </div>
                            <div class="kt-portlet__head-toolbar">
                                <ul class="nav nav-tabs nav-tabs-line nav-tabs-line-brand nav-tabs-bold" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active show" data-toggle="tab" href="#kt_portlet_tabs_1111_1_content" role="tab" aria-selected="false">
                                            Emails
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="kt-portlet__body">
                            <div class="tab-content">
                                <div class="tab-pane fade active show" id="kt_portlet_tabs_1111_1_content" role="tabpanel">
                                    <div class="kt-widget-11">
                                        <div class="kt-widget-11__item">
                                            <div class="kt-widget-11__wrapper">
                                                <div class="kt-widget-11__title">
                                                    Pendings Tasks
                                                </div>
                                                <div class="kt-widget-11__value">
                                                    78%
                                                </div>
                                            </div>
                                            <div class="kt-widget-11__progress">
                                                <div class="progress">

                                                    <!-- Doc: A bootstrap progress bar can be used to show a user how far along it's in a process, see https://getbootstrap.com/docs/4.1/components/progress/ -->
                                                    <div class="progress-bar bg-success" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="kt-widget-11__item">
                                            <div class="kt-widget-11__wrapper">
                                                <div class="kt-widget-11__title">
                                                    Completed Tasks
                                                </div>
                                                <div class="kt-widget-11__value">
                                                    320&nbsp;/&nbsp;<span class="kt-opacity-5">780</span>
                                                </div>
                                            </div>
                                            <div class="kt-widget-11__progress">
                                                <div class="progress">

                                                    <!-- Doc: A bootstrap progress bar can be used to show a user how far along it's in a process, see https://getbootstrap.com/docs/4.1/components/progress/ -->
                                                    <div class="progress-bar bg-primary" role="progressbar" style="width: 55%" aria-valuenow="55" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="kt-widget-11__item">
                                            <div class="kt-widget-11__wrapper">
                                                <div class="kt-widget-11__title">
                                                    Tasks In Progress
                                                </div>
                                                <div class="kt-widget-11__value">
                                                    45%
                                                </div>
                                            </div>
                                            <div class="kt-widget-11__progress">
                                                <div class="progress">

                                                    <!-- Doc: A bootstrap progress bar can be used to show a user how far along it's in a process, see https://getbootstrap.com/docs/4.1/components/progress/ -->
                                                    <div class="progress-bar bg-danger" role="progressbar" style="width: 80%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="kt-widget-11__item">
                                            <div class="kt-widget-11__wrapper">
                                                <div class="kt-widget-11__title">
                                                    All Tasks
                                                </div>
                                                <div class="kt-widget-11__value">
                                                    1200
                                                </div>
                                            </div>
                                            <div class="kt-widget-11__progress">
                                                <div class="progress">

                                                    <!-- Doc: A bootstrap progress bar can be used to show a user how far along it's in a process, see https://getbootstrap.com/docs/4.1/components/progress/ -->
                                                    <div class="progress-bar bg-warning" role="progressbar" style="width: 60%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="kt-widget-11__item">
                                            <div class="kt-widget-11__wrapper">
                                                <div class="kt-widget-11__title">
                                                    Reports
                                                </div>
                                                <div class="kt-widget-11__value">
                                                    40
                                                </div>
                                            </div>
                                            <div class="kt-widget-11__progress">
                                                <div class="progress">

                                                    <!-- Doc: A bootstrap progress bar can be used to show a user how far along it's in a process, see https://getbootstrap.com/docs/4.1/components/progress/ -->
                                                    <div class="progress-bar bg-primary" role="progressbar" style="width: 40%" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="kt-margin-t-30 kt-align-center">
                                        <a href="#" class="btn btn-brand btn-upper btn-bold kt-align-center">Full Report</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--end::Portlet-->
                </div>
                <div class="col-lg-12 col-xl-4  order-lg-1 order-xl-1">

                    <!--begin::Portlet-->
                    <div class="kt-portlet kt-portlet--height-fluid kt-portlet--tabs">
                        <div class="kt-portlet__head">
                            <div class="kt-portlet__head-label">
                                <h3 class="kt-portlet__head-title">
                                    Latest Tasks
                                </h3>
                            </div>
                            <div class="kt-portlet__head-toolbar">
                                <ul class="nav nav-tabs nav-tabs-line nav-tabs-line-brand nav-tabs-bold" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active show" data-toggle="tab" href="#kt_portlet_tabs_1_1_content" role="tab" aria-selected="false">
                                            Today
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="kt-portlet__body">
                            <div class="tab-content">
                                <div class="tab-pane fade active show" id="kt_portlet_tabs_1_1_content" role="tabpanel">
                                    <div class="kt-widget-5">
                                        <div class="kt-widget-5__item kt-widget-5__item--info">
                                            <div class="kt-widget-5__item-info">
                                                <a href="#" class="kt-widget-5__item-title">
                                                    Management meeting
                                                </a>
                                                <div class="kt-widget-5__item-datetime">
                                                    09:30 AM
                                                </div>
                                            </div>
                                            <div class="kt-widget-5__item-check">
                                                <label class="kt-radio">
                                                    <input type="radio" checked="checked" name="radio1">
                                                    <span></span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="kt-widget-5__item kt-widget-5__item--danger">
                                            <div class="kt-widget-5__item-info">
                                                <a href="#" class="kt-widget-5__item-title">
                                                    Replace datatables rows color
                                                </a>
                                                <div class="kt-widget-5__item-datetime">
                                                    12:00 AM
                                                </div>
                                            </div>
                                            <div class="kt-widget-5__item-check">
                                                <label class="kt-radio">
                                                    <input type="radio" checked="checked" name="radio1">
                                                    <span></span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="kt-widget-5__item kt-widget-5__item--brand">
                                            <div class="kt-widget-5__item-info">
                                                <a href="#" class="kt-widget-5__item-title">
                                                    Export Navitare booking table
                                                </a>
                                                <div class="kt-widget-5__item-datetime">
                                                    01:20 PM
                                                </div>
                                            </div>
                                            <div class="kt-widget-5__item-check">
                                                <label class="kt-radio">
                                                    <input type="radio" checked="checked" name="radio1">
                                                    <span></span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="kt-widget-5__item kt-widget-5__item--success">
                                            <div class="kt-widget-5__item-info">
                                                <a href="#" class="kt-widget-5__item-title">
                                                    NYCS internal discussion
                                                </a>
                                                <div class="kt-widget-5__item-datetime">
                                                    03: 00 PM
                                                </div>
                                            </div>
                                            <div class="kt-widget-5__item-check">
                                                <label class="kt-radio">
                                                    <input type="radio" checked="checked" name="radio1">
                                                    <span></span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="kt-widget-5__item kt-widget-5__item--danger">
                                            <div class="kt-widget-5__item-info">
                                                <a href="#" class="kt-widget-5__item-title">
                                                    Project Launch
                                                </a>
                                                <div class="kt-widget-5__item-datetime">
                                                    11: 00 AM
                                                </div>
                                            </div>
                                            <div class="kt-widget-5__item-check">
                                                <label class="kt-radio">
                                                    <input type="radio" checked="checked" name="radio1">
                                                    <span></span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="kt-widget-5__item kt-widget-5__item--success">
                                            <div class="kt-widget-5__item-info">
                                                <a href="#" class="kt-widget-5__item-title">
                                                    Server maintenance
                                                </a>
                                                <div class="kt-widget-5__item-datetime">
                                                    4: 30 PM
                                                </div>
                                            </div>
                                            <div class="kt-widget-5__item-check">
                                                <label class="kt-radio">
                                                    <input type="radio" checked="checked" name="radio1">
                                                    <span></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--end::Portlet-->
                </div>
            </div>
        </div>

        <!--End:: App Content-->

    </div>
</div>
@endsection

@section('js')
<script src="{{ asset('vendor/vue/vue.js') }}"></script>
@endsection
