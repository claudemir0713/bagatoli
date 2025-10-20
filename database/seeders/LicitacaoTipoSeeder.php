<?php

namespace Database\Seeders;

use App\Models\licitacao_tipo;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LicitacaoTipoSeeder extends Seeder
{
    public function run()
    {
        licitacao_tipo::truncate();
        $sql=[
            [
                'descricao'             =>'Pregão'
                , 'ativo'               =>'S'
                ,'controla_preco_minimo'=>'S'
            ],
            [
                'descricao'             =>'Tomada de preço'
                , 'ativo'               =>'S'
                ,'controla_preco_minimo'=>'N'
            ],

        ];
        licitacao_tipo::insert($sql);
    }
}
