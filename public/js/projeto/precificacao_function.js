function alteraEmpresa(empresa_id){
    let route = '/precificacao/alteraEmpresa';
    let proposta_id = $(document).find('#proposta_id').val();
    let dados = {
        'empresa_id'    : empresa_id
        ,'proposta_id'  : proposta_id
    };alteraEmpresa
    $.ajax({
        data: dados,
        type: 'post',
        dataType: 'JSON',
        url: url + route,
        beforeSend:function(){
            Swal({
                title: 'Aguarde!',
                type: 'warning',
                html:'<b>Aguarde calculando!</b>'
            })
        },
        success:function(result){
            console.log(result);
            $(document).find('#taxa_financeira').val(result[0].taxa_financeira)
            let imposto_venda   = 0;
            let difal           = 0;

            $.each(result, function (result, val) {
                console.log(val)
                let id = val.proposta_item_id;
                imposto_venda = (val.aliq_icms*(val.base_icms/100)) + val.pis + val.cofins
                imposto_venda = (formCurrency.format(imposto_venda)).replace('R$', '').replace(/\s/g, '');
                $(document).find('#imposto_venda'+id).val(imposto_venda)

                if(val.origem=='mysql'){
                    difal = val.difal
                }else{
                    difal = parseFloat(val.aliq_iterna) - parseFloat(val.aliq_icms)
                    difal = (formCurrency.format(difal)).replace('R$', '').replace(/\s/g, '');
                }
                $(document).find('#difal'+id).val(difal)

                ir_csll = parseFloat(val.ir_csll)
                ir_csll = (formCurrency.format(ir_csll)).replace('R$', '').replace(/\s/g, '');
                $(document).find('#ir_csll'+id).val(ir_csll)

                outros = parseFloat(val.outros)
                outros = (formCurrency.format(outros)).replace('R$', '').replace(/\s/g, '');
                $(document).find('#outros'+id).val(outros)

                comissao = parseFloat(val.comissao)
                comissao = (formCurrency.format(comissao)).replace('R$', '').replace(/\s/g, '');
                $(document).find('#comissao'+id).val(comissao)

                frete = parseFloat(val.frete)
                frete = (formCurrency.format(frete)).replace('R$', '').replace(/\s/g, '');
                $(document).find('#frete'+id).val(frete)

                despesa_fixa = parseFloat(val.despesa_fixa)
                despesa_fixa = (formCurrency.format(despesa_fixa)).replace('R$', '').replace(/\s/g, '');
                $(document).find('#despesa_fixa'+id).val(despesa_fixa)

                margem = parseFloat(val.margem)
                margem = (formCurrency.format(margem)).replace('R$', '').replace(/\s/g, '');
                $(document).find('#margem'+id).val(margem)

                imposto_custo = parseFloat(val.imposto_custo)
                imposto_custo = (formCurrency.format(imposto_custo)).replace('R$', '').replace(/\s/g, '');
                $(document).find('#imposto_custo'+id).val(imposto_custo)

            })
        },
        complete:function(){
            precoVendaForEach();
            Swal.close();
        }
    })
}

function precoVendaForEach(){
    $('.calc_pre_venda').each(function(index, element) {
        let id = element.id.replace(/[^0-9]/g,'');
        precoVenda(id)
    });
}

function precoVenda(id){
        let vlr_venda       = 0;
        let vlr_venda_unt   = 0;
        let markup          = 0;
        let markup_ir_csl   = 0;
        let custo           = $(document).find('#total_custo'+id).val().replaceAll('.','').replaceAll(',','.');
        let imposto_custo   = $(document).find('#imposto_custo'+id).val().replaceAll('.','').replaceAll(',','.');
        let imposto_venda   = $(document).find('#imposto_venda'+id).val().replaceAll('.','').replaceAll(',','.');
        let difal           = $(document).find('#difal'+id).val().replaceAll('.','').replaceAll(',','.');
        let ir_csll         = $(document).find('#ir_csll'+id).val().replaceAll('.','').replaceAll(',','.');
        let outros          = $(document).find('#outros'+id).val().replaceAll('.','').replaceAll(',','.');
        let comissao        = $(document).find('#comissao'+id).val().replaceAll('.','').replaceAll(',','.');
        let frete           = $(document).find('#frete'+id).val().replaceAll('.','').replaceAll(',','.');
        let despesa_fixa    = $(document).find('#despesa_fixa'+id).val().replaceAll('.','').replaceAll(',','.');
        let margem          = $(document).find('#margem'+id).val().replaceAll('.','').replaceAll(',','.');
        let qtd             = $(document).find('#qtd'+id).val().replaceAll('.','').replaceAll(',','.');
        let prazoMedio      = parseFloat($(document).find('#prazoMedio').val());
        let taxa_financeira = parseFloat($(document).find('#taxa_financeira').val());
        let custo_unt       = 0;
        let equivalencia    = Math.pow( (taxa_financeira/100+1),(prazoMedio/30) ) ;

        let vlrVendaUnt        = parseFloat($(document).find('#vlrVendaUnt'+id).val().replaceAll('.','').replaceAll(',','.'));
        let vlrVenda        = parseFloat($(document).find('#vlrVenda'+id).val().replaceAll('.','').replaceAll(',','.'));
        let total_edital    = parseFloat($(document).find('#total_edital'+id).val().replaceAll('.','').replaceAll(',','.'));

        if(isNaN(equivalencia)){equivalencia = 1};

        imposto_venda   = imposto_venda/100;
        imposto_custo   = imposto_custo/100;
        custo           = custo* ((imposto_custo-1)*-1)
        custo_unt       = custo / qtd
        difal           = difal/100;
        ir_csll         = ir_csll/100;
        outros          = outros/100;
        comissao        = comissao/100;
        frete           = frete/100;
        despesa_fixa    = despesa_fixa/100;
        margem          = margem/100;


        /***************preco de venda a prazo***************************/
        if(margem>=0){
            if(equivalencia<=0 || equivalencia === 'undefined'){equivalencia = 1}
            markup_ir_csl = 1-((ir_csll*equivalencia));
            markup = (((1-(margem/markup_ir_csl))/(equivalencia))-imposto_venda-frete-comissao-despesa_fixa-difal-outros)
            vlr_venda_unt  = (custo_unt/markup);
            vlr_venda  = vlr_venda_unt * qtd;
        };

        fundoValor(total_edital,vlr_venda,id)
        fundoMargem(margem,id)

        vlrVendaUnt =vlr_venda/qtd;

        vlr_venda = (formCurrency.format(vlr_venda)).replace('R$', '').replace(/\s/g, '');
        vlrVendaUnt = (formCurrency.format(vlrVendaUnt)).replace('R$', '').replace(/\s/g, '');
        $(document).find('#vlrVenda'+id).val(vlr_venda);
        $(document).find('#vlrVendaUnt'+id).val(vlrVendaUnt);
}

