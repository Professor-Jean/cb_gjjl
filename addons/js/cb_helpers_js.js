//Função que pega o conteudo HTMl dentro de uma class imprimir
function catchContent(){
	var dados="";//Criando variavel dados

	$('.imprimir').each(function(){
		dados += $(this).html();
	});

	if(dados!=""){
		$('#dadospdf').val(dados);
		return true;
	}

	alert('Problema ao gerar PDF, recarregue a página e tente novamente!');
	return false;
}

function validatePrint(){
	alert("Você deve salvar a rota de entrega antes de imprimi-la");
}