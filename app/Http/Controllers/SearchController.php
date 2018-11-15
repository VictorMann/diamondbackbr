<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Produto;

class SearchController extends Controller
{
    public function index (Request $request)
    {
        $search = $request->input('s');
        $produtos = Produto::where('titulo', 'like', "%{$search}%")->paginate(16);


        return view('lista-produtos')->with([
            'produtos' => $produtos,
            'titulo' => $search,
        ]);
    }
}
