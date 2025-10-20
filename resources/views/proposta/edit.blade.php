@extends('layouts.model')
@section('content')
    <script src="{{ (asset('js/projeto/proposta.js')) }}"></script>
    <script src="{{ (asset('js/projeto/proposta_function.js')) }}"></script>

    <h3 class=""><i class="fas fa-tags"></i> Proposta</h3><hr>
    <form action=""  id="cadastro-proposta"  method="post">
        @csrf
        @method('patch')

        <input type="hidden" name="route" id="route" value="/proposta/edit/{{$proposta->id}}">
        <input type="hidden" name="type" id="type" value="PATCH">
        <input type="hidden" name="origem" id="origem" value="proposta">
        <input type="hidden" name="retornoUrl" id="retornoUrl" value="?proposta={{session('dateForm.proposta')}}">

        <div class="row">
            <div class="form-group col-md-1">
                <sup><b>Cliente:</b></sup>
                <input type="text" class="form-control fonte-10 localizaCliente" id="cliente_id" name="cliente_id" value="{{$proposta->cliente_id}}" required autofocus>
            </div>
            <div class="form-group col-md-3">
                <br>
                <input type="text" class="form-control fonte-10" id="cliente" name="cliente" value="{{$cliente->cliente}}" readonly>
            </div>
            <div class="form-group col-md-2">
                <sup><b>Tipo processo:</b></sup>
                <select class="form-control" id="tipo_licitacao_id" name="tipo_licitacao_id">
                    <option value="">Selecione</option>
                    @foreach ($licitacao_tipo as $item )
                        <option value="{{$item->id}}" {{($item->id==$proposta->tipo_licitacao_id)?'selected':''}}>{{ $item->descricao}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md-2">
                <sup><b>Data digitação:</b></sup>
                <input class="form-control limpar fonte-10" type="date"  name="data" id="data"  value="{{$proposta->data}}">
            </div>
            <div class="form-group col-md-2">
                <sup><b>Nr Processo:</b></sup>
                <input class="form-control limpar fonte-10" type="text"  name="nr_processo" id="nr_processo"  value="{{$proposta->nr_processo}}">
            </div>
            <div class="form-group col-md-2">
                <sup><b>Nr pregão:</b></sup>
                <input class="form-control limpar fonte-10" type="text"  name="nr_pregao" id="nr_pregao"  value="{{$proposta->nr_pregao}}">
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-2">
                <sup><b>Data do processo:</b></sup>
                <input class="form-control limpar fonte-10" type="date"  name="data_processo" id="data_processo" value="{{$proposta->data_processo}}">
            </div>
            <div class="form-group col-md-2">
                <sup><b>Hora do processo:</b></sup>
                <input class="form-control limpar fonte-10" type="time"  name="hora_processo" id="hora_processo" value="{{$proposta->hora_processo}}">
            </div>
            <div class="form-group col-md-2">
                <sup><b>Data de entrega da proposta:</b></sup>
                <input class="form-control limpar fonte-10" type="date"  name="data_entrega_proposta" id="data_entrega_proposta" value="{{$proposta->data_entrega_proposta}}">
            </div>
            <div class="form-group col-md-2">
                <sup><b>Hora de entrega da proposta:</b></sup>
                <input class="form-control limpar fonte-10" type="time"  name="hora_entrega_proposta" id="hora_entrega_proposta" value="{{$proposta->hora_entrega_proposta}}">
            </div>
            <div class="form-group col-md-6">
                <sup><b>Portal de compras:</b></sup>
                <input class="form-control limpar fonte-10" type="text"  name="portal_de_compras" id="portal_de_compras"  value="{{$proposta->portal_de_compras}}">
            </div>
            <div class="form-group col-md-2">
                <sup><b>id do portal:</b></sup>
                <input class="form-control limpar fonte-10" type="text"  name="id_portal_compras" id="id_portal_compras"  value="{{$proposta->id_portal_compras}}">
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-12">
                <sup><b>obs:</b></sup>
                <textarea  class="form-control limpar fonte-10" id="obs" name="obs" rows="3">{{$proposta->obs}}</textarea>
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
                                    <table class="table table-borderless table-advance table-condensed fonte-10" id="tbItem">
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
                                        <tbody id="sectionItem">
                                            @foreach ($proposta_item as $item )
                                                <tr>
                                                    <td>
                                                        <input type="text" class="form-control fonte-10 direita seq" id="seq{{$item->item}}" name="seq[]" value="{{$item->item}}">
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control fonte-10" id="produto{{$item->item}}" name="produto[]" value="{{$item->produto}}">
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control fonte-10" id="und{{$item->item}}" name="und[]" value="{{$item->und}}">
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control fonte-10 direita calc_total calc_custo" id="qtd{{$item->item}}" name="qtd[]" value="{{$item->qtd}}">
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control fonte-10 direita calc_total calc_custo" id="unt_edital{{$item->item}}" name="unt_edital[]" value="{{$item->unt_edital}}">
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control fonte-10 direita" id="total_edital{{$item->item}}" name="total_edital[]" value="{{$item->total_edital}}">
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control fonte-10 direita calc_total calc_custo" id="unt_custo{{$item->item}}" name="unt_custo[]" value="{{$item->unt_custo}}">
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control fonte-10 direita" id="total_custo{{$item->item}}" name="total_custo[]" value="{{$item->total_custo}}">
                                                    </td>
                                                    <td>
                                                        <button type="button" name="delServico[]" id="minusItem{{$item->item}}" value="{{$item->item}}" class="btn btn-outline-danger fonte-10 removeItem"><span class="fas fa-minus"></span></button>
                                                    </td>
                                                </tr>
                                                <tr class="sectionItem1">
                                                    <td colspan="3">
                                                        <textarea type="text" class="form-control fonte-10" id="descricao{{$item->item}}" name="descricao[]">{{$item->descricao}}</textarea>
                                                    </td>
                                                    <td colspan="3">
                                                        <input type="text" class="form-control fonte-10" id="marca{{$item->item}}" name="marca[]" value="{{$item->marca}}">
                                                    </td>
                                                    <td colspan="3">
                                                        <input type="text" class="form-control fonte-10" id="modelo{{$item->item}}" name="modelo[]" value="{{$item->modelo}}">
                                                        <input type="hidden" id="lote{{$item->item}}" name="lote[]" value="{{$item->lote}}">
                                                        <input type="hidden" id="lote_descricao{{$item->item}}" name="lote_descricao[]" value="{{$item->lote_descricao}}">
                                                        <input type="hidden" id="cod_produto{{$item->item}}" name="cod_produto[]" value="{{$item->cod_produto}}">
                                                        <input type="hidden" id="frete_custo{{$item->item}}" name="frete_custo[]" value="{{$item->frete_custo}}">
                                                        <input type="hidden" id="impostos_credito{{$item->item}}" name="impostos_credito[]" value="{{$item->impostos_credito}}">
                                                        <input type="hidden" id="obs_item{{$item->item}}" name="obs_item[]" value="{{$item->obs}}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="10"><hr></td>
                                                </tr>
                                            @endforeach
                                        </tbody>
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
