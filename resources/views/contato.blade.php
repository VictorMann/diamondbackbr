@extends("templates.master")

@section("title")
    Contato
@endsection

@section("styles")
    <link rel="stylesheet" href="{{ url('/') }}/css/contato.css">
@endsection

@section("content")
<section class="container">
    <h1 class="header-page">Contato</h1>
    <div class="row">
        <div class="col-md-5">
            <form class="form-contato">
                <div class="form-group">
                    <label for="name">Nome</label>
                    <input name="name" id="name" class="form-control">
                </div>
                <div class="form-group">
                    <label for="phone">telefone</label>
                    <input name="phone" id="phone" class="form-control">
                </div>
                <div class="form-group">
                    <label for="email">email</label>
                    <input type="email" name="email" id="email" class="form-control">
                </div>
                <div class="form-group">
                    <label for="comment">Mensagem</label>
                    <textarea name="comment" id="comment" class="form-control"></textarea>
                </div>
                <input type="submit" value="Enviar" class="btn btn-success">
            </form>
        </div>
    </div>
</section>
@endsection