$(document).ready(function () {
    $(document).find('select').chosen();

    function colocaChosen(){
        $(document).find('select').chosen();
    }

    /*************************grava cliente com ajax************************************/
    $(document).on('submit', 'form#cadastro-empresa', function (event) {
        event.preventDefault()
        var route = $(this).find('input#route').val();
        var type = $(this).find('input#type').val();
        var origem = $(this).find('input#origem').val();
        var retornoUrl = $(this).find('input#retornoUrl').val();
        origem = origem+retornoUrl

        var cnpj = $(this).find('#cnpjEmp').val();
        var razao = $(this).find('#razao').val();
        var fantasia = $(this).find('#fantasia').val();
        var insc_estadual = $(this).find('#insc_estadual').val();
        var insc_municipal = $(this).find('#insc_municipal').val();
        var cep = $(this).find('#cep').val();
        var endereco = $(this).find('#endereco').val();
        var bairro = $(this).find('#bairro').val();
        var cidade = $(this).find('#cidade').val();
        var uf = $(this).find('#uf').val();
        var pais = $(this).find('#pais').val();

        var representante_legal = $(this).find('#representante_legal').val();
        var cpf = $(this).find('#cpf').val();
        var rg = $(this).find('#rg').val();
        var cargo = $(this).find('#cargo').val();

        var regime_tributario   = $(this).find('#regime_tributario').val();
        var icms                = $(this).find('#icms').val();
        var simples             = $(this).find('#simples').val();
        var pis                 = $(this).find('#pis').val();
        var cofins              = $(this).find('#cofins').val();
        var ir_csll             = $(this).find('#ir_csll').val();
        var difal               = $(this).find('#difal').val();

        var frete               = $(this).find('#frete').val();
        var despesa_fixa        = $(this).find('#despesa_fixa').val();
        var comissao            = $(this).find('#comissao').val();
        var outros              = $(this).find('#outros').val();
        var taxa_financeira      = $(this).find('#taxa_financeira').val();
        var margem              = $(this).find('#margem').val();

        if(!cnpj){cnpj=0;};

        /********************************************************************************************* */
        if (!razao || !cnpj ) {
            Swal({
                title: 'Preencha todos os campos obrigatório',
                type: 'error',
                timer: 3000
            })
        } else {
            var dados = {
                'cnpj'                  : cnpj
                ,'razao'                : razao
                ,'fantasia'             : fantasia
                ,'insc_estadual'        : insc_estadual
                ,'insc_municipal'       : insc_municipal
                ,'cep'                  : cep
                ,'endereco'             : endereco
                ,'bairro'               : bairro
                ,'cidade'               : cidade
                ,'uf'                   : uf
                ,'pais'                 : pais
                ,'representante_legal'  : representante_legal
                ,'cpf'                  : cpf
                ,'rg'                   : rg
                ,'cargo'                : cargo

                ,'regime_tributario'    : regime_tributario
                ,'icms'                 : icms
                ,'simples'              : simples
                ,'pis'                  : pis
                ,'cofins'               : cofins
                ,'ir_csll'              : ir_csll

                ,'difal'                : difal
                ,'frete'                : frete
                ,'despesa_fixa'         : despesa_fixa
                ,'comissao'             : comissao
                ,'outros'               : outros
                ,'taxa_financeira'      : taxa_financeira
                ,'margem'               : margem
            }
            cadastrar(dados, route, type, origem);
            // console.log(dados, route, type, origem)
        }
    })



})
