/***********************************************************************************************************************************************
 *Autores: Gabriel Dezan;
					 João Santucci;
					 João Spieker;
					 Lucas Janning;
 *Data de Criação: 02/10/2016
 *Data de Modificação: 02/10/2016
 *Descrição: Esta página contém as funções responsáveis por fazer a rota de entrega funcionar.
 ***********************************************************************************************************************************************/

var aux = 0;
//Inicializando Variável auxiliar
//Função responsável pela montagem da rota de entrega
function criarRota(idE, cliente, telefone, cep, cidade, bairro, logradouro, numero, complemento, horario){

	aux++;
	//Variavel auxiliar

	//se o elemento clicado tiver a classe selecionado...
	if ($('.events #'+idE+'').hasClass("selecionado")) {
		//...retorna false
		return false;
		//senão...
	} else {
		//...o elemento clicado recebe a classe 'selecionado', que desabilita o click no tr selecionado,...
		$('.events #'+idE+'').addClass("selecionado");

		//...remove a tr com a clase warning, que é o tr de aviso quando não há eventos na rota, ...
		$(".warning").remove();

		//...adiciona um tr na tabela de rota de entrega com os dados recebibos nos parametros, ...
		$(".delivery_route tbody").append("<tr id='" + idE + "' class='"+aux+"'>" +
																				"<td>" + cliente + "</td>" +
																				"<td>" + telefone + "</td>" +
																				"<td>" + cep + "</td>" +
																				"<td>" + cidade + "</td>" +
																				"<td>" + bairro + "</td>" +
																				"<td>" + logradouro + "</td>" +
																				"<td>" + numero + "</td>" +
																				"<td>" + complemento + "</td>" +
																				"<td>" + horario + "</td>" +
																				"<td align='center'><img class='remover' id='" + idE + "' src='../layout/images/close.png' width='25px' title='Remover'></td>" +
																			"</tr>");

			//Ao clicak no Bootão X com a clase remover na tr...
			$(".remover").click(function () {
				//...remove o elemento pai(td) da elemento pai(tr) do botão(x) de remover, ...
				$(this).parent().parent().remove();
				//...pega o valor do id do botão(x), ...
				var id = $(this).attr("id");
				//...remove a clase selecionado da tr da tabela events que tem o mesmo id do botão(x), ...
				$(".events #"+id+"").removeClass("selecionado");
				//...pega a quantidade de trs que tem na tabela de rota de entrega, ...
				var nLinhas = $(".delivery_route tbody tr").length;
				//...se o número de linhas é iagual a zero...
				if (nLinhas == 0) {
					//...reseta a variável auxiliar e
					aux = 0;
					//...adiciona um tr de aviso na tabela de rota de entrega
					$(".delivery_route tbody").append("<tr class='warning'>" +
							"<td colspan='11' align='center'>Não há eventos vinculados a rota de entrega</td>" +
							"</tr>");
				}else{
					aux--;
					//Variável auxiliar
				}
			});
	}
}


//Função responsável por Pegar os valores necessários da tabela de rota de entrega para salvá-la
function catchDeliveryRoute() {
	//
	var user = $(".slick-center").attr("id");
	var qtd = $(".delivery_route tbody tr").length;
	
	$('#idUsuario').val(user);
	$('#qtd').val(qtd);
	
	$('.delivery_route tbody tr').each(function () {
		
		var eventosId = [];
		var aux = 0;
		$('.delivery_route tbody tr').each(function () {
			eventosId[aux] = $(this).attr("id");
			aux++;
		});
		$('#idEvento').val(eventosId);
		
	});
}

function filtrarRota(){
	var data = $('#seldata').val();
	var cidade = $('#selcidade').val();
	var bairro = $('#selbairro').val();
	var horaDe = $('#txthorade').val();
	var horaAte = $('#txthoraate').val();
	$.ajax({
		type: "POST",
		url: "events_control/deliveryroute/cb_filter_deliveryroute.php",
		data: {data: data, cidade: cidade, bairro: bairro, horaDe: horaDe, horaAte: horaAte},
		success: function(dados){
			var filtrar = JSON.parse(dados);

			$('.events tbody tr').remove();
			$('.delivery_route tbody tr').remove();
			
			for(var auxE=0; auxE<filtrar[3]; auxE++){
				$('.events tbody').append(filtrar[0][auxE]);
			}
			for(var auxR=0; auxR<filtrar[4]; auxR++){
				$('.delivery_route tbody').append(filtrar[1][auxR]);
				
			}
			if(filtrar[2] != ""){
				$('.slider').html(filtrar[2]);
			}
			
			if((filtrar[5] == 1) || (filtrar[6] == 1)){
				$(".events tbody tr").addClass("selecionado");
				$(".delivery_route tbody").removeAttr("id", "sortable");

			}

			$('.search').html(filtrar[7]);

		},
	});


}
