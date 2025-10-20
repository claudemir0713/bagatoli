@extends('layouts.model')
@section('content')
    <table class="table table-borderless table-advance table-condensed">
        <tr>
            <td width="80%">
                <h3>
                    <i class="fas fa-hand-holding-usd"></i> Precificação
                </h3>
            </td>
            <td width="50%" align="center">
            </td>
        </tr>
    </table><hr>
    <div class="row">
        <div class="form-group col-md-2">
            <button class="btn btn-info btn-sm fonte-12 btn-block" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                <span class="fas fa-filter"></span> Filtros
            </button>
        </div>
    </div>
    <p>
    <div class="collapse" id="collapseExample">
        <div class="card card-body">
            <form method="get" action="{{ route('precificacao.listAll') }}">
                @csrf
                <div class="row">
                    <div class="form-group col-md-4">
                        Tabela:
                        <input class="form-control fonte-12" type="text" name="tabela" id="tabela" value="{{ array_key_exists('tabela',$dateForm) ? $dateForm['tabela'] : '' }}">
                    </div>
                </div>
                <button class="btn btn-primary btn-sm fonte-12" type="submit" >
                    <span class="fas fa-play"></span> Filtrar
                </button>
            </form >
        </div>
    </div>
    <p>
    <div class="row">
        <div class="form-group col-md-12">
            <table class="table table-bordered table-condensed table-striped fonte-10" >
                <thead>
                    <tr>
                        <th width="5%">id</th>
                        <th width="5%">Data</th>
                        <th width="20%">Cliente</th>
                        <th width="5%">Status</th>
                        <th width="5%">Data Entrega</th>
                        <th width="5%">Data Licitação</th>
                        <th width="10%">Valor Edital</th>
                        <th width="10%">Valor Venda</th>
                        <th width="5%">Ação</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($proposta as $item)
                        <tr>
                            <td align="center">{{$item->id}}</td>
                            <td align="center">{{date('d/m/Y', strtotime($item->data))}}</td>
                            <td align="">{{$item->cliente}}</td>
                            <td align="">{{$item->fase}}</td>
                            <td align="center">{{date('d/m/Y', strtotime($item->data_entrega_proposta))}}</td>
                            <td align="center">{{date('d/m/Y', strtotime($item->data_processo))}}</td>
                            <td align="right">{{number_format($item->total_edital,2,',','.')}}</td>
                            <td align="right">{{number_format($item->total_venda,2,',','.')}}</td>
                            <td  align="center">
                                <a class="btn btn-warning fonte-10" href="{{route('precificacao.formPrecificacao', ['id'=>$item->id])}}">
                                    <i class="fas fa-dollar-sign"></i>&nbsp;&nbsp;&nbsp;
                                    <span>Precificar</span>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @if (isset($dateForm))
        {{$proposta->appends($dateForm)->links()}}
    @else
        {{$proposta->links()}}
    @endif

@endsection


