<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Revenda extends Model
{
    protected $table = "revenda";
    public $timestamps = false;

    public static function qtdRevendasPerEstado ()
    {
        return DB::table('estado as e')
        ->leftJoin('revenda as r', 'e.id', '=', 'r.estado_id')
        ->selectRaw('e.abbr, e.nome, COUNT(r.id) as qtd')
        ->groupBy('e.abbr', 'e.nome')
        ->get();
    }
}
