<?php

namespace App\Http\Controllers;

use App\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index ()
    {
        $produtos = Produto::orderBy('dt_create', 'DESC')->take(6)->get();
        return view("home")->with([
            'produtos' => $produtos
        ]);
    }

    // cadastro via ajax
    public function cadastroNewsletter (Request $req)
    {
        $exist = DB::table('newsletters')->where('email', $req->input('email'))->first();
        if (!$exist) DB::table('newsletters')->insert(['email' => $req->input('email')]);
        return $exist ? 'exist' : 'add';
    }
}