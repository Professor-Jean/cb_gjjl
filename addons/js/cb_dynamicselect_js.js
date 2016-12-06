/***********************************************************************************************************************************************
 *Autores: Gabriel Dezan;
					 João Santucci;
					 João Spieker;
					 Lucas Janning;
 *Data de Criação: 23/10/2016
 *Data de Modificação: 23/10/2016
 *Descrição: Esta página é responsável por fazer o carregamento dinâmico no select de cidade, para mostrar só os bairros que são da cidade selecionada.
 ***********************************************************************************************************************************************/

function mostraBairro() {
	var bairroMudar = document.getElementsByName('selbairro');
	var cidadeAtual = document.getElementsByName('selcidade');
	var cidadeAntigo = "";
	for (var i=0;i<bairroMudar.length;i++){
		if (cidadeAntigo[i] != cidadeAtual[i].value){
			atual=i;
		}
	}

	cod = cidadeAtual[atual].value;
	$(bairroMudar[atual]).html("<option>Aguarde</option>");
	$.post("../addons/php/cb_dynamicsearch_php.php", {cod:cod},
		function(busca){
			$(bairroMudar[atual]).html(busca);
		});
}