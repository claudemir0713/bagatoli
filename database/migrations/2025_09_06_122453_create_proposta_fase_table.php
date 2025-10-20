<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropostaFaseTable extends Migration
{

    public function up()
    {
        Schema::create('proposta_fase', function (Blueprint $table) {
            $table->id();
            $table->string('descricao',255)->nullable();
            $table->string('status',1)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
    public function down()
    {
        Schema::dropIfExists('proposta_fase');
    }
}
