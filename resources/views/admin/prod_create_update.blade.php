@extends("templates.admin")

@section("content")

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
            <input name="codigo" id="titulo" class="form-control" value="{{ $produto->codigo or old('codigo', '') }}">
        </div>
        <div class="form-group">
            <label for="titulo">titulo</label>
            <input name="titulo" id="titulo" class="form-control" value="{{ $produto->titulo or old('titulo', '') }}">
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
                <input name="cor" id="cor" class="form-control" value="{{ $produto->cor or old('cor', '') }}">
            </div>
            <div class="form-group">
                <label for="ano">ano</label>
                <input name="ano" id="ano" class="form-control" maxlength="4" value="{{ $produto->ano or old('ano', '') }}">
            </div>
        </div>
        <div class="form-group">
            @php
                // tratamento descrição
                $descricao = isset($produto)? $produto->descricao : old('descricao', '');
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
                <div class="ctn-img-pri"></div>
                <ul class="ctn-mini list-unstyled"></ul>
            @endif
            <div class="up-img" title="Inserir imagem">
                <input type="file" name="img[]">
            </div>
        </div>
    </div>
    
    <div class="f-btns">
        <input type="submit" class="btn btn-primary" value="<?=!empty($produto)?'Editar':'Criar'?>">
        <a href="{{ route('dashboard') }}" class="btn btn-default" id="voltar">Voltar</a>
    </div>
    
</form>

<script>
// reatribui a ultima URL acessada gravada em localStorage.btnVoltar
localStorage.btnVoltar && 
(document.querySelector('#voltar').href = localStorage.btnVoltar);

document.forms.fc.addEventListener('submit', function(event) {

    let ctnImg = document.querySelector('.f-images .ctn-img-pri');

    if (!ctnImg.childElementCount)
    {
        event.preventDefault();
        alert('É necessário inserir pelo menos 1 imagem');
        return;
    }

    spinner();
    let descricao = this.elements.descricao;
    descricao.value = descricao.value
    .replace(/</g, '&lt;')
    .replace(/>/g, '&gt;')
    .replace(/$/mg, '<br>');
});

document
.querySelector('.f-images')
.addEventListener('click', function(e) {
    
    if (e.target.classList.contains('up-img'))
    {
        let input_file = e.target.lastElementChild;
        input_file.addEventListener('change', function(e) {
            e.stopImmediatePropagation();
            readAndPreview(this.files.item(0));
        }, false);

        input_file.click();
    }

}, false);

function readAndPreview(file) {
    if (file)
    {
        let reader = new FileReader();
        reader.addEventListener('load', function(e) {
            let ctnImg = document.querySelector('.f-images .ctn-img-pri');
            let img = new Image();
            img.src = this.result;
            if (!ctnImg.childElementCount) ctnImg.appendChild(img);
            else
            {
                let li = document.createElement('li');
                li.appendChild(img);
                document.querySelector('.f-images .ctn-mini').appendChild(li);
            }

            geraFileImgUpload();

        }, false);

        reader.readAsDataURL(file);
    }
}


function geraFileImgUpload() {

    let ctn = document.querySelector('.f-images .up-img');
    let input = document.createElement('input');
    input.type = 'file';
    input.name = 'img[]';
    ctn.appendChild(input);
}

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