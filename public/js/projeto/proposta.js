$(document).ready(function () {
    /*************************pegando a url do servidor**************************************/
        url = $('input#appurl').val();

    /***************************localiza cliente******************************************/
        $(document).on('keyup','.localizaCliente',function(event){
            if(event.key=='Enter'){
                if(event.ctrlKey){
                    $("#ModalLocalizaCliente").modal("show");
                }
            }
        })
        $('#ModalLocalizaCliente').on('shown.bs.modal', function (event) {
            $(document).find('#md_localizaCliente').focus();
        })

        /**********************localizaProduto**************************/
        $(document).on('keyup','#md_localizaCliente',function(event){
            let cliente = $(this).val();
            if(event.ctrlKey){
                $("#ModalCadastraCliente").modal("show");

                $('#ModalCadastraCliente').on('shown.bs.modal', function (event) {
                    $(document).find('#cnpj').focus();
                })
            }
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
                if(event.ctrlKey){
                    let cliente_id = $(this).val();
                    $(document).find('#cliente_id').val(cliente_id)
                    localizaNomeCliente()
                    $("#ModalLocalizaCliente").modal("hide");
                    $(document).find('#cliente_id').focus();
                }
            })

            $(document).on('dblclick','.selecionaCliente',function(event){
                let cliente_id = $(this).val();
                $(document).find('#cliente_id').val(cliente_id)
                localizaNomeCliente()
                $("#ModalLocalizaCliente").modal("hide");
                $(document).find('#cliente_id').focus();
            })




    /**********************selecionaProduto**************************/
        $(document).on('keyup','.selecionaProduto',function(event){
            if(event.ctrlKey){
                let md_cod_produto = $(this).val();
                $(document).find('#md_cod_produto').val(md_cod_produto)
                localizaNomeCliente()
                $("#ModalLocalizaProduto").modal("hide");
                localizaNomeProduto()
                $(document).find('#md_cod_produto').focus();
            }
        })
        $(document).on('dblclick','.selecionaProduto',function(event){
                let md_cod_produto = $(this).val();
                $(document).find('#md_cod_produto').val(md_cod_produto)
                localizaNomeCliente()
                $("#ModalLocalizaProduto").modal("hide");
                localizaNomeProduto()
                $(document).find('#md_cod_produto').focus();
        })


        /**********************NomeCliente**************************/
        $(document).on('change','.localizaProduto',function(event){
            localizaNomeProduto()
        })

        $(document).on('blur','#md_produto',function(event){
            let cod_produto =  $(document).find('#md_cod_produto').val()
            if(cod_produto){
                $("#mdImpostoVenda").hide();
            }else{
                $("#mdImpostoVenda").show();
            }

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
            let portal_compras = $(this).find('#portal_compras').val();
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

            let impostos_venda = [];
            $(document).find('input[name="impostos_venda[]"]').each(function(index){
                impostos_venda.push($(this).val());
            })

            let difal = [];
            $(document).find('input[name="difal[]"]').each(function(index){
                difal.push($(this).val());
            })


            let obs_item = [];
            $(document).find('input[name="obs_item[]"]').each(function(index){
                obs_item.push($(this).val());
            })


            let ir_csll = [];
            $(document).find('input[name="ir_csll[]"]').each(function(index){
                ir_csll.push($(this).val());
            });

            let frete = [];
            $(document).find('input[name="frete[]"]').each(function(index){
                frete.push($(this).val());
            });

            let outros = [];
            $(document).find('input[name="outros[]"]').each(function(index){
                outros.push($(this).val());
            });

            let margem = [];
            $(document).find('input[name="margem[]"]').each(function(index){
                margem.push($(this).val());
            });

            let despesa_fixa = [];
            $(document).find('input[name="despesa_fixa[]"]').each(function(index){
                despesa_fixa.push($(this).val());
            });

            let comissao = [];
            $(document).find('input[name="comissao[]"]').each(function(index){
                comissao.push($(this).val());
            });

            let unt_minimo = [];
            $(document).find('input[name="unt_minimo[]"]').each(function(index){
                unt_minimo.push($(this).val());
            });

            let total_minimo = [];
            $(document).find('input[name="total_minimo[]"]').each(function(index){
                total_minimo.push($(this).val());
            });

            let unt_venda = [];
            $(document).find('input[name="unt_venda[]"]').each(function(index){
                unt_venda.push($(this).val());
            });

            let total_venda = [];
            $(document).find('input[name="total_venda[]"]').each(function(index){
                total_venda.push($(this).val());
            });


            /********************************************************************************************* */
            if (!descricao || !tipo_licitacao_id ) {
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
                    ,'portal_compras'       :portal_compras
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
                    ,'impostos_venda'       :impostos_venda
                    ,'difal'                :difal
                    ,'ir_csll'              :ir_csll
                    ,'frete'                :frete
                    ,'outros'               :outros
                    ,'margem'               :margem
                    ,'despesa_fixa'         :despesa_fixa
                    ,'comissao'             :comissao
                    ,'unt_minimo'           :unt_minimo
                    ,'total_minimo'         :total_minimo
                    ,'unt_venda'            :unt_venda
                    ,'total_venda'          :total_venda
                }
                console.log(dados);
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

            let md_impostos_venda = $(document).find('#md_impostos_venda').val();
            let md_difal = $(document).find('#md_difal').val();

            if(!md_cod_produto && !md_impostos_venda ){
                Swal({
                    title: 'Preencha todos os campos obrigatório',
                    html: 'Quando o Código do produto estiver em branco é obrigatório preencher os campos <b>Icms % Compra, Icms % venda e Difal %',
                    type: 'error',
                    timer: 3000
                })
            }else{
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
                            linha +='<input type="text" class="form-control fonte-10"id="modelo'+md_seq+'"              name="modelo[]"             value="'+md_modelo+'"            title="modelo">'
                            linha +='<input type="hidden"                            id="lote'+md_seq+'"               name="lote[]"               value="'+md_lote+'"              title="lote">'
                            linha +='<input type="hidden"                            id="lote_descricao'+md_seq+'"     name="lote_descricao[]"     value="'+md_lote_descricao+'"    title="lote_descricao">'
                            linha +='<input type="hidden"                            id="cod_produto'+md_seq+'"        name="cod_produto[]"        value="'+md_cod_produto+'"       title="cod_produto">'
                            linha +='<input type="hidden"                            id="frete_custo'+md_seq+'"        name="frete_custo[]"        value="'+md_frete_custo+'"       title="frete_custo">'
                            linha +='<input type="hidden"                            id="impostos_credito'+md_seq+'"   name="impostos_credito[]"   value="'+md_impostos_credito+'"  title="impostos_credito">'
                            linha +='<input type="hidden"                            id="obs_item'+md_seq+'"           name="obs_item[]"           value="'+md_obs+'"               title="obs_item">'
                            linha +='<input type="hidden"                            id="impostos_venda'+md_seq+'"     name="impostos_venda[]"     value="'+md_impostos_venda+'"    title="impostos_venda">'
                            linha +='<input type="hidden"                            id="difal'+md_seq+'"              name="difal[]"              value="'+md_difal+'"             title="difal">'
                            linha +='<input type="hidden"                            id="comissao'+md_seq+'"           name="comissao[]"           value="0,00"                     title="comissao">'
                            linha +='<input type="hidden"                            id="ir_csll'+md_seq+'"            name="ir_csll[]"            value="0,00"                     title="ir_csll">'
                            linha +='<input type="hidden"                            id="frete'+md_seq+'"              name="frete[]"              value="0,00"                     title="frete">'
                            linha +='<input type="hidden"                            id="margem'+md_seq+'"             name="margem[]"             value="0,00"                     title="margem">'
                            linha +='<input type="hidden"                            id="outros'+md_seq+'"             name="outros[]"             value="0,00"                     title="outros">'
                            linha +='<input type="hidden"                            id="despesa_fixa'+md_seq+'"       name="despesa_fixa[]"       value="0,00"                     title="despesa_fixa">'
                            linha +='<input type="hidden"                            id="unt_minimo'+md_seq+'"         name="unt_minimo[]"         value="0,00"                     title="unt_minimo">'
                            linha +='<input type="hidden"                            id="total_minimo'+md_seq+'"       name="total_minimo[]"       value="0,00"                     title="total_minimo">'
                            linha +='<input type="hidden"                            id="unt_venda'+md_seq+'"          name="unt_venda[]"          value="0,00"                     title="unt_venda">'
                            linha +='<input type="hidden"                            id="total_venda'+md_seq+'"        name="total_venda[]"        value="0,00"                     title="total_venda">'
                    linha +='</td>';
                linha +='</tr>';
                linha +='<tr class="sectionItem'+md_seq+'">';
                    linha +='<td colspan="9"><hr></td>'
                linha +='</tr>';

                $(document).find('#tbItem >tbody').append(linha);
                // $("#ModalItem").modal("hide")
                atualizaModalItem();
            }

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
            if(event.key=='Enter'){
                if(event.ctrlKey){
                    $("#ModalLocalizaProduto").modal("show")
                }
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

    /**********************Abre ModalLocalAlteraData**************************************************/
        $(document).on('click','.alteraData',function(event){
            const item_id                 = $(this).attr('item_id');
            const data_entrega_proposta   = $(this).attr('data_entrega_proposta');
            const data_processo           = $(this).attr('data_processo');


            $('#md_data_entrega_proposta').val(data_entrega_proposta ?? '');
            $('#md_data_processo').val(data_processo ?? '');
            $('#md_id').val(item_id ?? '');
            $('.md_proposta').html(item_id ?? '');

            $("#modalAleraData").modal("show")
        })
        $('#modalAleraData').on('shown.bs.modal', function (event) {
            $(document).find('#md_data_processo').focus();
        })


        $(document).on('click','#md_salvarData',function(event){
            let id = $(document).find('#md_id').val()
            let data_entrega_proposta = $(document).find('#md_data_entrega_proposta').val()
            let data_processo = $(document).find('#md_data_processo').val()
            let dados = {
                'id'                        :id
                ,'data_entrega_proposta'    :data_entrega_proposta
                ,'data_processo'            :data_processo
            }
            alteraData(dados)
        })

    /**********************************************************************************************/
        // Util: extrai números do atributo id (ex.: "total_custo12" -> 12)
        function extractNumericIdFromElement(el) {
            const m = String(el.id || '').match(/(\d+)/);
            return m ? m[1] : undefined;
        }

        $(document).on('blur', '.precoVendaCalcular', function () {
        const id = $(this).attr('id').replace(/\D+/g, '');

        // Coleta TODOS os parâmetros do DOM (formato BR) para passar à função pura
        const params = {
            custo:              $(document).find('#md_unt_custo'+id).val(),
            imposto_custo:      $(document).find('#md_impostos_credito'+id).val(),
            imposto_venda:      $(document).find('#imposto_venda').val(),
            difal:              $(document).find('#difal').val(),
            ir_csll:            $(document).find('#ir_csll').val(),
            outros:             $(document).find('#outros').val(),
            comissao:           $(document).find('#comissao').val(),
            frete:              $(document).find('#frete').val(),
            despesa_fixa:       $(document).find('#despesa_fixa').val(),
            margem:             $(document).find('#margem').val(),
            qtd:                $(document).find('#md_qtd'+id).val(),
            prazoMedio:         $(document).find('#prazoMedio').val(),
            taxa_financeira:    $(document).find('#taxa_financeira').val(),
            vlrVendaUntInicial: $(document).find('#md_unt_edital'+id).val(),
            vlrVendaInicial:    $(document).find('#vlrVenda'+id).val(),
            total_edital:       0
        };

        // Chama a função pura de cálculo passando TODOS os parâmetros
        const r = precoVendaCalcular(params);
        console.log(r);

        // Atualiza UI com os resultados formatados
        $(document).find('#vlrVenda'+id).val(r.vlrVendaTotalFormatado);
        $(document).find('#vlrVendaUnt'+id).val(r.vlrVendaUnitarioFormatado);

        // Mantém suas funções auxiliares (se existirem)
        if (typeof fundoValor === 'function') fundoValor(r.total_edital, r.vlrVendaTotal, id);
        if (typeof fundoMargem === 'function') fundoMargem((precoVendaCalcular ? r.impostos?.margem ?? 0 : 0), id);
        if (typeof calculaCard === 'function') calculaCard();
        });
})
