<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- API Token -->
    <meta name="api-token" content="{{ auth()->user() ? auth()->user()->api_token : ''}}">

    <title>{{ config('app.name', 'MyWeather') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        @include('layouts.partials.navbar')
        <main class="py-4 main-body">
            @yield('content')
        </main>
        @if(Auth::user() && Auth::user()->email_verified_at)
            @include('layouts.modals.location')
            @include('layouts.modals.signup')
        @endif
    </div>
</body>
</html>
