@extends('templates.admin')

@section('content')
<div class="flx flx-between">
    <form method="GET">
        <div class="input-group">
            <input class="form-control" name="q" placeholder="Pesquisar...">
            <div class="input-group-btn">
                <select name="tipo_busca" class="btn btn-default" style="height: 34px">
                    <option value="codigo">cod.</option>
                    <option value="titulo" selected>titulo</option>
                    <option value="categoria">categoria</option>
                    <option value="cor">cor</option>
                    <option value="ano">ano</option>
                </select>
                <button class="btn btn-default">
                    <div class="glyphicon glyphicon-search"></div>
                </button>
            </div>
        </div>
    </form>
    <div>
        <a href="{{ route('produtos.create') }}" class="btn btn-primary">Novo</a>
    </div>
</div>
<div>
    {{ $produtos->links() }}
    
    @if (session('action'))
    <div class="mensagem">
            <div class="{{ session('class') }}">
                {{ session('msg') }}
            </div>
    </div>
    @endif
    
    <table class="table table-striped" style="background:white; margin-top: 2em">
        <thead>
            <tr>
                <th>cod.</th>
                <th>titulo</th>
                <th>cat.</th>
                <th>cor</th>
                <th>ano</th>
                <th>última modif.</th>
                <th>ação</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($produtos as $p)
            <tr>
                <td>{{$p->codigo}}</td>
                <td>{{$p->titulo}}</td>
                <td>{{$p->categoria->nome}}</td>
                <td>{{$p->cor}}</td>
                <td>{{$p->ano}}</td>
                <td>{{$p->dt_modify}}</td>
                <td>
                    <a class="p-edit" href="{{ route('produtos.edit', ['id' => $p->id]) }}"><i class="glyphicon glyphicon-pencil"></i></a>
                    <a class="p-destroy" href="{{ route('produtos.destroy', ['id' => $p->id]) }}"><i class="glyphicon glyphicon-trash"></i></a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <form name="spoofing" class="hidden" method="POST">
        {{ csrf_field() }}
        <input type="hidden" name="_method" value="DELETE">
    </form>
</div>
@stop