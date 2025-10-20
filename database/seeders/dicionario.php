<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Seeder;

class dicionario extends Seeder
{

    public function run()
    {
        DB::table('dicionario')->insert([
            ['descricao'=>'Código do processo'					, 'tag'=>'#Processo#'],
            ['descricao'=>'Codigo de Barras'					, 'tag'=>'#CodigoBarras#'],
            ['descricao'=>'Data da abertura do processo'		, 'tag'=>'#DataAbertura#'],
            ['descricao'=>'Status'								, 'tag'=>'#status#'],
            ['descricao'=>'Nome do Cliente'						, 'tag'=>'#Cliente#'],
            ['descricao'=>'Cpf/Cnpj do cliente'					, 'tag'=>'#CpfCnpj#'],
            ['descricao'=>'Nr da nota'							, 'tag'=>'#Nota#'],
            ['descricao'=>'imei'								, 'tag'=>'#imei#'],
            ['descricao'=>'Descrição do Defeito'				, 'tag'=>'#Defeito#'],
            ['descricao'=>'Telefone de contato'					, 'tag'=>'#telefoneContato#'],
            ['descricao'=>'Etapa'								, 'tag'=>'#Etapa#'],
            ['descricao'=>'Dias para execução da etapa'			, 'tag'=>'#DiasEtapa#'],
            ['descricao'=>'Data de vencimento da etapa'			, 'tag'=>'#DtVencimentoEtapa#'],
            ['descricao'=>'Data prevista para entrega'			, 'tag'=>'#DtPrevistaEntrega#'],
            ['descricao'=>'Data prevista inicialmente'			, 'tag'=>'#DtInicialPrevista#'],
            ['descricao'=>'Data da etapa'						, 'tag'=>'#DtEtapa#'],
            ['descricao'=>'Responsavel'							, 'tag'=>'#Responsavel#'],
            ['descricao'=>'Tabela documentos'					, 'tag'=>'#tabelaDocumentos#'],
            ['descricao'=>'Tabela etapas'						, 'tag'=>'#tabelaEtapas#'],
            ['descricao'=>'Filial de movimento'					, 'tag'=>'#Filial#'],
            ['descricao'=>'Data da compra'						, 'tag'=>'#DataCompra#'],
            ['descricao'=>'Produto da nota'						, 'tag'=>'#Produto#'],
            ['descricao'=>'Obs'									, 'tag'=>'#obs#'],
            ['descricao'=>'Serviço Contratado'					, 'tag'=>'#Serviço#'],
            ['descricao'=>'Modelo da nota'						, 'tag'=>'#Modelo#']
        ]);

    }
}
