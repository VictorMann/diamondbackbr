<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LojaController extends Controller
{
    public function revendedor ()
    {
        return view('revendedor');
    }
}
