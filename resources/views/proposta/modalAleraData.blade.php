<div class="modal fade modalAleraData" id="modalAleraData" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modalAleraDataLabel">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="panel panel-dark">
                <div class="panel-heading bg-dark text-white">
                    <div class="">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="ModalInsercaoLabel">
                            <sup><span class="far fa-calendar"></span></sup>
                            <sup>Altera data da proposta</sup> <span class="md_proposta"></span>
                        </h4>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-md-4">
                        <sup><b>Data processo:</b></sup>
                        <input type="date" step="any" class="form-control fonte-12" id="md_data_processo" name="md_data_processo" autocomplete="off">
                    </div>
                    <div class="form-group col-md-4">
                        <sup><b>Data entrega:</b></sup>
                        <input type="date" step="any" class="form-control fonte-12" id="md_data_entrega_proposta" name="md_data_entrega_proposta" autocomplete="off">
                    </div>
                    <div class="form-group col-md-4">
                        <br>
                        <button type="button" class="btn btn-success btn-sm btn-block" id="md_salvarData" ><i class="fa fa-check"></i>  Salvar</button>
                        <input type="hidden"  id="md_id" name="md_id" autocomplete="off">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
