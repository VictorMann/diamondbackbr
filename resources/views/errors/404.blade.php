@extends("templates.master")

@section("title")
    404: página não encotrada
@stop

@section("styles")
    <link rel="stylesheet" href="{{ url('/') }}/css/404.css">
@stop

@section("content")
<div class="container e404">
    <h1>404 página não encotrada :'(</h1>
    <div class="detail">
        <p>Pedimos desculpas. A página que você buscou não pode ser encontrada.</p>
        <div>
            <p>O que pode ter acontecido:</p>
            <ul>
                <li>O conteúdo não está mais no ar</li>
                <li>Você digitou o endereço errado.</li>
            </ul>
        </div>
    </div>
</div>
@stop