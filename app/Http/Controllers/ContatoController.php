<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\ContatoShipped;
use Illuminate\Support\Facades\Mail;

class ContatoController extends Controller
{
    public function index ()
    {
        return view("contato");
    }

    public function send (Request $request)
    {
        Mail::to(config('mail.from.address'))
        ->send(new ContatoShipped(
            (object) $request->only([
                'name',
                'phone',
                'email',
                'comment'
            ])
        ));

        return back()->with('send-ok', true);
    }
}
