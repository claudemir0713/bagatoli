function alteraEmpresa(empresa_id){
    let route = '/precificacao/alteraEmpresa';
    let proposta_id = $(document).find('#proposta_id').val();
    let dados = {
        'empresa_id'    : empresa_id
        ,'proposta_id'  : proposta_id
    };
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
                console.log(val);
                let id = val.proposta_item_id;
                let icms = 0
                if(val.base_icms==100){
                    icms  = (val.aliq_icms*((val.base_icms)/100))
                }else{
                    icms  = (val.aliq_icms*((100-val.base_icms)/100))
                }
                imposto_venda =  icms + val.pis + val.cofins
                imposto_venda = (formCurrency.format(imposto_venda)).replace('R$', '').replace(/\s/g, '');
                $(document).find('#imposto_venda'+id).val(imposto_venda)
                $(document).find('#imposto_venda'+id).prop('title', val.regra);

                difal = (formCurrency.format(val.difal)).replace('R$', '').replace(/\s/g, '');


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
            calculaCard()
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

        let vlrVendaUnt     = parseFloat($(document).find('#vlrVendaUnt'+id).val().replaceAll('.','').replaceAll(',','.'));
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
        calculaCard()
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
        calculaCard()
}

function fundoValor(total_edital,vlrVenda,id){
    let controla_preco_minimo = $(document).find('#controla_preco_minimo').val();
    let css_edital      = 'fundoAmarelo'
    if(total_edital >= vlrVenda || controla_preco_minimo!='S' || total_edital==0){
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

function calculaCard(){
    let lote                = '';
    let vlrVenda            = 0;
    let somaVlrVenda        = 0;
    let somaVlrVendaLote    = 0
    let total_custo         = 0;
    let custo               = 0;
    let imposto_custo       = 0;
    let imposto_venda       = 0;
    let imposto             = 0;
    let difal               = 0;
    let vlrDifal            = 0;
    let outros              = 0;
    let vlrOutros           = 0;
    let comissao            = 0;
    let vlrComissao         = 0;
    let frete               = 0;
    let vlrFrete            = 0;
    let despesa_fixa        = 0;
    let ir_csll             = 0;
    let vlrDespesa_fixa     = 0;
    let prazoMedio          = parseFloat($(document).find('#prazoMedio').val());
    let taxa_financeira     = parseFloat($(document).find('#taxa_financeira').val());
    let equivalencia        = Math.pow( (taxa_financeira/100+1),(prazoMedio/30) ) ;
    let mc                  = 0;
    let vlrMc               = 0;
    let lucroBruto          = 0;
    let lucro               = 0;
    let vlrLucro            = 0;


    $('.vlrVenda').each(function(index, element){
        let id = element.id.replace(/[^0-9]/g,'');

        vlrVenda            = parseFloat($(this).val().replaceAll('.','').replaceAll(',','.'));
        somaVlrVenda        += vlrVenda
        somaVlrVendaLote    += vlrVenda

        if(lote!=$(document).find('#lote'+id).val() && lote.trim!=''){
            lote            = $(document).find('#lote'+id).val();
            calculaCardLote(lote,equivalencia);
        }

        imposto_custo   = parseFloat($(document).find('#imposto_custo'+id).val().replaceAll('.','').replaceAll(',','.'));
        custo           = parseFloat($(document).find('#total_custo'+id).val().replaceAll('.','').replaceAll(',','.'));

        custo           = (custo*(1-(imposto_custo/100)))*equivalencia;
        total_custo     += custo

        imposto         = parseFloat($(document).find('#imposto_venda'+id).val().replaceAll('.','').replaceAll(',','.'));
        difal           = parseFloat($(document).find('#difal'+id).val().replaceAll('.','').replaceAll(',','.'));
        outros          = parseFloat($(document).find('#outros'+id).val().replaceAll('.','').replaceAll(',','.'));
        comissao        = parseFloat($(document).find('#comissao'+id).val().replaceAll('.','').replaceAll(',','.'));
        frete           = parseFloat($(document).find('#frete'+id).val().replaceAll('.','').replaceAll(',','.'));
        ir_csll         = parseFloat($(document).find('#ir_csll'+id).val().replaceAll('.','').replaceAll(',','.'));

        despesa_fixa    = parseFloat($(document).find('#despesa_fixa'+id).val().replaceAll('.','').replaceAll(',','.'));

        imposto         = (vlrVenda * (imposto/100))*equivalencia
        difal           = (vlrVenda * (difal/100))*equivalencia
        outros          = (vlrVenda * (outros/100))*equivalencia
        comissao        = (vlrVenda * (comissao/100))*equivalencia
        frete           = (vlrVenda * (frete/100))*equivalencia
        mc              =  vlrVenda - (custo+imposto+difal+outros+comissao+frete)
        despesa_fixa    = (vlrVenda * (despesa_fixa/100))*equivalencia
        lucroBruto      = mc - despesa_fixa
        ir_csll         = (lucroBruto * (ir_csll/100))*equivalencia
        lucro           = (lucroBruto - ir_csll)

        imposto_venda   += imposto
        vlrDifal        += difal
        vlrOutros       += outros
        vlrComissao     += comissao
        vlrFrete        += frete
        vlrDespesa_fixa += despesa_fixa
        vlrMc           += mc
        vlrLucro        += lucro
    })
    if( ((vlrLucro/somaVlrVenda)*100).toFixed(2) <=0 ){
        $(document).find('#lucroCard').removeClass();
        $(document).find('#lucroCard').addClass('card text-white bg-danger');
    }else if(((vlrLucro/somaVlrVenda)*100).toFixed(2) <=2 ){
        $(document).find('#lucroCard').removeClass();
        $(document).find('#lucroCard').addClass('card text-white bg-warning');
    }else{
        $(document).find('#lucroCard').removeClass();
        $(document).find('#lucroCard').addClass('card text-white bg-success');
    }


    if( ((vlrMc/somaVlrVenda)*100).toFixed(2) <=0){
        $(document).find('#mcCard').removeClass();
        $(document).find('#mcCard').addClass('card text-white bg-danger');
    }else if( ((vlrMc/somaVlrVenda)*100).toFixed(2)  <=2 ){
        $(document).find('#mcCard').removeClass();
        $(document).find('#mcCard').addClass('card text-white bg-warning');
    }else{
        $(document).find('#mcCard').removeClass();
        $(document).find('#mcCard').addClass('card text-white bg-success');
    }

    $(document).find('.fatCard').html(formCurrency.format(somaVlrVenda).replace('R$', '').replace(/\s/g, ''))
    $(document).find('.mcCard').html(formCurrency.format((vlrMc/somaVlrVenda)*100).replace('R$', '').replace(/\s/g, ''))
    $(document).find('.lucroCard').html(formCurrency.format((vlrLucro/somaVlrVenda)*100).replace('R$', '').replace(/\s/g, ''))
}

function calculaCardLote(lote,equivalencia){
    let vlrVenda            = 0;
    let somaVlrVenda        = 0;
    let somaVlrVendaLote    = 0
    let total_custo         = 0;
    let custo               = 0;
    let imposto_custo       = 0;
    let imposto_venda       = 0;
    let imposto             = 0;
    let difal               = 0;
    let vlrDifal            = 0;
    let outros              = 0;
    let vlrOutros           = 0;
    let comissao            = 0;
    let vlrComissao         = 0;
    let frete               = 0;
    let vlrFrete            = 0;
    let despesa_fixa        = 0;
    let ir_csll             = 0;
    let vlrDespesa_fixa     = 0;
    let mc                  = 0;
    let vlrMc               = 0;
    let lucroBruto          = 0;
    let lucro               = 0;
    let vlrLucro            = 0;



    $('.'+lote).each(function(index, element){
        let id = $(this).attr('id').replace(/[^0-9]/g,'');
        let vlrVenda    = parseFloat($(this).val().replaceAll('.','').replaceAll(',','.'))

        imposto_custo   = parseFloat($(document).find('#imposto_custo'+id).val().replaceAll('.','').replaceAll(',','.'));
        custo           = parseFloat($(document).find('#total_custo'+id).val().replaceAll('.','').replaceAll(',','.'));
        custo               = (custo*(1-(imposto_custo/100)))*equivalencia;
        total_custo     += custo

        imposto         = parseFloat($(document).find('#imposto_venda'+id).val().replaceAll('.','').replaceAll(',','.'));
        difal           = parseFloat($(document).find('#difal'+id).val().replaceAll('.','').replaceAll(',','.'));
        outros          = parseFloat($(document).find('#outros'+id).val().replaceAll('.','').replaceAll(',','.'));
        comissao        = parseFloat($(document).find('#comissao'+id).val().replaceAll('.','').replaceAll(',','.'));
        frete           = parseFloat($(document).find('#frete'+id).val().replaceAll('.','').replaceAll(',','.'));
        ir_csll         = parseFloat($(document).find('#ir_csll'+id).val().replaceAll('.','').replaceAll(',','.'));

        despesa_fixa    = parseFloat($(document).find('#despesa_fixa'+id).val().replaceAll('.','').replaceAll(',','.'));

        imposto         = (vlrVenda * (imposto/100))*equivalencia
        difal           = (vlrVenda * (difal/100))*equivalencia
        outros          = (vlrVenda * (outros/100))*equivalencia
        comissao        = (vlrVenda * (comissao/100))*equivalencia
        frete           = (vlrVenda * (frete/100))*equivalencia
        mc              =  vlrVenda - (custo+imposto+difal+outros+comissao+frete)
        despesa_fixa    = (vlrVenda * (despesa_fixa/100))*equivalencia
        lucroBruto      = mc - despesa_fixa
        ir_csll         = (lucroBruto * (ir_csll/100))*equivalencia
        lucro           = (lucroBruto - ir_csll)

        imposto_venda   += imposto
        vlrDifal        += difal
        vlrOutros       += outros
        vlrComissao     += comissao
        vlrFrete        += frete
        vlrDespesa_fixa += despesa_fixa
        vlrMc           += mc
        vlrLucro        += lucro

        somaVlrVenda += vlrVenda
    })

    if( ((vlrLucro/somaVlrVenda)*100).toFixed(2) <=0 ){
        $(document).find('#lucro'+lote).removeClass();
        $(document).find('#lucro'+lote).addClass('fundoVermelho');
    }else if(((vlrLucro/somaVlrVenda)*100).toFixed(2) <=2 ){
        $(document).find('#lucro'+lote).removeClass();
        $(document).find('#lucro'+lote).addClass('fundoAmarelo');
    }else{
        $(document).find('#lucro'+lote).removeClass();
        $(document).find('#lucro'+lote).addClass('fundoVerde');
    }


    if( ((vlrMc/somaVlrVenda)*100).toFixed(2) <=0){
        $(document).find('#mc'+lote).removeClass();
        $(document).find('#mc'+lote).addClass('fundoVermelho');
    }else if( ((vlrMc/somaVlrVenda)*100).toFixed(2)  <=2 ){
        $(document).find('#mc'+lote).removeClass();
        $(document).find('#mc'+lote).addClass('fundoAmarelo');
    }else{
        $(document).find('#mc'+lote).removeClass();
        $(document).find('#mc'+lote).addClass('fundoVerde');
    }


    $(document).find('.mc'+lote).html(formCurrency.format((vlrMc/somaVlrVenda)*100).replace('R$', '').replace(/\s/g, ''))
    $(document).find('.lucro'+lote).html(formCurrency.format((vlrLucro/somaVlrVenda)*100).replace('R$', '').replace(/\s/g, ''))
    $(document).find('.total'+lote).html(formCurrency.format((somaVlrVenda)).replace('R$', '').replace(/\s/g, ''))

}
