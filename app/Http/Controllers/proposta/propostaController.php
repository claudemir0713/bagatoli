<?php

namespace App\Http\Controllers\proposta;

use App\Helpers\help_produto;
use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\bg_item_mov_estoq;
use App\Models\bg_prduto;
use App\Models\cliente;
use App\Models\licitacao_tipo;
use App\Models\proposta;
use App\Models\proposta_item;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use Illuminate\Pagination\Paginator;
Paginator::useBootstrap();

class propostaController extends Controller
{
    public function listAll(Request $request){
        $dateForm = $request->except('_token');
        $filtros=[];
        $filtrosIn=[];

        $filtros[]=['fase_id',1];
        session()->put('fase_id', 1);

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
                        , 'proposta_fase.descricao as fase'
                        , 'fase_id'
                        , db::raw("sum(total_edital) as total_edital")
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
        return view('proposta.listAll',compact('proposta','dateForm'));
    }
    public function formAdd(){
        $licitacao_tipo = licitacao_tipo::orderBy('descricao')->get(['id','descricao']);
        return view('proposta.add',compact('licitacao_tipo'));
    }
    public function formEdit($id){
        $licitacao_tipo = licitacao_tipo::orderBy('descricao')->get(['id','descricao']);
        $proposta = proposta::find($id);
        $cliente = cliente::find($proposta->cliente_id);
        $proposta_item = proposta_item::where('proposta_id',$id)->get();
        return view('proposta.edit',compact('proposta','proposta_item','cliente','licitacao_tipo'));
    }
    public function store(Request $request){
        try{
            $proposta = new proposta([
                'empresa_id'            => 0
                ,'fase_id'              => 1
                ,'cliente_id'           => $request->cliente_id
                ,'tipo_licitacao_id'    => $request->tipo_licitacao_id
                ,'data'                 => $request->data
                ,'data_entrega_proposta'=> $request->data_entrega_proposta
                ,'hora_entrega_proposta'=> $request->hora_entrega_proposta
                ,'data_processo'        => $request->data_processo
                ,'hora_processo'        => $request->hora_processo
                ,'nr_processo'          => $request->nr_processo
                ,'nr_pregao'            => $request->nr_pregao
                ,'portal_compras'       => $request->portal_compras
                ,'id_portal_compras'    => $request->id_portal_compras
                ,'obs'                  => $request->obs
            ]);
            $proposta->save();
            $proposta_id = $proposta->id;

            foreach ($request->seq as $key => $seq) {

                try{
                    $proposta_item = new proposta_item([
                        'proposta_id'               => $proposta_id
                        , 'item'                    =>$seq
                        ,'status_item_id'           => 0
                        , 'lote'                    =>($request->lote) ? $request->lote[$key] : ''
                        , 'lote_descricao'          =>($request->lote_descricao) ? $request->lote_descricao[$key] : ''
                        , 'cod_produto'             =>($request->cod_produto) ? $request->cod_produto[$key] : '0'
                        , 'produto'                 =>$request->produto[$key]
                        , 'descricao'               =>$request->descricao[$key]
                        , 'marca'                   =>$request->marca[$key]
                        , 'modelo'                  =>$request->modelo[$key]
                        , 'qtd'                     =>$request->qtd[$key]
                        , 'und'                     =>$request->und[$key]
                        , 'unt_edital'              =>Helper::formata_valor($request->unt_edital[$key])
                        , 'total_edital'            =>Helper::formata_valor($request->total_edital[$key])
                        , 'unt_custo'               =>Helper::formata_valor($request->unt_custo[$key])
                        , 'total_custo'             =>Helper::formata_valor($request->total_custo[$key])
                        , 'frete_custo'             =>($request->frete_custo)? Helper::formata_valor($request->frete_custo[$key]) : 0
                        , 'impostos_credito'        =>($request->impostos_credito)? Helper::formata_valor($request->impostos_credito[$key]) : 0
                        , 'obs'                     =>($request->obs_item) ? $request->obs_item[$key] : ''
                    ]);
                    // dd($proposta_item);
                    $proposta_item->save();
                }catch(\Exception $e){
                    proposta::find($proposta_id)->delete();
                    proposta_item::where('proposta_id',$proposta_id)->delete();

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
    public function edit(Request $request, $id){
        try{
            $proposta  = proposta::find($id);
                $proposta->empresa_id           = 0;
                $proposta->cliente_id           = $request->cliente_id;
                $proposta->tipo_licitacao_id    = $request->tipo_licitacao_id;
                $proposta->data                 = $request->data;
                $proposta->data_entrega_proposta= $request->data_entrega_proposta;
                $proposta->hora_entrega_proposta= $request->hora_entrega_proposta;
                $proposta->data_processo        = $request->data_processo;
                $proposta->hora_processo        = $request->hora_processo;
                $proposta->nr_processo          = $request->nr_processo;
                $proposta->nr_pregao            = $request->nr_pregao;
                $proposta->portal_compras       = $request->portal_compras;
                $proposta->id_portal_compras    = $request->id_portal_compras;
                $proposta->obs                  = $request->obs;

            $proposta->save();
            $proposta_id = $id;

            proposta_item::where('proposta_id',$id)->delete();

            foreach ($request->seq as $key => $seq) {
                try{
                    $proposta_item = new proposta_item([

                        'proposta_id'               => $proposta_id
                        , 'item'                    =>$seq
                        ,'status_item_id'           => 0
                        , 'lote'                    =>($request->lote) ? $request->lote[$key] : ''
                        , 'lote_descricao'          =>($request->lote_descricao) ? $request->lote_descricao[$key] : ''
                        , 'cod_produto'             =>($request->cod_produto) ? $request->cod_produto[$key] : '0'
                        , 'produto'                 =>$request->produto[$key]
                        , 'descricao'               =>$request->descricao[$key]
                        , 'marca'                   =>$request->marca[$key]
                        , 'modelo'                  =>$request->modelo[$key]
                        , 'qtd'                     =>Helper::formata_valor($request->qtd[$key])
                        , 'und'                     =>$request->und[$key]
                        , 'unt_edital'              =>Helper::formata_valor($request->unt_edital[$key])
                        , 'total_edital'            =>Helper::formata_valor($request->total_edital[$key])
                        , 'unt_custo'               =>Helper::formata_valor($request->unt_custo[$key])
                        , 'total_custo'             =>Helper::formata_valor($request->total_custo[$key])
                        , 'frete_custo'             =>($request->frete_custo)? Helper::formata_valor($request->frete_custo[$key]) : 0
                        , 'impostos_credito'        =>($request->impostos_credito)? Helper::formata_valor($request->impostos_credito[$key]) : 0
                        , 'obs'                     =>($request->obs_item) ? $request->obs_item[$key] : ''
                    ]);
                    // dd($proposta_item);
                    $proposta_item->save();
                }catch(\Exception $e){
                    proposta::find($proposta_id)->delete();
                    proposta_item::where('proposta_id',$proposta_id)->delete();

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
    public function destroy($id){

    }

    public function bg_localizaCliente(Request $request){
        $arr_nome = explode(' ',trim($request->cliente));
        $filtros = [];
        foreach($arr_nome as $item){
            if( $item ){
                $filtros[] = ['cliente','like','%'.strtoupper($item).'%'];
            }
        }
        $cliente = cliente::where($filtros)
                    ->orderby('cliente')
                    ->get();
        $cli = [];
        foreach($cliente as $item){
            $cli[] = [
                'id'        => $item->id
                ,'cliente'  => $item->cliente
            ];
        }
        return response()->json($cli);

    }

    public function localizaNomeCliente(Request $request){
        $cliente = cliente::find($request->cliente_id);
        return response()->json($cliente);
    }

    public function bg_localizaProduto(Request $request){
        $arr_nome = explode(' ',trim($request->nome));
        $filtros = [];
        foreach($arr_nome as $item){
            if( $item ){
                $filtros[] = ['PR_NOM','like','%'.strtoupper($item).'%'];
            }
        }
        $produto = bg_prduto::leftJoin('marca_prduto','marca_prduto.mcpr_cod','prduto.mcpr_cod')
                    ->where($filtros)
                    ->orderby('pr_nom')
                    ->get();
        $prod = [];

        foreach($produto as $item){
            $entrada = help_produto::ultimasEntradas($item->pr_cod);
            $entradas = [];
            foreach($entrada as $itemEntrada){
                $entradas[] = array(
                    'fornecedor'    => $itemEntrada->en_nom
                    ,'data'         => helper::formatadata($itemEntrada->nfen_dat_entrad_saida)
                    ,'qtd'          =>($itemEntrada->infe_qtd)
                    ,'val_unit'     =>($itemEntrada->infe_val_unit)
                    ,'per_icms'     =>($itemEntrada->infe_per_icms)
                    ,'per_pis'      =>($itemEntrada->infe_per_pis)
                    ,'per_cofins'   =>($itemEntrada->infe_per_cofins)
                    ,'und'          =>($itemEntrada->und)
                );
            };

            $prod[] = [
                'pr_cod'    => $item->pr_cod
                ,'pr_nom'   => $item->pr_nom
                ,'ncm'      => $item->clfi_cod
                ,'und'      => $item->um_sig_venda
                ,'marca'    => $item->mcpr_desc
                ,'entradas' => $entradas
            ];
        }
        return response()->json($prod);
    }

    public function localizaNomeProduto(Request $request){
        $return = [];
        $entradas = [];
        $produto = bg_prduto::where('PR_COD',$request->produto_id)->first();
        $filtros = [];
        $filtros[] = ['PR_COD',$request->produto_id];
        $filtros[] = ['EM_COD',1];
        $filtros[] = ['FI_COD',1];

        $entrada = help_produto::ultimasEntradas($request->produto_id);
        foreach($entrada as $item){
            $entradas[] = array(
                'fornecedor'    => $item->en_nom
                ,'data'         => helper::formatadata($item->nfen_dat_entrad_saida)
                ,'qtd'          => ($item->infe_qtd)
                ,'val_unit'     => ($item->infe_val_unit)
                ,'per_icms'     => ($item->infe_per_icms)
                ,'per_pis'      => ($item->infe_per_pis)
                ,'per_cofins'   => ($item->infe_per_cofins)
                ,'und'          => ($item->und)
            );
        };


        $return = array(
            'pr_nom'                => $produto->pr_nom
            ,'pr_nom_reduz'         => $produto->pr_nom_reduz
            ,'entradas'             =>  $entradas
        );
        return response()->json($return);
    }

    public function importaItens(){
        return view('proposta.importaItens');
    }

    public function insereItens(Request $request)
    {
        $data = $request->texto;
        $texto = explode("\n",$data);
        $retorno = [];
        foreach($texto as $linhas){
            $linha      = explode("\t",$linhas);
            $retorno[] =[
                'Lote'              => (array_key_exists(0,$linha))? trim($linha[0]) : ''
                ,'LoteDescricao'    => (array_key_exists(1,$linha))? trim($linha[1]) : ''
                ,'Item'             => (array_key_exists(2,$linha))? trim($linha[2]) : ''
                ,'ItemDescricao'    => (array_key_exists(3,$linha))? trim($linha[3]) : ''
                ,'ItemUnd'          => (array_key_exists(4,$linha))? trim($linha[4]) : ''
                ,'ItemQtd'          => (array_key_exists(5,$linha))? trim($linha[5]) : ''
                ,'ItemUnt'          => (array_key_exists(6,$linha))? trim($linha[6]) : ''
            ];
        }
        dd($retorno);
        return response()->json(($retorno));

    }


}
