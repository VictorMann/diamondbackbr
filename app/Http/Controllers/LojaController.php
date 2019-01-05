<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Revenda;

class LojaController extends Controller
{
    public function revendedor ()
    {
        return view('revendedor');
    } 

    public function lojas ()
    {
        return view('lojas');
    }

    public function lojasPorEstado($estado)
    {
        $estado = DB::table('estado')->where('abbr', $estado)->first();
        if (!$estado) return redirect()->route('lojas.encontre');

        $revendas = Revenda::where('estado_id', $estado->id)->paginate(20);

        return view('lojas-estado')->with([
            'estado' => $estado->nome,
            'revendas' => $revendas
        ]);
    }

    public function listRevPerEstJson ()
    {
        return Revenda::qtdRevendasPerEstado();
    }
}
