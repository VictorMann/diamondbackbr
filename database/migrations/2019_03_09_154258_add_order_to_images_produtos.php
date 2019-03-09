<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOrderToImagesProdutos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Caso não tenha a coluna order em produto crie-a 
        if ( ! Schema::hasColumn('images_produtos', 'order') )
        {
            Schema::table('images_produtos', function (Blueprint $table) {
                $table
                ->unsignedTinyInteger('order')
                ->nullable(false)
                ->default(1);
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('images_produtos', function (Blueprint $table) {
            $table->dropColumn('order');
        });
    }
}
