<?php

namespace App\Http\CustomerCollection;

use Illuminate\Support\Collection;

class OrderImages extends Collection
{
    public function ordena()
    {
        return $this->sortBy(function($image) {
            return $image->order;
        })->values();
    }
}