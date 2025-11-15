@php
    $version_js = env('VERSAO_JS');
    $version_css = env('VERSAO_CSS');
@endphp

<script src="{{ (asset('js/projeto/cliente.js?v='.$version_js)) }}"></script>
<script src="{{ asset('js/functions.js?v='.$version_js) }}" type="text/javascript"></script>
<script src="{{ asset('js/custom.js?v='.$version_js) }}" type="text/javascript"></script>


<div class="modal fade ModalCadastraCliente" id="ModalCadastraCliente" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="ModalCadastraClienteLabel">
    <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="panel panel-dark">
                <div class="panel-heading bg-dark text-white">
                    <div class="">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="ModalInsercaoLabel">
                            <span class="fas fa-users"></span>
                            Cliente:
                        </h4>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-md-12">
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
                                                    <select class="form-control limpar" id="pessoa" name="pessoa" required autofocus>
                                                        <option value="J">Jurídica</option>
                                                        <option value="F">Física</option>
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
                                                    Optante Simples:
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
                                <div class="form-group col-md-2">
                                    <button type="submit" name="salvar" value="" id="salvar" class="btn btn-success btn-sm btn-block">
                                        <span class="fas fa-save"></span> Salvar
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

