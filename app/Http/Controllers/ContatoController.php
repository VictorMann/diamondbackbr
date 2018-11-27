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
        try
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
        catch (\Swift_TransportException $e)
        {
            return back()
            ->withInput()
            ->withErrors(new \Illuminate\Support\MessageBag([
                'error' => [
                    'Pedimos desculpas parece que houve um erro interno com nosso servidor.',
                    'Nossa equipe já foi notificado sobre o problema.',
                    'Por favor, tente nos enviar sua mensagem mais tarde. Obrigado!'
                ]
            ]));
        }
    }
}
