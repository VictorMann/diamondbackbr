@extends("templates.master")

@section("styles")
<link rel="stylesheet" href="{{ url('/') }}/css/produto.css">
@endsection

@section("content")
<section class="container pr">
    <div class="pr-header">
        <div class="pr-img">
            <img src="{{ url('/') }}/imgs/products/{{ $produto->image }}">
        </div>
        <div class="pr-title">
            <h1 class="title">{{ $produto->titulo }} <small>{{ $categoria->nome }}</small></h1>
        </div>
    </div>

    <ul class="pr-thumbnail">
        <li></li>    
        <li></li>    
        <li></li>    
    </ul>

    <div class="pr-description">
        <h3 class="title"><span>Descrição</span></h3>
        <div class="description">
            {!! $produto->descricao !!}
        </div>
    </div>

</section>
@endsection