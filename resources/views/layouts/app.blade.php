<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <meta name="user-id" content="{{ auth()->check() ? auth()->user()->id : 0 }}">
        <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests" />
        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">
        <link rel="stylesheet" href="/css/app.css">
        
    </head>
    <body class="font-sans antialiased">
        <div id="app">
            @if(auth()->check())
                <div>
                    <side-nav></side-nav>
                    <div class="main-content">
                        <router-view></router-view>
                        @yield('content')
                    </div>
                </div>
            @else
                <div>
                    <div class="main-content">
                        <router-view></router-view>
                        @yield('content')
                    </div>
                </div>
            @endif
        </div>

        <script src="/js/app.js"></script>
    </body>
</html>
