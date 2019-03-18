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
            <input name="codigo" id="codigo" class="form-control" value="{{ $produto->codigo or old('codigo', '') }}" required>
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
                    <?php $imagemPri = $produto->images->shift()?>
                    <img src="{{ asset('imgs/products/'. $imagemPri->nome) }}">
                    <span class="remover" data-i="{{ $imagemPri->id }}"></span>
                    <input class="order db" name="" value="1" maxlength="2">
                    <input type="hidden" name="order[]" value='{"id":{{ $imagemPri->id }}, "p":1}'>
                    <span class="n-order">1</span>
                </div>
                <ul class="ctn-mini list-unstyled">
                    @foreach ($produto->images as $key => $i)
                        <li>
                            <img src="{{ asset('imgs/products/'. $i->nome) }}">
                            <span class="remover" data-i="{{ $i->id }}"></span>
                            <input class="order db" name="" value="{{ $key + 2 }}" maxlength="2">
                            <input type="hidden" name="order[]" value='{"id":{{ $i->id }}, "p":{{ $key + 2 }}}'>
                            <span class="n-order">{{ $key + 2 }}</span>
                        </li>
                    @endforeach
                </ul>
            @else
                <div class="ctn-img-pri"></div>
                <ul class="ctn-mini list-unstyled"></ul>
            @endif

            <div class="up-img" title="Inserir imagem">
                <input type="file" name="img[]" class="add">
            </div>

        </div>
    </div>
    
    <div class="f-btns">
        <input type="submit" class="btn btn-primary" value="<?=!empty($produto)?'Editar':'Criar'?>">
        <a href="{{ route('dashboard') }}" class="btn btn-default" id="voltar">Voltar</a>
    </div>
    
</form>
@stop

@section('script')
    <script>
    
    // menu selecionado
    $('.item-nav-produto').addClass('active');

    // elementos base
    const upImg  = document.querySelector('.up-img');
    const ctnPri = document.querySelector('.ctn-img-pri');
    const ctnMin = document.querySelector('.ctn-mini');

    // reatribui a ultima URL acessada gravada em localStorage.btnVoltar
    localStorage.btnVoltar && 
    (document.querySelector('#voltar').href = localStorage.btnVoltar);
    
    // envio de formulário
    document.forms.fc.addEventListener('submit', function(event) {
    
        let imgs = document.querySelectorAll('.f-images img');
    
        if (!imgs.length) {
            event.preventDefault();
            alert('É necessário inserir pelo menos 1 imagem');
            return;
        }
        
        // loading
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
        
        // adicionar imagens
        if (e.target == upImg)
        {
            let file = e.target.querySelector('.add');
            file.removeEventListener('change', readAndPreview, false);
            file.addEventListener('change', readAndPreview, false);
            file.click();
        }
        // remover imagens
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
            }
    
            let parent = e.target.parentNode;
            let img = parent.querySelector('img');
    
            if (img.dataset.hash)
            {
                let input = upImg.querySelector(`[data-hash="${img.dataset.hash}"]`);
                upImg.removeChild(input);
            }
    
            if (parent.tagName == 'LI')
            {
                parent.parentNode.removeChild(parent);
            }
            else
            {
                ctnPri.textContent = '';
            }
        }
    
    }, false);
    
    // manipula ordenacao de elementos já existens
    $('.f-images').delegate('.order', 'change', function(event) {

        // order fake caso imagem do banco
        if ($(this).hasClass('db'))
        {
            let $orderReal = $(this).siblings('[name="order[]"]');
            let valueReal  = JSON.parse($orderReal.val());
            valueReal.p    = this.value;
            $orderReal.val(JSON.stringify(valueReal));
        }

        $(this).siblings('.n-order').text(this.value);
    });

    function readAndPreview(event) {

        // se foi passado alugum arquivo
        if (this.files.length)
        {
            // tipo file
            let type = this.files.item(0).type;
            // tipo invalido
            if (!tipeMimeValid.includes(type)) return;

            // gera Hash
            let hash = getHash();
            this.dataset.hash = hash;

            // retorna base64 da img
            geraBase64(this.files.item(0))
            .then(base64 => {

                let order = getMaxOrder() +1;

                let el = `
                <span class="n-order">${order}</span>
                <img src="${base64}" data-hash="${hash}">
                <span class="remover"></span>
                <input class="order" name="order[]" value="${order}" maxlength="2">`;

                if (!ctnPri.querySelector('img'))
                {
                    ctnPri.innerHTML = el;
                }
                else
                {
                    $(ctnMin).append(`<li>${el}</li>`);
                }
            })
            .then(() => {
                this.classList.remove('add');
                let input = document.createElement('input');
                input.type = 'file';
                input.name = 'img[]';
                input.className = 'add';
                upImg.append(input);
            });
        }
    }
    </script>
@stop