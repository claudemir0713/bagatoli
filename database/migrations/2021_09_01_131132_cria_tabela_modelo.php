<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CriaTabelaModelo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('modelo', function(Blueprint $table){
            $table->increments('id');
            $table->string('descricao',100)->nullable();
            $table->string('tamanho',50)->nullable();
            $table->longText('modelo')->nullable();
            $table->string('tipo',255)->nullable();
            $table->string('botaoCor',255)->nullable();
            $table->string('botaoImagem',255)->nullable();
            $table->integer('ordem')->default(0);
            $table->integer('margin_left')->default(0);
            $table->integer('margin_rigth')->default(0);
            $table->integer('margin_top')->default(0);
            $table->integer('margin_bottom')->default(0);
            $table->integer('margin_header')->default(0);
            $table->integer('margin_footer')->default(0);
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('modelo');
    }
}
