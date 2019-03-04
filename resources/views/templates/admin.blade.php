<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Área adminstrativa - Diamondback')</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Fjalla+One|Mada:400,700|Open+Sans:400,700">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap-theme.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-xs-12 flx topo">
            <div class="ctn-nav flx">
                <ul class="list-unstyled list-inline t-upper">
                    <li><a href="{{ route('dashboard') }}">Produtos</a></li>
                </ul>
            </div>
            <div class="ctn-user flx">
                <p><img src="{{ asset('imgs/logo.png') }}"></p>
                <div>
                    <a href="#">logout</a> | <a href="#"><i class="glyphicon glyphicon-user"></i></a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12 corpo">
            @yield("content")
        </div>
    </div>
</div>
<script src="{{ asset('js/admin.js') }}"></script>
</body>
</html>