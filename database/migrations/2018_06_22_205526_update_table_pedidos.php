<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTablePedidos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pedidos', function($table)
        {   
            $table->decimal('frete',8,2)->default(0);
            $table->text('observacoes')->nullable();
            $table->time('horario_entrega')->nullable();
            $table->date('data_entrega')->nullable();
        });

        Schema::table('users', function($table)
        {            
            $table->decimal('frete',8,2)->nullable();
            $table->string('tempo_entrega')->nullable();
        });

        Schema::table('horarios', function($table)
        {            
            $table->integer('entrega')->default(0);
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
