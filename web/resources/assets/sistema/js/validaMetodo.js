// JavaScript Document

$().ready(function() {

    listarPaginacaoSemBusca("listar");
	
	// Validando os campos de login
	$('#metodoForm').validate({
		errorElement: 'div',
		errorClass: 'help-block has-error',
		rules: {
			classe: {
				required: true
			},
			metodo: {
				required: true
			},
			nome: {
				required: true
			}
			
		},
		messages: {
			classe: {
				required: ""
			},
			metodo: {
				required: ""
			},
			nome: {
				required: ""
			}
		},
		success: function (e) {
			$(e).closest('.form-group').removeClass('has-error');//.addClass('has-info');
			$(e).remove();
		},
		submitHandler: function (form) {
			
			var parametros = $("#metodoForm").serialize();
			var urlPage = $("#actionForm").val();

			carregaMensagemSucesso(urlPage, parametros, "");
			
		}
	});
	
	// Validando os campos de login
	$('#metodoPermissaoForm').validate({
		errorElement: 'div',
		errorClass: 'help-block has-error',
		rules: {
			perfil: {
				required: true
			}
			
		},
		messages: {
			perfil: {
				required: ""
			}
		},
		success: function (e) {
			$(e).closest('.form-group').removeClass('has-error');//.addClass('has-info');
			$(e).remove();
		},
		submitHandler: function (form) {
			
			idPerfil = $("#perfil").val(); 
			listaMetodo = "";
			
			$("#selectedBox2 option").each(function(){
				valorCheck = $(this).val();
				listaMetodo += "&listaMetodo[]="+valorCheck;
			});
			var urlPage = $("#actionForm").val();
		
			//var parametros = $("#metodoPermissaoForm").serialize();
			var parametros = "actionForm="+urlPage+"&perfil="+idPerfil+listaMetodo;
			

			carregaMensagemSucesso(urlPage, parametros, "");
	    	
		}
	});
	
	$("#perfil").change(function(){
		
		if ($(this).val() == "") {
			$("#selectedBox1, #selectedBox2").html("");
		} else {
		
			$.ajax({
				url: "listaMetodoPermissao",
				async: false,
				data: {
					idPerfil: $(this).val()
				},
				type: 'POST',
				dataType: "json", 
				success: function(resposta){
					
					htmlOptionPermitido = "";
					htmlOptionNaoPermitido = "";
					
					$("#selectedBox1, #selectedBox2").html(htmlOptionPermitido);
					
					if (resposta['PERMITIDO'] != null) {
						$(resposta['PERMITIDO']).each(function(index, val){
						
							idMetodo = resposta['PERMITIDO'][index]['id'];
							nomeMetodo = resposta['PERMITIDO'][index]['nome'];
							
							htmlOptionPermitido += "<option value='"+idMetodo+"'>"+nomeMetodo+"</option>";
						
						
						});
		
						$("#selectedBox2").append(htmlOptionPermitido);
					}
					
					if (resposta['NAO_PERMITIDO'] != null) {
						$(resposta['NAO_PERMITIDO']).each(function(index2, val2){
							
							idMetodoNaoPermitido = resposta['NAO_PERMITIDO'][index2]['id'];
							nomeMetodoNaoPermitido = resposta['NAO_PERMITIDO'][index2]['nome'];
							
							htmlOptionNaoPermitido += "<option value='"+idMetodoNaoPermitido+"'>"+nomeMetodoNaoPermitido+"</option>";
						
						
						});
		
						$("#selectedBox1").append(htmlOptionNaoPermitido);
						
						
					}
					
				}
			});
		}
	});

});

