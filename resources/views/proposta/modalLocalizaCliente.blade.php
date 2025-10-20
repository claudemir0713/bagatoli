<div class="modal fade ModalLocalizaCliente" id="ModalLocalizaCliente" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="ModalLocalizaClienteLabel">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="panel panel-dark">
                <div class="panel-heading bg-dark text-white">
                    <div class="">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="ModalInsercaoLabel">
                            <span class="fas fa-search"></span>
                            Cliente:
                        </h4>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-md-12">
                        <sup><b>Cliente:</b></sup>
                        <input type="text" step="any" class="form-control fonte-12" id="md_localizaCliente" name="md_localizaCliente" autocomplete="off">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-12">
                        <div style="height: 300px; overflow-y: auto;">
                            <table class="table table-bordered table-condensed fonte-10" id="tbConsultaCliente">
                                <thead>
                                    <th width="10%">Cod</th>
                                    <th width="80%">Nome</th>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

