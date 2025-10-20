<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class proposta_item extends Model
{
    use HasFactory;
    protected $fillable= [
        'id'
        , 'proposta_id'
        , 'status_item_id'
        , 'lote'
        , 'lote_descricao'
        , 'item'
        , 'cod_produto'
        , 'produto'
        , 'descricao'
        , 'marca'
        , 'modelo'
        , 'qtd'
        , 'und'
        , 'unt_edital'
        , 'total_edital'
        , 'unt_custo'
        , 'total_custo'
        , 'frete_custo'
        , 'impostos_credito'
        , 'impostos_venda'
        , 'ir_csll'
        , 'difal'
        , 'frete'
        , 'bonus'
        , 'despesa_fixa'
        , 'comissao'
        , 'margem'
        , 'unt_minimo'
        , 'total_minimo'
        , 'unt_venda'
        , 'total_venda'
        , 'obs'
    ];
    protected $primaryKey = 'id';
    protected $table = 'proposta_item';
    // public $timestamps = false;

}
