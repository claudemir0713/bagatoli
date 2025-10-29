<head>
    <meta charset="UTF-8">
    {{-- <title>Cotação {{$proposta->id}}</title> --}}

    <style>
        /* 🔹 Estilos compatíveis com mPDF */
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #333;
        }

        h2 {
            text-align: center;
            color: #0d6efd;
            margin-bottom: 15px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th {
            background-color: #0d6efd;
            color: #fff;
            font-weight: bold;
            text-align: center;
            padding: 8px;
            border: 1px solid #ccc;
        }

        td {
            padding: 8px;
            border: 1px solid #ccc;
        }
        /*
        tr:nth-child(even) {
            background-color: #f8f9fa;
        } */

        tr:hover {
            background-color: #e9ecef;
        }

        .table-footer {
            margin-top: 15px;
            text-align: right;
            font-size: 11px;
            color: #555;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 4px;
        }

        input {
            width: 100%;
            padding: 6px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        /* Opcional: simular um card do Bootstrap */
        .card {
            border: 1px solid #ccc;
            border-radius: 8px;
            padding: 10px 15px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        .fonte-7{
            font-size: 7px !important;
        }
        .fonte-8{
            font-size: 8px !important;
        }
    /* ******************bordaSimples**************************** */
    table.bordaSimples {
            border-collapse: collapse;
            background: #FFF;
            width: 100%;
        }
        table.bordaSimples td {
            border: 0px solid #ccc;
            border-bottom: 1px solid #ccc;
            padding: 8px;
        }

    /* ******************semBordas**************************** */
    table.semBordas {
            border-collapse: collapse;
            background: #FFF;
            width: 100%;
        }
        table.semBordas td {
            border: 0px solid #ccc;
            padding: 8px;
        }

    </style>
</head>

<body>
    <table class="bordaSimples fonte-8" width='100%'>
        <tr>
            <td colspan="2" width="50%">
                <sup><b>Cliente:</b></sup> {{$cliente->cliente}}
            </td>
            <td colspan="2" width="50%">
                <sup><b>Cidade:</b></sup> {{$cliente->cidade}}
            </td>
        </tr>
        <tr>
            <td width="25%">
                <sup><b>Processo:</b></sup> {{$proposta->nr_processo}}
            </td>
            <td width="25%">
                <sup><b>Pregão:</b></sup> {{$proposta->nr_pregao}}
            </td>
            <td width="25%">
                <sup><b>Data:</b></sup> {{date('d/m/Y', strtotime($proposta->data))}}
            </td>
            <td width="25%">
                <sup><b>Data entrega:</b></sup> {{date('d/m/Y', strtotime($proposta->data_entrega_proposta))}}  {{$proposta->hora_entrega_proposta}}
            </td>
        </tr>
        <tr>
            <td width="25%">
                <sup><b>Data abertura:</b></sup> {{date('d/m/Y', strtotime($proposta->data_processo))}}  {{$proposta->hora_processo}}
            </td>
            <td colspan="2" width="50%">
                <sup><b>Portal:</b></sup> {{$proposta->portal_compras}}
            </td>
            <td width="25%">
                <sup><b>Id:</b></sup> {{$proposta->id_portal_compras}}
            </td>
        </tr>
        <tr>
            <td colspan="4">
                <sup><b>Obs:</b></sup> {{$proposta->obs}}
            </td>
        </tr>
    </table>

    <table class="table table-borderless fonte-8" width='100%'>
        <thead>
            <tr>
                <th width="5%">Item</th>
                <th width="5%">Cod.Prod</th>
                <th width="60%">Produto</th>
                <th width="10%">Qtd</th>
                <th width="10%">Unt</th>
                <th width="10%">Total</th>
            </tr>
        </thead>
        @php
        @endphp
        {{-- {{dd($proposta_item)}} --}}
        @php
            $lote           = '0';
            $total_venda    = 0;
            $qtd            = 0;
            $qtd_total      = 0;
            $venda_total    = 0;

        @endphp
        <tbody>
            @foreach ($proposta_item as $item )
                @if($lote!=$item->lote)
                    @if ($lote!='0' && $lote!='')
                        <tr bgcolor="#e3e3e3">
                            <td colspan="3"><b>TOTAL {{strtoupper($lote)}}</b></td>
                            <td align="right"><b>{{number_format($qtd,2,',','.')}}</b></td>
                            <td></td>
                            <td align="right"><b>{{number_format($total_venda,2,',','.')}}</b></td>
                        </tr>
                        @php
                            $total_venda = 0;
                            $qtd = 0;
                        @endphp
                    @endif
                    @if ($item->lote)
                        <tr>
                            <td colspan="6" bgcolor="#d3d3d3" align="center"><b>{{strtoupper($item->lote)}} </b></td>
                        </tr>
                    @endif
                @endif
                <tr>
                    <td align="center">{{$item->item}}</td>
                    <td align="center">{{$item->cod_produto}}</td>
                    <td align="">{{$item->produto}}</td>
                    <td align="right">{{number_format($item->qtd,2,',','.')}}</td>
                    <td align="right">{{number_format($item->unt_venda,2,',','.')}}</td>
                    <td align="right">{{number_format($item->total_venda,2,',','.')}}</td>
                </tr>
                @php
                    $lote               = $item->lote;
                    $total_venda        += $item->total_venda;
                    $qtd                += $item->qtd;
                    $venda_total        += $item->total_venda;
                    $qtd_total          += $item->qtd;
                @endphp
            @endforeach
            <tr bgcolor="#e3e3e3">
                <td colspan="3"><b>TOTAL {{strtoupper($lote)}}</b></td>
                <td align="right"><b>{{number_format($qtd,2,',','.')}}</b></td>
                <td></td>
                <td align="right"><b>{{number_format($total_venda,2,',','.')}}</b></td>
            </tr>
        </tbody>
        <tfoot>
            @if ($item->lote)
                <tr bgcolor="#e3e3e3">
                    <td colspan="3"><b>TOTAL</b></td>
                    <td align="right"><b>{{number_format($qtd_total,2,',','.')}}</b></td>
                    <td></td>
                    <td align="right"><b>{{number_format($venda_total,2,',','.')}}</b></td>
                </tr>
            @endif
        </tfoot>
    </table>
</body>
</html>
