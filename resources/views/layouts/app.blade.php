<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <meta name="user-id" content="{{ auth()->user()->id }}">
        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">
        <link rel="stylesheet" href="/css/app.css?id=9ad05949757f14bbcde58b0704a52774">
        
    </head>
    <body class="font-sans antialiased">
        <div id="app">
            <div>
                <side-nav></side-nav>
                <div class="main-content">
                    <router-view></router-view>
                    @yield('content')
                </div>
            </div>
        </div>

        <script src="/js/app.js?id=fd79cf3440ae0c5b50f694b4dc8cf775"></script>
    </body>
</html>
