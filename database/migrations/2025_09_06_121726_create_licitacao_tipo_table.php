<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLicitacaoTipoTable extends Migration
{

    public function up()
    {
        Schema::create('licitacao_tipo', function (Blueprint $table) {
            $table->id();
            $table->string('descricao',100)->nullable();
            $table->string('ativo',1)->default('S');
            $table->string('controla_preco_minimo',1)->default('S');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('licitacao_tipo');
    }
}
