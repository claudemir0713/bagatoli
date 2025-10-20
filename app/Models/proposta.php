<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class proposta extends Model
{
    use HasFactory;
    protected $fillable= [
        'id'
        , 'fase_id'
        , 'empresa_id'
        , 'cliente_id'
        , 'tipo_licitacao_id'
        , 'data'
        , 'prazo'
        , 'taxa_financeira'
        , 'data_processo'
        , 'hora_processo'
        , 'data_entrega_proposta'
        , 'hora_entrega_proposta'
        , 'nr_processo'
        , 'nr_pregao'
        , 'portal_compras'
        , 'id_portal_compras'
        , 'obs'
    ];
    protected $primaryKey = 'id';
    protected $table = 'proposta';
    // public $timestamps = false;


    public function proposta_item(){
        return $this->hasMany(proposta_item::class, 'proposta_id','id');
    }
}
