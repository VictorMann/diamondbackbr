<?php

namespace App\Http\Controllers;

use App\Categoria;
use App\Produto;
use App\Http\Traits\ProdutoPaginateTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ProdutoController extends Controller
{
    use ProdutoPaginateTrait;

    public function index (Categoria $categoria)
    {
        $produtos = $categoria
        ->produtos()
        ->select('id', 'titulo', 'slug')
        ->paginate(16);

        // obtem dados de paginação personalizados
        $this->getDataPaginate($produtos);
        
        return view('lista-produtos')->with([
            'produtos' => $produtos,
            'titulo' => ucfirst($categoria->nome),
            'header' => $categoria->nome,
            'pageAtual' => $this->pageAtual,
            'pageLimit' => $this->pageLimit,
            'pageTotalIntes' => $this->pageTotalIntes
        ]);
    }

    public function show ($slug)
    {
        try
        {
            $produto = Produto::where('slug', $slug)->first();
            $relacionados = Produto::where('categoria_id', $produto->categoria_id)
            ->where('id', '<>', $produto->id)
            ->orderBy('dt_create', 'desc')
            ->limit(4)
            ->get();

            return view('produto')->with([
                'produto' => $produto,
                'categoria' => $produto->categoria,
                'relacionados' => $relacionados,
            ]);
        }
        catch (\Exception $e)
        {
            return response()->view('errors.404', [], 404);
        }
    }
}
