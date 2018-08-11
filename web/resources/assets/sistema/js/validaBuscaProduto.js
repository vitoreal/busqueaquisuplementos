
$().ready(function() {


    $("#categoria").change(function(){

        carregaProduto($(this).val());

    });

    // Pegando o id do estado para listar a cidade
    $("#slcEstado").change(function(){

        if (isNotUndefinedEmpty($(this).val())){

            carregaCidadeBuscaSession($(this).val(), "", $("#urlEnderecoBusca").val());

        } else {

            htmlLimpaCampos = '<option value="" selected="selected">Selecione</option>';
            $("#slcCidade, #slcBairro").html(htmlLimpaCampos);
        }


    });
});


function carregaProduto(idCategoria) {

    $.ajax({
        url: $("#urlBuscaTipoProdutoPorCategoria").val(),
        async: false,
        type: 'POST',
        dataType: "json",
        data: {	idCategoria: idCategoria },
        success: function(resposta){

            carregaComboTipoProduto(resposta);
        }
    });

}

function carregaComboTipoProduto(tipoProdutoArray){

    html = '<option value="" selected="selected">Selecione</option>';

    $.each(tipoProdutoArray, function(k, v) {
        html += '<option value="'+v['id']+'">'+v['nome']+'</option>';
    });

    $("#tipoProduto").html(html)
    $("#tipoProduto").val( $("#idTipoProduto").val() );

}


function carregaCidadeBuscaSession(estado, cidade, pageUrl) {

    $.ajax({
        url: pageUrl,
        async: false,
        type: 'POST',
        dataType: "json",
        data: {	estado: estado },
        success: function(resposta){

            carregaCombosBuscaSession(resposta);
        }
    });

}

function carregaCombosBuscaSession(cidadeArray){

    htmlCidade = '<option value="" selected="selected">Selecione</option>';

    $.each(cidadeArray['CIDADE'], function(k, v) {
        htmlCidade += '<option value="'+k+'">'+v+'</option>';

    });

    $("#slcCidade").html(htmlCidade);

    $("#slcCidade").unbind();

    // Pegando o id do estado para listar a cidade
    $("#slcCidade").change(function(){

        $.ajax({
            url: $("#urlBairroBusca").val(),
            async: false,
            type: 'POST',
            dataType: "json",
            data: {	idCidade: $(this).val() },
            success: function(resposta){

                carregaCombosBairroSession(resposta);
            }
        });

    });


}

function carregaCombosBairroSession(bairroArray){

    htmlBairro = '<option value="" selected="selected">Selecione</option>';

    if (isNotUndefinedEmpty(bairroArray)){
        $.each(bairroArray['BAIRRO'], function(k, v) {
            htmlBairro += '<option value="'+k+'">'+v+'</option>';
        });
    }


    $("#slcBairro").html(htmlBairro);

}