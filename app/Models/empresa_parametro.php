<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class empresa_parametro extends Model
{
    use HasFactory;
    // use SoftDeletes;
    protected $fillable= [
        'id'
        ,'empresa_id'
        , 'taxa_financeira'
        , 'icms'
        , 'simples'
        , 'pis'
        , 'cofins'
        , 'ir_csll'
        , 'difal'
        , 'frete'
        , 'despesa_fixa'
        , 'comissao'
        , 'outros'
        , 'margem'

    ];
    protected $primaryKey = 'id';
    protected $table = 'empresa_parametro';
}
