<?php
	//Inicializando variaveis
	$labels_regioes = "";
	$labels_qtdr = "";
	$labels_locais = "";
	$labels_qtdl = "";
	$labels_itens = "";
	$labels_qtdi = "";
	$labels_kits = "";
	$labels_qtdk = "";
	$labels_reasons = "";
	$labels_qtdc = "";

	//********Realizando a contagem das regiôes mais atendidas*********\\

	//Realizando a busca no banco de dados pelos eventos e os bairros onde foram realizados e a quantidade que cada bairro aparece
  $sql_sel_eventsd = "SELECT COUNT(events.districts_id) AS qtdbairro, districts.name AS dname FROM events INNER JOIN districts ON events.districts_id=districts.id GROUP BY events.districts_id ORDER BY qtdbairro DESC LIMIT 5";
  $sql_sel_eventsd_preparado = $conexaobd->prepare($sql_sel_eventsd);
  $sql_sel_eventsd_preparado->execute();

	//Armazenado na variavel labels_regioes apenas os nomes dos 5 bairros que mais apareceram na consulta e armazenado sua respectiva quantidade na variavel labels_qtdr
  while($sql_sel_eventsd_dados = $sql_sel_eventsd_preparado->fetch()){
    $labels_regioes.=  "'".$sql_sel_eventsd_dados['dname']."', ";
    $labels_qtdr.= $sql_sel_eventsd_dados['qtdbairro'].", ";
  }

	//********Realizando a contagem dos Locais mais utilizados*********\\

	/*****Tipos de Local*****
	 * 0 -> Local da Empresa
	 * 1 -> Local do Cliente
	 * 2 -> Outro local
	 ***********************/

	//Realizando a busca no banco de dados pelos eventos e os tipos dos locais que foram utilizados e a quantidade que cada tipo aparece
	$sql_sel_eventsl = "SELECT COUNT(local) AS qtdlocal, local FROM events GROUP BY local ORDER BY qtdlocal DESC LIMIT 5";
	$sql_sel_eventsl_preparado = $conexaobd->prepare($sql_sel_eventsl);
	$sql_sel_eventsl_preparado->execute();

	//Armazenado na variavel labels_locais apenas os nomes dos 5 tipos de locais que mais apareceram na consulta e armazenando sua respectiva quantidade na variavel labels_qtdl
	while($sql_sel_eventsl_dados = $sql_sel_eventsl_preparado->fetch()){

		//Verirficando o Tipo de Local e Nomeando-o
		switch($sql_sel_eventsl_dados['local']){
			case 0:
				$sql_sel_eventsl_dados['local'] = "Local da Empresa";
			break;
			case 1:
				$sql_sel_eventsl_dados['local'] = "Local do Cliente";
			break;
			case 2:
				$sql_sel_eventsl_dados['local'] = "Outro Local";
			break;
		}

		$labels_locais.=  "'".$sql_sel_eventsl_dados['local']."', ";
		$labels_qtdl.= $sql_sel_eventsl_dados['qtdlocal'].", ";
	}

	//********Realizando a contagem dos Itens mais pedidos*********\\

	//Realizando a busca no banco de dados pelos eventos e os itens que foram pedidos, suas quantidades e a quantidade que cada item aparece
	$sql_sel_eventshasitems = "SELECT SUM(events_has_items.item_quantity) AS totalqtditem, items.name AS iname FROM events_has_items INNER JOIN items ON events_has_items.items_id=items.id GROUP BY events_has_items.items_id ORDER BY totalqtditem DESC LIMIT 5";
	$sql_sel_eventshasitems_preparado = $conexaobd->prepare($sql_sel_eventshasitems);
	$sql_sel_eventshasitems_preparado->execute();

	//Armazenado na variavel labels_itens apenas os nomes dos 5 itens que mais apareceram na consulta e armazenando sua respectiva quantidade na variavel labels_qtdi
	while($sql_sel_eventshasitems_dados = $sql_sel_eventshasitems_preparado->fetch()){
		
		$labels_itens.=  "'".$sql_sel_eventshasitems_dados['iname']."', ";
		$labels_qtdi.= $sql_sel_eventshasitems_dados['totalqtditem'].", ";
	}

	//********Realizando a contagem dos Kits mais pedidos*********\\
	
	//Realizando a busca no banco de dados pelos eventos e os kits que foram pedidos, suas quantidades e a quantidade que cada kit aparece
	$sql_sel_eventshaskits = "SELECT SUM(events_has_kits.kit_quantity) AS totalqtdkit, kits.name AS kname FROM events_has_kits INNER JOIN kits ON events_has_kits.kits_id=kits.id GROUP BY events_has_kits.kits_id ORDER BY totalqtdkit DESC LIMIT 5";
	$sql_sel_eventshaskits_preparado = $conexaobd->prepare($sql_sel_eventshaskits);
	$sql_sel_eventshaskits_preparado->execute();
	
	//Armazenado na variavel labels_kits apenas os nomes dos 5 itens que mais apareceram na consulta e armazenando sua respectiva quantidade na variavel labels_qtdk
	while($sql_sel_eventshaskits_dados = $sql_sel_eventshaskits_preparado->fetch()){
		
		$labels_kits.=  "'".$sql_sel_eventshaskits_dados['kname']."', ";
		$labels_qtdk.= $sql_sel_eventshaskits_dados['totalqtdkit'].", ";
	}
	
	//************Realizando a contagem das razões de cancelamento mais frequentes************\\
	$sql_sel_canceledevents = "SELECT COUNT(reason) AS qtdMotivo, reason FROM canceled_events GROUP BY reason ORDER BY qtdMotivo DESC";
	$sql_sel_canceledevents_preparado = $conexaobd->prepare($sql_sel_canceledevents);
	$sql_sel_canceledevents_preparado->execute();
	
	while($sql_sel_canceledevents_dados = $sql_sel_canceledevents_preparado->fetch()){
		switch($sql_sel_canceledevents_dados['reason']){
			case 'FI':
				$sql_sel_canceledevents_dados['reason'] = 'Financeiro';
			break;
			case 'IN':
				$sql_sel_canceledevents_dados['reason'] = 'Insatisfação';
				break;
			case 'EI':
				$sql_sel_canceledevents_dados['reason'] = 'Evento mais Importante';
				break;
			case 'AF':
				$sql_sel_canceledevents_dados['reason'] = 'Adversidade Familiar';
				break;
			default:
				$sql_sel_canceledevents_dados['reason'] = 'Outros';
				break;
		}
		
		$labels_reasons.=  "'".$sql_sel_canceledevents_dados['reason']."', ";
		$labels_qtdc.= $sql_sel_canceledevents_dados['qtdMotivo'].", ";

	}

