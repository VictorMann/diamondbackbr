@extends('templates.admin')

@section('style')
    <style rel="stylesheet">
    .br {
        border: 1px dashed salmon;
    }
    .sel {
        min-height: 300px;
        max-width: 620px;
    }
    .sel > * {
        flex: 1;

    }
    .sel > :first-child {
        flex: 3;
        margin-right: 1em;
    }
    .s-item {
        position: relative;
        height: 100px;
        margin-bottom: 1em;
        background: #EEE no-repeat center;
        background-size: cover;
    }
    .order {
        display: none;
    }
    .up-img {
        width: auto;
        background-size: 30%;
        margin-bottom: 1em;
    }
    .up-img:hover {
        background-size: 32%;
    }
    .close {
        background: white;
        padding: 0 1em;
    }

    </style>
@stop


@section('content')

    @if (session('action'))
        <div class="{{ session('class') }}">
            {{ session('msg') }}
        </div>
    @endif

    <form method="POST" name="fcar" enctype="multipart/form-data">
        
        {{ csrf_field() }}
        <input type="hidden" id="del-img" name="del">

        <div class="sel flx">

            <div class="s1">
                @forelse ($carrossels as $i => $c)
                    <div class="s-item" data-id="{{ $c->id }}" data-mini="{{ $c->mini }}" style="background-image: url(/imgs/carrossel/{{ $c->nome }})">
                        <span class="n-order">{{ $i+1 }}</span>
                        <span class="close">&times;</span>
                        <input type="hidden" name="order[]" value='{"id":{{ $c->id }},"p":{{ $i+1 }}}'>
                    </div>
                @empty
                    vazio
                @endforelse
            </div>

            <div class="s2">
                <div class="up-img" title="Inserir imagem">
                    <input type="file" name="img[]" class="add">
                </div>

                <button id="btn-salvar" type="submit" class="btn btn-block btn-sm btn-success disabled" disabled>Salvar</button>
                <button id="btn-cancelar" type="button" class="btn btn-block btn-sm btn-default">Cancelar</button>
            </div>
        </div>

        <p><i>* Clique e arraste as imagens para ordena-las</i></p>
    </form>
@stop

@section('script')
    <script>
    
    // menu selecionado
    $('.item-nav-carrossel').addClass('active');
    
    // sortable
    $('.s1').sortable({
        axis: 'y',
        cursor: 'ns-resize',
        update: function(event, ui) {

            let $df = $(document.createDocumentFragment());

            $('.s-item [name="order[]"]').val(function(i, valor) {
                i += 1;
                valor = JSON.parse(valor);
                if (typeof(valor) == 'object') {
                    valor.p = i;
                    valor = JSON.stringify(valor);
                }
                else valor = i;
                return valor;
            })
            .parent()
            .filter('[data-hash]')
            .each(function() {
                let hash  = this.dataset.hash;
                let input = $(upImg).find(`:file[data-hash="${hash}"]`).get();
                $df.append(input);
            });

            if ($df.children().length) $(upImg).prepend($df);
            habilitarBtnSalvar();
        }
    });

    const s1    = document.querySelector('.s1');
    const upImg = document.querySelector('.up-img');
    const del   = document.querySelector('#del-img');

    document.forms.fcar
    .addEventListener('submit', function(event) {
        
        // loading
        spinner();

        del.value = (del.value.slice(-1) == ',')
        ? del.value.slice(0, -1) 
        : del.value;
    });

    // botão cancelar
    document
    .querySelector('#btn-cancelar')
    .addEventListener('click', function(event) {
        location.reload();
    }, false);

    // adiciona imagens
    upImg
    .addEventListener('click', function(event) {
        
        let file = this.querySelector('.add');
        file.removeEventListener('change', readAndPreview, false);
        file.addEventListener('change', readAndPreview, false);
        file.click();

    }, false);

    // remove imagens
    s1
    .addEventListener('click', function(event) {
        
        if (event.target.classList.contains('close'))
        {
            let x = event.target;
            let sItem = x.parentNode;

            if (sItem.dataset.id)
            {
                del.value = del.value + `${sItem.dataset.id},`;
            }
            else if (sItem.dataset.hash)
            {
                let hash = sItem.dataset.hash;
                let input = upImg.querySelector(`[data-hash="${hash}"]`);
                upImg.removeChild(input);
            }

            sItem.parentNode.removeChild(sItem);
            habilitarBtnSalvar();
        }

    }, false);


    function readAndPreview(event) {
        
        // se foi passado algum arquivo
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
                <div class="s-item" style="background-image: url(${base64})" data-hash="${hash}">
                    <span class="n-order">${order}</span>
                    <span class="close">&times;</span>
                    <input type="hidden" name="order[]" value="${order}">
                </div>`;

                $(s1).append(el);
            })
            .then(() => {
                this.classList.remove('add');
                let input = document.createElement('input');
                input.type = 'file';
                input.name = 'img[]';
                input.className = 'add';
                upImg.append(input);
            });

            habilitarBtnSalvar();
        }
    }

    function habilitarBtnSalvar() {
        $('#btn-salvar')
        .removeClass('disabled')
        .prop('disabled', false);
    }
    </script>
@stop