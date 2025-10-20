<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropostaItemTable extends Migration
{

    public function up()
    {
        Schema::create('proposta_item', function (Blueprint $table) {
            $table->id();
            $table->integer('proposta_id')->index();
            $table->integer('status_item_id')->default('1');
            $table->string('lote',50)->nullable();
            $table->string('lote_descricao',100)->nullable();
            $table->integer('item')->nullable();
            $table->string('cod_produto',50)->nullable();
            $table->string('produto',9000)->nullable();
            $table->longText('descricao')->nullable();
            $table->string('marca',255)->nullable();
            $table->string('modelo',255)->nullable();
            $table->double('qtd')->nullable();
            $table->string('und',50)->nullable();
            $table->double('unt_edital')->nullable();
            $table->double('total_edital')->nullable();

            $table->double('unt_custo')->nullable();
            $table->double('total_custo')->nullable();
            $table->double('frete_custo')->nullable();
            $table->double('impostos_credito')->nullable();

            $table->double('impostos_venda')->nullable();
            $table->double('ir_csll')->nullable();
            $table->double('difal')->nullable();
            $table->double('frete')->nullable();
            $table->double('bonus')->nullable();
            $table->double('despesa_fixa')->nullable();
            $table->double('comissao')->nullable();
            $table->double('margem')->nullable();

            $table->double('unt_minimo')->nullable();
            $table->double('total_minimo')->nullable();

            $table->double('unt_venda')->nullable();
            $table->double('total_venda')->nullable();



            $table->string('obs',9000)->nullable();


            $table->timestamps();
            $table->softDeletes();
        });
    }


    public function down()
    {
        Schema::dropIfExists('proposta_item');
    }
}
