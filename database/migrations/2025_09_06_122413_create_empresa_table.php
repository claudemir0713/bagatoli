<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpresaTable extends Migration
{

    public function up()
    {
        Schema::create('empresa', function (Blueprint $table) {
            $table->id();
            $table->integer('em_cod')->index()->nullable();
            $table->integer('fi_cod')->index()->nullable();
            $table->string('razao',255)->nullable();
            $table->string('fantasia',255)->nullable();
            $table->string('cnpj',20)->nullable();
            $table->string('insc_estadual',20)->nullable();
            $table->string('insc_municipal',20)->nullable();
            $table->string('cep',20)->nullable();
            $table->string('endereco',255)->nullable();
            $table->string('bairro',255)->nullable();
            $table->string('cidade',255)->nullable();
            $table->string('uf',4)->nullable();
            $table->string('pais',100)->nullable();
            $table->string('regime_tributario',100)->nullable();
            $table->string('representante_legal',255)->nullable();
            $table->string('cpf',50)->nullable();
            $table->string('rg',50)->nullable();
            $table->string('cargo',255)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('empresa');
    }
}
