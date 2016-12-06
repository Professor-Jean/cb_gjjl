<?php
if((isset($_POST['txtdatade'])) && (isset($_POST['txtdataate']))){
	//Se as variáveis POST txtdatade e txtdataate existirem...
	if(($_POST['txtdatade']=="") && ($_POST['txtdataate']=="")){
		//Se as variáveis POST txtdatade e txtdataate forem iguais a vazio.
		$datade = "";
		//Variável datade recebe vazio.
		$dataate = "";
		//Variável dataate recebe vazio.
		$data = "";
		//Variável data recebe vazio.
	}else {
		//Se as variáveis POST forem diferente de vazio.
		$p_datade = explode('/', $_POST['txtdatade']);
		//Variável p_datade, explode para formar a data no padrão do banco de dados.
		$datade = $p_datade[2].'-'.$p_datade[1].'-'.$p_datade[0];
		//Variável datade recebe a array da p_datade explodida.
		$p_dataate = explode('/', $_POST['txtdataate']);
		//Variável p_dataate, explode para formar a data no padrão do banco de dados.
		$dataate = $p_dataate[2].'-'.$p_dataate[1].'-'.$p_dataate[0];
		//Variável dataate recebe a array da p_dataate explodida.
		$data = "WHERE event_date BETWEEN '" . $datade . "' AND '" . $dataate . "'";
		//É atribuída a variável data a string com a cláusula where formando assim o filtro.
	}
}else{
	//Se as variáveis POST não existirem, atribui-se vazio as variáveis datade, dataate e data
	$datade = "";
	$dataate = "";
	$data = "";
}

//Este bloco é responsável por fazer a seleção de todos os dados da tabela cities (cidade) quando o nome for igual a JOINVILLE.
$sql_sel_cities = "SELECT * FROM cities WHERE name='JOINVILLE'";
$sql_sel_cities_preparado = $conexaobd->prepare($sql_sel_cities);
$sql_sel_cities_preparado->execute();
$sql_sel_cities_dados = $sql_sel_cities_preparado->fetch();
if(isset($_POST['selcidade'])){
	//Se a variável POST existir...
	$p_cidade = $_POST['selcidade'];
	//Atribua-a a variável p_cidade.
	if($data==""){
		//Se a variável data for igual a vazio...
		$cidade = "WHERE cities.id='".$p_cidade."'";
		//Variável cidade recebe a string com a cláusula where formando assim o filtro de escolha de cidade.
	}else {
		//Se a variável data for diferente de vazio...
		$cidade = "AND cities.id='" . $p_cidade . "'";
		//Variável cidade recebe a string com a cláusula and, pois já existe uma variável com string possuindo where.
	}
}else{
	//Se a variável POST não existir, quer dizer que nenhuma cidade foi alterada, sendo assim, a cidade com o nome JOINVILLE fará parte do filtro.
	$p_cidade = "";
	//Variável p_cidade recebe vazio.
	if($data=="") {
		//Se a variável data for igual a vazio...
		$cidade = "WHERE cities.id='" . $sql_sel_cities_dados['id'] . "'";
		//Variável cidade recebe a string com a cláusula where formando assim o filtro de escolha de cidade.
	}else{
		//Se a variável data for diferente de vazio...
		$cidade = "AND cities.id='" . $sql_sel_cities_dados['id'] . "'";
		//Variável cidade recebe a string com a cláusula and, pois já existe uma variável com string possuindo where.
	}
}


//Inicializando variaveis
$labels_regioes = "";
$labels_qtdr = "";
$labels_locais = "";
$labels_qtdl = "";
$labels_itens = "";
$labels_qtdi = "";
$labels_kits = "";
$labels_qtdk = "";
$labels_reasons= "";
$labels_qtdc = "";


//********Realizando a contagem das regiôes mais atendidas*********\\

//Realizando a busca no banco de dados pelos eventos e os bairros onde foram realizados e a quantidade de vezes que cada bairro aparece. Juntando com tabelas districts e cities para obter o campo id da cidade para poder ser feito o filtro.
$sql_sel_eventsd = "SELECT COUNT(events.districts_id) AS qtdbairro, districts.name AS dname FROM events INNER JOIN districts ON events.districts_id=districts.id INNER JOIN cities ON districts.cities_id=cities.id ".$data." ".$cidade." GROUP BY events.districts_id ORDER BY qtdbairro DESC";
$sql_sel_eventsd_preparado = $conexaobd->prepare($sql_sel_eventsd);
$sql_sel_eventsd_preparado->execute();

//Armazenado na variavel labels_regioes os nomes dos bairros que apareceram na consulta e armazenando sua respectiva quantidade na variavel labels_qtdr.
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

//Realizando a busca no banco de dados pelos eventos e os tipos dos locais que foram utilizados e a quantidade de vezes que cada tipo aparece. Juntando com tabelas districts e cities para obter o campo id da cidade para poder ser feito o filtro.
$sql_sel_eventsl = "SELECT COUNT(local) AS qtdlocal, local FROM events INNER JOIN districts ON events.districts_id=districts.id INNER JOIN cities ON districts.cities_id=cities.id ".$cidade." GROUP BY local ORDER BY qtdlocal DESC";
$sql_sel_eventsl_preparado = $conexaobd->prepare($sql_sel_eventsl);
$sql_sel_eventsl_preparado->execute();

//Armazenado na variavel labels_locais os nomes dos tipos de locais que apareceram na consulta e armazenando sua respectiva quantidade na variavel labels_qtdl.
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
$sql_sel_eventshasitems = "SELECT SUM(events_has_items.item_quantity) AS totalqtditem, items.name AS iname FROM events_has_items INNER JOIN items ON events_has_items.items_id=items.id GROUP BY events_has_items.items_id ORDER BY totalqtditem DESC";
$sql_sel_eventshasitems_preparado = $conexaobd->prepare($sql_sel_eventshasitems);
$sql_sel_eventshasitems_preparado->execute();

//Armazenado na variavel labels_itens apenas os nomes dos 5 itens que mais apareceram na consulta e armazenando sua respectiva quantidade na variavel labels_qtdi
while($sql_sel_eventshasitems_dados = $sql_sel_eventshasitems_preparado->fetch()){
	
	$labels_itens.=  "'".$sql_sel_eventshasitems_dados['iname']."', ";
	$labels_qtdi.= $sql_sel_eventshasitems_dados['totalqtditem'].", ";
}

//********Realizando a contagem dos Kits mais pedidos*********\\

//Realizando a busca no banco de dados pelos eventos e os kits que foram pedidos, suas quantidades e a quantidade que cada kit aparece
$sql_sel_eventshaskits = "SELECT SUM(events_has_kits.kit_quantity) AS totalqtdkit, kits.name AS kname FROM events_has_kits INNER JOIN kits ON events_has_kits.kits_id=kits.id GROUP BY events_has_kits.kits_id ORDER BY totalqtdkit DESC";
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
	$( document ).ready(function() {
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
							stepSize: 1
						}
					}]
				}
			}
		});

	});
</script>
