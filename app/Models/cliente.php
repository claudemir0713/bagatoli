<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class cliente extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable= [
        'id'
        , 'cliente'
        , 'cpf_cnpj'
        , 'pessoa'
        , 'IE'
        , 'contribuinte_icms'
        , 'simples_nascional'
        , 'contato'
        , 'endereco'
        , 'bairro'
        , 'cidade'
        , 'cep'
        , 'uf'
        , 'telefone'
        , 'celular'
        , 'email'
        , 'contato_estado_civil'
        , 'contato_profissao'
        , 'contato_cpf'
        , 'contato_endereco'
        , 'contato_rg'
        , 'nascionalidade'
    ];
    protected $primaryKey = 'id';
    protected $table = 'cliente';


    // public $timestamps = false;
}
