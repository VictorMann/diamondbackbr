@extends("templates.master")

@section("styles")
<link rel="stylesheet" href="{{ asset('css/lojas-estado.css') }}">
@endsection

@section("title")
    Revendas em {{ $estado }}
@stop

@section("content")
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1 class="header-page">Revendas em {{ $estado }}<a href="{{ route('lojas.encontre') }}" class="btn btn-primary pull-right">voltar ao mapa <i class="glyphicon glyphicon-triangle-right"></i></a></h1>
        </div>
    </div>
    <div class="row">
        @foreach ($revendas as $r)
        <div class="col-md-6">
            <div class="cartao">
                <h4 class="title">{{ $r->nome }}</h4>
                <ul class="list-unstyled body">
                    <li>End: {{ $r->endereco }}</li>
                    <li>Cidade: {{ $r->cidade }}, {{ $r->cep }}</li>
                    <li>Bairro: {{ $r->bairro }}</li>
                    <li>Telefone: {{ $r->telefone }}</li>
                    <li>Email: {{ $r->email }}</li>
                    <li>Site: <a href="http://{{ $r->site }}" target="_blank">{{ $r->site }}</a></li>
                </ul>
            </div>
        </div>
        @endforeach
    </div>
    <div class="text-center">
        {{ $revendas->links() }}
    </div>
</div>
@endsection