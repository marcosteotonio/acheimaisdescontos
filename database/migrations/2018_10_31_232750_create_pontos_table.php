<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePontosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pontos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('loja_id');
            $table->decimal('valor',8,2);
            $table->decimal('pontos',8,2);
            $table->timestamps();
        });

        Schema::table('users', function($table)
        {   
            $table->decimal('valor_ponto',8,2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pontos');
    }
}
