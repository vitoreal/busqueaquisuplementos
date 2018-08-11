// JavaScript Document

$().ready(function() {

    listarPaginacaoSemBusca("listar");
	
	// Validando os campos de login
	$('#editForm').validate({
		errorElement: 'div',
		errorClass: 'help-block has-error',
		rules: {

			nome: {
				required: true
			}
			
		},
		messages: {
			nome: {
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

