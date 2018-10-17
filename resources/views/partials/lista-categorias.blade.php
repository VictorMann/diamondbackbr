@foreach ($categorias as $categoria)
    <li>
        <a href="{{ route('produtos.index', ['categoria' => $categoria->slug]) }}">
            {{ $categoria->nome }}
        </a>
    </li>
@endforeach