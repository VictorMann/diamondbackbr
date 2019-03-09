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
            <input name="codigo" id="titulo" class="form-control" value="{{ $produto->codigo or old('codigo', '') }}" required>
        </div>
        <div class="form-group">
            <label for="titulo">titulo</label>
            <input name="titulo" id="titulo" class="form-control" value="{{ $produto->titulo or old('titulo', '') }}" required>
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
                    <img src="{{ asset('imgs/products/'. $produto->images->shift()->nome) }}">
                    <span class="remover" data-i="#{{ $produto->id }}"></span>
                    <input class="order" name="order[]" value="1" maxlength="2">
                </div>
                @if ($produto->images->count() > 1)
                    <ul class="ctn-mini list-unstyled">
                        @foreach ($produto->images as $key => $i)
                            <li>
                                <img src="{{ asset('imgs/products/'. $i->nome) }}">
                                <span class="remover" data-i="{{ $i->id }}"></span>
                                <input class="order" name="order[]" value="{{ $key + 2 }}" maxlength="2">
                            </li>
                        @endforeach
                    </ul>
                @endif
            @else
                <div class="ctn-img-pri">
                    <span class="remover"></span>
                    <input class="order" name="order[]" value="" maxlength="2">
                </div>
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

    let imgPri = document.querySelector('.f-images .ctn-img-pri img');

    if (!imgPri)
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
    else if (e.target.classList.contains('remover'))
    {
        // imagens do banco
        if (e.target.dataset.i)
        {
            let input = document.forms.fc.elements.ri;
            if (input)
            {
                input.value += `, ${e.target.dataset.i}`;
            }
            else
            {
                input       = document.createElement('input');
                input.name  = 'ri';
                input.type  = 'hidden';
                input.value = e.target.dataset.i;

                document.forms.fc.prepend(input);
            }

            delete e.target.dataset.i;
        }

        let parent = e.target.parentNode;
        let img = parent.querySelector('img');

        if (img.dataset.hash)
        {
            let input = document
            .querySelector('.up-img')
            .querySelector(`[data-hash="${img.dataset.hash}"]`);
            input.parentNode.removeChild(input);
        }

        if (parent.tagName == 'LI')
        {
            parent.parentNode.removeChild(parent);
        }
        else
        {
            parent.removeChild( img );
        }
    }

}, false);

function readAndPreview(file) {
    if (file)
    {
        let reader = new FileReader();
        reader.addEventListener('load', function(e) {
            let ctnImg = document.querySelector('.f-images .ctn-img-pri');
            let img = new Image();
            let nOrder = 1 + [].reduce.call(
                document.querySelectorAll('.f-images .order'),
                (min, el) => Math.max(el.value, min), 
                Number.MIN_VALUE
            );
            img.src = this.result;
            // gerando hash para ref em input
            img.dataset.hash = parseInt(Math.random() * new Date().getTime());
            if ( ! ctnImg.querySelector('img') )
            {
                ctnImg.prepend(img);
                ctnImg.querySelector('.order').value = nOrder;
            }
            else
            {
                let li   = document.createElement('li');
                let span = document.createElement('span');
                span.className = 'remover';

                let order = document.createElement('input');
                order.className = 'order';
                order.name = 'order[]';
                order.value = nOrder;
                order.maxLength = 2;

                li.append(img);
                li.append(span);
                li.append(order);

                document.querySelector('.f-images .ctn-mini').append(li);
            }

            // passando hash da imagem para o input
            geraFileImgUpload(img.dataset.hash);

        }, false);

        reader.readAsDataURL(file);
    }
}


function geraFileImgUpload(hash_img) {

    let ctn = document.querySelector('.f-images .up-img');
    let input = document.createElement('input');
    input.type = 'file';
    input.name = 'img[]';
    input.dataset.hash = hash_img;
    ctn.append(input);
}

const spinner = () => {

    let vlLoading = document.querySelector('.vl-loading');
    if (vlLoading) return;
    
    vlLoading = document.createElement('div');
    vlLoading.classList.add('vl-loading');
    
    vlContent = document.createElement('div');
    vlContent.classList.add('vl-loading-content');

    vlLoading.append(vlContent);
    document.body.append(vlLoading);
};
</script>
@stop