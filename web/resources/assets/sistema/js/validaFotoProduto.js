// JavaScript Document

$().ready(function() {


    loadImageProduto($("#idEdit").val());

    $('#fotoProdutoForm').validate({
        errorElement: 'div',
        errorClass: 'help-block has-error',
        rules: {
            foto: {
                required: true,
                extension:'jpg|gif|png'
            }

        },
        messages: {
            foto: {
                required: "",
                extension: "Arquivo inválido"
            }
        },
        success: function (e) {
            $(e).closest('.form-group').removeClass('has-error');//.addClass('has-info');
            $(e).remove();
        },
        submitHandler: function (form) {

            var urlPage = $("#actionForm").val();

            arquivo = $("#foto")[0].files[0];
            // Criando um novo objeto de FormData
            var formData = new FormData();
            // adicionando valores no form
            formData.append("foto", arquivo, arquivo.name);
            formData.append("idEdit", $("#idEdit").val());

            $.ajax({
                url: urlPage,
                async: false,
                data: formData,
                type: 'POST',
                dataType: "json",
                processData: false, // Don't process the files
                contentType: false, // Set content type to false as jQuery will tell the server its a query string request
                success: function(resposta){

                    tipoMsg = resposta['mensagem'].tipoMsg;
                    textoMsg = resposta['mensagem'].texto;

                    montaModalMensagem(tipoMsg, textoMsg);

                    $("#mensagemModalOk").click(function(e){
                        $('#modalMensagem').modal('hide');
                    });

                    loadImageProduto($("#idEdit").val());

                }
            });

        }
    });

});

function excluirImagem(valueID){

    $.ajax({
        url: "../excluirFotoProduto",
        async: false,
        data: {id: valueID},
        type: 'POST',
        dataType: "json",
        success: function(resposta){

            tipoMsg = resposta['mensagem'].tipoMsg;
            textoMsg = resposta['mensagem'].texto;

            montaModalMensagem(tipoMsg, textoMsg);

            $("#mensagemModalOk").click(function(e){
                $('#modalMensagem').modal('hide');
            });

            loadImageProduto($("#idEdit").val());
        }
    });

}

function loadImageProduto(idEdit){

    $.ajax({
        url: "../carregaFotoProduto",
        async: false,
        type: 'POST',
        data: {idEdit: idEdit},
        dataType: "json",
        success: function(resposta){
            $("#carregaFotoProduto").html(resposta['data']);

        }
    });

}
