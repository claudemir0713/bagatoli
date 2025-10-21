$(document).ready(function () {
    /*************************pegando a url do servidor**************************************/
        url = $('input#appurl').val();

    /***************************localiza cliente******************************************/
        $(document).on('keyup','.localizaCliente',function(event){
            if(event.which==113){
                $("#ModalLocalizaCliente").modal("show");
            }
        })
        $('#ModalLocalizaCliente').on('shown.bs.modal', function (event) {
            $(document).find('#md_localizaCliente').focus();
        })

        /**********************localizaProduto**************************/
        $(document).on('keyup','#md_localizaCliente',function(event){
            let cliente = $(this).val();
            if(cliente.length>=1){
                bg_localizaCliente(cliente)
            }
        })

        /**********************NomeCliente**************************/
        $(document).on('change','.localizaCliente',function(event){
            localizaNomeCliente()
        })
        /**********************selecionaCliente**************************/
        $(document).on('keyup','.selecionaCliente',function(event){
            if(event.which==13){
                let cliente_id = $(this).val();
                $(document).find('#cliente_id').val(cliente_id)
                localizaNomeCliente()
                $("#ModalLocalizaCliente").modal("hide");
                $(document).find('#cliente_id').focus();
            }
        })

    /**********************selecionaProduto**************************/
        $(document).on('keyup','.selecionaProduto',function(event){
            if(event.which==13){
                let md_cod_produto = $(this).val();
                $(document).find('#md_cod_produto').val(md_cod_produto)
                localizaNomeCliente()
                $("#ModalLocalizaProduto").modal("hide");
                localizaNomeProduto()
                $(document).find('#md_cod_produto').focus();
            }
        })
        /**********************NomeCliente**************************/
        $(document).on('change','.localizaProduto',function(event){
            localizaNomeProduto()
        })


    /***************************cadastro do proposta**************************************/
        $(document).on('submit', 'form#cadastro-proposta', function (event) {
            event.preventDefault()
            let route = $(this).find('input#route').val();
            let type = $(this).find('input#type').val();
            let origem = 'proposta'

            let cliente_id = $(this).find('#cliente_id').val();
            let tipo_licitacao_id = $(this).find('#tipo_licitacao_id').val();
            let data = $(this).find('#data').val();
            let nr_processo = $(this).find('#nr_processo').val();
            let nr_pregao = $(this).find('#nr_pregao').val();
            let data_processo = $(this).find('#data_processo').val();
            let hora_processo = $(this).find('#hora_processo').val();
            let data_entrega_proposta = $(this).find('#data_entrega_proposta').val();
            let hora_entrega_proposta = $(this).find('#hora_entrega_proposta').val();
            let portal_de_compras = $(this).find('#portal_de_compras').val();
            let id_portal_compras = $(this).find('#id_portal_compras').val();
            let obs = $(this).find('#obs').val();

            let seq = [];
            $(document).find('input[name="seq[]"]').each(function(index){
                seq.push($(this).val());
            })

            let lote = [];
            $(document).find('input[name="lote[]"]').each(function(index){
                lote.push($(this).val());
            })

            let lote_descricao = [];
            $(document).find('input[name="lote_descricao[]"]').each(function(index){
                lote_descricao.push($(this).val());
            })

            let cod_produto = [];
            $(document).find('input[name="cod_produto[]"]').each(function(index){
                cod_produto.push($(this).val());
            })
            let produto = [];
            $(document).find('input[name="produto[]"]').each(function(index){
                produto.push($(this).val());
            })

            let und = [];
            $(document).find('input[name="und[]"]').each(function(index){
                und.push($(this).val());
            })

            let qtd = [];
            $(document).find('input[name="qtd[]"]').each(function(index){
                qtd.push($(this).val());
            })

            let unt_edital = [];
            $(document).find('input[name="unt_edital[]"]').each(function(index){
                unt_edital.push($(this).val());
            })

            let total_edital = [];
            $(document).find('input[name="total_edital[]"]').each(function(index){
                total_edital.push($(this).val());
            })

            let unt_custo = [];
            $(document).find('input[name="unt_custo[]"]').each(function(index){
                unt_custo.push($(this).val());
            })

            let total_custo = [];
            $(document).find('input[name="total_custo[]"]').each(function(index){
                total_custo.push($(this).val());
            })

            let descricao = [];
            $(document).find('textarea[name="descricao[]"]').each(function(index){
                descricao.push($(this).val());
            })

            let marca = [];
            $(document).find('input[name="marca[]"]').each(function(index){
                marca.push($(this).val());
            })

            let modelo = [];
            $(document).find('input[name="modelo[]"]').each(function(index){
                modelo.push($(this).val());
            })

            let frete_custo = [];
            $(document).find('input[name="frete_custo[]"]').each(function(index){
                frete_custo.push($(this).val());
            })

            let impostos_credito = [];
            $(document).find('input[name="impostos_credito[]"]').each(function(index){
                impostos_credito.push($(this).val());
            })

            let obs_item = [];
            $(document).find('input[name="obs_item[]"]').each(function(index){
                obs_item.push($(this).val());
            })

            /********************************************************************************************* */
            if (!descricao ) {
                Swal({
                    title: 'Preencha todos os campos obrigatório',
                    type: 'error',
                    timer: 3000
                })
            } else {
                let dados = {
                    'cliente_id'            :cliente_id
                    ,'tipo_licitacao_id'    :tipo_licitacao_id
                    ,'data'                 :data
                    ,'nr_processo'          :nr_processo
                    ,'nr_pregao'            :nr_pregao
                    ,'data_processo'        :data_processo
                    ,'hora_processo'        :hora_processo
                    ,'data_entrega_proposta':data_entrega_proposta
                    ,'hora_entrega_proposta':hora_entrega_proposta
                    ,'portal_de_compras'    :portal_de_compras
                    ,'id_portal_compras'    :id_portal_compras
                    ,'obs'                  :obs
                    ,'seq'                  :seq
                    ,'lote'                 :lote
                    ,'lote_descricao'       :lote_descricao
                    ,'cod_produto'          :cod_produto
                    ,'produto'              :produto
                    ,'und'                  :und
                    ,'qtd'                  :qtd
                    ,'unt_edital'           :unt_edital
                    ,'total_edital'         :total_edital
                    ,'unt_custo'            :unt_custo
                    ,'total_custo'          :total_custo
                    ,'descricao'            :descricao
                    ,'marca'                :marca
                    ,'modelo'               :modelo
                    ,'obs_item'             :obs_item
                    ,'impostos_credito'     :impostos_credito
                }
                cadastrar(dados,route,type,origem);
            }
        })

    /***************************btnImportaItens******************************************/
        $(document).on('click','#AbreModalImportaItem',function(event){
            $("#ModalImportaItem").modal("show")
        })

        $(document).on('click','.btnImportaItens',function(){
            importaItens();
        })

    /**********************Abre ModalItem**************************************************/
        $(document).on('click','#AbreModalItem',function(event){
            $("#ModalItem").modal("show")
        })

        $('#ModalItem').on('shown.bs.modal', function (event) {
            atualizaModalItem()
        })

        $(document).on('click','#md_addItem',function(event){
            let md_seq = $(document).find('#md_seq').val();
            let md_cod_produto = $(document).find('#md_cod_produto').val();
            let md_produto = $(document).find('#md_produto').val();
            let md_marca = $(document).find('#md_marca').val();
            let md_modelo = $(document).find('#md_modelo').val();
            let md_qtd = $(document).find('#md_qtd').val();
            let md_und = $(document).find('#md_und').val();
            let md_unt_edital = $(document).find('#md_unt_edital').val();
            let md_total_edital = $(document).find('#md_total_edital').val();
            let md_unt_custo = $(document).find('#md_unt_custo').val();
            let md_total_custo = $(document).find('#md_total_custo').val();
            let md_descricao = $(document).find('#md_descricao').val();
            let md_obs = $(document).find('#md_obs').val();
            let md_lote = $(document).find('#md_lote').val();
            let md_lote_descricao = $(document).find('#md_lote_descricao').val();
            let md_frete_custo = $(document).find('#md_frete_custo').val();
            let md_impostos_credito = $(document).find('#md_impostos_credito').val();

            let linha = '';
            linha +='<tr class="sectionItem'+md_seq+'">';
                linha +='<td><input type="text" class="form-control fonte-10 direita seq"                           id="seq'+md_seq+'"          name="seq[]"            value="'+md_seq+'"          ></td>';
                linha +='<td><input type="text" class="form-control fonte-10"                                       id="produto'+md_seq+'"      name="produto[]"        value="'+md_produto+'"      ></td>';
                linha +='<td><input type="text" class="form-control fonte-10"                                       id="und'+md_seq+'"          name="und[]"            value="'+md_und+'"          ></td>';
                linha +='<td><input type="text" class="form-control fonte-10 direita"                               id="qtd'+md_seq+'"          name="qtd[]"            value="'+md_qtd+'"   ></td>';
                linha +='<td><input type="text" class="form-control fonte-10 direita "                              id="unt_edital'+md_seq+'"   name="unt_edital[]"     value="'+md_unt_edital+'"   ></td>';
                linha +='<td><input type="text" class="form-control fonte-10 direita"                               id="total_edital'+md_seq+'" name="total_edital[]"   value="'+md_total_edital+'" ></td>';
                linha +='<td><input type="text" class="form-control fonte-10 direita "                              id="unt_custo'+md_seq+'"    name="unt_custo[]"      value="'+md_unt_custo+'"    ></td>';
                linha +='<td><input type="text" class="form-control fonte-10 direita"                               id="total_custo'+md_seq+'"  name="total_custo[]"    value="'+md_total_custo+'"  ></td>';
                linha +='<td>';
                    linha +='<button type="button" name="delServico[]" id="minusItem'+md_seq+'" value="" class="btn btn-outline-danger fonte-10 removeItem">'
                        linha +='<span class="fas fa-minus"></span>'
                    linha +='</button>'
                linha +='</td>';
            linha +='</tr>';
            linha +='<tr class="sectionItem'+md_seq+'">';
                linha +='<td colspan="3"><textarea type="text" class="form-control fonte-10" id="descricao'+md_seq+'"   name="descricao[]">'+md_descricao+'</textarea></td>';
                linha +='<td colspan="3"><input type="text" class="form-control fonte-10"                id="marca'+md_seq+'"       name="marca[]" value="'+md_marca+'"   ></td>';
                linha +='<td colspan="3">'
                        linha +='<input type="text" class="form-control fonte-10" id="modelo'+md_seq+'"             name="modelo[]"             value="'+md_modelo+'">'
                        linha +='<input type="hidden"                            id="lote'+md_seq+'"               name="lote[]"               value="'+md_lote+'" >'
                        linha +='<input type="hidden"                            id="lote_descricao'+md_seq+'"     name="lote_descricao[]"     value="'+md_lote_descricao+'" >'
                        linha +='<input type="hidden"                            id="cod_produto'+md_seq+'"        name="cod_produto[]"        value="'+md_cod_produto+'" >'
                        linha +='<input type="hidden"                            id="frete_custo'+md_seq+'"        name="frete_custo[]"        value="'+md_frete_custo+'" >'
                        linha +='<input type="hidden"                            id="impostos_credito'+md_seq+'"   name="impostos_credito[]"   value="'+md_impostos_credito+'" >'
                        linha +='<input type="hidden"                            id="obs_item'+md_seq+'"           name="obs_item[]"           value="'+md_obs+'" >'
                linha +='</td>';
            linha +='</tr>';
            linha +='<tr class="sectionItem'+md_seq+'">';
                linha +='<td colspan="9"><hr></td>'
            linha +='</tr>';

            $(document).find('#tbItem >tbody').append(linha);
            // $("#ModalItem").modal("hide")
            atualizaModalItem();
        })

        $(document).on('change','.calc_total_md',function(){
            let qtd = $(document).find('#md_qtd').val()
            let unt = $(document).find('#md_unt_edital').val()

            if(qtd){qtd = qtd.replace('.','').replace(',','.')}
            if(unt){unt = unt.replace('.','').replace(',','.')}

            let total  = parseFloat(qtd)*parseFloat(unt);
            if(isNaN(total)){total = 0};

            total = formCurrency.format(total).replace('R$','');
            $(document).find('#md_total_edital').val(total)

        })

        $(document).on('change','.calc_custo_md',function(){
            let qtd = $(document).find('#md_qtd').val()
            let unt = $(document).find('#md_unt_custo').val()

            if(qtd){qtd = qtd.replace('.','').replace(',','.')}
            if(unt){unt = unt.replace('.','').replace(',','.')}

            let total  = parseFloat(qtd)*parseFloat(unt);
            if(isNaN(total)){total = 0};

            total = formCurrency.format(total).replace('R$','');
            $(document).find('#md_total_custo').val(total)
        })

        $(document).on('change','.calc_total',function(){
            let id = $(this).attr('id').replace(/[^0-9]/g,'');
            let qtd = $(document).find('#qtd'+id).val()
            let unt = $(document).find('#unt_edital'+id).val()

            if(qtd){qtd = qtd.replace('.','').replace(',','.')}
            if(unt){unt = unt.replace('.','').replace(',','.')}

            let total  = parseFloat(qtd)*parseFloat(unt);
            if(isNaN(total)){total = 0};

            total = formCurrency.format(total).replace('R$','');
            $(document).find('#total_edital'+id).val(total)

        })

        $(document).on('change','.calc_custo',function(){
            let id = $(this).attr('id').replace(/[^0-9]/g,'');
            let qtd = $(document).find('#qtd'+id).val()
            let unt = $(document).find('#unt_custo'+id).val()

            if(qtd){qtd = qtd.replace('.','').replace(',','.')}
            if(unt){unt = unt.replace('.','').replace(',','.')}

            let total  = parseFloat(qtd)*parseFloat(unt);
            if(isNaN(total)){total = 0};

            total = formCurrency.format(total).replace('R$','');
            $(document).find('#total_custo'+id).val(total)
        })



    /**********************Abre ModalLocalizaProduto**************************************************/
        $(document).on('keyup','#md_cod_produto',function(event){
            if(event.which==113){
                $("#ModalLocalizaProduto").modal("show")
            }
        })
        $('#ModalLocalizaProduto').on('shown.bs.modal', function (event) {
            $(document).find('#md_localizaProduto').focus();
        })

        /**********************localizaProduto**************************/
        $(document).on('keyup','#md_localizaProduto',function(event){
            if(event.which==13){
                let nome = $(this).val();
                bg_localizaProduto(nome)
            }
        })
})
