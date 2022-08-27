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
    <div id="preloader" class="d-flex align-items-center justify-content-center">
        <div class="text-center">
            <div class="spinner-border text-light f-36" role="status" style="width: 5rem; height: 5rem;">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    </div>
    @include('component.navbar')
    <main class="py-4" style="background-image: url({{ Storage::url('default-images/top-bg.png') }}); background-repeat: repeat-x;background-position: center top;">
        @yield('main-content')
    </main>
    @include('component.footer')
    @include('component.script')
</body>

</html>
