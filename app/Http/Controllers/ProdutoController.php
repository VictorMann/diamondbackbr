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
        ->get();

        return view('lista-produtos-categoria')->with('produtos', $produtos);
    }
}
