<?php

namespace App\Http\Traits;

trait ProdutoPaginateTrait
{
    public function getDataPaginate($modelPaginate)
    {
        $this->pageAtual = $modelPaginate->currentPage() * $modelPaginate->perPage() - $modelPaginate->perPage() + 1;
        $this->pageLimit = $modelPaginate->hasMorePages() ? $modelPaginate->currentPage() * $modelPaginate->perPage() : $modelPaginate->total();
        $this->pageTotalIntes = $modelPaginate->total();
    }
}