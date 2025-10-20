$(document).ready(function () {
    /*************************pegando a url do servidor***********************************/
        url = $('input#appurl').val();

        // precoVendaForEach();

    /***********************fecha slide bar***********************************************/
        $(document).find('#container').addClass('sidebar-closed');
        $(document).find('#sidebar > ul').hide();
        $(document).find('#main-content').addClass('sidebar-closed');


    /*************************preço de venda pela margem**********************************/
    $(document).on('change','.calc_pre_venda',function(event){
        event.preventDefault()
        let id = $(this).attr('id').replace(/[^0-9]/g,'');
        precoVenda(id);
    })

    $(document).on('change','.precoVendaForEach',function(event){
        event.preventDefault()
        precoVendaForEach()
    })
    /*************************preço de venda pelo valor***********************************/
    $(document).on('change','.calc_pre_venda_valor',function(event){
        event.preventDefault()
        let id = $(this).attr('id').replace(/[^0-9]/g,'');
        precoVendaValor(id);
    })
    /**********************altera emmpresa************************************************/
    $(document).on('change','.alteraEmpresa',function(event){
        event.preventDefault()
        let empresa_id = $(this).val()
        alteraEmpresa(empresa_id);
    })

    /***************************cadastro do proposta**************************************/
        $(document).on('submit', 'form#cadastro-precificacao', function (event) {
            event.preventDefault()
            let route = $(this).find('input#route').val();
            let type = $(this).find('input#type').val();
            let origem = 'precificacao'

            let empresa_id = $(document).find('#empresa').val();
            let prazo = $(document).find('#prazoMedio').val();
            let taxa_financeira = $(document).find('#taxa_financeira').val();


            let id = [];
            $(document).find('input[name="id[]"]').each(function(index){
                id.push($(this).val());
            })

            let qtd = [];
            $(document).find('input[name="qtd[]"]').each(function(index){
                qtd.push($(this).val());
            })

            let unt_custo = [];
            $(document).find('input[name="unt_custo[]"]').each(function(index){
                unt_custo.push($(this).val());
            })

            let total_custo = [];
            $(document).find('input[name="total_custo[]"]').each(function(index){
                total_custo.push($(this).val());
            })

            let impostos_credito = [];
            $(document).find('input[name="imposto_custo[]"]').each(function(index){
                impostos_credito.push($(this).val());
            })

            let imposto_venda = [];
            $(document).find('input[name="imposto_venda[]"]').each(function(index){
                imposto_venda.push($(this).val());
            })

            let ir_csll = [];
            $(document).find('input[name="ir_csll[]"]').each(function(index){
                ir_csll.push($(this).val());
            })
            let outros = [];
            $(document).find('input[name="outros[]"]').each(function(index){
                outros.push($(this).val());
            })

            let difal = [];
            $(document).find('input[name="difal[]"]').each(function(index){
                difal.push($(this).val());
            })

            let frete = [];
            $(document).find('input[name="frete[]"]').each(function(index){
                frete.push($(this).val());
            })

            let despesa_fixa = [];
            $(document).find('input[name="despesa_fixa[]"]').each(function(index){
                despesa_fixa.push($(this).val());
            })

            let comissao = [];
            $(document).find('input[name="comissao[]"]').each(function(index){
                comissao.push($(this).val());
            })

            let margem = [];
            $(document).find('input[name="margem[]"]').each(function(index){
                margem.push($(this).val());
            })

            let unt_venda = [];
            $(document).find('input[name="unt_venda[]"]').each(function(index){
                unt_venda.push($(this).val());
            })

            let total_venda = [];
            $(document).find('input[name="vlrVenda[]"]').each(function(index){
                total_venda.push($(this).val());
            })



            /*****************************************************************************/
            if (!id ) {
                Swal({
                    title: 'Preencha todos os campos obrigatório',
                    type: 'error',
                    timer: 3000
                })
            } else {
                let dados = {
                    'id'                    :id
                    ,'empresa_id'           :empresa_id
                    ,'taxa_financeira'      :taxa_financeira
                    ,'prazo'                :prazo
                    ,'qtd'                  :qtd
                    ,'unt_custo'            :unt_custo
                    ,'total_custo'          :total_custo
                    ,'impostos_credito'     :impostos_credito
                    ,'imposto_venda'        :imposto_venda
                    ,'ir_csll'              :ir_csll
                    ,'outros'               :outros
                    ,'difal'                :difal
                    ,'frete'                :frete
                    ,'despesa_fixa'         :despesa_fixa
                    ,'comissao'             :comissao
                    ,'margem'               :margem
                    ,'unt_venda'            :unt_venda
                    ,'total_venda'          :total_venda

                }
                // console.log(dados,route,type,origem);
                cadastrar(dados,route,type,origem);
            }
        })

})
