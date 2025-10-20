$(document).ready(function () {
    $(document).find('select').chosen();

    function colocaChosen(){
        $(document).find('select').chosen();
    }

    /*************************grava cliente com ajax************************************/
    $(document).on('submit', 'form#cadastro-cliente', function (event) {
        event.preventDefault()
        var route = $(this).find('input#route').val();
        var type = $(this).find('input#type').val();
        var origem = $(this).find('input#origem').val();
        var retornoUrl = $(this).find('input#retornoUrl').val();
        origem = origem+retornoUrl

        var pessoa = $(this).find('#pessoa').val();
        var cnpj = $(this).find('#cnpj').val();
        var IE = $(this).find('#IE').val();
        var contribuinte_icms = $(this).find('#contribuinte_icms').val();
        var simples_nascional = $(this).find('#simples_nascional').val();
        var cliente = $(this).find('#cliente').val();
        var cep = $(this).find('#Cep').val();
        var endereco = $(this).find('#endereco').val();
        var bairro = $(this).find('#bairro').val();
        var cidade = $(this).find('#cidade').val();
        var uf = $(this).find('#uf').val();
        var telefone = $(this).find('#telefone').val();
        var celular = $(this).find('#celular').val();
        var email = $(this).find('#email').val();

        var contato = $(this).find('#contato').val();
        var contato_estado_civil = $(this).find('#contato_estado_civil').val();
        var contato_profissao = $(this).find('#contato_profissao').val();
        var contato_cpf = $(this).find('#contato_cpf').val();
        var contato_rg = $(this).find('#contato_rg').val();
        var contato_endereco = $(this).find('#contato_endereco').val();
        var nascionalidade = $(this).find('#nascionalidade').val();


        if(!cnpj){cnpj=0;};

        /********************************************************************************************* */
        if (!pessoa || !cliente ) {
            Swal({
                title: 'Preencha todos os campos obrigatório',
                type: 'error',
                timer: 3000
            })
        } else {
            var dados = {
                'pessoa'                : pessoa
                ,'cnpj'                 : cnpj
                ,'IE'                   : IE
                ,'contribuinte_icms'    : contribuinte_icms
                ,'simples_nascional'    : simples_nascional
                ,'cliente'              : cliente
                ,'cep'                  : cep
                ,'endereco'             : endereco
                ,'bairro'               : bairro
                ,'cidade'               : cidade
                ,'uf'                   : uf
                ,'telefone'             : telefone
                ,'celular'              : celular
                ,'email'                : email
                ,'contato'              : contato
                ,'contato_estado_civil' : contato_estado_civil
                ,'contato_profissao'    : contato_profissao
                ,'contato_cpf'          : contato_cpf
                ,'contato_rg'           : contato_rg
                ,'contato_endereco'     : contato_endereco
                ,'nascionalidade'       : nascionalidade
            }
            cadastrar(dados, route, type, origem);
            // console.log(dados, route, type, origem)
        }
    })



})
