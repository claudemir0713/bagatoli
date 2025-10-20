<div class="modal fade ModalItem" id="ModalItem" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="ModalItemLabel">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="panel panel-info">
                <div class="panel-heading bg-info text-white">
                    <div class="">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="ModalInsercaoLabel">
                            <span class="fas fa-shopping-cart"></span>
                            Item:
                        </h4>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <form>
                    @csrf
                    <div class="row">
                        <div class="form-group col-md-2">
                            <sup><b>Lote:</b></sup>
                            <input type="text" class="form-control fonte-12" id="md_lote" name="md_lote">
                        </div>
                        <div class="form-group col-md-3">
                            <sup><b>Lote descrição:</b></sup>
                            <input type="text" class="form-control fonte-12" id="md_lote_descricao" name="md_lote_descricao">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-2">
                            <sup><b>Item:</b></sup>
                            <input type="number" step="any" class="form-control fonte-12" id="md_seq" name="md_seq">
                        </div>
                        <div class="form-group col-md-2">
                            <sup><b>Cod Produto:</b></sup>
                            <input type="text" class="form-control fonte-12 localizaProduto" id="md_cod_produto" name="md_cod_produto">
                        </div>
                        <div class="form-group col-md-4">
                            <sup><b>Produto:</b></sup>
                            <input type="text" class="form-control fonte-12" id="md_produto" name="md_produto">
                        </div>
                        <div class="form-group col-md-2">
                            <sup><b>Marca:</b></sup>
                            <input type="text" class="form-control fonte-12" id="md_marca" name="md_marca">
                        </div>
                        <div class="form-group col-md-2">
                            <sup><b>Modelo:</b></sup>
                            <input type="text" class="form-control fonte-12" id="md_modelo" name="md_modelo">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-2">
                            <sup><b>Qtd:</b></sup>
                            <input type="text" class="form-control fonte-12 direita calc_total_md calc_custo_md" id="md_qtd" name="md_qtd">
                        </div>
                        <div class="form-group col-md-2">
                            <sup><b>Und:</b></sup>
                            <input type="text" class="form-control fonte-12" id="md_und" name="md_und">
                        </div>
                        <div class="form-group col-md-2">
                            <sup><b>R$ unt:</b></sup>
                            <input type="text" class="form-control fonte-12 direita calc_total_md" id="md_unt_edital" name="md_unt_edital">
                        </div>
                        <div class="form-group col-md-2">
                            <sup><b>R$ Total:</b></sup>
                            <input type="text" class="form-control fonte-12 direita" id="md_total_edital" name="md_total_edital">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-2">
                            <sup><b>Custo Unt:</b></sup>
                            <input type="text" class="form-control fonte-12 direita calc_custo_md" id="md_unt_custo" name="md_unt_custo">
                        </div>
                        <div class="form-group col-md-2">
                            <sup><b>Custo Total:</b></sup>
                            <input type="text" class="form-control fonte-12 direita" id="md_total_custo" name="md_total_custo">
                        </div>
                        <div class="form-group col-md-2">
                            <sup><b>Frete compra:</b></sup>
                            <input type="text" class="form-control fonte-12 direita" id="md_frete_custo" name="md_frete_custo">
                        </div>
                        <div class="form-group col-md-2">
                            <sup><b>Icms %:</b></sup>
                            <input type="text" class="form-control fonte-12 direita" id="md_impostos_credito" name="md_impostos_credito">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <sup><b>Descrição do Edital:</b></sup>
                            <textarea  class="form-control limpar fonte-10" id="md_descricao" name="md_descricao" rows="4"></textarea>
                        </div>
                        <div class="form-group col-md-6">
                            <sup><b>Obs:</b></sup>
                            <textarea  class="form-control limpar fonte-10" id="md_obs" name="md_obs" rows="4"></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="form-group col-md-2">
                    <button type="button" class="btn btn-success btn-block" id="md_addItem" ><i class="fa fa-check"></i>  Inserir</button>
                </div>
            </div>
        </div>
    </div>
</div>

