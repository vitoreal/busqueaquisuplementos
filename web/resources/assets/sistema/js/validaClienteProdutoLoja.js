// JavaScript Document

$().ready(function() {

    listarPaginacaoSemBusca($("#urlClienteProdutoLoja").val());

    $("#btnModalAssociarProduto").click(function(){
        $('#modalAssociarProduto').modal('show');
    });

    $('.money').mask('#.##0,00', {reverse: true});
	
	// Validando os campos de login
	$('#alterarPrecoForm').validate({
		errorElement: 'div',
		errorClass: 'help-block has-error',
		rules: {

			preco: {
				required: true
			}
			
		},
		messages: {
            preco: {
				required: ""
			}
		},
		success: function (e) {
			$(e).closest('.form-group').removeClass('has-error');//.addClass('has-info');
			$(e).remove();
		},
		submitHandler: function (form) {
			
			var parametros = $("#alterarPrecoForm").serialize();
			var urlPage = $("#actionFormAlterarPreco").val();

			carregaMensagemSucesso(urlPage, parametros, "");

            $("#preco").val("");
            $('#openModalAlterarPreco').modal('hide');

            // Recarregando o datatable
            $('.datatable').dataTable().fnDraw();
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

function abreModalAlterarPreco(idLoja, idProduto, preco){

    $('#openModalAlterarPreco').modal('show');

    $("#idLoja").val(idLoja);
    $("#idProduto").val(idProduto);
    $("#preco").val(preco);

}