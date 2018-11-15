<?php

namespace App\Http\Controllers;

use App\Categoria;
use App\Produto;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ProdutoController extends Controller
{
    public function index (Categoria $categoria)
    {
        $produtos = Produto::select('titulo', 'ano', 'image', 'slug')
        ->where('categoria_id', $categoria->id)
        ->paginate(16);

        return view('lista-produtos')
        ->with([
            'produtos' => $produtos,
            'titulo' => $categoria->nome
        ]);
    }

    public function show ($slug)
    {
        $produto = Produto::where('slug', $slug)->first();
        $categoria = Categoria::findOrFail($produto->categoria_id);
        $images = DB::table('images_produtos')->where('produto_id', $produto->id)->get();
        $relacionados = Produto::where('categoria_id', $produto->categoria_id)
        ->orderBy('dt_create', 'desc')
        ->take(4)
        ->get();

        return view('produto')->with([
            'produto' => $produto,
            'categoria' => $categoria,
            'images' => $images,
            'relacionados' => $relacionados
        ]);
    }
}
