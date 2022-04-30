<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- font awesome -->
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" class="rel">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.1"></script>
    <script>
      window.onload = function () {
        let context = document.querySelector("#your_weight_chart").getContext('2d')
        new Chart(context, {
          type: 'line',
          data: {
            labels: ['1月', '2月', '3月', '4月', '5月', '6月', '7月', '8月', '9月', '10月', '11月', '12月'],
            datasets: [{
              label: "体重の変化",
              data: [8.0, 9.4, 11.9, 15.4, 21.1, 23.4, 26.4, 28.0, 25.9, 20.5, 14.9, 10.3],
              borderColor: '#ff6347',
              backgroundColor: '#ff6347',
            }],

          },
          options: {
            responsive: false,
          }
        })
      }
    </script>
    

</head>
<body>
    <div id="app" class="">
        <div>
        <nav class="navbar navbar-expand-md navbar-light bg-warning bg-opacity-25 shadow-sm ">
            <div class="container py-2">
                <a class="navbar-brand fw-bold fs-3 " href="{{ url('/index') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                                  <!-- 各種リンク -->
                            <ul class="navbar-nav mx-auto mb-lg-0 ">
                                <li class="nav-item px-3">
                                    <a class="nav-link active" aria-current="page" href="{{ route('index') }}">ホーム</a>
                                </li>
                                <li class="nav-item px-3">
                                    <a class="nav-link active " aria-current="page" href="{{ route('record') }}">記録する</a>                                    
                                </li>
                                <li class="nav-item px-3">
                                    <a class="nav-link active " aria-current="page" href="{{ route('rank') }}">ランキング</a> 
                                </li>
                                <li class="nav-item px-3">
                                    <a class="nav-link active" aria-current="page" href="{{ route('search.index') }}">ユーザー検索</a>
                                </li>

                            </ul>

                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else

                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('my_page') }}">マイページ</a>
                                    <a class="dropdown-item" href="{{ route('dm') }}">メッセージ</a>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('ログアウト') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        

        <main class="">
            @yield('content')
        </main>
        <div class="text-muted py-3 bg-warning bg-opacity-25 shadow-sm">
            <div class="row w-50 mx-auto ">
                <p>@copyright</p>
            </div>
        </div>

    </div>
</body>
</html>
