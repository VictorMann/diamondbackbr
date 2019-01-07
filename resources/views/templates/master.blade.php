<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield("title", "Home") | Diamondback Brasil, distribuidor exclusivo</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Fjalla+One|Mada:400,700|Open+Sans:400,700">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap-theme.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @yield("styles")
</head>
<body>
    <header class="topo">
        <div class="container t1 clearfix">
            <a href="{{ url('/') }}" id="logo" class="pull-left">
                <img src="{{ asset('imgs/logo.png') }}" alt="Logomarca Diamondback">
            </a>
            <form id="search" action="{{ route('search.index') }}" class="pull-right">
                <input name="s" type="text" class="form-control" placeholder="o que você procura?" required>
                <button type="submit"><span class="glyphicon glyphicon-search"></span></button>
            </form>
        </div>
        <div class="ctn-nav-main">
            <nav class="container">
                <ul class="nav-main">
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li><a href="{{ route('diamondbacks.index') }}">Diamondback</a></li>
                    <li>
                        <a href="#">Produtos</a>
                        <ul class="nav-sub">
                            @include('partials.lista-categorias')
                        </ul>
                    </li>
                    <li>
                        <a href="#">Lojas</a>
                        <ul class="nav-sub">
                            <li><a href="{{ route('lojas.revendedor') }}">Seja um revendedor</a></li>
                            <li><a href="{{ route('lojas.encontre') }}">Encontre uma loja</a></li>
                        </ul>
                    </li>
                    <li><a href="{{ route('garantias.index') }}">Garantia</a></li>
                    <li><a href="{{ route('contatos.index') }}">Contato</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <div>
        @yield("content")
    </div>
    <footer class="ctn-fend">
        <div class="fend container">
            <ul class="list-unstyled">
                <li>Institucional</li>
                <li><a href="{{ route('diamondbacks.index') }}">Diamondback</a></li>
                <li><a href="{{ route('garantias.index') }}">Garantia</a></li>
                <li><a href="{{ route('contatos.index') }}">Contato</a></li>
            </ul>
            <ul class="list-unstyled">
                <li>Produtos</li>
                @include('partials.lista-categorias')
            </ul>
            <ul class="list-unstyled">
                <li>Lojas</li>
                <li><a href="{{ route('lojas.revendedor') }}">Seja um revendedor</a></li>
                <li><a href="{{ route('lojas.encontre') }}">Encontre uma loja</a></li>
            </ul>
            <form id="form-newsletter">
                <fieldset>
                    <legend>Novidades</legend>
                    <p>
                        Cadastre-se para receber novidades
                        exclusivas da <span class="news-b">Diamondback Brasil</span>
                    </p>
                    <input type="email" class="form-control" name="email" placeholder="seu email aqui" required>
                    <input type="submit" class="btn btn-primary" value="Enviar">
                </fieldset>
            </form>
        </div>
        <div class="copyright">
            <div class="container clearfix">
                <p class="pull-left">Trabalhamos exclusivamente com o seguimento B2B distribuindo nossos produtos.</p>
                <p class="pull-right">Todos os direitos reservados</p>
            </div>
        </div>
    </footer>
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    @yield("scripts")
</body>
</html>