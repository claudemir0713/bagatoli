@extends('layouts.model')

@section('content')
    <script src="{{ (asset('js/projeto/cliente.js')) }}"></script>

    <h3 class=""><i class="fas fa-users"></i> Cliente</h3>
    <form action="" id="cadastro-cliente" nome="cadastro-cliente" method="post">
        @csrf
        @method('patch')
        <input type="hidden" name="route" id="route" value="/cliente/store">
        <input type="hidden" name="type" id="type" value="POST">
        <input type="hidden" name="origem" id="origem" value="cliente">
        <input type="hidden" name="retornoUrl" id="retornoUrl" value="?cliente={{session('dateForm.cliente')}}"">


        <div class="row">
            <div class="form-group col-md-12">
                <div class="card">
                    <h5 class="card-header" align="center"><sup>🏛</sup> Dados Gerais</h5>
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-2">
                                Pessoa:*
                                <select class="form-control limpar" id="pessoa" name="pessoa" required>
                                    <option value="">Selecione</option>
                                    <option value="F">Física</option>
                                    <option value="J">Jurídica</option>
                                    <option value="E">Exterior</option>
                                    <option value="FE">Exterior Física</option>
                                    <option value="JE">Exterior Jurídica</option>
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                Cpf/Cnpj:
                                <input class="form-control limpar fonte-10 cnpj" type="text" id="cnpj" name="cnpj" value="" >
                            </div>
                            <div class="form-group col-md-3 IE">
                                I.E.:
                                <input class="form-control limpar fonte-10" type="text" id="IE" name="IE" value="" >
                            </div>
                            <div class="form-group col-md-2 contribuinte_icms">
                                Contribuinte do ICMS:
                                <select class="form-control limpar fonte-10" id="contribuinte_icms" name="contribuinte_icms" >
                                    <option value="">Selecione</option>
                                    <option value="S">Sim</option>
                                    <option value="N">Não</option>
                                </select>
                            </div>
                            <div class="form-group col-md-2 contribuinte_icms">
                                Optante Simples Nacional:
                                <select class="form-control limpar fonte-10" id="simples_nascional" name="simples_nascional" >
                                    <option value="">Selecione</option>
                                    <option value="S">Sim</option>
                                    <option value="N">Não</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12">
                                Cliente:*
                                <input class="form-control limpar fonte-10" type="text" id="cliente" name="cliente" value="" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-2">
                                CEP:
                                <input class="form-control limpar fonte-10" type="text" id="Cep" name="Cep" value="" >
                            </div>
                            <div class="form-group col-md-3">
                                Endereço:
                                <input class="form-control limpar fonte-10" type="text" id="endereco" name="endereco" value="" >
                            </div>
                            <div class="form-group col-md-3">
                                Bairro:
                                <input class="form-control limpar fonte-10" type="text" id="bairro" name="bairro" value="" >
                            </div>
                            <div class="form-group col-md-3">
                                Cidade:
                                <input class="form-control limpar fonte-10" type="text" id="cidade" name="cidade" value="" >
                            </div>
                            <div class="form-group col-md-2">
                                Uf:
                                <input class="form-control limpar fonte-10" type="text" id="uf" name="uf" value="" >
                            </div>
                            <div class="form-group col-md-3">
                                Contato:
                                <input class="form-control limpar fonte-10" type="text" id="contato" name="contato" value="" >
                            </div>
                            <div class="form-group col-md-3">
                                Telefone:
                                <input class="form-control limpar fonte-10" type="text" id="telefone" name="telefone" value="" >
                            </div>
                            <div class="form-group col-md-3">
                                Celular:
                                <input class="form-control limpar fonte-10" type="text" id="celular" name="celular" value="" >
                            </div>
                            <div class="form-group col-md-12">
                                Email:
                                <input class="form-control limpar fonte-10" type="text" id="email" name="email" value="" >
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-12">
                <div class="card">
                    <h5 class="card-header" align="center"><sup>👥</sup>  Dados Pessoais do Repesentante Legal</h5>
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-4">
                                Nome:
                                <input class="form-control limpar fonte-10" type="text" id="contato" name="contato" value="" >
                            </div>
                            <div class="form-group col-md-4">
                                Nacionalidade:
                                <input class="form-control limpar fonte-10" type="text" id="nascionalidade" name="nascionalidade" value="" >
                            </div>
                            <div class="form-group col-md-4">
                                Estado Civil:
                                <input class="form-control limpar fonte-10" type="text" id="contato_estado_civil" name="contato_estado_civil" value="" >
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                Profiss.:
                                <input class="form-control limpar fonte-10" type="text" id="contato_profissao" name="contato_profissao" value="" >
                            </div>
                            <div class="form-group col-md-4">
                                CPF:
                                <input class="form-control limpar fonte-10" type="text" id="contato_cpf" name="contato_cpf" value="" >
                            </div>
                            <div class="form-group col-md-4">
                                RG:
                                <input class="form-control limpar fonte-10" type="text" id="contato_rg" name="contato_rg" value="" >
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12">
                                Ender.Completo:
                                <input class="form-control limpar fonte-10" type="text" id="contato_endereco" name="contato_endereco" value="" >
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-md-2">
                <button type="submit" name="salvar" value="" id="salvar" class="btn btn-success btn-sm btn-block">
                    <span class="fas fa-save"></span> Salvar
                </button>
            </div>
                <div class="form-group col-md-2">
                    <button type="button" name="sair" id="sair" value="" class="btn btn-danger btn-sm btn-block">
                        <span class="fa fa-door-open"></span> Sair
                    </button>
                </div>
            </div>
        </div>
    </form>
    <script>
        $(document).ready(function(){
            let retornoUrl = $(document).find('#retornoUrl').val();
            $('button#sair').click(function(){
                $(location).attr('href',url+'/cliente'+retornoUrl);
            })
        })
    </script>
@endsection
