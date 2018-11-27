@extends("templates.master")

@section("title")
    Contato
@endsection

@section("styles")
    <link rel="stylesheet" href="{{ url('/') }}/css/contato.css">
@endsection

@section("content")
<section class="container">
    
    @if (session('send-ok'))
        <div class="alert alert-success">
            Dados enviados com sucesso!
        </div>
    @endif

    <h1 class="header-page">Contato</h1>
    <div class="row">
        <div class="col-md-5">
            <form class="form-contato" method="POST" action="{{ route('contatos.send') }}">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="name">Nome</label>
                    <input name="name" id="name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="phone">telefone</label>
                    <input name="phone" id="phone" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="email">email</label>
                    <input type="email" name="email" id="email" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="comment">Mensagem</label>
                    <textarea name="comment" id="comment" class="form-control" required></textarea>
                </div>
                <input type="submit" value="Enviar" class="btn btn-success">
            </form>
        </div>
    </div>
</section>
@endsection

@section("scripts")
    <script src="{{ url('/') }}/js/contato.js"></script>
@stop