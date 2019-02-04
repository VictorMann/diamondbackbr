<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Fjalla+One|Mada:400,700|Open+Sans:400,700">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap-theme.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <title>@yield('title', 'Área adminstrativa - Diamondback')</title>
</head>
<body class="container c">
    <div class="c0 flx">
        <section>
            @yield('content')
        </section>
        <aside class="m">
            <div class="m-top">
                <a href="#" class="logo">
                    <img src="{{ asset('imgs/logo.png') }}" alt="">
                </a>
                <div class="user">
                    <i class="avatar glyphicon glyphicon-user"></i>
                    <span class="user-name">Admin</span>
                </div>
            </div>
        </aside>
    </div>
</body>
</html>