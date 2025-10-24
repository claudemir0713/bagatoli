    <div class="row">
        <div class="form-group col-md-2">
            <sup><b>Cliente:</b></sup> {{$cliente->cliente}}
        </div>
        <div class="form-group col-md-4">
            <sup><b>Cidade:</b></sup> {{$cliente->cidade}}
        </div>
    </div>

    <table class="table table-borderless table-advance table-striped  table-condensed fonte-8" width='100%'>
        <thead>
            <tr>
                <th width="7%">NF</th>
                <th width="5%">PARCELA</th>
                <th width="38%">CLIENTE</th>
                <th width="5%">EMISSÃO</th>
                <th width="5%">VENCIMENTO</th>
                <th width="5%">VALOR</th>
                <th width="5%">PAGO</th>
                <th width="5%">MULTA</th>
                <th width="5%">JUROS</th>
                <th width="10%">SALDO</th>
            </tr>
        </thead>
        @php
        @endphp
            <tbody>
                <tr>
                    <td width="7%">NF</td>
                    <td width="5%">PARCELA</td>
                    <td width="38%">CLIENTE</td>
                    <td width="5%">EMISSÃO</td>
                    <td width="5%">VENCIMENTO</td>
                    <td width="5%">VALOR</td>
                    <td width="5%">PAGO</td>
                    <td width="5%">MULTA</td>
                    <td width="5%">JUROS</td>
                    <td width="10%">SALDO</td>
                </tr>
                <tr>
                    <td width="7%">NF</td>
                    <td width="5%">PARCELA</td>
                    <td width="38%">CLIENTE</td>
                    <td width="5%">EMISSÃO</td>
                    <td width="5%">VENCIMENTO</td>
                    <td width="5%">VALOR</td>
                    <td width="5%">PAGO</td>
                    <td width="5%">MULTA</td>
                    <td width="5%">JUROS</td>
                    <td width="10%">SALDO</td>
                </tr>
            </tbody>
        {{-- <tbody>
            @foreach ($receber as $item )
                @if($COD_REP!=$item->COD_REP)
                    @if ($COD_REP!='0')
                        <tr bgcolor="#e3e3e3">
                            <td colspan="5"><b>TOTAL</b></td>
                            <td align="right"><b>{{number_format($vlr_total_rep,2,',','.')}}</b></td>
                            <td align="right"><b>{{number_format($vlr_total_pago_rep,2,',','.')}}</b></td>
                            <td align="right"><b>{{number_format($vlr_total_juros_rep,2,',','.')}}</b></td>
                            <td align="right"><b>{{number_format($vlr_total_multa_rep,2,',','.')}}</b></td>
                            <td align="right"><b>{{number_format($vlr_total_saldo_rep,2,',','.')}}</b></td>
                        </tr>
                        @php
                            $vlr_total_rep = 0;
                            $vlr_total_pago_rep = 0;
                            $vlr_total_juros_rep = 0;
                            $vlr_total_multa_rep = 0;
                            $vlr_total_saldo_rep = 0;
                        @endphp
                    @endif
                    <tr>
                        <td colspan="10" bgcolor="#d3d3d3"><b>{{$COD_REP}} - {{$item->REPRESENTANTE}}</b></td>
                    </tr>
                @endif
                <tr>
                    <td>{{$item->CON_NUMERO}}</td>
                    <td align="center">{{$item->CON_SEQUENCIA}}</td>
                    <td>{{$item->CLIENTE}}</td>
                    <td>{{date('d/m/Y',strtotime($item->CON_DT_INCLUSAO))}}</td>
                    <td>{{date('d/m/Y',strtotime($item->CON_DT_VENCIMENTO))}}</td>
                    <td align="right">{{number_format($item->CON_VALOR_ORIGINAL,2,',','.')}}</td>
                    <td align="right">{{number_format($item->CON_VALOR_TOTAL_PAGO,2,',','.')}}</td>
                    <td align="right">{{number_format($item->CON_VALOR_JUROS,2,',','.')}}</td>
                    <td align="right">{{number_format($item->CON_VALOR_MULTA,2,',','.')}}</td>
                    <td align="right">{{number_format($item->CON_VALOR_CORRIGIDO,2,',','.')}}</td>
                </tr>
                @php
                    $COD_REP            = $item->COD_REP;

                    $vlr_total          += $item->CON_VALOR_ORIGINAL;
                    $vlr_total_pago     += $item->CON_VALOR_TOTAL_PAGO;
                    $vlr_total_juros    += $item->CON_VALOR_JUROS;
                    $vlr_total_multa    += $item->CON_VALOR_MULTA;
                    $vlr_total_saldo    += $item->CON_VALOR_CORRIGIDO;

                    $vlr_total_rep       += $item->CON_VALOR_ORIGINAL;
                    $vlr_total_pago_rep  += $item->CON_VALOR_TOTAL_PAGO;
                    $vlr_total_juros_rep += $item->CON_VALOR_JUROS;
                    $vlr_total_multa_rep += $item->CON_VALOR_MULTA;
                    $vlr_total_saldo_rep += $item->CON_VALOR_CORRIGIDO;
                @endphp
            @endforeach
            <tr bgcolor="#e3e3e3">
                <td colspan="5"><b>TOTAL</b></td>
                <td align="right"><b>{{number_format($vlr_total_rep,2,',','.')}}</b></td>
                <td align="right"><b>{{number_format($vlr_total_pago_rep,2,',','.')}}</b></td>
                <td align="right"><b>{{number_format($vlr_total_juros_rep,2,',','.')}}</b></td>
                <td align="right"><b>{{number_format($vlr_total_multa_rep,2,',','.')}}</b></td>
                <td align="right"><b>{{number_format($vlr_total_saldo_rep,2,',','.')}}</b></td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="5">TOTAL</td>
                <td align="right">{{number_format($vlr_total,2,',','.')}}</td>
                <td align="right">{{number_format($vlr_total_pago,2,',','.')}}</td>
                <td align="right">{{number_format($vlr_total_juros,2,',','.')}}</td>
                <td align="right">{{number_format($vlr_total_multa,2,',','.')}}</td>
                <td align="right">{{number_format($vlr_total_saldo,2,',','.')}}</td>
            </tr>
        </tfoot> --}}
    </table>
