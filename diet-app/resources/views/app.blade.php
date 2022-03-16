<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Laravel</title>

    </head>
    <body>
       
        <div id="app">
        <div class="card-body pt-0 pb-2 pl-3">
                <div class="card-text">
                <article-like>
                @yield('content')
                </article-like>
                </div>
            </div>

        </div>

    <script src="{{ mix('/js/app.js') }}"></script>
    <!-- JQuery -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>  
  
    </body>
</html>
