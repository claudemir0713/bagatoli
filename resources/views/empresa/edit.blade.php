@extends('layouts.model')
@section('content')
    <script src="{{ (asset('js/projeto/empresa.js')) }}"></script>

    <h3 class=""><i class="fas fa-landmark"></i> Empresa</h3><hr>
    <form action=""  id="cadastro-empresa"  method="post">
        @csrf
        @method('patch')

        <input type="hidden" name="route" id="route" value="/empresa/edit/{{$empresa->id}}">
        <input type="hidden" name="type" id="type" value="PATCH">
        <input type="hidden" name="origem" id="origem" value="empresa">
        <input type="hidden" name="retornoUrl" id="retornoUrl" value="?empresa={{session('dateForm.empresa')}}">


        <div class="row">
            <div class="form-group col-md-12">
                <div class="card">
                    <div class="card-header">Dados da Empresa</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-2">
                                <sup><b>Cnpj:</b></sup>
                                <input class="form-control limpar fonte-10 cnpj" type="text" id="cnpjEmp" name="cnpjEmp" value="{{$empresa->cnpj}}" autofocus>
                            </div>
                            <div class="form-group col-md-4">
                                <sup><b>Razão Social:</b></sup>
                                <input class="form-control limpar fonte-10" type="text" id="razao" name="razao" value="{{$empresa->razao}}" >
                            </div>
                            <div class="form-group col-md-4">
                                <sup><b>Nome Fantasia:</b></sup>
                                <input class="form-control limpar fonte-10" type="text" id="fantasia" name="fantasia" value="{{$empresa->fantasia}}" >
                            </div>
                            <div class="form-group col-md-2">
                                <sup><b>I.E:</b></sup>
                                <input class="form-control limpar fonte-10" type="text" id="insc_estadual" name="insc_estadual" value="{{$empresa->insc_estadual}}" >
                            </div>
                            <div class="form-group col-md-2">
                                <sup><b>Insc.Municipal:</b></sup>
                                <input class="form-control limpar fonte-10" type="text" id="insc_municipal" name="insc_municipal" value="{{$empresa->insc_municipal}}" >
                            </div>
                            <div class="form-group col-md-2">
                                <sup><b>Cep:</b></sup>
                                <input class="form-control limpar fonte-10" type="text" id="cep" name="cep" value="{{$empresa->cep}}" >
                            </div>
                            <div class="form-group col-md-4">
                                <sup><b>Endereço:</b></sup>
                                <input class="form-control limpar fonte-10" type="text" id="endereco" name="endereco" value="{{$empresa->endereco}}" >
                            </div>
                            <div class="form-group col-md-3">
                                <sup><b>Bairro:</b></sup>
                                <input class="form-control limpar fonte-10" type="text" id="bairro" name="bairro" value="{{$empresa->bairro}}" >
                            </div>
                            <div class="form-group col-md-3">
                                <sup><b>Cidade:</b></sup>
                                <input class="form-control limpar fonte-10" type="text" id="cidade" name="cidade" value="{{$empresa->cidade}}" >
                            </div>
                            <div class="form-group col-md-2">
                                <sup><b>Uf:</b></sup>
                                <input class="form-control limpar fonte-10" type="text" id="uf" name="uf" value="{{$empresa->uf}}" >
                            </div>
                            <div class="form-group col-md-3">
                                <sup><b>País:</b></sup>
                                <input class="form-control limpar fonte-10" type="text" id="pais" name="pais" value="{{$empresa->pais}}" >
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-md-12">
                <div class="card">
                    <div class="card-header">Representante Legal</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-3">
                                <sup><b>Nome:</b></sup>
                                <input class="form-control limpar fonte-10" type="text" id="representante_legal" name="representante_legal" value="{{$empresa->representante_legal}}" >
                            </div>
                            <div class="form-group col-md-2">
                                <sup><b>Cpf:</b></sup>
                                <input class="form-control limpar fonte-10" type="text" id="cpf" name="cpf" value="{{$empresa->cpf}}" >
                            </div>
                            <div class="form-group col-md-2">
                                <sup><b>RG:</b></sup>
                                <input class="form-control limpar fonte-10" type="text" id="rg" name="rg" value="{{$empresa->rg}}" >
                            </div>
                            <div class="form-group col-md-3">
                                <sup><b>Cargo:</b></sup>
                                <input class="form-control limpar fonte-10" type="text" id="cargo" name="cargo" value="{{$empresa->cargo}}" >
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-md-12">
                <div class="card">
                    <div class="card-header">Tributação</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-2">
                                <sup><b>Regime:</b></sup>
                                <Select class="form-control" id="regime_tributario" name="regime_tributario">
                                    <option value=""></option>
                                    <option value="Simples Nacional" {{($empresa->regime_tributario == 'Simples Nacional')? 'selected' : ''}}>Simples Nacional</option>
                                    <option value="Lucro Presumido" {{($empresa->regime_tributario == 'Lucro Presumido')? 'selected' : ''}}>Lucro Presumido</option>
                                    <option value="Lucro Real" {{($empresa->regime_tributario == 'Lucro Real')? 'selected' : ''}}>Lucro Real</option>
                                </Select>
                            </div>
                            <div class="form-group col-md-2">
                                <sup><b>Icms (%):</b></sup>
                                <input class="form-control limpar fonte-10 direita" type="number" step="any"  id="icms" name="icms" value="{{ ($parametros) ? $parametros->icms : 0 }}" >
                            </div>
                            <div class="form-group col-md-2">
                                <sup><b>Simples (%):</b></sup>
                                <input class="form-control limpar fonte-10 direita" type="number" step="any"  id="simples" name="simples" value="{{ ($parametros) ? $parametros->simples : 0 }}" >
                            </div>
                            <div class="form-group col-md-2">
                                <sup><b>Pis (%):</b></sup>
                                <input class="form-control limpar fonte-10 direita" type="number" step="any"  id="pis" name="pis" value="{{ ($parametros) ? $parametros->pis : 0 }}" >
                            </div>
                            <div class="form-group col-md-2">
                                <sup><b>Cofins (%):</b></sup>
                                <input class="form-control limpar fonte-10 direita" type="number" step="any"  id="cofins" name="cofins" value="{{ ($parametros) ? $parametros->cofins : 0 }}" >
                            </div>
                            <div class="form-group col-md-2">
                                <sup><b>Ir/Csll:</b></sup>
                                <input class="form-control limpar fonte-10 direita" type="number" step="any"  id="ir_csll" name="ir_csll" value="{{ ($parametros) ? $parametros->ir_csll : 0 }}" >
                            </div>
                            <div class="form-group col-md-2">
                                <sup><b>Difal (%):</b></sup>
                                <input class="form-control limpar fonte-10 direita" type="number" step="any"  id="difal" name="difal" value="{{ ($parametros) ? $parametros->difal : 0 }}" >
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-md-12">
                <div class="card">
                    <div class="card-header">Parâmetros para Markup</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-2">
                                <sup><b>Despesa Fixa (%):</b></sup>
                                <input class="form-control limpar fonte-10 direita" type="number" step="any" id="despesa_fixa" name="despesa_fixa" value="{{ ($parametros) ? $parametros->despesa_fixa : 0 }}" >
                            </div>
                            <div class="form-group col-md-2">
                                <sup><b>Frete (%):</b></sup>
                                <input class="form-control limpar fonte-10 direita" type="number" step="any"  id="frete" name="frete" value="{{ ($parametros) ? $parametros->frete : 0 }}" >
                            </div>
                            <div class="form-group col-md-2">
                                <sup><b>Comissão (%):</b></sup>
                                <input class="form-control limpar fonte-10 direita" type="number" step="any"  id="comissao" name="comissao" value="{{ ($parametros) ? $parametros->comissao : 0 }}" >
                            </div>
                            <div class="form-group col-md-2">
                                <sup><b>Outros (%):</b></sup>
                                <input class="form-control limpar fonte-10 direita" type="number" step="any"  id="outros" name="outros" value="{{ ($parametros) ? $parametros->outros : 0 }}" >
                            </div>
                            <div class="form-group col-md-2">
                                <sup><b>Taxa Finan. (%):</b></sup>
                                <input class="form-control limpar fonte-10 direita" type="number" step="any" id="taxa_financeira" name="taxa_financeira" value="{{ ($parametros) ? $parametros->taxa_financeira : 0 }}" >
                            </div>
                            <div class="form-group col-md-2">
                                <sup><b>Margem (%):</b></sup>
                                <input class="form-control limpar fonte-10 direita" type="number" step="any"  id="margem" name="margem" value="{{ ($parametros) ? $parametros->margem : 0 }}" >
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="form-group col-md-2">
                <button type="submit" name="sair"  class="btn btn-success btn-block">
                    <span class="fas fa-save"></span> Salvar
                </button>
            </div>
                <div class="form-group col-md-2">
                    <button type="button" name="sair" id="sair" value="" class="btn btn-danger btn-block">
                        <span class="fa fa-door-open"></span> Sair
                    </button>
                </div>
            </div>
        </div>
    </form>

    <script>
        $(document).ready(function(){
            let retornoUrl = $(document).find('#retornoUrl').val();
            let origem = $(document).find('#origem').val();
            $('button#sair').click(function(){
                $(location).attr('href',url+'/'+origem+retornoUrl);
            })
        })

    </script>

@endsection
