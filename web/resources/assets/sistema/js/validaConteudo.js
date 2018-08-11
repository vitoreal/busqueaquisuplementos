// JavaScript Document

$().ready(function() {

    listarPaginacaoSemBusca("listar");
	
	// Validando os campos de login
	$('#editForm').validate({
		errorElement: 'div',
		errorClass: 'help-block has-error',
		rules: {

			descricao: {
				required: true
			},
            tipoConteudo: {
                required: true
            }
			
		},
		messages: {
            descricao: {
				required: ""
			},
            tipoConteudo: {
                required: ""
            }
		},
		success: function (e) {
			$(e).closest('.form-group').removeClass('has-error');//.addClass('has-info');
			$(e).remove();
		},
		submitHandler: function (form) {

            $("#editor1").val(CKEDITOR.instances.editor1.getData());

            var parametros = $("#editForm").serialize();
			var urlPage = $("#actionForm").val();

			carregaMensagemSucesso(urlPage, parametros, "");

			if (isVazio($("#idEdit").val())) {
				$("#editForm")[0].reset();
			}

		}
	});

});

