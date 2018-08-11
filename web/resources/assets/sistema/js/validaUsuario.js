// JavaScript Document

$().ready(function() {

    listarPaginacao("listar");

    $(".maskCpf").mask("999.999.999-99");

	// Validando os campos de login
	$('#usuarioForm').validate({
		errorElement: 'div',
		errorClass: 'help-block has-error',
		rules: {

			status: {
				required: true
			},
            permissoes: {
				required: true
			},
			nome: {
				required: true
			},
            cpf: {
                required: true,
                verificaCPF: true
            },
			email: {
				required: true,
				email: true
			},
			login: {
				required: true
			},
			senha: {
				required: true
			},
			resenha: {
				required: true,
				equalTo: "#senha"
			}
			
		},
		messages: {
			status: {
				required: ""
			},
            permissoes: {
				required: ""
			},
			nome: {
				required: ""
			},
            cpf: {
                required: "",
                verificaCPF: ""
            },
			email: {
				required: "",
				email: ""
			},
			login: {
				required: ""
			},
			senha: {
				required: ""
			},
			resenha: {
				required: "",
				equalTo: " Campos diferentes!"
			}
		},
		success: function (e) {
			$(e).closest('.form-group').removeClass('has-error');//.addClass('has-info');
			$(e).remove();
		},
		submitHandler: function (form) {
			
			var parametros = $("#usuarioForm").serialize();
			var urlPage = $("#actionForm").val();

			carregaMensagemSucesso(urlPage, parametros, "");

			if (isVazio($("#idEdit").val())) {
				$("#usuarioForm")[0].reset();
			}

		}
	});

});

