<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateProdutoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('produtos', function($table)
        {            
            $table->integer('adicional')->default(0);
            
            $table->string('descricao_adicionais')->nullable();
            $table->string('adicionais')->nullable();

            $table->string('descricao_adicionais2')->nullable();
            $table->string('adicionais2')->nullable();

            $table->string('descricao_adicionais3')->nullable();
            $table->string('adicionais3')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
