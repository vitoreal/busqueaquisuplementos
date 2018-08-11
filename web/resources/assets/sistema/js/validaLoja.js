// JavaScript Document

$().ready(function() {

    listarPaginacaoSemBusca($("#urlPageLoja").val());

    $(".maskCnpj").mask("99.999.999/9999-99");
    $(".maskTelefone").mask("(99) 99999-9999");

    // Validando os campos de login
    $('#cadlojaForm').validate({
        errorElement: 'div',
        errorClass: 'help-block has-error',
        rules: {
            nome: {
                required: true
            },
            razaoSocial: {
                required: true
            },
            cnpj: {
                required: true
            },
            telefone1: {
                required: true
            },
            cep: {
                required: true
            },
            estado: {
                required: true
            },
            cidade: {
                required: true
            },
            endereco: {
                required: true
            },
            bairro: {
                required: true
            }

        },
        messages: {
            nome: {
                required: ""
            },
            razaoSocial: {
                required: ""
            },
            cnpj: {
                required: ""
            },
            telefone1: {
                required: ""
            },
            cep: {
                required: ""
            },
            cidade: {
                required: ""
            },
            senha: {
                required: ""
            },
            endereco: {
                required: ""
            },
            bairro: {
                required: ""
            }
        },
        success: function (e) {
            $(e).closest('.form-group').removeClass('has-error');//.addClass('has-info');
            $(e).remove();
        },
        submitHandler: function (form) {

            $("#editor1").val(CKEDITOR.instances.editor1.getData());

            var parametros = $("#cadlojaForm").serialize();
            var urlPage = $("#actionForm").val();

            carregaMensagemRedirect(urlPage, parametros, $("#urlInicioRedirect").val());


        }
    });

});

