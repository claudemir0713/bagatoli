@extends('layouts.model')

@section('content')
    <script src="{{ (asset('js/projeto/proposta.js')) }}"></script>
    <script src="{{ (asset('js/projeto/proposta_function.js')) }}"></script>

    <h3 class=""><i class="fas fa-tags"></i> Proposta</h3><hr>
    <form action=""  id="cadastro-proposta"  method="post">
        @csrf

        <input type="hidden" name="route" id="route" value="/proposta/store">
        <input type="hidden" name="type" id="type" value="POST">
        <input type="hidden" name="origem" id="origem" value="proposta">
        <input type="hidden" name="retornoUrl" id="retornoUrl" value="?proposta={{session('dateForm.proposta')}}">

        <div class="row">
            <div class="form-group col-md-1">
                <sup><b>Cliente:</b></sup>
                <input type="text" class="form-control fonte-10 localizaCliente" id="cliente_id" name="cliente_id" required autofocus>
            </div>
            <div class="form-group col-md-3">
                <br>
                <input type="text" class="form-control fonte-10" id="cliente" name="cliente" readonly>
            </div>
            <div class="form-group col-md-2">
                <sup><b>Tipo processo:</b></sup>
                <select class="form-control" id="tipo_licitacao_id" name="tipo_licitacao_id">
                    <option value="">Selecione</option>
                    @foreach ($licitacao_tipo as $item )
                        <option value="{{$item->id}}">{{ $item->descricao}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md-2">
                <sup><b>Data digitação:</b></sup>
                <input class="form-control limpar fonte-10" type="date"  name="data" id="data"  value="{{date('Y-m-d')}}">
            </div>
            <div class="form-group col-md-2">
                <sup><b>Nr Processo:</b></sup>
                <input class="form-control limpar fonte-10" type="text"  name="nr_processo" id="nr_processo"  value="">
            </div>
            <div class="form-group col-md-2">
                <sup><b>Nr pregão:</b></sup>
                <input class="form-control limpar fonte-10" type="text"  name="nr_pregao" id="nr_pregao"  value="">
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-2">
                <sup><b>Data do processo:</b></sup>
                <input class="form-control limpar fonte-10" type="date"  name="data_processo" id="data_processo" value="">
            </div>
            <div class="form-group col-md-2">
                <sup><b>Hora do processo:</b></sup>
                <input class="form-control limpar fonte-10" type="time"  name="hora_processo" id="hora_processo" value="">
            </div>
            <div class="form-group col-md-2">
                <sup><b>Data de entrega da proposta:</b></sup>
                <input class="form-control limpar fonte-10" type="date"  name="data_entrega_proposta" id="data_entrega_proposta" value="">
            </div>
            <div class="form-group col-md-2">
                <sup><b>Hora de entrega da proposta:</b></sup>
                <input class="form-control limpar fonte-10" type="time"  name="hora_entrega_proposta" id="hora_entrega_proposta" value="">
            </div>
            <div class="form-group col-md-6">
                <sup><b>Portal de compras:</b></sup>
                <input class="form-control limpar fonte-10" type="text"  name="portal_de_compras" id="portal_de_compras"  value="">
            </div>
            <div class="form-group col-md-2">
                <sup><b>id do portal:</b></sup>
                <input class="form-control limpar fonte-10" type="text"  name="id_portal_compras" id="id_portal_compras"  value="">
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-12">
                <sup><b>obs:</b></sup>
                <textarea  class="form-control limpar fonte-10" id="obs" name="obs" rows="3"></textarea>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-md-12">
                <div class="card">
                    <button class="btn card-header" type="button" data-toggle="collapse" data-target="#collapseInsumo" aria-expanded="true" aria-controls="collapseInsumo">
                        <h4><b><i>Produto</i></b></h4>
                    </button>
                    <div class="collapse1" id="collapseInsumo" >
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <table class="table table-borderless table-advance table-striped table-condensed fonte-10" id="tbItem">
                                        <thead>
                                            <tr>
                                                <th width="3%">Item</th>
                                                <th width="20%">Descrição</th>
                                                <th width="3%">und</th>
                                                <th width="5%">Qtd Venda</th>
                                                <th width="5%">R$ unt</th>
                                                <th width="5%">R$ total</th>
                                                <th width="5%">unt custo</th>
                                                <th width="5%">R$ custo</th>
                                                <th colspan="1" width="2%">
                                                    <button type="button" name="" id="AbreModalItem" value="" class="btn btn-outline-success fonte-10">
                                                        <span class="fas fa-plus"></span>
                                                    </button>
                                                </th>
                                                <th colspan="1" width="2%">
                                                    <button type="button" name="" id="AbreModalImportaItem" value="" class="btn btn-outline-secondary fonte-10">
                                                        <span class="far fa-file-excel"></span>
                                                    </button>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody id="sectionItem"></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="form-group col-md-3">
                <button type="submit" name="sair"  class="btn btn-success btn-block">
                    <span class="fas fa-save"></span> Salvar
                </button>
            </div>
                <div class="form-group col-md-3">
                    <button type="button" name="sair" id="sair" value="" class="btn btn-danger btn-block">
                        <span class="fa fa-door-open"></span> Sair
                    </button>
                </div>
            </div>
        </div>
    </form>
    @include('proposta.modalItem')
    @include('proposta.modalLocalizaProduto')
    @include('proposta.modalImportaItem')
    @include('proposta.modalLocalizaCliente')

    <script>
        $(document).ready(function(){
            let retornoUrl = $(document).find('#retornoUrl').val();
            let origem = $(document).find('#origem').val();
            $('button#sair').click(function(){
                $(location).attr('href',url+'/'+origem+retornoUrl);
            })
        })

        /******************************** clone Item ******************************/
            // var templateItem = $('#sectionItem .sectionItem:first').clone();
            // templateItem.find("select").val('');
            // templateItem.find(".limpar").val('');

            // var sectionsCountItem = $(document).find('.sectionItem').length;
            // $('body').on('click', '.addsectionItem', function() {
            //     sectionsCountItem++;
            //     templateItem.find(".seq").val(sectionsCountItem);
            //     var section = templateItem.clone().find(':input').each(function(){
            //         var newIdItem = this.id + sectionsCountItem;
            //         $(this).prev().attr('for', newIdItem);
            //         this.id = newIdItem;

            //     }).end()
            //     .appendTo('#sectionItem');
            //     colocaChosen();

            //     return false;
            // });

            $('#sectionItem').on('click', '.removeItem', function() {
                var id = $(this).attr("id").replace(/[^\d]+/g,'');
                var  acao = 'del';
                if($(document).find('.sectionItem'+id).length>1){
                    $(this).parent().fadeOut(300, function(){
                        $(document).find('.sectionItem'+id).remove();
                        return false;
                    })
                }
                return false;
            });

    </script>

@endsection



