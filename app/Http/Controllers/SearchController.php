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

        $produtos->withPath('?s='. $search);

        $pageAtual = $produtos->currentPage() * $produtos->perPage() - $produtos->perPage() + 1;
        $pageLimit = $produtos->hasMorePages() ? $produtos->currentPage() * $produtos->perPage() : $produtos->total();
        $pageTotalIntes = $produtos->total();

        return view('search')->with([
            'produtos' => $produtos,
            'search' => $search,
            'pageAtual' => $pageAtual,
            'pageLimit' => $pageLimit,
            'pageTotalIntes' => $pageTotalIntes
        ]);
    }
}
