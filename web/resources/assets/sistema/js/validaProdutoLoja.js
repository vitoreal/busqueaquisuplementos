// JavaScript Document

$().ready(function() {

    listarPaginacaoSemBusca($("#urlProdutoLoja").val());

    $("#btnModalAssociarProduto").click(function(){
        listarDuasPaginacaoComBusca($("#urlListaProdutoLoja").val(), $(".datatableProduto"))
        $('#modalAssociarProduto').modal('show');
    });
	
	// Validando os campos de login
	$('#editForm').validate({
		errorElement: 'div',
		errorClass: 'help-block has-error',
		rules: {

			nome: {
				required: true
			},
            tipoProduto: {
                required: true
            },
            marca: {
                required: true
            },
            descricao: {
                required: true
            }
			
		},
		messages: {
			nome: {
				required: ""
			},
            tipoProduto: {
                required: ""
            },
            marca: {
                required: ""
            },
            descricao: {
                required: ""
            }
		},
		success: function (e) {
			$(e).closest('.form-group').removeClass('has-error');//.addClass('has-info');
			$(e).remove();
		},
		submitHandler: function (form) {
			
			var parametros = $("#editForm").serialize();
			var urlPage = $("#actionForm").val();

			carregaMensagemSucesso(urlPage, parametros, "");

			if (isVazio($("#idEdit").val())) {
				$("#editForm")[0].reset();
			}

		}
	});

});

function associarProdutoLoja(idLoja, idProduto){

    textoMsg = "Tem certeza que deseja associar esse produto a esta loja?";
    modalConfirmation(textoMsg);

    var param = "idLoja="+idLoja+"&idProduto="+idProduto;

    $('.datatable tr').removeClass('.selected');

    $("#confirmationModalOK").click(function(){

        $('#modalConfirmation').modal('hide');
        $("#txtModalDinamico").html("");
        carregaMensagemSucesso($("#urlProdutoAssociar").val(), param);

        // Recarregando o datatable
        $('.datatable').dataTable().fnDraw();

    });

}

function desassociarProdutoLoja(idLoja, idProduto){

    textoMsg = "Tem certeza que deseja desassociar esse produto a esta loja?";
    modalConfirmation(textoMsg);

    var param = "idLoja="+idLoja+"&idProduto="+idProduto;

    $('.datatable tr').removeClass('.selected');

    $("#confirmationModalOK").click(function(){

        $('#modalConfirmation').modal('hide');
        $("#txtModalDinamico").html("");
        carregaMensagemSucesso($("#urlProdutoDesassociar").val(), param);

        // Recarregando o datatable
        $('.datatable').dataTable().fnDraw();

    });

}