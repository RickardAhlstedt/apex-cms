<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta http-equiv="x-pjax-version" content="{{ mix('/css/app.css') }}">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield( 'title' )</title>

    <!-- Scripts -->
    <script src="{{ asset( 'js/mdb.min.js' ) }}" defer></script>
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/simple-notify@0.5.4/dist/simple-notify.min.css" />

    @stack( 'styles' )

</head>
    <body id="admin">
        <!--Main Navigation-->
        <header>
            @include( 'components.nav-dash' )
            <div id="loader">
                <span class="loader-bar" style="width: 100%"></span>
            </div>
        </header>
        <!--Main Navigation-->
        <div>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-2">
                        @include( 'components.sidebar-dash' )
                    </div>
                    <div class="col-md-10" id="content">
                        @include( 'partials.notification')
                        @yield('content')
                    </div>
                </div>

        </div>

        <script src="https://kit.fontawesome.com/2f7a4e69cd.js" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-notify@0.5.4/dist/simple-notify.min.js"></script>
        @stack( 'scripts' )
    </body>
</html>
