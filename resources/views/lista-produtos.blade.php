@extends("templates.master")

@section("styles")
    <link rel="stylesheet" href="{{ url('/') }}/css/lista-produtos.css">
@stop

@section("title")
    {{ $titulo }}
@stop

@section("content")
<div class="container psearch">
    <div class="header">
        <h1 class="header-page">{{ $header }}</h1>
        @if ($pageTotalIntes)
        <div class="detail-page clearfix">
            @if ($pageTotalIntes > $produtos->perPage())
            <span>itens {{ $pageAtual }} para {{ $pageLimit }} de {{ $pageTotalIntes }} total</span>
            @else
            <span>{{ $pageTotalIntes }} item(ns)</span>
            @endif
            <div class="cnt-pagination">{{ $produtos->links() }}</div>
        </div>
        @endif
    </div>
    
    <div class="ctn-grade-img">
        @forelse ($produtos as $produto)
        <div class="ctn-product">
            <a href="{{ url('/') . '/p/' . $produto->slug }}">
                <figure class="product-img">
                    <img src="{{ url('/') }}/imgs/products/{{ $produto->image }}">
                </figure>
                <h3 class="product-name">
                    {{ $produto->titulo }}
                </h3>
            </a>
        </div>
        @empty
            <p class="msg-not-items">Não existem produtos que correspondem com a busca.</p>
        @endforelse
    </div>
    @if ($pageTotalIntes)
    <div class="detail-page bottom clearfix">
            @if ($pageTotalIntes > $produtos->perPage())
            <span>itens {{ $pageAtual }} para {{ $pageLimit }} de {{ $pageTotalIntes }} total</span>
            @else
            <span>{{ $pageTotalIntes }} item(ns)</span>
            @endif
            <div class="cnt-pagination">{{ $produtos->links() }}</div>
        </div>
    @endif
</div> 
@stop