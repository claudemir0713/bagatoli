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
function buscaCnpj(cnpj){
    $.ajax({
        data: {cnpj:cnpj},
        type: 'POST',
        dataType: 'JSON',
        url:url+'/cliente/buscaCnpj',
        beforeSend: function(){
            Swal({
                title: 'Consultando dados…',
                type: 'info',
                text: 'Aguarde alguns segundos.',
                allowOutsideClick: false,
                didOpen: () => Swal.showLoading()
            })
        },
        success: function (result, textStatus, xhr)
        {
                // console.log(result)
                // $(document).find('input#cliente').val(result.razao_social);
                // $(document).find('input#email').val(result.email);
                // $(document).find('input#Cep').val(result.cep);
                // $(document).find('input#cidade').val(result.municipio);
                // $(document).find('input#endereco').val(result.logradouro+','+result.numero);
                // $(document).find('input#bairro').val(result.bairro);
                // $(document).find('input#uf').val(result.uf);


            // Alguns campos podem vir nulos; trate fallbacks:
            const razao      = result?.razao_social || result?.razaoSocial || '';
            const email      = result?.email || '';
            const cep        = (result?.cep || '').replace(/\D+/g, '');
            const municipio  = result?.municipio || result?.cidade || '';
            const logradouro = result?.logradouro || '';
            const numero     = result?.numero || '';
            const bairro     = result?.bairro || '';
            const uf         = (result?.uf || '').toUpperCase();

            // Preenche os inputs
            $(document).find('input#cliente').val(razao);
            $(document).find('input#email').val(email);
            $(document).find('input#Cep').val(cep);                // formate no seu inputmask se usar
            $(document).find('input#cidade').val(municipio);
            $(document).find('input#endereco').val(
                numero ? `${logradouro}, ${numero}` : logradouro
            );
            $(document).find('input#bairro').val(bairro);
            $(document).find('input#uf').val(uf);

            Swal.close(); // fecha loading
        },error: function (xhr) {
            Swal.close();

            const status = xhr.status;
            console.log(xhr.responseJSON, xhr.responseJSON.erro);
            let msg = 'Erro ao consultar o CNPJ. Tente novamente.';

            if (status === 404) {
                msg = 'CNPJ não encontrado na base pública.';
            } else if (status === 429) {
                msg = 'Muitas requisições agora. Aguarde alguns instantes e tente novamente.';
            } else if (status === 422) {
                msg = 'CNPJ inválido.';
            } else if (status >= 500) {
                msg = 'Serviço temporariamente indisponível.';
            } else if (xhr.responseJSON && xhr.responseJSON.erro) {
                msg = xhr.responseJSON.erro + ''+xhr.responseJSON.body;
            }

            Swal({
                title: 'Atenção',
                type: 'info',
                text: msg,
                icon: 'warning'
            });
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


    $.ajax({
        data: dados,
        type: type,
        dataType: 'JSON',
        url:url+route,
        success: function(result)
        {
            Swal.fire({
                title   : result.title,
                type    : result.type,
                html    : result.html,
                timer   : result.timer,
            }).then(() => {
                    if(result.acao=="voltar"){
                        if(origem=='precificacao'){
                            window.open(url + '/' + origem + '/imprimir/'+dados.proposta_id, '_blank');
                        }
                        if(dados.page){
                            origem = origem+'?page='+dados.page
                        }
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


