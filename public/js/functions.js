/**********************formata numero **************************************************/
const formCurrency = new Intl.NumberFormat('pt-BR', {
    style: 'currency',
    currency: 'BRL',
    minimumFractionDigits: 2
})

/**********************formata cub **************************************************/
const formCub = new Intl.NumberFormat('pt-BR', {
    style: 'currency',
    currency: 'BRL',
    minimumFractionDigits: 4
})

/********************* busca cep cliente *****************************************/
function buscaCep(cep){
    $.ajax({
        data: {cep:cep},
        type: 'POST',
        dataType: 'JSON',
        url:url+'/empresa/buscaCep',
        beforeSend: function(){

        },
        success: function(result)
        {
            $('#Mun').val(result.localidade);
            $('#Ender').val(result.logradouro);
            $('#Bairro').val(result.bairro);
            $('#Uf').val(result.uf);
        }
    });

}

/*****************************busca cnpj*****************************************/
/*****************************busca cnpj*****************************************/
function buscaCnpj(cnpj){
    $.ajax({
        data: {cnpj:cnpj},
        type: 'POST',
        dataType: 'JSON',
        url:url+'/cliente/buscaCnpj',
        beforeSend: function(){
            Swal({
                title: 'Aguarde consultado dados!',
                type: 'warning',
                timer:2000
            })
        },
        success: function(result)
        {
            console.log(result)
            $(document).find('input#email').val(result.email);
            if(result.emails[0]){
                $(document).find('input#email').val(result.emails[0].address);
            }
            if(result.address){
                $(document).find('input#Cep').val(result.address.zip);
                $(document).find('input#cidade').val(result.address.city);
                $(document).find('input#endereco').val(result.address.street+','+result.address.number);
                $(document).find('input#bairro').val(result.address.district);
                $(document).find('input#uf').val(result.address.state);
            }

            if(result.phones['0']){
                $(document).find('input#telefone').val(result.phones['0'].area+' '+result.phones['0'].number);
            }
            if(result.company){
                $(document).find('input#cliente').val(result.company.name);
                if(result.company.members['0']){
                    $(document).find('input#contato').val(result.company.members['0'].person.name);
                }
            }
            $(document).find('#contribuinte_icms').val('N').trigger('chosen:updated')
            let IE = 'Isento';
            if(result.registrations['0']){
                if(result.registrations['0'].number){IE = result.registrations['0'].number}
                $(document).find('#contribuinte_icms').val('S').trigger('chosen:updated')
            }
            $(document).find('#IE').val(IE)

            if(result.company.simples.optant==true){
                $(document).find('#simples_nascional').val('S').trigger('chosen:updated')
            }else{
                $(document).find('#simples_nascional').val('N').trigger('chosen:updated')
            }
        }
    });
}

function colocaChosen(){
    $(document).find('select').chosen();
}

function atualizaCards(){
    $.ajax({
        data: '',
        type: 'post',
        url:url+'/home/atualizaCard',
        dataType: 'JSON',
        error: function(result){
        },
        success: function(result)
        {
            $.each(result, function(i, val){
                $('#span-nr'+val.etapa.replace(/\s/g, '')).html(val.qtd)
            });
        }

    })
}

/******************calcula PMT **************************************/
function PMT(ir,np, pv, fv = 0){
    var  fator = 0;
    fator = Math.pow((1 + ir), np);
    var pmt = ir * pv  * (fator + fv)/(fator-1);
    return pmt;
}


// /***********************************cadastrar************************************ */
function cadastrar(dados,route,type,origem){
    console.log(dados,route,type,origem);
    $.ajax({
        data: dados,
        type: type,
        dataType: 'JSON',
        url:url+route,
        success: function(result)
        {
            console.log(result);
            Swal.fire({
                title   : result.title,
                type    : result.type,
                html    : result.html,
                timer   : result.timer,
            }).then(() => {
                    if(result.acao=="voltar"){
                        window.location.replace(url+'/'+origem);
                    }else if(result.acao=="atualizar"){
                        window.location.reload();
                    }else if(result.acao=="limpar"){
                        $('.limpar').val('');
                        $('select').trigger("chosen:updated");
                    }

            });
        },
        complete: function(result){
            $('#salvar').prop("disabled",false);
        }
    })
}

