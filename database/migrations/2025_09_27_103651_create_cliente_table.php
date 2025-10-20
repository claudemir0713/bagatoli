<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClienteTable extends Migration
{
    public function up(): void
    {
        Schema::create('cliente', function (Blueprint $table) {
            $table->id();
            $table->string('cliente',100)->nullable();
            $table->string('cpf_cnpj',50)->unique();
            $table->string('pessoa',1)->nullable();
            $table->string('IE',20)->nullable();
            $table->string('contribuinte_icms',1)->nullable();
            $table->string('simples_nascional',1)->default('N');
            $table->string('contato',100)->nullable();
            $table->string('endereco',100)->nullable();
            $table->string('bairro',100)->nullable();
            $table->string('cidade',100)->nullable();
            $table->string('cep',50)->nullable();
            $table->string('uf',2)->nullable();
            $table->string('telefone',50)->nullable();
            $table->string('celular',50)->nullable();
            $table->string('email',255)->nullable();
            $table->string('contato_estado_civil',50)->nullable();
            $table->string('contato_profissao',100)->nullable();
            $table->string('contato_cpf',14)->nullable();
            $table->string('contato_endereco',100)->nullable();
            $table->string('contato_rg',50)->nullable();
            $table->string('nascionalidade',50)->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cliente');
    }
}
