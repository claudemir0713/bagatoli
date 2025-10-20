<?php
namespace App\Helpers;

use App\Models\bg_prduto_uf_aliq_icms;
use App\Models\cliente;
use App\Models\empresa;
use App\Models\empresa_parametro;
use App\Models\proposta;
use App\Models\proposta_item;
use Illuminate\Support\Facades\Auth;

class bg_impostos {
    public static function icms($proposta_id)
    {
        $filtros = [];
        $proposta_item = proposta_item::where('proposta_id',$proposta_id)->get();
        $proposta = proposta::find($proposta_id);
        $cliente = cliente::find($proposta->cliente_id);
        $empresa = empresa::find($proposta->empresa_id);

        $em_cod = $empresa->em_cod;
        $fi_cod = $empresa->fi_cod;
        $regime_tributario = $empresa->regime_tributario;

        $return = [];

        foreach($proposta_item as $item){
            $filtros        = [];
            $filtros[]      = ['EM_COD',$em_cod];
            $filtros[]      = ['FI_COD',$fi_cod];
            $filtros[]      = ['UF_SIG',$cliente->uf];
            $filtros[]      = ['PR_COD',$item->cod_produto];

            ($regime_tributario=='Simples Nacional')? $imposto_custo  = 0  : $imposto_custo  = $item->impostos_credito;


            $icms = bg_prduto_uf_aliq_icms::leftJoin('ALIQ_ICMS','ALIQ_ICMS.AI_COD','PRDUTO_UF_ALIQ_ICMS.AI_COD')
                            ->select([
                                'PRDUTO_UF_ALIQ_ICMS.PR_COD'
                                , 'PRDUTO_UF_ALIQ_ICMS.UF_SIG'
                                , 'PRDUTO_UF_ALIQ_ICMS.PRAI_PERC_ALIQ_INTERNA   as aliq_iterna'
                                , 'ALIQ_ICMS.AI_PER_REDUC_ICMS                  as base'
                                , 'PRDUTO_UF_ALIQ_ICMS.PRAI_PERC_ALIQ_INT_COMP  as aliq_icms'
                            ])
                            ->where($filtros)
                            ->first();
            $empresa_parametro = empresa_parametro::where('empresa_id',$proposta->empresa_id)->first();
            if($icms){
                $return[] = array(
                    'proposta_item_id'      =>$item->id
                    ,'base_icms'            => ($icms->base>0)? $icms->base : 100
                    ,'aliq_icms'            => $icms->aliq_icms
                    ,'aliq_iterna'          => $icms->aliq_iterna
                    ,'pis'                  => $empresa_parametro->pis
                    ,'cofins'               => $empresa_parametro->cofins
                    ,'ir_csll'              => $empresa_parametro->ir_csll
                    ,'difal'                => $empresa_parametro->difal
                    ,'frete'                => $empresa_parametro->frete
                    ,'despesa_fixa'         => $empresa_parametro->despesa_fixa
                    ,'comissao'             => $empresa_parametro->comissao
                    ,'outros'               => $empresa_parametro->outros
                    ,'margem'               => $empresa_parametro->margem
                    ,'regime_tributario'    => $regime_tributario
                    ,'imposto_custo'        => $imposto_custo
                    ,'origem'               => 'oracle'
                );
            }else{
                $return[] = array(
                    'proposta_item_id'      =>$item->id
                    ,'base_icms'            => 100
                    ,'aliq_icms'            => $empresa_parametro->icms + $empresa_parametro->simples
                    ,'aliq_iterna'          => $empresa_parametro->icms + $empresa_parametro->simples
                    ,'pis'                  => $empresa_parametro->pis
                    ,'cofins'               => $empresa_parametro->cofins
                    ,'ir_csll'              => $empresa_parametro->ir_csll
                    ,'difal'                => $empresa_parametro->difal
                    ,'frete'                => $empresa_parametro->frete
                    ,'despesa_fixa'         => $empresa_parametro->despesa_fixa
                    ,'comissao'             => $empresa_parametro->comissao
                    ,'outros'               => $empresa_parametro->outros
                    ,'margem'               => $empresa_parametro->margem
                    ,'regime_tributario'    => $regime_tributario
                    ,'imposto_custo'        => $imposto_custo
                    ,'origem'               => 'mysql'
                );
            }
        }
        return response()->json($return);
    }
}
