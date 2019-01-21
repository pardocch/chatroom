<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link href="{{asset('css/app.css')}}" rel="stylesheet" type="text/css">
        <title>Chatroom demo</title>
    </head>
    <body>
        <header>
            <div style="border: 1px solid black; height: 8vh; background: #e0e0e0;">

            </div>
        </header>
        <nav>nav</nav>
        <section>
            @yield('content')
        </section>
        <footer>footer</footer>
    </body>
</html>