function liberaMenuDisponivel()
{
    var usuario = $(document).find('#usuario').val();
    var dados = {
        'usuario': usuario
    };
    var route = '/menu/disponivel'
    var linhas = '';
    $.ajax({
        data: dados,
        type: 'post',
        dataType: 'JSON',
        url: url + route,
        beforeSend : function(){
            linhas = '';
            $('#menuDisponivel').html('');
            swal({
                title: 'Aguarde!',
                type: 'warning',
                html: '<strong>Efetuando busca</strong>',
                onOpen: () => {
                    swal.showLoading()
                }
            })
        },
        success: function (result) {
            linhas = '';
            classe = '';
            $.each(result, function (i, val) {
                if(val.tipo=='Título'){
                    classe='negrito';
                }else{
                    classe='paragrafo';
                };
                var id = 0;
                (val.selecionado=="checked")?id = val.selecionadoId : id=val.disponivelId
                linhas += '<tr>';
                    linhas += '<td class="'+classe+'"><button class="btn btn-link" value="'+val.disponivelId+'">'+val.ordem+'-'+val.descricao+'</button></td>';
                    linhas += '<td>';
                        linhas += '<label class="switch" >';
                            linhas += '<input type="checkbox" class="disponivel" id="protrang" name="protrang" '+val.selecionado+' value="'+id+'">';
                            linhas += '<span class="slider round"></span>';
                        linhas += '</label>';
                    linhas += '</td>';
                linhas += '</tr>';
            })

        },
        complete:function(){
            $('#menuDisponivel').html(linhas);
            swal.close();
        }
    })
}

function removeMenuLiberado()
{
    var usuario = $(document).find('#usuario').val();
    var dados = {
        'usuario': usuario
    };
    var route = '/menu/menuLiberado'
    var linhas = '';
    $.ajax({
        data: dados,
        type: 'post',
        dataType: 'JSON',
        url: url + route,
        beforeSend : function(){
            linhas = '';
            $('#menuLiberado').html('');
            swal({
                title: 'Aguarde!',
                type: 'warning',
                html: '<strong>Efetuando busca</strong>',
                onOpen: () => {
                    swal.showLoading()
                }
            })
        },
        success: function (result) {
        },
        complete:function(){
            $('#menuLiberado').html(linhas);
            swal.close();
        }
    })
}

function addMenuUsuario(disponivelId,usuario){
    var dados = {
        'usuario': usuario,
        'disponivelId' : disponivelId
    };
    var route = '/menu/addMenuUsuario'
    $.ajax({
        data: dados,
        type: 'post',
        dataType: 'JSON',
        url: url + route,
        complete:function(){
            liberaMenuDisponivel();
            removeMenuLiberado();
        }
    })
}
function removeMenuUsuario(liberadoId){
    var dados = {
        'liberadoId' : liberadoId
    };
    var route = '/menu/removeMenuUsuario'
    $.ajax({
        data: dados,
        type: 'post',
        dataType: 'JSON',
        url: url + route,
        complete:function(){
            liberaMenuDisponivel();
            removeMenuLiberado();
        }
    })
}

function ativaUsuario(usuario_id,ativo,route){
    var dados = {
        'usuario_id': usuario_id,
        'ativo' : ativo
    };
    $.ajax({
        data: dados,
        type: 'post',
        dataType: 'JSON',
        url: url + route
    })
}

function nivelUsuario(usuario_id,nivel,route){
    var dados = {
        'usuario_id': usuario_id,
        'nivel' : nivel
    };
    $.ajax({
        data: dados,
        type: 'post',
        dataType: 'JSON',
        url: url + route
    })
}


