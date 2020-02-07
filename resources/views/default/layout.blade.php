<!doctype html>
<html lang="en">

    <head>
        <!-- Title -->
        <title>{{ setting('site.title', 'SroCMS') }}@hasSection('pagetitle') ~ @yield('pagetitle')@endif</title>

        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <meta name="description" content="{{ setting('site.metadesc') }}" />
        <meta name="keywords" content="{{ setting('site.metakeys') }}" />

        <!-- Favicon -->
        <link rel="shortcut icon" href="{{ Theme::url('srocms/img/favicon.png') }}">

        <!-- Main CSS -->
        {!! Theme::css('css/bootstrap.min.css') !!}
        {!! Theme::css('css/theme.css?' . time()) !!}

        <!-- Additional CSS -->
        {!! Theme::css('vendor/fontawesome/css/fontawesome-all.min.css') !!}

        <!-- Custom CSS -->
        @yield('css')
    </head>

    <body>
        <div class="container">
            @include ('header')
        </div>
        <div class="container" role="main">
            <div class="row">
                <div class="col-md-8 mt-4">
                    @hasSection('contenttitle')
                    <h3 class="pb-3 mb-3 border-bottom">
                        @yield('contenttitle')
                    </h3>
                    @endif

                    @yield('content')
                </div>
                <div class="col-md-4 mt-4">
                    @foreach (\App\Http\Controllers\SidebarController::getSidebars(5) as $sidebar)
                    <div class="row">
                        <div class="col-12">
                            <div class="sidebar">
                                <div class="card mt-4 shadow-sm">
                                    <div class="card-header">
                                        {{ $sidebar->title }}
                                    </div>
                                    <div class="card-body overflow-auto">
                                        {!! $sidebar->getContent() !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        <!-- JS Global -->
        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

        <script type="text/javascript">
            $(function () {
                $('[data-toggle="tooltip"]').tooltip()
            })
        </script>
        @include('sweetalert::alert')
        @yield('js')
    </body>

</html>
