<?php

namespace App\Http\Controllers\empresa;

use App\Http\Controllers\Controller;
use App\Models\empresa;
use App\Models\empresa_parametro;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;

Paginator::useBootstrap();

class empresaController extends Controller
{
    public function listAll(Request $request){
        $dateForm = $request->except('_token');
        $filtros=[];
        session()->put('dateForm',$dateForm);

        $empresa = empresa::orderBy('id')->get();
        return view('empresa.listAll',compact('empresa','dateForm'));
    }

    public function formAdd(){
        return view('empresa.add');
    }

    public function formEdit($id){
        $empresa = empresa::find($id);
        $parametros = empresa_parametro::where('empresa_id',$empresa->id)->first();

        return view('empresa.edit',compact('empresa','parametros'));
    }

    public function store(Request $request){
        try{
            $empresa = new empresa([
                'cnpj'                  => $request->cnpj,
                'razao'                 => $request->razao,
                'fantasia'              => $request->fantasia,
                'insc_estadual'         => $request->insc_estadual,
                'insc_municipal'        => $request->insc_municipal,
                'cep'                   => $request->cep,
                'endereco'              => $request->endereco,
                'bairro'                => $request->bairro,
                'cidade'                => $request->cidade,
                'uf'                    => $request->uf,
                'pais'                  => $request->pais,
                'representante_legal'   => $request->representante_legal,
                'cpf'                   => $request->cpf,
                'rg'                    => $request->rg,
                'cargo'                 => $request->cargo,
                'regime_tributario'     => $request->regime_tributario
            ]);
            $empresa->save();
            $empresa_id = $empresa->id;
            $parametros = new empresa_parametro([
                'empresa_id'        => $empresa_id,
                'icms'              => $request->icms,
                'simples'           => $request->simples,
                'pis'               => $request->pis,
                'cofins'            => $request->cofins,
                'ir_csll'           => $request->ir_csll,
                'difal'             => $request->difal,
                'frete'             => $request->frete,
                'despesa_fixa'      => $request->despesa_fixa,
                'comissao'          => $request->comissao,
                'outros'            => $request->outros,
                'taxa_financeira'   => $request->taxa_financeira,
                'margem'            => $request->margem
            ]);
            $parametros->save();



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
                'acao'      => 'atualizar',
                'html'      => 'Cadastro efetuado com sucesso!',
                'timer'     => 1000
            ], 200);

    }

    public function edit(Request $request,$id){
        $empresa = empresa::find($id);
        $parametros = empresa_parametro::where('empresa_id',$empresa->id)->first();
        try{
            $empresa->cnpj                  = $request->cnpj;
            $empresa->razao                 = $request->razao;
            $empresa->fantasia              = $request->fantasia;
            $empresa->insc_estadual         = $request->insc_estadual;
            $empresa->insc_municipal        = $request->insc_municipal;
            $empresa->cep                   = $request->cep;
            $empresa->endereco              = $request->endereco;
            $empresa->bairro                = $request->bairro;
            $empresa->cidade                = $request->cidade;
            $empresa->uf                    = $request->uf;
            $empresa->pais                  = $request->pais;
            $empresa->representante_legal   = $request->representante_legal;
            $empresa->cpf                   = $request->cpf;
            $empresa->rg                    = $request->rg;
            $empresa->cargo                 = $request->cargo;
            $empresa->regime_tributario     = $request->regime_tributario;
            $empresa->save();

            $parametros->icms               = $request->icms;
            $parametros->simples            = $request->simples;
            $parametros->pis                = $request->pis;
            $parametros->cofins             = $request->cofins;
            $parametros->ir_csll            = $request->ir_csll;
            $parametros->difal              = $request->difal;
            $parametros->frete              = $request->frete;
            $parametros->despesa_fixa       = $request->despesa_fixa;
            $parametros->comissao           = $request->comissao;
            $parametros->outros             = $request->outros;
            $parametros->taxa_financeira    = $request->taxa_financeira;
            $parametros->margem             = $request->margem;
            $parametros->save();

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
                'html'      => 'Cadastro efetuado com sucesso!',
                'timer'     => 1000
            ], 200);
    }

    public function destroy($id){

    }

    public function buscaCep(Request $request){
        $cep = $request->get('cep');
        // Remove os caracteres especiais do cep
        $cep = preg_replace('/[^0-9]/', '' , $cep);
        // Faz a chamada na API
        $curl = curl_init();

        $url = "https://viacep.com.br/ws/{$cep}/json/";
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_TIMEOUT, 3);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $json = curl_exec($curl);
        curl_close($curl);
        return response($json);
    }

    /******************** buscaCnpj *******************************************/

    public function buscaCnpj(Request $request){
        $cnpj = $request->get('cnpj');
        $cnpj =  preg_replace('/[^0-9]/', '' , $cnpj);
        $curl = curl_init();

        // $url = "https://www.receitaws.com.br/v1/cnpj/{$cnpj}";
        $url = "https://open.cnpja.com/office/{$cnpj}";


        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_TIMEOUT, 3);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $json = curl_exec($curl);
        $erro = curl_error($curl);

        //dd($json);
        curl_close($curl);

        if ($erro) {
            return response()->json(['erro' => $erro]);
        } else if ($json == 'Too many requests, please try again later.') {
            return response()->json(['erro' => $json]);
        }
        // dd($json);
        return response($json);

    }


}
