<?php

namespace App\Http\Controllers\modelo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\modelo;
use App\Models\dicionario;
use Illuminate\Support\Facades\DB;
use App\Helpers\Helper;

class modeloController extends Controller
{
    public function listAllModelo(Request $request ){
        $modelos = modelo::orderBy('descricao')->get();
        return view('modelo.listAllModelo',compact('modelos'));
    }

    public function addModelo(Request $request ){
        $dicionarios = dicionario::orderBy('descricao')->get();
        return view('modelo.addModelo', compact('dicionarios'));
    }

    public function stroreModelo(Request $request){
        try{
            $modelo = new modelo([
                "descricao"     => $request->descricao
                ,"tamanho"      => $request->tamanho
                ,"tipo"         => $request->tipo
                ,"botaoCor"     => $request->botaoCor
                ,"botaoImagem"  => $request->botaoImagem
                ,"modelo"       => $request->modelo
				,"margin_left"	=> $request->margin_left
                ,"margin_rigth"  => $request->margin_rigth
                ,"margin_top"    => $request->margin_top
                ,"margin_bottom" => $request->margin_bottom
                ,"margin_header" => $request->margin_header
                ,"margin_footer" => $request->margin_footer
            ]);
            $modelo->save();
        }catch(\Exception $e){
            return response()->json($modelo);
        }
        return response()->json('success');
    }

    public function formEditModelo($id)
    {
        $modelo = modelo::where('id','=',$id)->first();
        $dicionarios = dicionario::orderBy('descricao')->get();
        return view('modelo.editModelo' , compact('modelo','dicionarios'));
    }

    public function edit($id, Request $request)
    {
        try{
            $modelo = modelo::find($id);
            $modelo->descricao      = $request->descricao;
            $modelo->tamanho	    = $request->tamanho;
            $modelo->tipo	        = $request->tipo;
            $modelo->botaoCor	    = $request->botaoCor;
            $modelo->botaoImagem	= $request->botaoImagem;
            $modelo->modelo		    = $request->modelo;
            $modelo->margin_left	= $request->margin_left;
            $modelo->margin_rigth  	= $request->margin_rigth;
            $modelo->margin_top    	= $request->margin_top;
            $modelo->margin_bottom 	= $request->margin_bottom;
            $modelo->margin_header 	= $request->margin_header;
            $modelo->margin_footer 	= $request->margin_footer;
            $modelo->save();
        }catch(\Exception $e){
            return response()->json($modelo);
        }
        return response()->json('success');
    }


}
