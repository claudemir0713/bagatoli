<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLicitacaoTipoItemTable extends Migration
{

    public function up()
    {
        Schema::create('licitacao_tipo_item', function (Blueprint $table) {
            $table->id();
            $table->integer('tipo_id')->index();
            $table->string('descricao',255)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('licitacao_tipo_item');
    }
}
