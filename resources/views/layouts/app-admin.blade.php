<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') : {{ config('app.name') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @include('component.header')
</head>

<body>
    <div class="d-block d-md-none">
        @include('component.navbar-admin')
        <div class="container-fluid p-0">
            <div class="row m-0">
                <div class="col-12">
                    @yield('content')
                </div>
            </div>
            @include('component.footer')
        </div>
    </div>

    <div class="container-fluid d-none d-md-block p-0">
        <div class="admin-sidebar float-start p-0">
            @include('component.navbar-admin')
        </div>
        <div class="admin-content float-start p-0">
            <div class="row m-0">
                <div class="col-12 ps-0 text-secondary">
                    @yield('content')
                </div>
            </div>
            @include('component.footer')
        </div>
    </div>


    @include('component.script')
</body>


</html>
