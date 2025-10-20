@extends('layouts.model')
@section('content')
    <table class="table table-borderless table-advance table-condensed">
        <tr>
            <td width="80%">
                <h3>
                    <i class="fas fa-landmark"></i> Empresa
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
            <a class="btn btn-primary btn-sm fonte-12 btn-block" href="{{route('empresa.formAdd')}}">
                <i class="fas fa-plus-circle"></i>&nbsp;&nbsp;&nbsp;
                <span>Nova</span>
            </a>

        </div>
    </div>
    <p>
    <div class="collapse" id="collapseExample">
        <div class="card card-body">
            <form method="get" action="{{ route('empresa.listAll') }}">
                @csrf
                <div class="row">
                    <div class="form-group col-md-4">
                        Empresa:
                        <input class="form-control" type="text" name="razao" id="razao" value="{{ array_key_exists('razao',$dateForm) ? $dateForm['razao'] : '' }}">
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
                        <th width="20%">Razão</th>
                        <th width="10%">Cnpj</th>
                        <th width="10%">Cidade</th>
                        <th width="10%">Regime</th>
                        <th width="5%">Ação</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($empresa as $item)
                        <tr>
                            <td>{{$item->id}}</td>
                            <td>{{$item->razao}}</td>
                            <td>{{$item->cnpj}}</td>
                            <td>{{$item->cidade}}</td>
                            <td>{{$item->regime_tributario}}</td>
                            <td  align="center">
                        <div class="btn-group-vertical">
                            <div class="btn-group dropleft">
                                <button type="button"  class="btn btn-outline-info dropdown-toggle btn-sm" data-toggle="dropdown">
                                    <i class="fas fa-cogs"></i>
                                    <span>Ação</span>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item fonte-12" href="{{ route('empresa.formEdit',['id'=>$item->id]) }}">
                                        <i class="far fa-edit"></i>&nbsp;&nbsp;&nbsp;
                                        <span>Editar</span>
                                    </a><hr>
                                    {{-- <a class="dropdown-item fonte-12 delete" href="#">
                                        <form action=" {{ route('empresa.destroy',['id'=> $item->id ]) }} " method="POST">
                                            @csrf
                                            @method('delete')
                                            <i class="far fa-trash-alt"></i>  Eliminar
                                            <button type="submit" class="btn btn-default btn-sm"></button>
                                        </form>
                                    </a> --}}
                                </div>
                            </div>
                        </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>


@endsection


