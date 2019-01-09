@extends("templates.master")

@section("title")
    Contato
@endsection

@section("styles")
    <link rel="stylesheet" href="{{ asset('css/contato.css') }}">
@endsection

@section("content")
<section class="container">
    
    @if (session('send-ok'))
        <div class="alert alert-success">
            Dados enviados com sucesso!
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <div class="media">
                <div class="media-left media-middle">
                    <i class="glyphicon glyphicon-exclamation-sign"></i>
                </div>
                <div class="media-body">
                    <ul class="list-unstyled">
                        @foreach ($errors->get('error') as $err)
                        <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    <h1 class="header-page" id="contato-title">Contato</h1>
    <div class="row">
        <div class="col-md-5">
            <form class="form-contato" method="POST" action="{{ route('contatos.send') }}">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="name">Nome</label>
                    <input name="name" id="name" class="form-control" value="{{ old('name') }}" required>
                </div>
                <div class="form-group">
                    <label for="phone">telefone</label>
                    <input name="phone" id="phone" class="form-control" value="{{ old('phone') }}" required>
                </div>
                <div class="form-group">
                    <label for="email">email</label>
                    <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required>
                </div>
                <div class="form-group ctn-comment">
                    <label for="comment">Mensagem</label>
                    <textarea name="comment" id="comment" class="form-control" required>{{ old('comment') }}</textarea>
                    <div class="inf">Não é necessário alterar este campo</div>
                </div>
                <input type="submit" value="Enviar" class="btn btn-success {{old('name')?'disabled':''}}" {{old('name')?'disabled':''}}>
            </form>
        </div>
    </div>
</section>
@endsection

@section("scripts")
    @parent
    <script src="{{ asset('js/contato.js') }}"></script>
@stop