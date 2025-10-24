function bg_localizaCliente(cliente){
    let route = '/proposta/bg_localizaCliente';
    let dados = {
        'cliente': cliente,
    };
    $.ajax({
        data: dados,
        type: 'post',
        dataType: 'JSON',
        url: url + route,
        beforeSend:function(){
            $(document).find('#tbConsultaCliente >tbody').html('')
            // Swal({
            //     title: 'Aguarde!',
            //     type: 'warning',
            //     html:'<b>Aguarde Localizando!</b>'
            // })
        },
        success:function(result){
            let linhas = '';
            console.log(result)
            $.each(result, function(i,val){
                linhas += '<tr>'
                    linhas +='<td><input class="semBorda direita selecionaCliente" type="text" size="10" value="'+val.id+'"></td>'
                    linhas +='<td>'+val.cliente+'</td>'
                linhas += '</tr>'
            })
            $(document).find('#tbConsultaCliente >tbody').html(linhas)
        },
        complete:function(){
            swal.close();
        }
    })
}

function localizaNomeCliente(){
    let cliente_id = $(document).find('#cliente_id').val();
    let route = '/proposta/localizaNomeCliente';
    let dados = {
        'cliente_id': cliente_id,
    };
    $.ajax({
        data: dados,
        type: 'post',
        dataType: 'JSON',
        url: url + route,
        beforeSend:function(){
            $(document).find().val('');
            Swal({
                title: 'Aguarde!',
                type: 'warning',
                html:'<b>Aguarde Localizando!</b>'
            })
        },
        success:function(result){
            $(document).find('#cliente').val(result.cliente);
        },
        complete:function(){
            swal.close();
        }
    })
}

function bg_localizaProduto(nome){
    let route = '/proposta/bg_localizaProduto';
    let dados = {
        'nome': nome,
    };
    $.ajax({
        data: dados,
        type: 'post',
        dataType: 'JSON',
        url: url + route,
        beforeSend:function(){
            $(document).find('#tbConsultaProduto >tbody').html('')
            Swal({
                title: 'Aguarde!',
                type: 'warning',
                // timer:2000
            })
        },
        success:function(result){
            let linhas = '';
            console.log(result)
            $.each(result, function(i,val){
                linhas += '<tr >'
                    linhas +='<td rowspan="2" align="center" class="verticalCenter"><input type="text" class="semBorda direita selecionaProduto" size="10"  value="'+val.pr_cod+'"></td>'
                    linhas +='<td bgcolor="#f3f3f3">'+val.pr_nom+'</td>'
                linhas += '</tr>'
                linhas += '<tr bgcolor="#F9F9F9">'
                    linhas +='<td colspan="0"><b><i>Ultimas Entradas</i></b>'
                        linhas +='<table class="table caption-top fonte-8">'
                            linhas+="<thead>"
                            linhas +='<tr><th>Data</th><th>Valor Unit.</th><th>% ICMS</th><th>% COFINS + PIS</th></tr>'
                            linhas+="<thead>"
                            linhas+="<tbody>"
                            $.each(val.entradas, function(i1,val1){
                                linhas += '<tr>'
                                    linhas +='<td>'+val1.data+'</td>';
                                    linhas +='<td align="right">'+formCurrency.format(val1.val_unit).replace('R$', '').replace(/\s/g, '')+'</td>';
                                    linhas +='<td align="right">'+formCurrency.format(val1.per_icms).replace('R$', '').replace(/\s/g, '')+'</td>';
                                    linhas +='<td align="right">'+formCurrency.format(val1.per_cofins+val1.per_pis).replace('R$', '').replace(/\s/g, '')+'</td>';
                                linhas += '</tr>'
                            })
                            linhas+="<tbody>"
                        linhas +='</table>'
                    linhas +='</td>'
                linhas += '</tr>'

            })
            $(document).find('#tbConsultaProduto >tbody').html(linhas)
        },
        complete:function(){
            swal.close();
        }
    })
}

function localizaNomeProduto(){
    let produto_id = $(document).find('#md_cod_produto').val();
    let route = '/proposta/localizaNomeProduto';
    let dados = {
        'produto_id': produto_id,
    };
    $.ajax({
        data: dados,
        type: 'post',
        dataType: 'JSON',
        url: url + route,
        beforeSend:function(){
            $(document).find().val('');
            Swal({
                title: 'Aguarde!',
                type: 'warning',
                html:'<b>Aguarde Localizando!</b>'
            })
            $(document).find('#md_und').val('');
            $(document).find('#md_unt_custo').val('');
            $(document).find('#md_impostos_credito').val('');
            $(document).find('#md_produto').val('');
            $(document).find('#md_marca').val('');
        },
        success:function(result){
            $(document).find('#md_produto').val(result.pr_nom);
            $(document).find('#md_marca').val(result.pr_nom_reduz);
            if(result.entradas[0]){
                $(document).find('#md_und').val(result.entradas[0].und);
                $(document).find('#md_unt_custo').val(formCurrency.format(result.entradas[0].val_unit).replace('R$', '').replace(/\s/g, ''));
                $(document).find('#md_impostos_credito').val(formCurrency.format(result.entradas[0].per_icms).replace('R$', '').replace(/\s/g, ''));
            }
        },
        complete:function(){
            swal.close();
        }
    })
}

function importaItens(){
    let texto = $(document).find('#texto').val();

    let route = '/proposta/insereItens';
    let dados = {
        'texto'        : texto,
    };

    $.ajax({
        data: dados,
        type: 'post',
        dataType: 'JSON',
        url: url + route,
        beforeSend: function(){
            Swal({
                title: 'Aguarde!',
                type: 'warning',
                // timer:2000
            })
        },
        success:function(result){
            console.log(result);
            $(document).find('#texto').val('');
            $(document).find('#texto').val(result)
        },
        complete:function(){
            Swal({
                title: 'Arquivo processado!',
                type: 'success',
                timer:2000
            })
        }
    })
}


function atualizaModalItem(){
    let seq1 = 1;
    $('.seq').each(function(){
        seq1 = parseInt($(this).val())+1;
    })

    $(document).find('#md_lote').focus();
    $(document).find('#md_seq').val(seq1);
    $(document).find('#md_cod_produto').val('');
    $(document).find('#md_produto').val('');
    $(document).find('#md_marca').val('');
    $(document).find('#md_modelo').val('');
    $(document).find('#md_qtd').val('');
    $(document).find('#md_und').val('');
    $(document).find('#md_unt_edital').val('');
    $(document).find('#md_total_edital').val('');
    $(document).find('#md_unt_custo').val('');
    $(document).find('#md_total_custo').val('');
    $(document).find('#md_descricao').val('');
    $(document).find('#md_obs').val('');
}
