<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class bg_aliq_icms extends Model
{
    use HasFactory;
    protected $fillable = [
        'ai_cod',
        'ai_nom',
        'ai_per_icms',
        'ai_per_reduc_icms',
        'ai_flg_tip_sitrib',
        'naop_cod',
        'naop_cod_uf_difer',
        'naop_cod_devolv',
        'naop_cod_uf_difer_devolv',
        'naop_cod_compra',
        'naop_cod_uf_difer_compra',
        'naop_cod_compra_devolv',
        'naop_cod_uf_compra_difer_dev',
        'ai_cod_cons_final',
        'ai_cod_nao_contrib',
        'dat_atualizacao',
        'usu_atualizacao',
        'ai_cod_sn',
        'ai_cod_automacao',
        'ai_cod_pf',
        'ai_per_desc_efetivo',
        'ai_cod_sn_cf',
        'ai_per_reduc_difal',
        'tabf_cod',
        'mdic_num_seq',
        'ai_per_icms_deson',
        'ai_cod_ec',
        'naop_cod_transf',
        'naop_cod_transf_uf_dif',
        'ai_cod_industria',
        'tabf_cod_cred_pres',
    ];
    protected $connection = 'oracle';
    // protected $primaryKey = ['PR_COD'];
    protected $table = 'PRDUTO_UF_ALIQ_ICMS';
    public $timestamps = false;
}
