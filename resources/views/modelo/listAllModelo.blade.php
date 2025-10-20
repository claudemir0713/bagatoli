@extends('layouts.model')
@section('content')
<table class="table table-borderless table-advance table-condensed">
    <tr>
        <td width="80%">
            <h3>
                <i class="fa fa-cubes"></i> Modelo de relatórios
            </h3>
        </td>
        <td width="50%" align="center">
            <h3>
                <a class="cor-digiliza" href="{{route('modelo.formAddModelo')}}">
                    <i class="fas fa-plus-circle"></i>&nbsp;&nbsp;&nbsp;
                    <span>Novo</span>
                </a>
            </h3>
        </td>
    </tr>
</table><hr>

<p>
<table class="table table-bordered table-condensed table-striped">
    <thead>
        <tr>
            <th width="20%" data-field="name">Descrição</th>
            <th width="5%" data-field="">Ação</th>
        </tr>
    </thead>
        @foreach ($modelos as $modelo )
            <tr>
                <td>{{$modelo->descricao}}</td>
                <td align="center">
                    <div class="btn-group-vertical">
                        <div class="btn-group">
                        <button type="button"  class="btn btn-outline-info dropdown-toggle" data-toggle="dropdown">
                            <i class="fas fa-cogs"></i>
                            <span>Ação</span>
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="{{route('modelo.formEditModelo', $modelo->id)}}">
                                <i class="far fa-edit"></i>&nbsp;&nbsp;&nbsp;
                                <span>Editar</span>
                            </a>
                            <a class="dropdown-item" href="#">
                                <form action=" {{ route('modelo.destroy',['modelo'=> $modelo->id ]) }} " method="POST">
                                    @csrf
                                    @method('delete')
                                    <input type="hidden" name='modelo' value=" {{ $modelo->id }} ">
                                    <i class="far fa-trash-alt"></i>
                                    <input type="submit" class="btn btn-default delete"  value="Eliminar">
                                </form>
                            </a>
                        </div>
                        </div>
                    </div>            </tr>
        @endforeach
    <tbody>

    </tbody>
</table>
@endsection


