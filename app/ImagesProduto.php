<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ImagesProduto extends Model
{
    public $timestamps = false;

    public function produto()
    {
        return $this->belongsTo(Produto::class);
    }
}
