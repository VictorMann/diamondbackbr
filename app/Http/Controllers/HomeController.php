<?php

namespace App\Http\Controllers;

use App\Produto;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index ()
    {
        $produtos = Produto::take(6)->get();
        return view("home")->with([
            'produtos' => $produtos
        ]);
    }
}
