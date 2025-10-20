<?php

namespace App\Http\Controllers\pdf;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\Helper;
use App\Models\modelo;
use NumberFormatter;
use PhpParser\Node\Stmt\Foreach_;
use Illuminate\Support\Facades\DB;
use App\Models\movimentos;
use App\Models\movimentoAnexos;
use App\Models\movimentoEtapas;
use App\Models\documentos;
use App\Models\etapas;
use App\Models\filiais;

// ini_set('memory_limit','64M');

class PdfController extends Controller
{
    public function generate($processo_id,$modelo_id){

        $documento_id = $modelo_id;
        $documento  = modelo::where('id','=',$documento_id)->first();
        $tamanho = $documento->tamanho;
        $documentoNome = $documento->descricao;

        $html       = $documento->modelo;// carregando o modelo do documento
        $html1      = $html;


        /****************************** código de barras ****************************************************/
        $code =  str_pad($processo_id,9,"0",STR_PAD_LEFT);

        if(strlen($code)>14){
            $codigo_barras = "<div><barcode code='$code' type='EAN128A' size='0.9' height='0.8'/></div>";
        }else{
            $codigo_barras = "<div><barcode code='$code' type='EAN13' size='0.8' height='0.4'/></div>";
        };


        $movimento = movimentos::select(
                'movimentos.id'
                , 'movimentos.data'
                , 'movimentos.status'
                , 'movimentos.filial_id'
                , 'movimentos.funcionario_id'
                , 'movimentos.nome_cliente'
                , 'movimentos.imei'
                , 'movimentos.servico_id'
                , 'movimentos.nr_nota'
                , 'movimentos.Defeito'
                , 'movimentos.telefone'
                , 'movimentos.cpf_cnpj'
                , 'movimentos.codigo_cliente'
                , 'movimentos.etapa_id'
                , 'etapas.etapa'
                , 'etapas.modelo_id'
                , 'modelo.descricao'
                , 'modelo.botaoCor'
                , 'modelo.botaoImagem'
                , 'etapas.tempoDaEtapa'
                ,  DB::raw("DATE_ADD(movimento_etapas.data, INTERVAL etapas.tempoDaEtapa DAY) as dt_vencimento" )
                ,  DB::raw("DATE_ADD(curdate(), INTERVAL (SELECT sum(tempoDaEtapa)  FROM etapas WHERE id >= movimento_etapas.etapa_id) DAY) as prvisao_entrega" )
                ,  DB::raw("DATE_ADD(movimentos.data, INTERVAL (SELECT sum(tempoDaEtapa)  FROM etapas) DAY) as previsao_inicial" )
                , 'movimento_etapas.movimento_id as me_movimento_id'
                , 'movimento_etapas.usuario_id as me_usuario_id'
                , 'movimento_etapas.data as me_data'
                , 'movimento_etapas.etapa_id as me_etapa_id'
                , 'users.name'
                ,  DB::raw("(SELECT count(*)  FROM movimento_anexos WHERE movimento_id = movimentos.id AND anexo IS NULL) as existeAnexo")
                ,  DB::raw("case when coalesce(user_etapa.user_id,0)>0 then 'S' else 'N' end as usuario_na_etapa")
                , 'filiais.filial'
                , 'movimentos.produto'
                , 'movimento_etapas.obs'
                , 'movimentos.servico'
                , 'movimentos.modelo'
                , 'movimentos.data_compra'

            )
            ->leftJoin('etapas','etapas.id','movimentos.etapa_id')
            ->leftJoin('movimento_etapas', function($join){
                $join->on('movimento_etapas.id','=','movimentos.movimento_etapa_id');
                    //  ->on('movimento_etapas.etapa_id','=','movimentos.etapa_id');
            })
            ->leftJoin('modelo','modelo.id','=','etapas.modelo_id' )
            ->leftJoin('users','users.id','=','movimento_etapas.usuario_id' )
            ->leftJoin('user_etapa', function($join){
                $join->on('user_etapa.user_id','=','users.id')
                    ->on('user_etapa.etapa_id','=','movimento_etapas.etapa_id');
            })
            ->leftJoin('filiais','filiais.filial_id','movimentos.filial_id')

            ->find($processo_id);


        $documentos = movimentoAnexos::leftJoin('documentos','documentos.id','=','movimento_anexos.documento_id')
            ->where('movimento_anexos.movimento_id',$processo_id)
            ->get([
                    'anexo'
                    ,'documento'
                    ,'obrigatorio'
            ]);
            $tabelaDocumentos='
                <table class="bordaSimples font10">
                <thead>
                    <tr bgcolor="#c3c3c3">
                        <td width="80%" align="center">Documento</td>
                        <td width="10%" align="center">Obrigatório</td>
                        <td width="5%" align="center">Anexado</td>
                    </tr>
                </thead>
                <tbody class="font-10">';
                    foreach ($documentos as $doc )
                    {
                        $tabelaDocumentos.="
                            <tr>
                                <td> $doc->documento </td>
                                <td align='center'> $doc->obrigatorio </td>
                                <td align='center'> ".($doc->anexo ? 'S' : 'N')." </td>
                            </tr>
                        ";
                    }
            $tabelaDocumentos.="
                    </tbody>
                </table>
            ";


        $etapas = movimentoEtapas::leftJoin('users','users.id','=','movimento_etapas.usuario_id')
            ->leftJoin('etapas','etapas.id','=','movimento_etapas.etapa_id')
            ->where('movimento_id',$processo_id)
            ->orderBy('movimento_etapas.id')
            ->get([
                'movimento_etapas.data'
                ,'movimento_etapas.obs'
                ,'users.name'
                ,'etapas.etapa'
            ]);

            $tabelaEtapas='
                <table class="table bordaSimples font10">
                <thead>
                    <tr bgcolor="#c3c3c3">
                        <td width="20%" align="center" >Data</td>
                        <td width="15%" align="center" >Etapa</td>
                        <td width="15%" align="center" >Responsável</td>
                        <td width="45%" align="center" >Obs</td>
                    </tr>
                </thead>
                <tbody class="font-10">
            ';
                foreach ($etapas as $item ){
                    $tabelaEtapas.="
                        <tr>
                            <td align='center'> ".date('d/m/Y',strtotime($item->data))." </td>
                            <td> $item->etapa </td>
                            <td> $item->name </td>
                            <td> $item->obs </td>
                        </tr>
                    ";
                };
            $tabelaEtapas.='
                    </tbody>
                </table>
            ';

        /******************************** substituindo tags *************************************************/

        $html = str_replace( "#Processo#",$code , $html );
        $html = str_replace( "#CodigoBarras#", $codigo_barras , $html );
        $html = str_replace( "#DataAbertura#", date('d/m/Y',strtotime($movimento->data)) , $html );
        $html = str_replace( "#DataCompra#", date('d/m/Y',strtotime($movimento->data_compra)) , $html );
        $html = str_replace( "#status#", $movimento->status , $html );
        $html = str_replace( "#Cliente#", $movimento->nome_cliente , $html );
        $html = str_replace( "#CpfCnpj#", $movimento->cpf_cnpj , $html );
        $html = str_replace( "#Nota#", $movimento->nr_nota , $html );
        $html = str_replace( "#imei#", $movimento->imei , $html );
        $html = str_replace( "#Defeito#", $movimento->Defeito , $html );
        $html = str_replace( "#telefoneContato#", $movimento->telefone , $html );
        $html = str_replace( "#Etapa#", $movimento->etapa , $html );
        $html = str_replace( "#DiasEtapa#", $movimento->tempoDaEtapa , $html );
        $html = str_replace( "#DtVencimentoEtapa#", $movimento->dt_vencimento , $html );
        $html = str_replace( "#DtPrevistaEntrega#", $movimento->prvisao_entrega , $html );
        $html = str_replace( "#DtInicialPrevista#", $movimento->previsao_inicial , $html );
        $html = str_replace( "#DtEtapa#", $movimento->me_data , $html );
        $html = str_replace( "#Responsavel#", $movimento->name , $html );
        $html = str_replace( "#Filial#", $movimento->filial , $html );
        $html = str_replace( "#Produto#", $movimento->produto , $html );
        $html = str_replace( "#obs#", $movimento->obs , $html );
        $html = str_replace( "#Serviço#", $movimento->servico , $html );
        $html = str_replace( "#Modelo#", $movimento->modelo , $html );
        $html = str_replace( "#tabelaDocumentos#", $tabelaDocumentos , $html );
        $html = str_replace( "#tabelaEtapas#", $tabelaEtapas , $html );

        $htmlPDF = $html;

        /******** configurações pdf *************************/

        $fileName = $documentoNome.'.pdf';
        $mpdf = new \Mpdf\Mpdf([
            'format' => $tamanho,
            'margin_left'   => $documento->margin_left,
            'margin_rigth'  => $documento->margin_rigth,
            'margin_top'    => $documento->margin_top,
            'margin_bottom' => $documento->margin_bottom,
            'margin_header' => 2,
            'margin_footer' => 2
        ]);

        // $imgCabecalho = url('img/logo.png');
        // $imgRodape = url('img/orcamentoRodape.png');

        // $mpdf->SetHTMLHeader('
        // <div style="text-align: right; font-weight: bold;">
        //     <img src="'.$imgCabecalho.'" width="100">
        // </div><hr>'
        // );

        $mpdf->SetHTMLFooter('
        <hr>
        <table width="100%">
            <tr>
                <td width="33%">{DATE j/m/Y}</td>
                <td width="33%" style="text-align: right;"></td>
                <td width="33%" align="right">{PAGENO}/{nbpg}</td>
            </tr>
        </table>');

        $html = view('pdf.pdf', compact('htmlPDF'));
        $html = $html->render();
        $mpdf->AddPage('P');

        $mpdf->WriteHTML($html);
        $mpdf->Output($fileName, 'I');


    }
}
