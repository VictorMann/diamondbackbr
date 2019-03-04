@extends("templates.admin")

@section("content")
<style rel="stylesheet">
@keyframes anima_loading {
    from {opacity: 0}
    to {opacity: 1}
}

.form-prod {
    width: 100%;
    max-width: 900px;
    flex-wrap: wrap;
}
.form-prod > * {
    flex: 1;
    /* border: 1px dotted salmon; */
    margin-right: 10px;
}
.f-dados {
    flex: 3;
}
.f-btns {
    flex: auto;
    width: 100%;
}
.form-control {
    font-size: inherit;
}
select.form-control {
    width: auto;
}
.f-cor {
    margin-right: 1em;
}
.vl-loading {
    position: fixed;
    top: 0; bottom: 0; left: 0; right: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    background: rgba(0, 0, 0, .7);
    animation: anima_loading .5s;
}
.vl-loading-content {
    height: 50px;
    width: 50px;
    background: url("/imgs/loading2.gif") no-repeat center;
    background-size: 500%;
    animation: anima_loading .3s;
    animation-delay: .3s;
    animation-fill-mode: forwards;
    opacity: 0;
}
/* images **/
.ctn-mini {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
}
.ctn-mini > * {
    display: flex;
    align-items: center;
    width: calc(50% - 3px);
    /* border: 1px dotted blue; */
    margin-top: 6px;
    background: white;
}
.ctn-mini > *:nth-child(3n+1) {
    margin-left: 0;
}
img {
    max-width: 100%;
}
</style>
<form class="flx form-prod" method="POST" action="{{ route('produtos.store') }}" name="fc" enctype="multipart/form-data">
    {{ csrf_field() }}

    @if (isset($produto))
    <input type="hidden" name="_method" value="PUT">
    <script>
        document.forms.fc.action = "{{ route('produtos.update', ['id' => $produto->id]) }}";
    </script>
    @endif

    <div class="f-dados">
        <div class="form-group">
            <label for="codigo">cod.</label>
            <input name="codigo" id="titulo" class="form-control" value="{{ $produto->codigo or '' }}">
        </div>
        <div class="form-group">
            <label for="titulo">titulo</label>
            <input name="titulo" id="titulo" class="form-control" value="{{ $produto->titulo or '' }}">
        </div>
        <div class="form-group">
            <select name="categoria_id" class="form-control">
                @foreach ($categorias as $c)
                <option value="{{ $c->id }}" <?=(!empty($produto) && $produto->categoria_id == $c->id)?'selected':''?>>{{ $c->nome }}</option>
                @endforeach
            </select>
        </div>
        <div class="flx">
            <div class="form-group f-cor">
                <label for="cor">cor</label>
                <input name="cor" id="cor" class="form-control" value="{{ $produto->cor or '' }}">
            </div>
            <div class="form-group">
                <label for="ano">ano</label>
                <input name="ano" id="ano" class="form-control" maxlength="4" value="{{ $produto->ano or '' }}">
            </div>
        </div>
        <div class="form-group">
            @php
                // tratamento descrição
                $descricao = isset($produto)? $produto->descricao : '';
                $descricao = strip_tags($descricao);
            @endphp
            <label for="descricao">descrição</label>
            <textarea name="descricao" id="descricao" class="form-control" rows="10">{{ $descricao }}</textarea>
        </div>
    </div>
    <div class="f-images">
        <div class="img-pri">
            @if (isset($produto))
                <div class="ctn-img-pri">
                    <img src="{{ asset('imgs/products/'. $produto->image) }}">
                </div>
                @if (count($produto->images))
                <ul class="ctn-mini list-unstyled">
                    @foreach ($produto->images as $i)
                        <li><img src="{{ asset('imgs/products/'. $i->nome) }}"></li>
                    @endforeach
                </ul>
                @endif
            @else
                <input type="file" name="imgs" multiple>
            @endif
        </div>
    </div>
    
    <div class="f-btns">
        <input type="submit" class="btn btn-primary" value="<?=!empty($produto)?'Editar':'Criar'?>">
        <a href="{{ route('dashboard') }}" class="btn btn-default">Voltar</a>
    </div>
    
</form>

<script>
document.forms.fc.addEventListener('submit', function(event) {
    spinner();
    let descricao = this.elements.descricao;
    descricao.value = descricao.value
    .replace(/</g, '&lt;')
    .replace(/>/g, '&gt;')
    .replace(/$/mg, '<br>');
});

const spinner = () => {

    let vlLoading = document.querySelector('.vl-loading');
    if (vlLoading) return;
    
    vlLoading = document.createElement('div');
    vlLoading.classList.add('vl-loading');
    
    vlContent = document.createElement('div');
    vlContent.classList.add('vl-loading-content');

    vlLoading.appendChild(vlContent);
    document.body.appendChild(vlLoading);
};
</script>
@stop