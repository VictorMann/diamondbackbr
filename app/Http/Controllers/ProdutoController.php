<?php

namespace App\Http\Controllers;

use App\Categoria;
use App\Produto;
use Illuminate\Http\Request;

class ProdutoController extends Controller
{
    public function index (Categoria $categoria)
    {
        $produtos = Produto::select('titulo', 'ano', 'image', 'slug')
        ->where('categoria_id', $categoria->id)
        ->paginate(16);

        return view('lista-produtos-categoria')
        ->with([
            'produtos' => $produtos,
            'nome_categoria' => $categoria->nome
        ]);
    }

    public function show ($slug)
    {
        $produto = Produto::where('slug', $slug)->first();
        $categoria = Categoria::findOrFail($produto->categoria_id);

        return view('produto')->with([
            'produto' => $produto,
            'categoria' => $categoria
        ]);
    }
}
