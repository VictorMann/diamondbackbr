@extends("emails.templates.master")

@section("content")
<table border=1>
    <tr>
        <td>Nome</td>
        <td>{{ $contato->name }}</td>
    </tr>
    <tr>
        <td>Telefone</td>
        <td>{{ $contato->phone }}</td>
    </tr>
    <tr>
        <td>Email</td>
        <td>{{ $contato->email }}</td>
    </tr>
</table>
<div class="comment-data">
    <h4>Comentário</h4>
    <p>
        {{ $contato->comment }}
    </p>
</div>
@stop
