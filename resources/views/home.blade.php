@extends("templates.master")

@section("styles")
<link rel="stylesheet" href="{{ url('/') }}/css/home.css">
@endsection

@section("content")
<section class="ctn-sel">
    <ul class="sel">
        <li><img src="{{ url('/') }}/imgs/carrossel/imageExample.jpg"></li>
    </ul>
</section>
<section class="ctn-cat">
    <ul class="cat">
        <li><a href="#">Bicicletas</a></li>
        <li><a href="#">Quadros</a></li>
        <li><a href="#">Components</a></li>
        <li><a href="#">Ferramentas</a></li>
    </ul>
</section>
<section class="ctn-h-p">
    @foreach ($produtos as $produto)
    <figure class="gprod">
        <div class="ctn-img">
            <a href="#">
                <img src="{{ url('/') }}/imgs/products/{{ $produto->image }}">
            </a>
        </div>
        <figcaption>
            <a href="#">
                {{ $produto->titulo }}
            </a>
        </figcaption>
    </figure>
    @endforeach
</section>
@endsection
