<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropostaTable extends Migration
{
    public function up()
    {
        Schema::create('proposta', function (Blueprint $table) {
            $table->id();
            $table->integer('fase_id')->index()->nullable();
            $table->integer('empresa_id')->index()->nullable();
            $table->integer('cliente_id')->index()->nullable();
            $table->integer('tipo_licitacao_id')->index()->nullable();
            $table->integer('prazo')->nullable();
            $table->double('taxa_financeira')->nullable();
            $table->date('data')->nullable();
            $table->date('data_entrega_proposta')->nullable();
            $table->time('hora_entrega_proposta')->nullable();
            $table->date('data_processo')->nullable();
            $table->time('hora_processo')->nullable();
            $table->string('nr_processo',100)->nullable();
            $table->string('nr_pregao',100)->nullable();
            $table->string('portal_compras',255)->nullable();
            $table->string('id_portal_compras',255)->nullable();
            $table->string('obs',9000)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('proposta');
    }
}
