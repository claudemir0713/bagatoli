<?php

namespace App\Http\Controllers\cliente;

use App\Http\Controllers\Controller;
use App\Models\cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use Illuminate\Pagination\Paginator;
Paginator::useBootstrap();

class clienteController extends Controller
{
    public function listAll(Request $request){
        $dateForm = $request->except('_token');
        $filtros = [];
        session()->put('cliente', '');
        if(array_key_exists('cliente',$dateForm)){
            if($dateForm['cliente']){
                $filtros[]=['cliente.cliente','like',$dateForm['cliente'].'%'];
                session()->put('cliente', $dateForm['cliente']);
            }
        };
        session()->put('dateForm',$dateForm);
        $clientes = cliente::where($filtros)->orderBy('cliente')->select(['id','cliente'])->paginate(7);
        return view('cliente.listAll', compact('clientes','dateForm'));
    }

    public function formAdd(){
        return view('cliente.add');
    }

    public function store(Request $request)
    {
        try{

            $cliente = new cliente([
                'cliente'               => $request->cliente
                , 'cpf_cnpj'            => $request->cnpj
                , 'pessoa'              => $request->pessoa
                , 'IE'                  => $request->IE
                , 'contribuinte_icms'   => $request->contribuinte_icms
                , 'simples_nascional'   => ($request->simples_nascional)? $request->simples_nascional : 'N'
                , 'endereco'            => $request->endereco
                , 'bairro'              => $request->bairro
                , 'cidade'              => $request->cidade
                , 'cep'                 => $request->cep
                , 'uf'                  => $request->uf
                , 'contato'             => $request->contato
                , 'telefone'            => $request->telefone
                , 'celular'             => $request->celular
                , 'email'               => $request->email
                , 'contato'             => $request->contato
                , 'contato_estado_civil'=> $request->contato_estado_civil
                , 'contato_profissao'   => $request->contato_profissao
                , 'contato_cpf'         => $request->contato_cpf
                , 'contato_rg'          => $request->contato_rg
                , 'contato_endereco'    => $request->contato_endereco
                , 'nascionalidade'      => $request->nascionalidade
            ]);
            $cliente->save();
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

    public function formEdit($cliente)
    {
        $cliente = cliente::where('id',$cliente)->first();
        return view('cliente.edit',compact('cliente'));
    }

    public function edit($cliente, Request $request)
    {
        try{
            $cliente = cliente::find($cliente);
            $cliente->pessoa                = $request->pessoa;
            $cliente->cpf_cnpj              = $request->cnpj;
            $cliente->IE                    = $request->IE;
            $cliente->contribuinte_icms     = $request->contribuinte_icms;
            $cliente->simples_nascional     = $request->simples_nascional;
            $cliente->cliente               = $request->cliente;
            $cliente->cep                   = $request->cep;
            $cliente->endereco              = $request->endereco;
            $cliente->bairro                = $request->bairro;
            $cliente->cidade                = $request->cidade;
            $cliente->uf                    = $request->uf;
            $cliente->contato               = $request->contato;
            $cliente->telefone              = $request->telefone;
            $cliente->celular               = $request->celular;
            $cliente->email                 = $request->email;
            $cliente->contato               = $request->contato;
            $cliente->contato_estado_civil  = $request->contato_estado_civil;
            $cliente->contato_profissao     = $request->contato_profissao;
            $cliente->contato_cpf           = $request->contato_cpf;
            $cliente->contato_endereco      = $request->contato_endereco;
            $cliente->contato_rg            = $request->contato_rg;
            $cliente->nascionalidade        = $request->nascionalidade;
            $cliente->save();
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


    public function verificaNaBase(Request $request)
    {
        $cliente = cliente::where('cpf_cnpj',$request->cnpj)->count();
        return $cliente;
    }
}
