@extends('templates.admin')

@section('content')
<div class="flx flx-between">
    <form method="GET" name="fbusca">
        <div class="input-group">

            <select name="" class="form-control q hide" style="height: 34px">
                @foreach ($categorias as $c)
                <option value="{{ $c->id }}">{{ $c->nome }}</option>
                @endforeach
            </select>
            
            <input class="form-control q hide" name="" placeholder="Pesquisar...">

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
        <a href="{{ route('produtos.create') }}" class="btn btn-primary urlVoltar">Novo</a>
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
                    <a class="p-edit urlVoltar" href="{{ route('produtos.edit', ['id' => $p->id]) }}"><i class="glyphicon glyphicon-pencil"></i></a>
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

@section('script')
    <script>
        $('.item-nav-produto').addClass('active');

        document.querySelectorAll('.urlVoltar').forEach(el =>
            el.addEventListener('click', () => 
                localStorage.btnVoltar = location.href
            )
        );

        /**
         * Gera objeto partir da query URl
         * @return {Object}
         */
        function getURLParaObject() {
            let q = location.search.substring(1).split('&');
            let o = {};
            
            q.forEach(d => {
                let pos = d.indexOf('=');
                if (pos == -1) return;
                let prop = d.substr(0, pos);
                let value = d.substr(pos+1);
                o[prop] = decodeURI(value);
            });

            return o;
        }
        // CASO BUSCA
        let dadosBusca = getURLParaObject();
        let formBusca = document.forms.fbusca;
        ativaCampoBusca(dadosBusca['tipo_busca']);

        if (dadosBusca['tipo_busca'])
        {
            formBusca.elements['q'].value = dadosBusca['q'];
            formBusca.elements['tipo_busca'].value = dadosBusca['tipo_busca'];
        }

        formBusca.elements.tipo_busca.addEventListener('change', function(event) {
            ativaCampoBusca(this.value);
        });

        function ativaCampoBusca(tipo = null, formBusca = document.forms.fbusca) {
            
            formBusca
            .querySelectorAll('.q')
            .forEach(q => {
                
                if (tipo == 'categoria')
                {
                    if (q.tagName == 'SELECT')
                        q.name = 'q', q.classList.remove('hide');
                    else
                        q.name = '', q.classList.add('hide');
                }
                else
                {
                    if (q.tagName == 'SELECT')
                        q.name = '', q.classList.add('hide');
                    else
                        q.name = 'q', q.classList.remove('hide');
                }
            });
        }
    </script>
    
@endsection