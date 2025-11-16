<?php

namespace App\Http\Controllers\proposta;

use App\Helpers\bg_impostos;
use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\cliente;
use App\Models\empresa;
use App\Models\empresa_parametro;
use App\Models\licitacao_tipo;
use App\Models\proposta;
use App\Models\proposta_item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;
Paginator::useBootstrap();

class precificacaoController extends Controller
{
    public function listAll(Request $request){
        $dateForm = $request->except('_token');
        $filtros=[];

        if(array_key_exists('cliente',$dateForm)){
            if($dateForm['cliente']){
                $filtros[]=['cliente','like','%'.$dateForm['cliente'].'%'];
            }
        };
        if(array_key_exists('cidade',$dateForm)){
            if($dateForm['cidade']){
                $filtros[]=['cidade','like','%'.$dateForm['cidade'].'%'];
            }
        };

        if(array_key_exists('uf',$dateForm)){
            if($dateForm['uf']){
                $filtros[]=['uf',$dateForm['uf']];
            }
        };
        if(array_key_exists('processo',$dateForm)){
            if($dateForm['processo']){
                $filtros[]=['nr_processo',$dateForm['processo']];
            }
        };
        if(array_key_exists('pregao',$dateForm)){
            if($dateForm['pregao']){
                $filtros[]=['nr_pregao',$dateForm['pregao']];
            }
        };
        if(array_key_exists('dtEI',$dateForm)){
            if($dateForm['dtEI']){
                $filtros[]=['data_entrega_proposta','>=',$dateForm['dtEI']];
            }
        };
        if(array_key_exists('dtEF',$dateForm)){
            if($dateForm['dtEF']){
                $filtros[]=['data_entrega_proposta','<=',$dateForm['dtEF']];
            }
        };
        if(array_key_exists('dtAI',$dateForm)){
            if($dateForm['dtAI']){
                $filtros[]=['data_processo','>=',$dateForm['dtAI']];
            }
        };
        if(array_key_exists('dtAF',$dateForm)){
            if($dateForm['dtAF']){
                $filtros[]=['data_processo','<=',$dateForm['dtAF']];
            }
        };

        if(array_key_exists('proposta',$dateForm)){
            if($dateForm['proposta']){
                $filtros=[];
                $filtros[]=['fase_id',1];
                $filtros[]=['proposta.id',$dateForm['proposta']];
            }
        };

        session()->put('dateForm',$dateForm);

        $proposta = proposta::leftJoin('cliente','cliente.id','proposta.cliente_id')
                    ->leftJoin('proposta_item','proposta_item.proposta_id','proposta.id')
                    ->leftJoin('proposta_fase','proposta_fase.id','proposta.fase_id')
                    ->whereIn('fase_id',[1,2,3])
                    ->where($filtros)
                    ->select([
                        'proposta.id'
                        , 'proposta.empresa_id'
                        , 'proposta.cliente_id'
                        , 'proposta.tipo_licitacao_id'
                        , 'proposta.data'
                        , 'proposta.data_entrega_proposta'
                        , 'proposta.hora_entrega_proposta'
                        , 'proposta.data_processo'
                        , 'proposta.hora_processo'
                        , 'proposta.nr_processo'
                        , 'proposta.nr_pregao'
                        , 'proposta.portal_compras'
                        , 'proposta.id_portal_compras'
                        , 'proposta.obs'
                        , 'cliente.cliente'
                        , 'cliente.uf'
                        , 'proposta_fase.descricao as fase'
                        , 'fase_id'
                        , db::raw("sum(total_edital) as total_edital")
                        , db::raw("sum(total_venda)  as total_venda")
                    ])
                    ->groupBy([
                        'proposta.id'
                        , 'proposta.empresa_id'
                        , 'proposta.cliente_id'
                        , 'proposta.tipo_licitacao_id'
                        , 'proposta.data'
                        , 'proposta.data_entrega_proposta'
                        , 'proposta.hora_entrega_proposta'
                        , 'proposta.data_processo'
                        , 'proposta.hora_processo'
                        , 'proposta.nr_processo'
                        , 'proposta.nr_pregao'
                        , 'proposta.portal_compras'
                        , 'proposta.id_portal_compras'
                        , 'proposta.obs'
                        , 'cliente.cliente'
                        , 'cliente.uf'
                        , 'proposta_fase.descricao'
                        , 'fase_id'

                    ])
                    ->paginate(7);
        return view('precificacao.listAll',compact('proposta','dateForm'));
    }

    public function formPrecificacao($id){
        $proposta = proposta::find($id);
        $cliente = cliente::find($proposta->cliente_id);
        $proposta_item = proposta_item::where('proposta_id',$id)->orderBy('lote')->orderBy('item')->orderBy('id')->get();
        $empresa = empresa::orderBy('razao')->get();
        $empresa_parametro = empresa_parametro::where('empresa_id',$proposta->empresa_id)->first();
        $licitacao_tipo = licitacao_tipo::find($proposta->tipo_licitacao_id);

        return  view('precificacao.precificacao',compact('proposta','proposta_item','empresa_parametro','cliente','licitacao_tipo','empresa'));
    }

