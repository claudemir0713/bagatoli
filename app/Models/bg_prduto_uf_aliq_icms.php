<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class bg_prduto_uf_aliq_icms extends Model
{
    use HasFactory;
    protected $fillable = [
        'pr_cod'
        ,'uf_sig'
        ,'ai_cod'
        ,'tfic_cod'
        ,'ai_cod_devol'
        ,'tfic_cod_devol'
        ,'prai_perc_aliq_interna'
        ,'prai_marg_vlr_agreg'
        ,'em_cod'
        ,'fi_cod'
        ,'prai_perc_aliq_int_comp'
        ,'ai_cod_comp'
        ,'prai_mva_original'
        ,'prai_per_red_mva'
        ,'dat_atualizacao'
        ,'usu_atualizacao'
        ,'prai_per_fcp'
        ,'prai_flg_cesta_basica'
    ];
    protected $connection = 'oracle';
    // protected $primaryKey = ['PR_COD'];
    protected $table = 'PRDUTO_UF_ALIQ_ICMS';
    public $timestamps = false;
}
