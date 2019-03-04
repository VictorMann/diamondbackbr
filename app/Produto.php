<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    protected $table = 'produto';
    public $timestamps = false;

    protected $guarded = ['id'];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function images()
    {
        return $this->hasMany(ImagesProduto::class);
    }
}
