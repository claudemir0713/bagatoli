<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class bg_marca_prduto extends Model
{
    use HasFactory;

    protected $fillable = [
        'MCPR_COD'
        , 'MCPR_DESC'
        , 'DAT_ATUALIZACAO'
        , 'USU_ATUALIZACAO'
        , 'MCPR_PER_DESC_CP'
        , 'MCPR_NOM_COMPRADOR'
        , 'ID_ECOMMERCE'
        , 'MCPR_DESC_ECOMMERCE'
    ];
    protected $connection = 'oracle';
    // protected $primaryKey = ['PR_COD'];
    protected $table = 'MARCA_PRDUTO';
    public $timestamps = false;
}
