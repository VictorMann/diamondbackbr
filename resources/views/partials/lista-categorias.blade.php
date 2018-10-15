@foreach ($categorias as $categoria)
    <li>
        <a href="{{ route('produtos.index', ['categoria' => $categoria->nome]) }}">
            {{ $categoria->nome }}
        </a>
    </li>
@endforeach