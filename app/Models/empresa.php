<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class empresa extends Model
{
    use HasFactory;
    protected $fillable= [
        'id'
        , 'em_cod'
        , 'fi_cod'
        , 'razao'
        , 'fantasia'
        , 'cnpj'
        , 'insc_estadual'
        , 'insc_municipal'
        , 'cep'
        , 'endereco'
        , 'bairro'
        , 'cidade'
        , 'uf'
        , 'pais'
        , 'regime_tributario'
        , 'representante_legal'
        , 'cpf'
        , 'rg'
        , 'cargo'
    ];
    protected $primaryKey = 'id';
    protected $table = 'empresa';
    // public $timestamps = false;
}