    public function editPrecificacao(Request $request,$id){
        try{
            $proposta = proposta::find($id);
            $proposta->fase_id           = 3;
            $proposta->empresa_id        = $request->empresa_id;
            $proposta->prazo             = $request->prazo;
            $proposta->taxa_financeira   = $request->taxa_financeira;
            $proposta->save();

            foreach ($request->id as $key => $id) {
                try{
                    $proposta_item = proposta_item::find($id);
                    $total_custo    = Helper::formata_valor($request->total_custo[$key]);
                    $total_venda    = Helper::formata_valor($request->total_venda[$key]);
                    $qtd            = Helper::formata_valor($request->qtd[$key]);

                    $proposta_item->unt_custo           = $total_custo/$qtd;
                    $proposta_item->total_custo         = $total_custo;
                    $proposta_item->impostos_credito    = Helper::formata_valor($request->impostos_credito[$key]);
                    $proposta_item->impostos_venda      = Helper::formata_valor($request->imposto_venda[$key]);
                    $proposta_item->ir_csll             = Helper::formata_valor($request->ir_csll[$key]);
                    $proposta_item->outros              = Helper::formata_valor($request->outros[$key]);
                    $proposta_item->difal               = Helper::formata_valor($request->difal[$key]);
                    $proposta_item->frete               = Helper::formata_valor($request->frete[$key]);
                    $proposta_item->despesa_fixa        = Helper::formata_valor($request->despesa_fixa[$key]);
                    $proposta_item->comissao            = Helper::formata_valor($request->comissao[$key]);
                    $proposta_item->margem              = Helper::formata_valor($request->margem[$key]);
                    $proposta_item->unt_venda           = $total_venda/$qtd;
                    $proposta_item->total_venda         = $total_venda;

                    $proposta_item->save();
                }catch(\Exception $e){
                    return response()->json([
                        'message'   => 'Error',
                        'title'     => 'Error',
                        'type'      => 'error',
                        'acao'      => '',
                        'html'      => $e->getMessage(),
                        'timer'     => 3000
                    ], 200);
                }
            }

        }catch(\Exception $e){
            return response()->json([
                'message'   => 'Error',
                'title'     => 'Error',
                'type'      => 'error',
                'acao'      => '',
                'html'      => $e->getMessage(),
                'timer'     => 3000
            ], 200);
        }
        return response()->json([
                'message'   => 'Success',
                'title'     => 'Success',
                'type'      => 'success',
                'acao'      => 'voltar',
                'html'      => 'Cadastro alterado com sucesso!',
                'timer'     => 500
            ], 200);


    }

    public function alteraEmpresa(Request $request){
        $proposta = proposta::find($request->proposta_id);
        $proposta->fase_id = 2;
        $proposta->empresa_id = $request->empresa_id;
        $proposta->save();

        $impostos = bg_impostos::icms($request->proposta_id);

        return ($impostos);
    }

    public function imprimir($id){
        $proposta = proposta::find($id);
        $cliente = cliente::find($proposta->cliente_id);
        $empresa = empresa::find($proposta->empresa_id);
        $proposta_item = proposta_item::where('proposta_id',$id)->orderBy('lote')->orderBy('item')->orderBy('id')->get();

        $fileName = 'COTAÇÃO '.$id.'-'.$cliente->cliente.'-'.$proposta->nr_processo.'.pdf';
        $mpdf = new \Mpdf\Mpdf([
            'format' => 'A4',
            'margin_left'   => 15,
            'margin_rigth'  => 10,
            'margin_top'    => 20,
            'margin_bottom' => 18,
            'margin_header' => 8,
            'margin_footer' => 8
        ]);

        $cabecalho = '<table class="semBordas" width="100%">';
        $cabecalho .='<tr>';
        $cabecalho .='<td width="10%" align="center"><img src="'.asset('img/logo.png').'" height="30"></td>';
        $cabecalho .= '<td width="90%" align="center"><span style="font-size:20px"><b>Cotação '.str_pad($id,4,'0',STR_PAD_LEFT).'</b></span></td>';
        $cabecalho .='</tr>';
        $cabecalho .='</table><hr>';

        // dd($empresa);

        $rodape = '<hr><table class="semBordas fonte-8" width="100%">';
            $rodape .='<tr>';
                $rodape .='<td width="80%" class="fonte-7" align="center">';
                    $rodape .='<b>'.$empresa->razao.'</b><br>';
                    $rodape .=$empresa->cnpj.'<br>';
                    $rodape .=$empresa->endereco.' '.$empresa->bairro.'-'.$empresa->cep.'<br>';
                    $rodape .=$empresa->cidade.'-'.$empresa->uf.'-'.$empresa->pais.'<br>';
                $rodape .='</td>';
                $rodape .= '<td width="20%" align="center">Página {PAGENO} de {nb}</td>';
            $rodape .='</tr>';
        $rodape .='</table>';


        $html = view('precificacao.imprimePdf',compact('proposta','proposta_item','cliente'));
        $html->render();
        $mpdf->SetHTMLHeader($cabecalho);
        $mpdf->SetHTMLFooter($rodape);
        $mpdf->AddPage('P');
        $mpdf->SetTitle($fileName);
        $mpdf->WriteHTML($html);
        $mpdf->Output($fileName, 'I');
    }
}