function precoVendaValor(id){
        let custo           = $(document).find('#total_custo'+id).val().replaceAll('.','').replaceAll(',','.');
        let imposto_custo   = $(document).find('#imposto_custo'+id).val().replaceAll('.','').replaceAll(',','.');
        let imposto_venda   = $(document).find('#imposto_venda'+id).val().replaceAll('.','').replaceAll(',','.');
        let difal           = $(document).find('#difal'+id).val().replaceAll('.','').replaceAll(',','.');
        let ir_csll         = $(document).find('#ir_csll'+id).val().replaceAll('.','').replaceAll(',','.');
        let outros          = $(document).find('#outros'+id).val().replaceAll('.','').replaceAll(',','.');
        let comissao        = $(document).find('#comissao'+id).val().replaceAll('.','').replaceAll(',','.');
        let frete           = $(document).find('#frete'+id).val().replaceAll('.','').replaceAll(',','.');
        let despesa_fixa    = $(document).find('#despesa_fixa'+id).val().replaceAll('.','').replaceAll(',','.');
        let qtd             = $(document).find('#qtd'+id).val().replaceAll('.','').replaceAll(',','.');
        let prazoMedio      = parseFloat($(document).find('#prazoMedio').val());
        let taxa_financeira = parseFloat($(document).find('#taxa_financeira').val());
        let custo_unt       = 0;
        let equivalencia    = Math.pow( (taxa_financeira/100+1),(prazoMedio/30) ) ;

        let vlrVenda        = parseFloat($(document).find('#vlrVenda'+id).val().replaceAll('.','').replaceAll(',','.'));
        let total_edital    = parseFloat($(document).find('#total_edital'+id).val().replaceAll('.','').replaceAll(',','.'));


        if(isNaN(equivalencia)){equivalencia = 1};

        imposto_venda   = imposto_venda/100;
        imposto_custo   = imposto_custo/100;
        custo           = custo* ((imposto_custo-1)*-1)
        custo_unt       = custo / qtd
        difal           = difal/100;
        ir_csll         = ir_csll/100;
        outros          = outros/100;
        comissao        = comissao/100;
        frete           = frete/100;
        despesa_fixa    = despesa_fixa/100;

        let impostos_desp_perc = imposto_venda+difal+outros+comissao+frete+despesa_fixa
        let impostos_desp = (vlrVenda * impostos_desp_perc);
        let impostos_desp_fin = impostos_desp * equivalencia;
        let custo_fin = custo * equivalencia;
        let vlrVendaAntes_ir_csll =  vlrVenda - (custo_fin+impostos_desp_fin)
        let imposto_ir_csll = (vlrVendaAntes_ir_csll * ir_csll)* equivalencia
        let margem = vlrVenda - (custo_fin+impostos_desp_fin+imposto_ir_csll)
        let margem_perc = (margem/vlrVenda)*100
        let vlrVendaUnt = vlrVenda/qtd

        fundoValor(total_edital,vlrVenda,id)
        fundoMargem(margem_perc,id)


        margem_perc  = formCub.format(margem_perc).replace('R$', '').replace(/\s/g, '')
        vlrVendaUnt  = formCurrency.format(vlrVendaUnt).replace('R$', '').replace(/\s/g, '')
        vlrVenda  = formCurrency.format(vlrVenda).replace('R$', '').replace(/\s/g, '')

        $(document).find('#margem'+id).val(margem_perc)
        $(document).find('#vlrVendaUnt'+id).val(vlrVendaUnt)
        $(document).find('#vlrVenda'+id).val(vlrVenda)


}

function fundoValor(total_edital,vlrVenda,id){
    let controla_preco_minimo = $(document).find('#controla_preco_minimo').val();
    let css_edital      = 'fundoAmarelo'
    if(total_edital >= vlrVenda || controla_preco_minimo!='S'){
        $(document).find('#linhaPrecificacao'+id).removeClass(css_edital);
    }else{
        $(document).find('#linhaPrecificacao'+id).addClass(css_edital);
    }
}

function fundoMargem(margem_perc,id){
    let css_margem      = 'fundoVermelho'
    if(margem_perc <= 0){
        $(document).find('#margem'+id).addClass(css_margem);
    }else{
        $(document).find('#margem'+id).removeClass(css_margem);
    }
}

