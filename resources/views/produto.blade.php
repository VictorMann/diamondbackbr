@extends("templates.master")

@section("styles")
<link rel="stylesheet" href="{{ url('/') }}/css/produto.css">
@endsection

@section("title")
{{ $produto->titulo }}
@stop

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

    @if (count($images))
    <ul class="pr-thumbnail">
        <li><img src="{{ url('/') }}/imgs/products/{{ $produto->image }}"></li>
        @foreach ($images as $image)
        <li><img src="{{ url('/') }}/imgs/products/{{ $image->nome }}"></li>
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
        <ul class="l">
            @foreach ($relacionados as $r)
            <li>
                <a href="{{ url('/') }}/p/{{ $r->slug }}" title="{{ $r->titulo }}">
                    <div class="pr-r-img">
                        <figure>
                            <img src="{{ url('/') }}/imgs/products/{{ $r->image }}" alt="{{ $r->titulo }}">
                        </figure>
                        <p class="title">{{ $r->titulo }}</p>
                    </div>
                </a>
            </li>
            @endforeach
        </ul>
    </div>

</section>
@endsection

@section("scripts")
<script src="{{ url('/') }}/js/produto.js"></script>
@stop