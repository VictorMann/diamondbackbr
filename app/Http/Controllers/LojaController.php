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

    public function lojas ($estado = null)
    {
        if ($estado)
        {
            $estado = DB::table('estado')->where('abbr', $estado)->first();
            if (!$estado) return redirect()->route('lojas.encontre');

            return view('lojas-estado')->with([
                'estado' => $estado->nome
            ]);
        }

        return view('lojas');
    }

    public function listRevPerEstJson ()
    {
        return Revenda::qtdRevendasPerEstado();
    }
}
