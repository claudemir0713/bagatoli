@extends('layouts.model')
@section('content')
    <table class="table table-borderless table-advance table-condensed">
        <tr>
            <td width="80%">
                <h3>
                    <i class="fas fa-tags"></i> Proposta
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
        <div class="form-group col-md-2" align="right">
            <a class="btn btn-primary btn-sm fonte-12 btn-block" href="{{route('proposta.formAdd')}}">
                <i class="fas fa-plus-circle"></i>&nbsp;&nbsp;&nbsp;
                <span>Nova</span>
            </a>
        </div>
    </div>
    <p>
    <div class="collapse" id="collapseExample">
        <div class="card card-body">
            <form method="get" action="{{ route('proposta.listAll') }}" autocomplete="off">
                @csrf
                <div class="row">
                    <div class="form-group col-md-2">
                        Proposta:
                        <input class="form-control fonte-12" type="text" name="proposta" id="proposta" value="{{ array_key_exists('proposta',$dateForm) ? $dateForm['proposta'] : '' }}" autofocus title="Ao preencher esse campos os demais filtros serão desconsiderados" autocomplete="off">
                    </div>
                    <div class="form-group col-md-4">
                        Cliente:
                        <input class="form-control fonte-12" type="text" name="cliente" id="cliente" value="{{ array_key_exists('cliente',$dateForm) ? $dateForm['cliente'] : '' }}" autocomplete="off">
                    </div>
                    <div class="form-group col-md-4">
                        Cidade:
                        <input class="form-control fonte-12" type="text" name="cidade" id="cidade" value="{{ array_key_exists('cidade',$dateForm) ? $dateForm['cidade'] : '' }}">
                    </div>
                    <div class="form-group col-md-1">
                        UF:
                        <input class="form-control fonte-12" type="text" name="uf" id="uf" value="{{ array_key_exists('uf',$dateForm) ? $dateForm['uf'] : '' }}">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-2">
                        Data Entreda de:
                        <input class="form-control fonte-12" type="date" name="dtEI" id="dtEI" value="{{ array_key_exists('dtEI',$dateForm) ? $dateForm['dtEI'] : '' }}" >
                    </div>
                    <div class="form-group col-md-2">
                        Data Entreda até:
                        <input class="form-control fonte-12" type="date" name="dtEF" id="dtEF" value="{{ array_key_exists('dtEF',$dateForm) ? $dateForm['dtEF'] : '' }}" >
                    </div>
                    <div class="form-group col-md-2">
                        Data Abertura de:
                        <input class="form-control fonte-12" type="date" name="dtAI" id="dtAI" value="{{ array_key_exists('dtAI',$dateForm) ? $dateForm['dtAI'] : '' }}" >
                    </div>
                    <div class="form-group col-md-2">
                        Data Abertura até:
                        <input class="form-control fonte-12" type="date" name="dtAF" id="dtAF" value="{{ array_key_exists('dtAF',$dateForm) ? $dateForm['dtAF'] : '' }}" >
                    </div>
                    <div class="form-group col-md-2">
                        Processo nr:
                        <input class="form-control fonte-12" type="text" name="processo" id="processo" value="{{ array_key_exists('processo',$dateForm) ? $dateForm['processo'] : '' }}" >
                    </div>
                    <div class="form-group col-md-2">
                        Pregão nr:
                        <input class="form-control fonte-12" type="text" name="pregao" id="pregao" value="{{ array_key_exists('pregao',$dateForm) ? $dateForm['pregao'] : '' }}" >
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
            <table class="table table-bordered table-condensed table-striped fonte-10 tabela-ordenavel" >
                <thead>
                    <tr>
                        <th width="5%">id <i class="fas fa-caret-down icone-ordem"></i></th>
                        <th width="5%">Data <i class="fas fa-caret-down icone-ordem"></i></th>
                        <th width="20%">Cliente <i class="fas fa-caret-down icone-ordem"></i></th>
                        <th width="5%">Status <i class="fas fa-caret-down icone-ordem"></i></th>
                        <th width="5%">Dt Entrega <i class="fas fa-caret-down icone-ordem"></i></th>
                        <th width="5%">Dt Licitação <i class="fas fa-caret-down icone-ordem"></i></th>
                        <th width="5%">Processo <i class="fas fa-caret-down icone-ordem"></i></th>
                        <th width="5%">Pregão <i class="fas fa-caret-down icone-ordem"></i></th>
                        <th width="5%">Valor <i class="fas fa-caret-down icone-ordem"></i></th>
                        <th width="5%">Ação <i class="fas fa-caret-down icone-ordem"></i></th>
                        <th width="4%">Ação <i class="fas fa-caret-down icone-ordem"></i></th>
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
                            <td align="center">{{$item->nr_processo}}</td>
                            <td align="center">{{$item->nr_pregao}}</td>
                            <td align="right">{{number_format($item->total_edital,2,',','.')}}</td>
                            <td  align="center">
                                <a class="btn btn-success fonte-10" href="{{route('proposta.formEdit', ['id'=>$item->id])}}">
                                    <i class="far fa-edit"></i>
                                </a>
                            </td>
                            <td  align="center">
                                <a class="btn btn-danger fonte-10 delete" href="{{route('proposta.destroy', ['id'=>$item->id])}}">
                                    <i class="fas fa-trash"></i>
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


