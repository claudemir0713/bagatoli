<?php

namespace Database\Seeders;

use App\Models\menu;
use Ramsey\Uuid\Uuid;
use GuzzleHttp\Promise\Create;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        menu::truncate();
        $menus=[
            [

                'ordem'        =>'01.000'
                , 'descricao'   =>'Cadastros'
                , 'tipo'        =>'Título'
                , 'rota'        =>''
                , 'icone'       =>''
            ],
            [

                'ordem'         =>'01.001'
                , 'descricao'   =>'Menu'
                , 'tipo'        =>'Link'
                , 'rota'        =>'menu.listAll'
                , 'icone'       =>'fa fa-list'
            ],
            [
                'ordem'         =>'01.002'
                , 'descricao'   =>'Menu Usuário'
                , 'tipo'        =>'Link'
                , 'rota'        =>'menu.menuUsuario'
                , 'icone'       =>'fas fa-user-cog'
            ],
            [
                'ordem'         =>'01.003'
                , 'descricao'   =>'Empresa'
                , 'tipo'        =>'Link'
                , 'rota'        =>'empresa.listAll'
                , 'icone'       =>'fas fa-landmark'
            ],
            [
                'ordem'         =>'01.004'
                , 'descricao'   =>'Cliente'
                , 'tipo'        =>'Link'
                , 'rota'        =>'cliente.listAll'
                , 'icone'       =>'fas fa-users'
            ],
            [
                'ordem'         =>'02.000'
                , 'descricao'   =>'Movimento'
                , 'tipo'        =>'Título'
                , 'rota'        =>''
                , 'icone'       =>''
            ],
            [
                'ordem'         =>'02.001'
                , 'descricao'   =>'Cad.Proposta'
                , 'tipo'        =>'Link'
                , 'rota'        =>'proposta.listAll'
                , 'icone'       =>'fas fa-tags'
            ],
            [
                'ordem'         =>'02.002'
                , 'descricao'   =>'Precificação'
                , 'tipo'        =>'Link'
                , 'rota'        =>'proposta.listAll'
                , 'icone'       =>'fas fa-hand-holding-usd'
            ],
            [
                'ordem'         =>'02.003'
                , 'descricao'   =>'Consulta'
                , 'tipo'        =>'Link'
                , 'rota'        =>'proposta.listAll'
                , 'icone'       =>'fas fa-file-invoice-dollar'
            ],
            [
                'ordem'         =>'02.004'
                , 'descricao'   =>'Finaliza'
                , 'tipo'        =>'Link'
                , 'rota'        =>'proposta.listAll'
                , 'icone'       =>'fas fa-stamp'
            ],
        ];
        menu::insert($menus);
    }
}
