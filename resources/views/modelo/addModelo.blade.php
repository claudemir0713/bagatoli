@extends('layouts.model')

@section('content')
    <h3 class=""><i class="fa fa-cubes"></i> Modelo</h3>
    <form action="" id="cadastro-modelo" nome="cadastro-modelo" method="post">
        @csrf
        @method('patch')
        <input type="hidden" name="route" id="route" value="/modelo/store">
        <input type="hidden" name="type" id="type" value="POST">

        <div class="row">
            <div class="form-group col-md-3">
                Modelo:
                <input type="text" class="form-control" id="descricao" name="descricao" >
            </div>
            <div class="form-group col-md-2">
                Papel:
                <select id="tamanho" name="tamanho">
                    <option value="A4">A4</option>
                </select>
            </div>
            <div class="form-group col-md-2">
                Tipo:
                <select id="tipo" name="tipo">
                    <option value="Documento">Documento</option>
                </select>
            </div>
            <div class="form-group col-md-2">
                Cor:
                <select id="botaoCor" name="botaoCor">
                    <option value="">Selecione</option>
                    <option value="btn-primary"    class="text-primary">primary</option>
                    <option value="btn-secondary"  class="text-secondary">secondary</option>
                    <option value="btn-success"    class="text-success">success</option>
                    <option value="btn-danger"     class="text-danger">danger</option>
                    <option value="btn-warning"    class="text-warning">warning</option>
                    <option value="btn-info"       class="text-info">info</option>
                </select>
            </div>
            <div class="form-group col-md-2">
                Imagem:
                <select id="botaoImagem" name="botaoImagem">
                    <option value="fa fa-print"         class="fa fa-print"> Print</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-1">
                M.Top:
                <input type="number" class="form-control" id="margin_top" name="margin_top" value="0">
            </div>
            <div class="form-group col-md-1">
                M.Left:
                <input type="number" class="form-control" id="margin_left" name="margin_left" value="0">
            </div>
            <div class="form-group col-md-1">
                M.Bottom:
                <input type="number" class="form-control" id="margin_bottom" name="margin_bottom" value="0">
            </div>
            <div class="form-group col-md-1">
                M.Rigth:
                <input type="number" class="form-control" id="margin_rigth" name="margin_rigth" value="0">
            </div>
            <div class="form-group col-md-3">
                Dicionário:
                <select id="dicionario">
                    <option value="">Selecione</option>
                    @foreach ( $dicionarios as $item)
                        <option value="{{$item->tag}}">{{$item->tag}}</option>
                    @endforeach
                </select>
                <div id="tag"></div>
            </div>
            <div class="form-group col-md-2">
                &nbsp;
                <button type="submit" name="salvar" value="" id="salvar" class="btn btn-success btn-block">
                    <span class="fas fa-save"></span> Salvar
                </button>
            </div>
                <div class="form-group col-md-2">
                    &nbsp;
                    <button type="button" name="sair" id="sair" value="" class="btn btn-danger btn-block">
                        <span class="fa fa-door-open"></span> Sair
                    </button>
                </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="form-group col-md-12">
                <textarea id="modelo" name="modelo" class="ckeditor"></textarea>
            </div>
        </div>
    </form>

    <script>
        $(document).ready(function(){

            $('button#sair').click(function(){
                $(location).attr('href',url+'/modelo');
            })

        })
    </script>


@endsection
