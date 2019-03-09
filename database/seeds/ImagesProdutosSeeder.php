<?php

use Illuminate\Database\Seeder;
use App\Produto;

class ImagesProdutosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // verifica se o produto tem a coluna image
        if (Produto::first()->image)
        {
            Produto::get()->each(function($p) {
                $p->images()->create([
                    'nome' => $p->image
                ]);
            });
            
            // remove coluna do banco
            DB::unprepared('ALTER TABLE produto DROP COLUMN image');
        }
    }
}
