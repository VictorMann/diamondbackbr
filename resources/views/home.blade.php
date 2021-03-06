@extends("templates.master")

@section("styles")
<link rel="stylesheet" href="{{ asset('css/slick.css') }}">
<link rel="stylesheet" href="{{ asset('css/home.css') }}">
@endsection

@section("content")

<section class="ctn-sel">
    @include('partials.carrossel')
</section>

<section class="ctn-cat">
    <ul class="cat">
        @include('partials.lista-categorias')
    </ul>
</section>
<section class="ctn-h-p">
    @foreach ($produtos as $produto)
    <figure class="gprod">
        <div class="ctn-img">
            <a href="{{ route('produtos.show', ['slug' => $produto->slug]) }}"> 
                <img src="{{ asset('imgs/products/'. $produto->images[0]->nome) }}">
            </a>
        </div>
        <figcaption>
            <a href="{{ route('produtos.show', ['slug' => $produto->slug]) }}">
                {{ $produto->titulo }}
            </a>
        </figcaption>
    </figure>
    @endforeach
</section>
@endsection

@section("scripts")
@parent
<script src="{{ asset('js/slick.min.js') }}"></script>
<script src="{{ asset('js/home.js') }}"></script>
@stop
