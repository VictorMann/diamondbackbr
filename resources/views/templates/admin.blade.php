<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Área adminstrativa - Diamondback')</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Fjalla+One|Mada:400,700|Open+Sans:400,700">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap-theme.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <style rel="stylesheet">
    .ar-login {
        position: relative;
    }
    .f-pass {
        display: none;
        position: absolute;
        background: white;
        width: 150px;
        padding: 8px;
        border-radius: 5px;
        box-shadow: 1px 1px 3px rgba(0, 0, 0, .3);
        z-index: 10;
    }
    .f-pass.active {
        display: block;
    }
    </style>

    @yield('style')
    
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-xs-12 flx topo">
            <div class="ctn-nav flx">
                <ul class="list-unstyled list-inline t-upper">
                    <li class="item-nav-produto"><a href="{{ route('dashboard') }}">Produtos</a></li>
                    <li class="item-nav-carrossel"><a href="{{ route('carrossel') }}">Carrossel</a></li>
                </ul>
            </div>
            <div class="ctn-user flx">
                <p><img src="{{ asset('imgs/logo.png') }}"></p>
                <div class="ar-login">
                    <a href="{{ route('logout') }}">logout</a> | <a href="#"><i class="glyphicon glyphicon-user"></i></a>
                    
                    <form method="POST" class="f-pass">
                        {{ csrf_field() }}
                        <input type="hidden" name="_method" value="PUT">
                        <div class="form-group"><input type="password" name="pass" class="form-control" placeholder="Nova senha" required></div>
                        <div class="form-group"><input type="password" name="pass2" class="form-control" placeholder="Repetir" required></div>
                        <span class="text-danger bg-warning msg-pass"></span>
                        <button type="submit" class="btn btn-success btn-xs btn-block">Salvar</button>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12 corpo">
            @yield("content")
        </div>
    </div>
</div>
<script
  src="http://code.jquery.com/jquery-1.12.4.min.js"
  integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ="
  crossorigin="anonymous"></script>
<script
src="http://code.jquery.com/ui/1.12.1/jquery-ui.min.js"
integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU="
crossorigin="anonymous"></script>
<script src="{{ asset('js/admin.js') }}"></script>
<script>
let fpass = document.querySelector('.f-pass');
document
.querySelector('.glyphicon-user')
.addEventListener('click', function(event) {
    fpass.classList.toggle('active');
}, false);

fpass
.addEventListener('submit', function(event) {
    
    event.preventDefault();

    let pass  = this.elements.pass;
    let pass2 = this.elements.pass2;

    if (pass.value != pass2.value) {
        this.querySelector('.msg-pass').textContent = 'senhas não coincidem';
    }
    else {
        this.querySelector('.msg-pass').textContent = '';

        fetch('{{ route("alter-password") }}', {
            method: "POST",
            body: new FormData(this)
        })
        .then(res => res.ok ? res.text() : Promise.reject(res.statusText))
        .then(dados => {
            if (dados > 0) {
                this.querySelector('.msg-pass').textContent = 'Sucesso!';
                pass.value = pass2.value = '';
                setTimeout(() => {
                    this.classList.toggle('active');
                    this.querySelector('.msg-pass').textContent = '';
                }, 1000);
            }
            console.log(dados);
        })
        .catch(console.error);
    }

}, false);
</script>

@yield("script")

</body>
</html>