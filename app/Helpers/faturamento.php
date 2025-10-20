<?php
namespace App\Helpers;

use App\Models\blu_cliente;
use App\Models\blu_crm_pedido;
use App\Models\blu_crm_pedido_item;
use App\Models\blu_pedido;
use App\Models\blu_pedido_item;
use App\Models\condicao_pgto;
use App\Models\cotacao;
use App\Models\cotacao_item;
use App\Models\despesa_fixa_mes;
use App\Models\frete;
use App\Models\parametros_preco_vendas;
use App\Models\produto;
use App\Models\tabela;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class faturamento {
    public static function vendas($DataI,$DataF,$Cliente,$Produto,$Grupo)
    {
        if($Cliente){
            $Cliente = "AND CLIENTE.RAZ_SOCIAL like '%$Cliente%'";
        }else{
            $Cliente = '';
        }
        if($Produto){
            $Produto = "AND SAIDA_ITEM.COD_PRODUTO like ('$Produto%')";
        }else{
            $Produto = '';
        }
        if($Grupo){
            $Grupo = "AND NOME_GRUPO_PR_2 = '$Grupo'";
        }else{
            $Grupo = '';
        }

        $sql="
            SELECT
                EMPRESA.NOME_EMPRESA   				AS EMPRESA
                , SAIDA.COD_EMPRESA                 AS COD_EMPRESA
                , SAIDA.ESP_NF                      AS ESPECIE
                , SAIDA.NUM_NF     					AS DOCUMENTO
                , SAIDA.SERIE_NF                    AS SERIE
                , CASE
                    WHEN SAIDA.SERIE_NF ='99' THEN 'ROMANEIO'
                    ELSE 'NF'
                END                           		AS SERIE_FAT
                , SAIDA.DATA_EMISSAO   				AS DATA_COMP
                , SAIDA_ITEM.NUM_PEDIDO   			AS NUM_PED
                , SAIDA.COD_CLIENTE    				AS COD_CLIENTE
                , CLIENTE.RAZ_SOCIAL   				AS CLIENTE
                , SAIDA.CFOP_1     					AS CEP_IBGE
                , CIDADE.NOME_CIDADE    			AS MUNICIPIO
                , CIDADE.COD_UF     				AS ESTADO
                , PAIS.NOME_PAIS    				AS PAIS
                , SAIDA.COD_VEND_1     				AS COD_REP
                , REPRESENTANTE.NOME_INTEGRANTE 	AS REPRESENTANTE
                , SAIDA.COD_VEND_2     				AS COD_VENDEDOR
                , VENDEDOR_INTERNO.NOME_INTEGRANTE 	AS VENDEDOR
                , sum(SAIDA_ITEM.QTD_ITEM)   		AS QUANTIDADE
                , sum(SAIDA_ITEM.VAL_TOT_MERCADORIA)AS FAT_BRUTO
                , sum(SAIDA_ITEM.VAL_DESCONTO)  	AS DESCONTO
            FROM SAIDA
            LEFT JOIN SAIDA_ITEM ON SAIDA_ITEM.COD_EMPRESA 	= SAIDA.COD_EMPRESA
                                AND SAIDA_ITEM.NUM_NF		= SAIDA.NUM_NF
                                AND SAIDA_ITEM.ESP_NF		= SAIDA.ESP_NF
                                AND SAIDA_ITEM.SERIE_NF		= SAIDA.SERIE_NF
            LEFT JOIN EMPRESA ON EMPRESA.COD_EMPRESA = SAIDA.COD_EMPRESA
            LEFT JOIN CLIENTE ON CLIENTE.COD_CLIENTE = SAIDA.COD_CLIENTE
            LEFT JOIN CIDADE ON CIDADE.COD_CIDADE = CLIENTE.COD_CIDADE
            LEFT JOIN PAIS ON PAIS.COD_PAIS = CIDADE.COD_PAIS
            LEFT JOIN EQUIPE_VENDA  REPRESENTANTE ON REPRESENTANTE.COD_EQUIP_VENDA = SAIDA.COD_VEND_1
            LEFT JOIN EQUIPE_VENDA VENDEDOR_INTERNO ON VENDEDOR_INTERNO.COD_EQUIP_VENDA = SAIDA.COD_VEND_2
            LEFT JOIN PRODUTO ON PRODUTO.COD_EMPRESA	= SAIDA_ITEM.COD_EMPRESA
                            AND PRODUTO.COD_PROD		= SAIDA_ITEM.COD_PRODUTO
            LEFT JOIN GRUPO_PROD_1 ON GRUPO_PROD_1.COD_EMPRESA		= PRODUTO.COD_EMPRESA
                                AND GRUPO_PROD_1.COD_GRUPO_PR_1	= PRODUTO.COD_GRUPO_PR_1
            LEFT JOIN GRUPO_PROD_4 SUB_GRUPO ON SUB_GRUPO.COD_EMPRESA		= PRODUTO.COD_EMPRESA
                                            AND SUB_GRUPO.COD_GRUPO_PR_4 	= PRODUTO.COD_GRUPO_PR_4
            LEFT JOIN GRUPO_PROD_2  FAMILIA ON FAMILIA.COD_EMPRESA		= PRODUTO.COD_EMPRESA
                                            AND FAMILIA.COD_GRUPO_PR_2 	= PRODUTO.COD_GRUPO_PR_2
            LEFT JOIN NAT_OPERACAO ON NAT_OPERACAO.COD_EMPRESA = SAIDA.COD_EMPRESA
                                AND NAT_OPERACAO.COD_NAT_OPER = SAIDA.COD_NAT_OPER
            WHERE SAIDA.SITUACAO_NF <> 'C'
            AND SAIDA_ITEM.CFOP_ITEM NOT IN (5922,6922,5202,6202,5915,6915,5949,6949,5910,6910,5909,6909,5901,6901,5251,6921,5921,5913,5551,6551,5911,6911,5556,6556,5913,6913,5201,6201,6924,5924)
            AND SAIDA.COD_FORMA_PGTO NOT IN (7,8,9)
            AND DATA_EMISSAO BETWEEN TO_DATE('$DataI', 'YYYY-MM-DD') AND TO_DATE('$DataF', 'YYYY-MM-DD')
            $Cliente
            $Produto
            $Grupo
            GROUP BY
                EMPRESA.NOME_EMPRESA
                , SAIDA.COD_EMPRESA
                , SAIDA.ESP_NF
                , SAIDA.NUM_NF
                , SAIDA.SERIE_NF
                , SAIDA.DATA_EMISSAO
                , SAIDA_ITEM.NUM_PEDIDO
                , SAIDA.COD_CLIENTE
                , CLIENTE.RAZ_SOCIAL
                , SAIDA.CFOP_1
                , CIDADE.NOME_CIDADE
                , CIDADE.COD_UF
                , PAIS.NOME_PAIS
                , SAIDA.COD_VEND_1
                , REPRESENTANTE.NOME_INTEGRANTE
                , SAIDA.COD_VEND_2
                , VENDEDOR_INTERNO.NOME_INTEGRANTE
        ";
        try{
            $vendas = DB::connection('oracle')->select($sql);
        }catch(\Exception $e){
            dd($sql);
        }

        $retorno = [];
        foreach($vendas as $item){
            $sql_item="
                SELECT
                    SAIDA_ITEM.COD_PRODUTO  			AS COD_PRODUTO
                    , SAIDA_ITEM.NOME_PRODUTO  			AS PRODUTO
                    , GRUPO_PROD_1.COD_GRUPO_PR_1   	AS COD_GRUPO
                    , GRUPO_PROD_1.NOME_GRUPO_PR_1  	AS GRUPO
                    , SUB_GRUPO.COD_GRUPO_PR_4      	AS COD_SUB_GRUPO
                    , SUB_GRUPO.NOME_GRUPO_PR_4     	AS SUB_GRUPO
                    , FAMILIA.COD_GRUPO_PR_2     		AS COD_FAMILIA
                    , FAMILIA.NOME_GRUPO_PR_2     		AS FAMILIA
                    , SAIDA_ITEM.COD_UNID_MEDIDA 		AS UN_MEDIDA
                    , (SAIDA_ITEM.QTD_ITEM)   			AS QUANTIDADE
                    , (SAIDA_ITEM.VAL_TOT_MERCADORIA)	AS FAT_BRUTO
                    , (SAIDA_ITEM.VAL_DESCONTO)  		AS DESCONTO

                FROM SAIDA_ITEM
                LEFT JOIN PRODUTO ON PRODUTO.COD_EMPRESA = SAIDA_ITEM.COD_EMPRESA
                                AND PRODUTO.COD_PROD  = SAIDA_ITEM.COD_PRODUTO
                LEFT JOIN GRUPO_PROD_1 ON GRUPO_PROD_1.COD_EMPRESA  = PRODUTO.COD_EMPRESA
                                    AND GRUPO_PROD_1.COD_GRUPO_PR_1 = PRODUTO.COD_GRUPO_PR_1
                LEFT JOIN GRUPO_PROD_4 SUB_GRUPO ON SUB_GRUPO.COD_EMPRESA  = PRODUTO.COD_EMPRESA
                                                AND SUB_GRUPO.COD_GRUPO_PR_4  = PRODUTO.COD_GRUPO_PR_4
                LEFT JOIN GRUPO_PROD_2  FAMILIA ON FAMILIA.COD_EMPRESA  = PRODUTO.COD_EMPRESA
                                                AND FAMILIA.COD_GRUPO_PR_2  = PRODUTO.COD_GRUPO_PR_2
                WHERE SAIDA_ITEM.CFOP_ITEM NOT IN (5922,6922,5202,6202,5915,6915,5949,6949,5910,6910,5909,6909,5901,6901,5251,6921,5921,5913,5551,6551,5911,6911,5556,6556,5913,6913,5201,6201,6924,5924)
                AND SAIDA_ITEM.COD_EMPRESA  = $item->cod_empresa
                AND SAIDA_ITEM.NUM_NF  		= $item->documento
                AND SAIDA_ITEM.ESP_NF  		= '$item->especie'
                AND SAIDA_ITEM.SERIE_NF  	= $item->serie
            ";
            try{
                $venda_itens = DB::connection('oracle')->select($sql_item);
            }catch(\Exception $e){
                dd($sql_item);
            }

            $retorno_item=[];
            foreach($venda_itens as $item1){
                $retorno_item[] = array(
                    'cod_produto'     =>$item1->cod_produto
                    ,'produto'         =>$item1->produto
                    ,'cod_grupo'       =>$item1->cod_grupo
                    ,'grupo'           =>$item1->grupo
                    ,'cod_sub_grupo'   =>$item1->cod_sub_grupo
                    ,'sub_grupo'       =>$item1->sub_grupo
                    ,'cod_familia'     =>$item1->cod_familia
                    ,'familia'         =>$item1->familia
                    ,'un_medida'       =>$item1->un_medida
                    ,'quantidade'      =>$item1->quantidade
                    ,'fat_bruto'       =>$item1->fat_bruto
                    ,'desconto'        =>$item1->desconto
                );
            };

            $retorno[] = array(
                'empresa'       => $item->empresa
                ,'documento'    => $item->documento
                ,'serie_fat'    => $item->serie_fat
                ,'data_comp'    => $item->data_comp
                ,'num_ped'      => $item->num_ped
                ,'cod_cliente'  => $item->cod_cliente
                ,'cliente'      => $item->cliente
                ,'municipio'    => $item->municipio
                ,'estado'       => $item->estado
                ,'cod_rep'      => $item->cod_rep
                ,'representante'=> $item->representante
                ,'cod_vendedor' => $item->cod_vendedor
                ,'vendedor'     => $item->vendedor
                ,'quantidade'   => $item->quantidade
                ,'fat_bruto'    => $item->fat_bruto
                ,'desconto'     => $item->desconto
                ,'item'         => $retorno_item
            );
        }
        return $retorno;
    }
}
