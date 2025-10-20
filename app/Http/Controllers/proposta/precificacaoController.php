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
        $filtrosIn=[];

        if(array_key_exists('cotacao',$dateForm)){
            if($dateForm['cotacao']){
                $filtros[]=['cotacao','like','%'.$dateForm['cotacao'].'%'];
                session()->put('cotacao', $dateForm['cotacao']);
            }
        };
        if(array_key_exists('origem',$dateForm)){
            if($dateForm['origem']){
                $filtros[]=['origem',$dateForm['origem']];
                session()->put('origem', $dateForm['origem']);
            }
        };


        session()->put('dateForm',$dateForm);

        $proposta = proposta::leftJoin('cliente','cliente.id','proposta.cliente_id')
                    ->leftJoin('proposta_item','proposta_item.proposta_id','proposta.id')
                    ->leftJoin('proposta_fase','proposta_fase.id','proposta.fase_id')
                    ->whereIn('fase_id',[1,2,3])
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
}
