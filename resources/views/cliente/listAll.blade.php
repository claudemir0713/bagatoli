@extends('layouts.model')
@section('content')
    <table class="table table-borderless table-advance table-condensed">
        <tr>
            <td width="80%">
                <h3>
                    <i class="fas fa-users"></i> Clientes
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
        <div class="form-group col-md-2">
            <a class="btn btn-primary btn-sm fonte-12 btn-block" href="{{route('cliente.formAdd')}}">
                <i class="fas fa-plus-circle"></i>&nbsp;&nbsp;&nbsp;
                <span>Novo</span>
            </a>
        </div>
    </div>
    <div class="collapse" id="collapseExample">
        <div class="card card-body">
            <form method="get" action="{{ route('cliente.listAll') }}">
                @csrf
                <div class="row">
                    <div class="form-group col-md-4">
                        Nome:
                        <input type="text" class="form-control" name="cliente" id="cliente" value="{{ array_key_exists('cliente',$dateForm) ? $dateForm['cliente'] : '' }}">
                    </div>
                </div>
                <button class="btn btn-primary btn-sm fonte-12" type="submit" >
                    <span class="fas fa-play"></span> Filtrar
                </button>
            </form >
        </div>
    </div>

    <p>
    <table class="table table-bordered table-condensed table-striped fonte-10">
        <thead>
            <tr>
                <th width="5%">Cliente</th>
                <th width="20%">Cliente</th>
                <th width="5%" colspan="3">Ação</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($clientes as $cliente)
                <tr>
                    <td align="center">{{$cliente->id}}  </td>
                    <td >{{$cliente->cliente}}  </td>
                    <td align="center">
                        <div class="btn-group-vertical">
                            <div class="btn-group dropleft">
                                <button type="button"  class="btn btn-outline-info dropdown-toggle btn-sm" data-toggle="dropdown">
                                    <i class="fas fa-cogs"></i>
                                    <span>Ação</span>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item fonte-12" href="{{route('cliente.formEdit', $cliente->id)}}">
                                        <i class="far fa-edit"></i>&nbsp;&nbsp;&nbsp;
                                        <span>Editar</span>
                                    </a><hr>
                                    <a class="dropdown-item fonte-12 delete" href="#">
                                        <form action=" {{ route('cliente.destroy',['cliente'=> $cliente->id ]) }} " method="POST">
                                            @csrf
                                            @method('delete')
                                            {{-- <input type="hidden" name='cliente' value=" {{ $cliente->id }} "> --}}
                                            <i class="far fa-trash-alt"></i>  Eliminar
                                            <button type="submit" class="btn btn-default btn-sm"></button>
                                        </form>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>


    @if (isset($dateForm))
        {{$clientes->appends($dateForm)->links()}}
    @else
        {{$clientes->links()}}
    @endif

@endsection


