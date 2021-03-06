@extends("templates.master")

@section("styles")
<link rel="stylesheet" href="{{ asset('js/fancybox/jquery.fancybox-1.3.4.css') }}">
<link rel="stylesheet" href="{{ asset('css/produto.css') }}">
@endsection

@section("title")
{{ $produto->titulo }}
@stop

@section("content")
<section class="container pr">
    <!-- breadcrumb -->
    <ul class="breadcrumb">
        <li><a href="{{ route('produtos.index', [$categoria->nome]) }}">{{ $categoria->nome }}</a></li>
        <li>{{ $produto->titulo }}</li>
    </ul>

    <div class="pr-header">
        <div class="pr-img">
            <a href="{{ asset('imgs/products/'. $produto->images[0]->nome) }}" class="fancybox-gallery" rel="group1">    
                <img src="{{ asset('imgs/products/'. $produto->images[0]->nome) }}">
            </a>
        </div>
        <div class="pr-title">
            <h1 class="title">{{ $produto->titulo }} <small class="cod">cod.: {{ $produto->codigo }}</small></h1>
        </div>
    </div>

    @if ($produto->images->count() > 1)
    <ul class="pr-thumbnail">
        @foreach ($produto->images as $image)
        <li>
            <a href="{{ asset('imgs/products/'. $image->nome) }}" class="fancybox-gallery" rel="group1">
                <img src="{{ asset('imgs/products/'. $image->nome) }}">
            </a>
        </li>
        @endforeach
    </ul>
    @endif

    <div class="pr-description">
        <h3 class="title"><span>Descrição</span></h3>
        <div class="description">
            {!! $produto->descricao or 'Sem descrição' !!}
        </div>
    </div>

    <div class="pr-rel">
        <h4 class="header-rel">Relacionados</h4>
        <div class="shadow-right">
            <div class="roller">
                <ul class="l">
                    @foreach ($relacionados as $r)
                    <li>
                        <a href="{{ route('produtos.show', ['slug' => $r->slug]) }}" title="{{ $r->titulo }}">
                            <div class="pr-r-img">
                                <figure>
                                    <img src="{{ asset('imgs/products/'. $r->images[0]->nome) }}" alt="{{ $r->titulo }}">
                                </figure>
                                <p class="title">{{ $r->titulo }}</p>
                            </div>
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

</section>
@endsection

@section("scripts")
<script src="{{ asset('js/fancybox/jquery-1.4.3.min.js') }}"></script>
<script src="{{ asset('js/fancybox/jquery.fancybox-1.3.4.pack.js') }}"></script>
<script src="{{ asset('js/produto.js') }}"></script>
@stop