?>
<script>

$(document).ready(function () {

	if(<?php echo $sql_sel_eventsd_preparado->rowCount() ?> <= 0){
		$('#chart1').css('display', 'none');
	}
	if(<?php echo $sql_sel_eventsl_preparado->rowCount() ?> <= 0){
		$('#chart2').css('display', 'none');
	}
	if(<?php echo $sql_sel_eventshasitems_preparado->rowCount() ?> <= 0){
		$('#chart3').css('display', 'none');
	}
	if(<?php echo $sql_sel_eventshaskits_preparado->rowCount() ?> <= 0){
		$('#chart4').css('display', 'none');
	}
	if(<?php echo $sql_sel_canceledevents_preparado->rowCount() ?> <= 0){
		$('#chart5').css('display', 'none');
	}
	//Este bloco é responsável por construir o Gráfico de regiões
	var ctx = document.getElementById("chart_region");
	var chart_region = new Chart(ctx, {
		type: 'horizontalBar',
		data: {
			labels: [<?php echo $labels_regioes;?>],
			datasets: [{
				label: 'Qtd',
				data: [<?php echo $labels_qtdr;?>],
				backgroundColor: 'rgba(54, 162, 235, 0.2)',
				borderColor: 'rgba(54, 162, 235, 1)',
				borderWidth: 1
			}]
		},
		options: {
			title: {
				display: true,
				text: 'Regiões mais atendidas'
			},
			legend: {
				display: false
			},
			scales: {
				xAxes: [{
					ticks: {
						beginAtZero: true,
					}
				}]
			}
		}
	});

	//Este bloco é responsável por construir o Gráfico de locais
	var ctx1 = document.getElementById("chart_locals");
	var chart_locals = new Chart(ctx1, {
		type: 'horizontalBar',
		data: {
			labels: [<?php echo $labels_locais;?>],
			datasets: [{
				label: 'Qtd',
				data: [<?php echo $labels_qtdl;?>],
				backgroundColor: 'rgba(54, 162, 235, 0.2)',
				borderColor: 'rgba(54, 162, 235, 1)',
				borderWidth: 1
			}]
		},
		options: {
			title: {
				display: true,
				text: 'Locais mais Utilizados'
			},
			legend: {
				display: false,
			},
			scales: {
				xAxes: [{
					ticks: {
						beginAtZero: true,
					}
				}]
			}
		}
	});

	//Este bloco é responsável por construir o Gráfico de Itens
	var ctx2 = document.getElementById("chart_items");
	var chart_items = new Chart(ctx2, {
		type: 'horizontalBar',
		data: {
			labels: [<?php echo $labels_itens;?>],
			datasets: [{
				label: 'Qtd',
				data: [<?php echo $labels_qtdi;?>],
				backgroundColor: 'rgba(54, 162, 235, 0.2)',
				borderColor: 'rgba(54, 162, 235, 1)',
				borderWidth: 1
			}]
		},
		options: {
			title: {
				display: true,
				text: 'Itens mais Pedidos'
			},
			legend: {
				display: false,
			},
			scales: {
				xAxes: [{
					ticks: {
						beginAtZero: true,
					}
				}]
			}
		}
	});

	//Este bloco é responsável por construir o Gráfico de kits
	var ctx3 = document.getElementById("chart_kits");
	var chart_kits = new Chart(ctx3, {
		type: 'horizontalBar',
		data: {
			labels: [<?php echo $labels_kits;?>],
			datasets: [{
				label: 'Qtd',
				data: [<?php echo $labels_qtdk;?>],
				backgroundColor: 'rgba(54, 162, 235, 0.2)',
				borderColor: 'rgba(54, 162, 235, 1)',
				borderWidth: 1
			}]
		},
		options: {
			title: {
				display: true,
				text: 'Kits mais pedidos'
			},
			legend: {
				display: false,
			},
			scales: {
				xAxes: [{
					ticks: {
						beginAtZero: true,
					}
				}]
			}
		}
	});

	//Este bloco é responsável por construir o Gráfico de motivos de cancelamento
	var ctx4 = document.getElementById("chart_reasons");
	var chart_reasons = new Chart(ctx4, {
		type: 'horizontalBar',
		data: {
			labels: [<?php echo $labels_reasons;?>],
			datasets: [{
				label: 'Qtd',
				data: [<?php echo $labels_qtdc;?>],
				backgroundColor: 'rgba(54, 162, 235, 0.2)',
				borderColor: 'rgba(54, 162, 235, 1)',
				borderWidth: 1
			}]
		},
		options: {
			title: {
				display: true,
				text: 'Motivos de Cancelamento mais Frequentes'
			},
			legend: {
				display: false,
			},
			scales: {
				xAxes: [{
					ticks: {
						beginAtZero: true,
					}
				}]
			}
		}
	});
});
</script>