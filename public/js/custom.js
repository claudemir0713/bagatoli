$(document).ready(function () {
    $(document).find('select').chosen();

    function colocaChosen(){
        $(document).find('select').chosen();
    }

    /**********sempre que tabalhar com Ajax no Laravel tem que incluir essa tag *************/
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    /***********************colocando duas casas decimais************************************* */
    var decimal = $('.floatNumberField').attr('decimal');
    $('.floatNumberField').val(parseFloat($('.floatNumberField').val()).toFixed(decimal));

    $(".floatNumberField").on('change', function () {
        var decimal = $(this).attr('decimal');
        $(this).val(parseFloat($(this).val()).toFixed(decimal));
    });
    /**********************formata numero **************************************************/
    const formCurrency = new Intl.NumberFormat('pt-BR', {
        style: 'currency',
        currency: 'BRL',
        minimumFractionDigits: 2
    })


    /*************************pegando a url do servidor**************************************/

    url = $('input#appurl').val();

    /*************************passar campos com enter****************************************/

        // // Retorna apenas campos válidos e focáveis
        // function getCampos(container = document) {
        //     return $(container)
        //         .find('input, select, textarea, [tabindex]:not([tabindex="-1"])')
        //         .filter(':visible')
        //         .not(':disabled')
        //         .not('[readonly]')
        //         .not('button, a')
        //         .not('[type=hidden]')
        //         .not('[data-skip-enter="true"]');
        // }

        // // Animação ao focar
        // $(document).on('focus', 'input, select, textarea', function () {
        //     $(this).addClass('campo-focus-animado');
        // });
        // $(document).on('blur', 'input, select, textarea', function () {
        //     $(this).removeClass('campo-focus-animado');
        // });

        // // Selecionar automaticamente o texto do campo ao focar
        // $(document).on('focus', 'input[type=text], input[type=number], input[type=search], input[type=email], input[type=tel], textarea', function () {
        //     let campo = this;
        //     setTimeout(function () {
        //         campo.select();
        //     }, 10);
        // });

        // // Movimento com Enter
        // let travarFoco = false;
        // $(document).on('keydown', 'input, select, textarea', function (e) {

        //     if (travarFoco) {
        //         e.preventDefault();
        //         return;
        //     }

        //     // CTRL + Enter → ignorar navegação
        //     if (e.ctrlKey) return;

        //     // ENTER
        //     if (e.key === 'Enter') {
        //         // Enter normal no textarea = quebra de linha
        //         if ($(this).is('textarea') && !e.shiftKey) return;

        //         e.preventDefault();

        //         let campos = getCampos();
        //         let index = campos.index(this);

        //         if (e.shiftKey) {
        //             if (index > 0) {
        //                 travarFoco = true;
        //                 campos.eq(index - 1).focus();
        //                 setTimeout(() => travarFoco = false, 50);
        //             }
        //             return;
        //         }

        //         if (index + 1 < campos.length) {
        //             travarFoco = true;
        //             campos.eq(index + 1).focus();
        //             setTimeout(() => travarFoco = false, 50);
        //         }
        //     }
        // });


        $(document).on('keydown', 'form', function (e) {
            if (e.key === 'Enter') {
                // Se não for um textarea, bloqueia o submit
                if (!$(e.target).is('textarea')) {
                    e.preventDefault();
                }
            }
        })



    /***********************Detecta apenas seta para cima e seta para baixo******************/
        $(document).on("keydown", "#tbItem input, #tbItem select, #tbItem textarea", function (e) {

            // Não navegar se Ctrl estiver pressionado
            if (e.ctrlKey) return;

            const KEY_UP = 38;
            const KEY_DOWN = 40;

            if (e.which !== KEY_UP && e.which !== KEY_DOWN) return;

            e.preventDefault();

            let $campoAtual   = $(this);
            let $tdAtual      = $campoAtual.closest("td");
            let colIndex      = $tdAtual.index();       // coluna atual
            let $trAtual      = $campoAtual.closest("tr");

            let $trDestino = null;

            // seta cima = linha anterior válida
            if (e.which === KEY_UP) {
                $trDestino = $trAtual.prevAll("tr").not(":has(td[colspan])").first();
            }

            // seta baixo = próxima linha válida
            if (e.which === KEY_DOWN) {
                $trDestino = $trAtual.nextAll("tr").not(":has(td[colspan])").first();
            }

            if (!$trDestino || $trDestino.length === 0) return;

            // Seleciona o mesmo campo da mesma coluna
            let $campoDestino = $trDestino.find("td").eq(colIndex).find("input, select, textarea");

            // Se a célula tiver 2 inputs (ex: custo ou venda)
            // pega o input na mesma posição do campo anterior
            if ($campoDestino.length > 1) {
                let pos = $tdAtual.find("input, select, textarea").index($campoAtual);
                if (pos >= 0 && pos < $campoDestino.length) {
                    $campoDestino = $campoDestino.eq(pos);
                } else {
                    $campoDestino = $campoDestino.first();
                }
            }

            // Foca no campo encontrado
            if ($campoDestino.length > 0) {
                $campoDestino.focus();
                $campoDestino.select?.(); // se for input
            }
        });

    /*************************ordernar tabela com click no cabecalho*************************/
        function parseValue(val) {
            val = val.trim();

            // moeda R$
            if (val.match(/^R?\$?\s*\d/)) {
                return parseFloat(val.replace(/[^0-9,-]/g, "").replace(",", "."));
            }

            // datas dd/mm/yyyy
            if (/^\d{2}\/\d{2}\/\d{4}/.test(val)) {
                let [d, m, y] = val.split("/");
                return new Date(`${y}-${m}-${d}`).getTime();
            }

            // datas yyyy-mm-dd
            if (/^\d{4}-\d{2}-\d{2}/.test(val)) {
                return new Date(val).getTime();
            }

            // números
            if (!isNaN(val.replace(",", "."))) {
                return parseFloat(val.replace(",", "."));
            }

            // texto
            return val.toLowerCase();
        }

        $(".tabela-ordenavel th").click(function () {
            const th = $(this);
            const tabela = th.closest("table");
            const tbody = tabela.find("tbody");
            const colIndex = th.index();

            // direção asc/desc
            let asc = !th.data("asc");
            th.data("asc", asc);

            // remover destaque & reset ícones
            tabela.find("th").removeClass("col-ordenada")
                .find(".icone-ordem")
                .removeClass("fas fa-caret-down fas fa-caret-up")
                .addClass("fas fa-caret-down");

            // ícone atual
            const icon = th.find(".icone-ordem");
            icon.removeClass("fas fa-caret-down");
            icon.addClass(asc ? "fas fa-caret-down" : "fas fa-caret-up");

            th.addClass("col-ordenada");

            // ordenar linhas
            const linhas = tbody.find("tr").get();

            linhas.sort(function (a, b) {
                const A = parseValue($(a).children().eq(colIndex).text());
                const B = parseValue($(b).children().eq(colIndex).text());

                if (A < B) return asc ? -1 : 1;
                if (A > B) return asc ? 1 : -1;
                return 0;
            });

            $.each(linhas, function (_, row) {
                tbody.append(row);
            });
        });

    /************************ buscaCep ******************************************************/
    $(document).on('blur', 'input#cep', function (event) {
        event.preventDefault() // não permite que o navegador faça o submit
        var cep = $(this).val();
        var endereco = $('input#endereco').val().trim();
        if (endereco == '') {
            buscaCep(cep);
        };
    })

    /************************ buscaCnpj ******************************************************/
    $(document).on('blur', 'input#cnpj', function (event) {
        let cnpj = $(this).val();
        if(cnpj){
            let route = '/cliente/verificaNaBase';
            dados ={
                'cnpj'  : cnpj
            }
            $.ajax({
                data: dados,
                type: 'post',
                dataType: 'JSON',
                url: url + route,
                beforeSend:function(){
                    Swal({
                        title: 'Aguarde!',
                        type: 'info',
                        timer:2000
                    })
                },
                success:function(result){
                    Swal.close();
                    if(result>0){
                        Swal({
                            title: 'Cliente já cadastrado!',
                            type: 'error',
                            timer:2000
                        })
                    }else{
                        cnpj = cnpj.replace('.', '').replace('/', '').replace('-', '');
                        console.log(cnpj);
                        if (cnpj.length >= 14) {
                            buscaCnpj(cnpj);
                        };
                    }
                }
            })
        }

    })


    /********************** mascara cnpj cpf e cep ********************************************/
    function cnpj(v){
        v=v.replace(/\D/g,"")                           //Remove tudo o que não é dígito
        v=v.replace(/^(\d{2})(\d)/,"$1.$2")             //Coloca ponto entre o segundo e o terceiro dígitos
        v=v.replace(/^(\d{2})\.(\d{3})(\d)/,"$1.$2.$3") //Coloca ponto entre o quinto e o sexto dígitos
        v=v.replace(/\.(\d{3})(\d)/,".$1/$2")           //Coloca uma barra entre o oitavo e o nono dígitos
        v=v.replace(/(\d{4})(\d)/,"$1-$2")              //Coloca um hífen depois do bloco de quatro dígitos
        return v
    }
    function cpf(v){
        v=v.replace(/\D/g,"")                    //Remove tudo o que não é dígito
        v=v.replace(/(\d{3})(\d)/,"$1.$2")       //Coloca um ponto entre o terceiro e o quarto dígitos
        v=v.replace(/(\d{3})(\d)/,"$1.$2")       //Coloca um ponto entre o terceiro e o quarto dígitos
                                                 //de novo (para o segundo bloco de números)
        v=v.replace(/(\d{3})(\d{1,2})$/,"$1-$2") //Coloca um hífen entre o terceiro e o quarto dígitos
        return v
    }
    function cep(v){
        v=v.replace(/\D/g,"")                    //Remove tudo o que não é dígito
        v=v.replace(/(\d{2})(\d)/,"$1.$2")       //Coloca um ponto entre o terceiro e o quarto dígitos
        v=v.replace(/(\d{3})(\d)/,"$1-$2")       //Coloca um ponto entre o terceiro e o quarto dígitos
        return v
    }


    $(document).on('keypress','.cnpj', function(event){
        $(this).val(cnpj($(this).val()));
    })
    $(document).on('keypress','#contato_cpf', function(event){
        var pessoa = $(document).find('#pessoa').val();
        if(pessoa!="JE" || pessoa!="FE"){
            $(this).val(cpf($(this).val()));
        }
    })

    /****************************adiciona mascara cep***********************************/
    $(document).on('keypress','#cep', function(event){
        $(this).val(cep($(this).val()));
    })

    /***********************mensagem confirma exclusão **************************************/
    $(document).on('click', '.delete', function (event) {
        event.preventDefault()
        let link = $(this); // botão clicado
        Swal({
            title: 'Deseja realmente excluir?',
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            cancelButtonText: 'Cancelar',
            confirmButtonText: 'Remover'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: $(event.target).closest('a').attr('href'),
                    type: 'DELETE',
                    success: function () {
                        Swal.fire({
                            type: 'success',
                            title: 'Removido!',
                            text: 'O registro foi excluído.',
                            timer: 2000, // tempo em milissegundos (2 segundos)
                            showConfirmButton: false // remove botão OK
                        });

                        // Remove a linha da tabela
                        link.closest('tr').remove();
                    },
                    error: function () {
                        Swal.fire({
                            type: 'error',
                            title: 'Erro!',
                            text: 'Não foi possível excluir.',
                            timer: 2000, // tempo em milissegundos (2 segundos)
                            showConfirmButton: false // remove botão OK
                        });

                    }
                })
            }
        });
    })

    // $('#salvar').keypress(function(e) {
    //     if(e.which == 13) {
    //         e.preventDefault();
    //     }
    // });

    // document.addEventListener("keydown", function(e) {
    //     if(e.keyCode === 13) {
    //         e.preventDefault();
    //     }
    // });

    /**********************time intervel *********************************************************************/
        // atualizaCards();
        // setInterval(function(){
        //     atualizaCards();
        // }, 5000);



    /****************************altera senha*************************************************/

    $('#ModalSenha').on('show.bs.modal', function (event) {
        $(document).find('.alert').hide();
    })

    $(document).on('change',"#confirmaSenha",function(event){
        var novaSenha       = $(document).find('#novaSenha').val();
        var confirmaSenha   = $(document).find('#confirmaSenha').val();
        if(novaSenha != confirmaSenha){
            $(document).find('#confirmaSenha').focus();
            $(document).find('#alteraSenha').prop('disabled', true);;
            $(document).find('.alert').show();

            return false;
        }else{
            $(document).find('#alteraSenha').prop('disabled', false);;
            $(document).find('.alert').hide();
            return true;
        }
    })

    $(document).on('click',"#alteraSenha",function(event){
        var novaSenha       = $(document).find('#novaSenha').val();
        var confirmaSenha   = $(document).find('#confirmaSenha').val();
        var route   = '/usuario/updateSenha';
        var type    = 'POST';
        var origem  = 'home';

        if(!novaSenha || !confirmaSenha ){
            Swal({
                title: 'Preencha todos os campos obrigatório',
                type: 'error',
                timer:3000
            })
        }else{
            var dados= {
                'novaSenha'     : novaSenha
            }
            // console.log(dados);
            cadastrar(dados,route,type,origem);
        }
    })


    /**********************gravar menu com ajax **************************************************/
    $(document).on('submit', 'form#cadastro-menu', function (event) {
        event.preventDefault()
        var route = $(this).find('input#route').val();
        var type = $(this).find('input#type').val();
        var origem = 'menu'

        var descricao = $(this).find('input#descricao').val();
        var tipo = $(this).find('select#tipo').val();
        var ordem = $(this).find('input#ordem').val();
        var rota = $(this).find('input#rota').val();
        var icone = $(this).find('input#icone').val();


        /********************************************************************************************* */
        if (!descricao || !tipo || !ordem) {
            Swal({
                title: 'Preencha todos os campos obrigatório',
                type: 'error',
                timer: 3000
            })
        } else {
            var dados = {
                'descricao': descricao
                , 'tipo': tipo
                , 'ordem': ordem
                , 'rota': rota
                , 'icone': icone
            }
            cadastrar(dados, route, type, origem);
        }
    })
    /***********************liberaMenu *****************************/
    $('#usuario').on('change',function(){
        liberaMenuDisponivel();
        removeMenuLiberado();
    })

    $(document).on('click','input.disponivel',function(event){
        if($(this).is(":checked")){
            var disponivelId = $(this).val();
            var usuario = $(document).find('#usuario').val();
            addMenuUsuario(disponivelId,usuario)
        }else{
            var liberadoId = $(this).val();
            removeMenuUsuario(liberadoId)
        }
    })
    $(document).on('click','button.liberado',function(event){
        var liberadoId = $(this).val();
        removeMenuUsuario(liberadoId)
    })


    /**********************AtivaInativaUsuario**************************************************/
    $(document).on('click','input.cliente_ativo',function(event){
        var usuario_id = $(this).val();
        var route = '/usuario/ativaUsuario'
        if($(this).is(":checked")){
            var ativo = 'S';
        }else{
            var ativo = 'N';
        }
        ativaUsuario(usuario_id,ativo,route)
    })
    /**********************AtivaInativaUsuario**************************************************/
    $(document).on('click','input.cliente_nivel',function(event){
        var usuario_id = $(this).val();
        var route = '/usuario/nivelUsuario'
        if($(this).is(":checked")){
            var nivel = 'adm';
        }else{
            var nivel = 'usuário';
        }
        nivelUsuario(usuario_id,nivel,route)
    })

})


