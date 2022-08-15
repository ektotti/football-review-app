<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>

    <!-- Scripts -->
    @if(env('APP_ENV')==='local')
    <script src="{{ asset('js/app.js') }}" defer></script>
    @else
    <script src="{{ secure_asset('js/app.js') }}" defer></script>
    @endif
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    @if(env('APP_ENV')==='local')
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @else
    <link href="{{ secure_asset('css/app.css') }}" rel="stylesheet">
    @endif
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav row justify-content-end">
                        <!-- Authentication Links -->
                        @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                        @endif
                        @else
                        <div class="row operation-menu align-items-center">
                            <div class="col-8">
                                <search-post></search-post>
                            </div>
                            <li class="nav-item col-2">
                                <a id="" class="nav-link" href="/create/prepare" role="button" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <i class="fa-solid fa-paper-plane"></i>
                                </a>
                            </li>
                            <li class="nav-item col-2">
                                <a id="" class="nav-link" href="/user/{{Auth::id()}}" role="button" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <i class="fa-solid fa-user"></i>
                                </a>
                            </li>
                        </div>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4 container">
            @yield('content')
        </main>
    </div>
</body>

</html>