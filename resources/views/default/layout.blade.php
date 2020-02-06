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

        <!-- Main CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        {!! Theme::css('css/theme.css?' . time()) !!}

        <!-- Additional CSS -->
        {!! Theme::css('vendor/fontawesome/css/fontawesome-all.min.css') !!}

        <!-- Custom CSS -->
        @yield('css')
    </head>

    <body>
        <div class="container">
            @include ('header')
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
        <!-- JS Global -->
        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

        @include('sweetalert::alert')
        @yield('js')
    </body>

</html>