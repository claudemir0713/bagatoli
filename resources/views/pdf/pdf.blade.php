<style>
    table.borda {
        border-collapse: collapse;
        background: #FFF;
        width: 100%;
    }

    table.borda td {
        border-bottom: 1px solid black;
        /* border-left: 1px solid black; */
        padding: 0.20em;
    }

    table.borda th {
        border: 1px solid black;
        padding: 0.20em;
    }
    table tr td:first-child,
    table tr th:first-child {
        border-left: 0;
    }

    table.bordaSimples {
        border-collapse: collapse;
        background: #FFF;
        width: 100%;
    }

    table.bordaSimples td {
        border: 1px solid c3c3c3;
        padding: 0.40em;
    }
    table.bordaSimples th {
        border: 1px solid #c3c3c3;
        padding: 0.40em;
    }

    .fundoCapa{
        background: rgb(233, 117, 117) !important;
    }
    .fontArial{
        font-family: Arial, Helvetica, sans-serif;
    }
    .font7{
        font-size: 7px;
    }
    .font10{
        font-size: 10px;
    }
    .font12{
        font-size: 12px;
    }
    .fundoTh{
        background: #e3e3e3
    }
</style>
<table class="table fontArial font12" width="100%">
    <tr class="">
        <td width="80%"><sup><b><i>Tabloide</i></b></sup> {!! $tabloide->descricao !!}</td>
        <td width="20%" align="rigth"><sup><b><i>Data</i></b></sup> {!! date('d/m/Y',strtotime($tabloide->data)) !!}</td>
    </tr>
</table><hr>
<table class="table bordaSimples fontArial font10" width="100%">
    <thead>
        <tr class="fundoTh">
            <th width='5%'>Capa</th>
            <th width='7%'>Cod Prod</th>
            <th width='10%'>Produto</th>
            <th width='7%'>Cor</th>
            <th width='7%'>Estoque</th>
            <th width='7%'>A vista</th>
            <th width='7%'>Duas Vidas vista</th>
            <th width='7%'>Período</th>
            <th width='7%'>Parcela</th>
            <th width='7%'>Duas Vidas prazo</th>
            <th width='7%'>Total prazo</th>
        </tr>
    </thead>
    <tbody>
        @php  $subGrupo = '@'; @endphp
        @foreach ($tabloideItem as $item )
            @php
                $bgColor = ( $item->capa=='S') ? 'fundoCapa' : ''
            @endphp
            @if($subGrupo != $item->sub_grupo)
                @php $subGrupo = $item->sub_grupo @endphp
                <tr class='fundoTh'>
                    <td colspan="11">
                        {!! $item->departamento.' - '.$item->sub_grupo !!}
                    </td>
                </tr>
            @endif
            <tr class='{{$bgColor}}'>
                <td align="center">{!! $item->capa !!}</td>
                <td >{!! $item->produto_codigo !!}</td>
                <td>{!! $item->produto_nome !!}</td>
                <td>{!! $item->produto_cor !!}</td>
                <td align="right">{!! number_format($item->qtd_estoque,0,',','.') !!}</td>
                <td align="right">{!! number_format($item->venda_unt,2,',','.') !!}</td>
                <td align="right">{!! number_format($item->vlr_garantia_vista,2,',','.') !!}</td>
                <td align="right">{!! number_format($item->qtd_parcelas,0,',','.') !!}</td>
                <td align="right">{!! number_format($item->valor_parcela_prazo,2,',','.') !!}</td>
                <td align="right">{!! number_format($item->vlr_garantia_prazo,2,',','.') !!}</td>
                <td align="right">{!! number_format($item->totalPrazo,2,',','.') !!}</td>
            </tr>
        @endforeach
    </tbody>
</table>

