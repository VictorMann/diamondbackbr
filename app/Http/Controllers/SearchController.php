<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Produto;
use App\Http\Traits\ProdutoPaginateTrait;

class SearchController extends Controller
{
    use ProdutoPaginateTrait;
    
    public function index (Request $request)
    {
        $search = $request->input('s');
        $produtos = Produto::select('id', 'titulo', 'slug')
        ->where('titulo', 'like', "%{$search}%")
        ->orderBy('dt_create', 'DESC')
        ->paginate(16);

        $produtos->withPath('?s='. $search);

        // obtem dados de paginação personalizados
        $this->getDataPaginate($produtos);

        return view('lista-produtos')->with([
            'produtos' => $produtos,
            'titulo' => "Busca por: '{$search}'",
            'header' => "Resultado da busca para '{$search}'",
            'pageAtual' => $this->pageAtual,
            'pageLimit' => $this->pageLimit,
            'pageTotalIntes' => $this->pageTotalIntes
        ]);
    }
}
