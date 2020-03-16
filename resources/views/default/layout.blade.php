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
        {{-- <link rel="shortcut icon" href="{{ Theme::url('srocms/img/favicon.png') }}"> --}}

        <!-- Main CSS -->
        {!! Theme::css('css/bootstrap.css') !!}
        {!! Theme::css('css/theme.css') !!}

        <!-- Additional CSS -->
        {!! Theme::css('vendor/fontawesome/css/fontawesome-all.min.css') !!}
        {!! Theme::css('vendor/lineawesome/css/line-awesome.min.css') !!}

        <!-- Custom CSS -->
        @yield('css')
    </head>

    <body>
        <div class="container">
            @include('header')
        </div>
        <main class="container" role="main">
            <div class="row mt-5">
                <div class="@hasSection('withsidebar') col-md-8 @else col-md-12 @endif">
                    @hasSection('contenttitle')
                    <h2 class="pb-3 mb-3 border-bottom border-secondary">@yield('contenttitle')</h2>
                    @endif

                    @yield('content')
                </div>

                @hasSection ('withsidebar')
                <div class="col-md-4 mt-4 mt-md-0">
                    @foreach (\App\Http\Controllers\SidebarController::getSidebars(5) as $sidebar)
                    <div class="row">
                        <div class="col-12">
                            <div class="sidebar">
                                <div class="card mb-4 shadow-sm">
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
                @endif
            </div>

            @include('components.footer')
        </main>
        <!-- JS Global -->
        <script src="{{ asset('vendor/jquery-1.10.2.min.js') }}"></script>
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
