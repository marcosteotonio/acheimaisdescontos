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
            $table->integer('unidade')->default(0); //un
            $table->integer('tempo_entrega')->nullable(); //min
            
            $table->string('tam1')->nullable();
            $table->decimal('vlr_tam1',8,2)->nullable();

            $table->string('tam2')->nullable();
            $table->decimal('vlr_tam2',8,2)->nullable();

            $table->string('tam3')->nullable();
            $table->decimal('vlr_tam3',8,2)->nullable();

            $table->string('tam4')->nullable();
            $table->decimal('vlr_tam4',8,2)->nullable();

            $table->string('tam5')->nullable();
            $table->decimal('vlr_tam5',8,2)->nullable();
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
