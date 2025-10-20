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
                var form = $(this).parent()
                form.submit()
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


