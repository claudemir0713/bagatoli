<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpresaParametro extends Migration
{
    public function up()
    {
        Schema::create('empresa_parametro', function (Blueprint $table) {
            $table->id();
            $table->integer('empresa_id')->index();
            $table->double('taxa_financeira')->nullable();
            $table->double('icms')->nullable();
            $table->double('simples')->nullable();
            $table->double('pis')->nullable();
            $table->double('cofins')->nullable();
            $table->double('ir_csll')->nullable();
            $table->double('difal')->nullable();
            $table->double('frete')->nullable();
            $table->double('despesa_fixa')->nullable();
            $table->double('comissao')->nullable();
            $table->double('outros')->nullable();
            $table->double('margem')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('empresa_parametro');
    }
}
