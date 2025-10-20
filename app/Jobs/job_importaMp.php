<?php

namespace App\Jobs;

use App\Models\blu_estoque_mes;
use App\Models\custo_mp;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class job_importaMp implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $ano = blu_estoque_mes::max('ANO_REF');
        $mes = blu_estoque_mes::where('ANO_REF',$ano)->max('MES_REF');

        $custo = blu_estoque_mes::leftJoin('PRODUTO', function($join){
                                $join->on('PRODUTO.COD_EMPRESA','ESTOQUE_MES.COD_EMPRESA');
                                $join->on('PRODUTO.COD_PROD', 'ESTOQUE_MES.COD_PRODUTO');
                            })
                            ->where('ANO_REF',$ano)
                            ->where('MES_REF',$mes)
                            ->where('PRODUTO.COD_GRUPO_PR_1','=',2)
                            ->where('PRODUTO.SIT_PRODUTO','A')
                            ->get([
                                'ESTOQUE_MES.COD_PRODUTO AS COD_MP'
                                ,'PRODUTO.NOME_PROD AS MATERIA_PRIMA'
                                ,'PRODUTO.COD_UNID_MEDIDA AS UN_MEDIDA'
                                ,'ESTOQUE_MES.CUSTO_MEDIO'
                            ]);
        foreach($custo as $item)
        {
            $custo_mps = custo_mp::where('cod_produto',$item->cod_mp)->count();
            if($custo_mps>0){
                $custo_mps = custo_mp::where('cod_produto',$item->cod_mp)->first();
                $custo_mps->custo_mp = $item->custo_medio;
            }else{
                $custo_mps = new custo_mp([
                    'cod_produto'   => $item->cod_mp
                    , 'descricao'   => $item->materia_prima
                    , 'und'         => $item->un_medida
                    , 'custo_mp'    => $item->custo_medio
                ]);
            }
            $custo_mps->save();

            print_r($item->cod_mp.' - '.$item->materia_prima.' - '.$item->un_medida.' - '.$item->custo_medio."\n");
        }

    }
}
