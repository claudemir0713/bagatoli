<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class bg_item_mov_estoq extends Model
{
    use HasFactory;

    protected $fillable = [
        'EM_COD'
        ,'FI_COD'
        ,'ME_SEQ_MOV'
        ,'ITME_NUM_ITEM'
        ,'PR_COD'
        ,'ITME_QTD_MOV'
        ,'ITME_VAL_MOV'
        ,'DAT_ATUALIZACAO'
        ,'USU_ATUALIZACAO'
        ,'ITME_FLG_USANDO_BARRA'
        ,'ITME_NUM_ITEM_ORIGEM'
        ,'ITME_VAL_CUSTO_REAL'
        ,'ITME_VAL_PRVDA'
        ,'ITME_VAL_CUSTO_MEDIO'
    ];
    protected $connection = 'oracle';
    // protected $primaryKey = ['PR_COD'];
    protected $table = 'ITEM_MOV_ESTOQ';
    public $timestamps = false;
}
