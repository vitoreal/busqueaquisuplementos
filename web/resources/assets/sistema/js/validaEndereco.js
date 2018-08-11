// JavaScript Document

$().ready(function() {

    $(".maskCep").mask("99999-999");
    $(".camposEndereco").attr('disabled', true);

    urlEndereco = $("#urlEndereco").val();

	if (isNotUndefinedEmpty($("#idCidadeAlterar").val())) {
		carregaCidade($("#estado").val(), $("#idCidadeAlterar").val(), $("#urlEndereco").val());
        $(".camposEndereco").attr('disabled', false);
	} else {
		carregaCidade("", "", $("#urlEndereco").val());
	}

	// Pegando o id do estado para listar a cidade
	$("#estado").change(function(){
		carregaCidade($(this).val(), "", urlEndereco);
	});
	
	
	//Quando o campo cep perde o foco.
    $("#cep").blur(function() {

        $(".camposEndereco").attr('disabled', false);

        //Nova variável com valor do campo "cep".
        var cep = $(this).val();

        if (!isNotUndefinedEmpty(cep) ) {
            $(".camposEndereco").attr('disabled', true);

            carregaCidade("", "", urlEndereco);

            $( "#estado option" ).each(function() {
                if ($(this).val() == "") {
                    $(this).attr("selected", "selected")
                } else {
                    $(this).removeAttr("selected")
                }
            });
        }



        //Verifica se campo cep possui valor informado.
        if (cep != "") {

            //Expressão regular para validar o CEP.
            var validacep = /^[0-9]{5}-?[0-9]{3}$/;

            //Valida o formato do CEP.
            if(validacep.test(cep)) {

                //Consulta o webservice viacep.com.br/
                $.getJSON("//viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {

                	if (!("erro" in dados)) {
                        //Atualiza os campos com os valores da consulta.
                        $("#endereco").val(dados.logradouro);
                        $("#bairro").val(dados.bairro);
                        //$("#cidade").val(dados.localidade);
                        //$("#estado").val(dados.uf);
                        carregaCidade(dados.uf, dados.localidade, urlEndereco);
                        
                    } //end if.
                    else {
                        //CEP pesquisado não foi encontrado.
                    	//Consulta o webservice republicavirtual.com.br/
                        buscaReplublicaVirtual( cep );
                        
                    }
                });
            } //end if.
            else {
                //cep é inválido.
                limpa_formulário_cep();
            }
        } //end if.
        else {
            //cep sem valor, limpa formulário.
            limpa_formulário_cep();
        }
    });
	

});

function buscaReplublicaVirtual( cep ){
	
	$.ajax({
		url: "http://cep.republicavirtual.com.br/web_cep.php?cep="+cep+"&formato=json",
		async: false,
		type: 'POST',
		dataType: "json", 
		success: function(resultadoCEP){
			
			 //Atualiza os campos com os valores da consulta.
            $("#endereco").val(resultadoCEP.tipo_logradouro + " " + resultadoCEP.logradouro);
            $("#bairro").val(resultadoCEP.bairro);
            //$("#cidade").val(resultadoCEP.cidade);
            //$("#estado").val(resultadoCEP.uf);
            
            carregaCidade(resultadoCEP.uf, resultadoCEP.cidade, urlEndereco);
            
			return false;
			
		}
	});
	
}

function carregaCidade(estado, cidade, pageUrl) {

	$.ajax({
		url: pageUrl,
		async: false,
		type: 'POST',
		dataType: "json", 
		data: {	estado: estado },
		success: function(resposta){
			
			carregaCombos(estado, resposta, cidade);
		}
	});
	
}

function carregaCombos(estado, cidadeArray, cidade){


	$( "#estado option" ).each(function() {
        if ($(this).val() == estado) {
        	$(this).attr("selected", "selected")
        }
     });
    
    html = '<option value="" selected="selected">Selecione</option>';
    
    $.each(cidadeArray, function(k, v) {
    	html += '<option value="'+v['id']+'">'+v['cidade']+'</option>';
    	// se o nome da cidade do webbservice for igual ao do array, pego o id da cidade para selecionar na combo
    	if (cidade == v['cidade']) {
    		cidade = v['id'];
    	}
    });
    
    $("#cidade").html(html)
    $("#cidade").val( cidade );
    
}
function limpa_formulário_cep() {
    // Limpa valores do formulário de cep.
    $("#endereco").val("");
    $("#bairro").val("");
    $("#cep").val("");
}