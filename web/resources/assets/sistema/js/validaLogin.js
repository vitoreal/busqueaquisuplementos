// JavaScript Document
$().ready(function() {

    if (isNotUndefinedEmpty($("#errorMsg").val())) {
        montaModalMensagem("ALERTA", $("#errorMsg").val());
    }


	$(".maskCpf").mask("999.999.999-99");


	$("#btnRecuperarSenha").click(function(){
            $('#recuperarSenhaForm')[0].reset();
            $("div.has-error").remove();
            $("#modalRecuperarSenha").modal("show");
            $("#modalLogin").modal("hide");
	});
	
	// Recuperando a senha atraves do token
	if (isNotUndefinedEmpty($("#tokenId").val())) {
		/*
            $.ajax({
                url: 'login/validarSenha',
                async: false,
                data: {tokenId: $("#tokenId").val() },
                type: 'POST',
                dataType: "json", 
                success: function(resposta){

                    if (resposta == true) {
                        $("#modalResetSenha").modal("show");	
                    } else {
                        montaModalMensagem("ALERTA", "Este número de token não existe.");

                        $("#mensagemModalOk").click(function(){
                            $('#modalMensagem').modal('hide');
                        });
                    }
                    
                    return false;
                    
                }
            });
            */
	}
	
	if ($("#senhaTrocada").val() == "true") {
		montaModalMensagem("SUCESSO", "Senha alterada com sucesso, você já pode acessar o sistema.");

	}

	// Validando o campo de recuperar senha
	$('#recuperarSenhaForm').validate({
		errorElement: 'div',
		errorClass: 'help-block has-error',
		rules: {
			"txtRecuperarSenha": {
				required: true,
				email: true
			}
		},
		messages: {
			"txtRecuperarSenha": {
				required: "",
				email: "Informe um email válido!"
			}
		},

		success: function (e) {
			$(e).closest('.form-group').removeClass('has-error');//.addClass('has-info');
			$(e).remove();
		},
		
		submitHandler: function (form) {
			
			$.ajax({
				url: $("#baseUrl").val()+'login/actionRecuperarSenha',
				async: false,
				data: $("#recuperarSenhaForm").serialize(),
				type: 'POST',
				dataType: "json", 
				success: function(resposta){
					
					tipoMsg = resposta['mensagem'].tipoMsg;
					textoMsg = resposta['mensagem'].texto;
					
					montaModalMensagem(tipoMsg, textoMsg);
					
					$('#modalRecuperarSenha').modal('hide');
					
					$("#mensagemModalOk").click(function(){
						$('#modalMensagem').modal('hide');
					});
					
					return false;
					
				}
			});
			
		}
	});

	// Validando os campos de login
	$('#logarForm').validate({
		errorElement: 'div',
		errorClass: 'help-block has-error',
		rules: {
			"_username": {
				required: true
			},
			"_password": {
				required: true
			}
		},
		messages: {
			"_username": {
				required: "Informe o login!"
			},
			"_password": {
				required: "Informe a senha!"
			}
		},

		success: function (e) {
			$(e).closest('.form-group').removeClass('has-error');//.addClass('has-info');
			$(e).remove();
		},
		
		submitHandler: function (form) {


            $("#logarForm")[0].submit();


			
		}
	});

    // Validando os campos de login
    $('#registrarForm').validate({
        errorElement: 'div',
        errorClass: 'help-block has-error',
        rules: {

            nome: {
                required: true
            },
            email: {
                required: true,
                email: true
            },
            login: {
                required: true,
                minlength: 8
            },
            senha: {
                required: true,
                minlength: 8
            },
            cpf: {
                required: true,
                verificaCPF: true
            },
            resenha: {
                required: true,
                equalTo: "#senha"
            }

        },
        messages: {
            nome: {
                required: "Campo nome é obrigatório!"
            },
            email: {
                required: "Campo email é obrigatório!",
                email: "Email inválido!"
            },
            login: {
                required: "Campo login é obrigatório!",
                minlength: "Campo login tem que ter no mínimo 8 dígitos!"
            },
            senha: {
                required: "Campo senha é obrigatório!",
				minlength: "Campo senha tem que ter no mínimo 8 dígitos!"
            },
            cpf: {
                required: "Campo cpf é obrigatório!",
                verificaCPF: "CPF inválido!"
            },
            resenha: {
                required: "Campo para conferir a senha é obrigatório!",
                equalTo: "Campos de senha diferentes!"
            }
        },
        success: function (e) {
            $(e).closest('.form-group').removeClass('has-error');//.addClass('has-info');
            $(e).remove();
        },
        submitHandler: function (form) {

            $.ajax({
                url: $("#inputHiddenPathRegistrarForm").val(),
                async: false,
                data: $("#registrarForm").serialize(),
                type: 'POST',
                dataType: "json",
                success: function(resposta){

                    tipoMsg = resposta['mensagem'].tipoMsg;
                    textoMsg = resposta['mensagem'].texto;

                    montaModalMensagem(tipoMsg, textoMsg);

                    $('#modalResetSenha').modal('hide');

                    $("#mensagemModalOk").click(function(){
                        $('#modalMensagem').modal('hide');
                    });

                    //$("#registrarForm")[0].reset();
                    //$('#modalRegistrar').modal('hide');

                    return false;

                }
            });

        }
    });
	
	// Validando o campo de recuperar senha
	$('#resetSenhaForm').validate({
		errorElement: 'div',
		errorClass: 'help-block has-error',
		rules: {
			"txtNovaSenha": {
				required: true
			},
			"txtRecNovaSenha": {
				required: true,
				equalTo: "#txtNovaSenha"
			}
		},
		messages: {
			"txtNovaSenha": {
				required: ""
			},
			"txtRecNovaSenha": {
				required: "",
				equalTo: "Senha não confere!"
			}
		},
		success: function (e) {
			$(e).closest('.form-group').removeClass('has-error');
			$(e).remove();
		},
		submitHandler: function (form) {
			
			$.ajax({
				url: $("#baseUrl").val()+'login/resetSenha',
				async: false,
				data: $("#resetSenhaForm").serialize(),
				type: 'POST',
				dataType: "json", 
				success: function(resposta){
					
					tipoMsg = resposta['mensagem'].tipoMsg;
					textoMsg = resposta['mensagem'].texto;
						
					montaModalMensagem(tipoMsg, textoMsg);
					
					$('#modalResetSenha').modal('hide');
					
					$("#mensagemModalOk").click(function(){
						$('#modalMensagem').modal('hide');
					});
					
					return false;
					
				}
			});
			
		}
	});
		 
});
