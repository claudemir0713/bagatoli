@extends('layouts.model')
@section('content')
    <script src="{{ (asset('js/projeto/precificacao.js')) }}"></script>
    <script src="{{ (asset('js/projeto/precificacao_function.js')) }}"></script>

    <div class="row">
        <div class="form-group col-md-6">
            <h3 style="display: inline;"><i class="fas fa-hand-holding-usd"></i> <sup>Proposta</sup></h3>
            <h6 style="display: inline;">    <b><i>{{str_pad($proposta->id, 4 , '0' , STR_PAD_LEFT)}}</i> - {{$cliente->cliente}}</b></h6>
        </div>
        <div class="form-group col-md-3">
            Empresa:
            <select class="form-control alteraEmpresa" id="empresa" name="empresa">
                <option value="">Selecione</option>
                @foreach ($empresa as $item )
                    <option value="{{$item->id}}" {{($item->id == $proposta->empresa_id)?'selected':''}}>{{$item->razao}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group col-md-1">
            Prazo (dias):
            <input type="number" step="1" min="0"  class="form-control direita fonte-9 precoVendaForEach" id="prazoMedio" name="prazoMedio" value="30">
        </div>
        <div class="form-group col-md-1">
            Tx:
            <input type="number" step="1" min="0"  class="form-control direita fonte-9 precoVendaForEach" id="taxa_financeira" name="taxa_financeira" value="{{($proposta->taxa_financeira)?$proposta->taxa_financeira : (($empresa_parametro) ? $empresa_parametro->taxa_financeira : 0.5) }}">
        </div>

    </div>
    <hr>
    <form action=""  id="cadastro-precificacao"  method="post">
        @csrf
        @method('patch')

        <input type="hidden" name="route" id="route" value="/precificacao/editPrecificacao/{{$proposta->id}}">
        <input type="hidden" name="proposta_id" id="proposta_id" value="{{$proposta->id}}">
        <input type="hidden" name="type" id="type" value="PATCH">
        <input type="hidden" name="origem" id="origem" value="precificacao">
        <input type="hidden" name="retornoUrl" id="retornoUrl" value="?precificacao={{session('dateForm.precificacao')}}">
        <input type="hidden" name="controla_preco_minimo" id="controla_preco_minimo" value="{{$licitacao_tipo->controla_preco_minimo}}">

        <div class="row">
            <div class="form-group col-md-12" style="overflow: auto; height: 400px; width: 100%">
                <table class="table table-borderless table-advance table-striped  table-condensed fonte-8" id="tbItem">
                    <thead>
                        <tr class="fonte-10">
                            <th width="2%">Item</th>
                            <th width="6%">Descrição</th>
                            <th width="5%">Qtd</th>
                            <th width="5%">R$ unt</th>
                            <th width="5%">R$ total</th>
                            <th width="8%">R$ custo</th>
                            <th width="6%">% Imp.Cust</th>
                            <th width="6%">% Imp.Vend</th>
                            <th width="6%">% Difal</th>
                            <th width="6%">% Ir/Csl</th>
                            <th width="6%">% Outros</th>
                            <th width="6%">% Comis.</th>
                            <th width="6%">% Frete</th>
                            <th width="6%">% Desp.Fix</th>
                            <th width="6%">% Marg</th>
                            <th width="8%">R$ Venda</th>
                        </tr>
                    </thead>
                    @php
                        $lote = '';
                    @endphp
                    <tbody id="sectionItem">
                        @foreach ($proposta_item as $item )
                            @php
                                $imposto_custo      = 12;
                                $total_custo        = 0;
                                $imposto_venda      = 0;
                                $ir_csll            = 0;
                                $difal              = 0;
                                $outros             = 0;
                                $comissao           = 0;
                                $frete              = 0;
                                $despesa_fixa       = 0;
                                $margem             = 0;
                                $vlrVenda           = 0;
                                $cssFundoLinha      = '';
                                $cssFundoMargem     = '';


                                if($empresa_parametro){
                                    $icms               = ($empresa_parametro->icms)        ? $empresa_parametro->icms          : 0;
                                    $pis                = ($empresa_parametro->pis)         ? $empresa_parametro->pis           : 0;
                                    $cofins             = ($empresa_parametro->cofins)      ? $empresa_parametro->cofins        : 0;
                                    $simples            = ($empresa_parametro->simples)     ? $empresa_parametro->simples       : 0;
                                    $ir_csll            = ($empresa_parametro->ir_csll)     ? $empresa_parametro->ir_csll       : 0;
                                    $difal              = ($empresa_parametro->difal)       ? $empresa_parametro->difal         : 0;
                                    $outros             = ($empresa_parametro->outros)      ? $empresa_parametro->outros        : 0;
                                    $comissao           = ($empresa_parametro->comissao)    ? $empresa_parametro->comissao      : 0;
                                    $frete              = ($empresa_parametro->frete)       ? $empresa_parametro->frete         : 0;
                                    $despesa_fixa       = ($empresa_parametro->despesa_fixa)? $empresa_parametro->despesa_fixa  : 0;
                                    $margem             = ($empresa_parametro->margem)      ? $empresa_parametro->margem        : 0;
                                    $imposto_venda      = $icms+$pis+$cofins+$simples;
                                }

                                if($item){
                                    $total_custo = $item->total_custo;
                                    $imposto_venda = $item->impostos_venda;
                                    $ir_csll = $item->ir_csll;
                                    $difal = $item->difal;
                                    $outros = $item->outros;
                                    $imposto_custo = $item->impostos_credito;
                                    $comissao = $item->comissao;
                                    $frete = $item->frete;
                                    $despesa_fixa = $item->despesa_fixa;
                                    $margem = $item->margem;
                                    $vlrVenda = $item->total_venda;
                                };

                                $total_custo        = number_format($total_custo,2,',','.');
                                $imposto_venda      = number_format($imposto_venda,2,',','.');
                                $ir_csll            = number_format($ir_csll,2,',','.');
                                $difal              = number_format($difal,2,',','.');
                                $outros             = number_format($outros,2,',','.');
                                $imposto_custo      = number_format($imposto_custo,2,',','.');
                                $comissao           = number_format($comissao,2,',','.');
                                $frete              = number_format($frete,2,',','.');
                                $despesa_fixa       = number_format($despesa_fixa,2,',','.');
                                $margem             = number_format($margem,2,',','.');
                                $vlrVenda           = number_format($vlrVenda,2,',','.');

                                if($item->total_venda>=$item->total_edital){
                                    $cssFundoLinha = 'fundoAmarelo';
                                }

                                if($licitacao_tipo->controla_preco_minimo == 'N'){$cssFundoLinha ='';};

                                if($item->margem<=0){
                                    $cssFundoMargem = 'fundoVermelho';
                                }


                            @endphp
                            @if($lote!=$item->lote && trim($item->lote)!='')
                                <tr class="fonte-10">
                                    <td colspan="16" bgcolor="#c3c3c3">{{$item->lote_descricao}}</td>
                                </tr>
                                @php $lote=$item->lote @endphp
                            @endif
                            <tr id="linhaPrecificacao{{$item->id}}" class="{{$cssFundoLinha}}">
                                <td>{{$item->id}}</td>
                                <td>{{$item->produto}}</td>
                                <td align="right">{{number_format($item->qtd,2,',','.')}}</td>
                                <td align="right">{{number_format($item->unt_edital,2,',','.')}}</td>
                                <td align="right">{{number_format($item->total_edital,2,',','.')}}</td>
                                <td><input type="text" class="form-control fonte-8 direita calc_pre_venda"                  id="total_custo{{$item->id}}"     name="total_custo[]"    value="{{$total_custo}}"></td>
                                <td><input type="text" class="form-control fonte-8 direita calc_pre_venda"                  id="imposto_custo{{$item->id}}"   name="imposto_custo[]"  value="{{$imposto_custo}}"></td>
                                <td><input type="text" class="form-control fonte-8 direita calc_pre_venda imposto_venda"    id="imposto_venda{{$item->id}}"   name="imposto_venda[]"  value="{{$imposto_venda}}"></td>
                                <td><input type="text" class="form-control fonte-8 direita calc_pre_venda difal"            id="difal{{$item->id}}"           name="difal[]"          value="{{$difal}}"></td>
                                <td><input type="text" class="form-control fonte-8 direita calc_pre_venda ir_csll"          id="ir_csll{{$item->id}}"         name="ir_csll[]"        value="{{$ir_csll}}"></td>
                                <td><input type="text" class="form-control fonte-8 direita calc_pre_venda outros"           id="outros{{$item->id}}"          name="outros[]"         value="{{$outros}}"></td>
                                <td><input type="text" class="form-control fonte-8 direita calc_pre_venda comissao"         id="comissao{{$item->id}}"        name="comissao[]"       value="{{$comissao}}"></td>
                                <td><input type="text" class="form-control fonte-8 direita calc_pre_venda frete"            id="frete{{$item->id}}"           name="frete[]"          value="{{$frete}}"></td>
                                <td><input type="text" class="form-control fonte-8 direita calc_pre_venda despesa_fixa"     id="despesa_fixa{{$item->id}}"    name="despesa_fixa[]"   value="{{$despesa_fixa}}"></td>
                                <td><input type="text" class="form-control fonte-8 direita calc_pre_venda margem {{$cssFundoMargem}}"           id="margem{{$item->id}}"          name="margem[]"         value="{{$margem}}"></td>
                                <td>
                                    <input type="text" class="form-control fonte-8 direita calc_pre_venda_valor" id="vlrVenda{{$item->id}}" name="vlrVenda[]" value="{{$vlrVenda}}">
                                    <input type="hidden" class="form-control fonte-8 direita" id="qtd{{$item->id}}" name="qtd[]" value="{{number_format($item->qtd,2,',','.')}}">
                                    <input type="hidden" class="form-control fonte-8 direita" id="total_edital{{$item->id}}" name="total_edital[]" value="{{number_format($item->total_edital,2,',','.')}}">
                                    <input type="hidden" class="form-control fonte-8 direita" id="id{{$item->id}}" name="id[]" value="{{$item->id}}">
                                </td>
                            </tr>
                            <tr>
                                <td colspan="16">
                                    {{$item->descricao}}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
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
    </script>

@endsection
