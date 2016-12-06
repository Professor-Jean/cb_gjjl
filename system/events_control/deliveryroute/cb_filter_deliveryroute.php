<?php
	include "../../../security/database/cb_connection_database.php";
	include "../../../addons/php/cb_messagerepository_php.php";
	//Está linha representa a inclusão do arquivo que faz a conexão com o banco de dados.

	$filtro = "";

	if((isset($_POST['cidade'])) && ($_POST['cidade'] != "")){
		$filtro = " AND districts.cities_id LIKE'%".$_POST['cidade']."%'";
	}

	if((isset($_POST['bairro'])) && ($_POST['bairro'] != "")){
		$filtro.= " AND districts.id LIKE'%".$_POST['bairro']."%'";
	}

	if((isset($_POST['horaDe'])) && (isset($_POST['horaAte']))){
		if(($_POST['horaDe'] != "") && ($_POST['horaAte'] != "")){
			$filtro.= " AND event_time BETWEEN '".$_POST['horaDe']."' AND '".$_POST['horaAte']."'";
		}
	}

	if((isset($_POST['data'])) && ($_POST['data'] != "")){
		$dataex = explode('/', $_POST['data']);
		$data = $dataex[2].'-'.$dataex[1].'-'.$dataex[0];
		$filtro.= " AND event_date LIKE'%".$data."%'";

	}else{
		$_POST['data'] = date("d/m/Y");
		$dataex = explode('/', $_POST['data']);
		$data = $dataex[2].'-'.$dataex[1].'-'.$dataex[0];
		$filtro.= " AND event_date LIKE'%".$data."%'";
	}

	$sql_sel_events = "SELECT events.id AS idevento, events.cep, events.street, events.number, events.event_date, events.event_time, IFNULL(events.complement, 'Casa') AS complement, clients.name AS cliente, clients.phone, cities.name AS cidade, districts.cities_id, districts.name AS bairro FROM events INNER JOIN clients ON events.clients_id = clients.id INNER JOIN districts ON events.districts_id = districts.id INNER JOIN cities ON districts.cities_id = cities.id WHERE events.status=1".$filtro." ORDER BY clients.name";
	$sql_sel_events_preparado = $conexaobd->prepare($sql_sel_events);
	$sql_sel_events_preparado->execute();
	
	$events = array();
	if($sql_sel_events_preparado->rowCount()>0) {
		while ($sql_sel_events_dados = $sql_sel_events_preparado->fetch()) {
			$events[] .= "<tr id='".$sql_sel_events_dados['idevento']."' onClick='criarRota(\"".$sql_sel_events_dados['idevento']."\", \"".$sql_sel_events_dados['cliente']."\", \"".$sql_sel_events_dados['phone']."\", \"".$sql_sel_events_dados['cep']."\", \"".$sql_sel_events_dados['cidade']."\", \"".$sql_sel_events_dados['bairro']."\", \"".$sql_sel_events_dados['street']."\", \"".$sql_sel_events_dados['number']."\", \"".$sql_sel_events_dados['complement']."\", \"".$sql_sel_events_dados['event_time']."\")'>
																	<td>".$sql_sel_events_dados['cliente']."</td>
																	<td>".$sql_sel_events_dados['phone']."</td>
																	<td>".$sql_sel_events_dados['cep']."</td>
																	<td>".$sql_sel_events_dados['cidade']."</td>
																	<td>".$sql_sel_events_dados['bairro']."</td>
																	<td>".$sql_sel_events_dados['street']."</td>
																	<td>".$sql_sel_events_dados['number']."</td>
																	<td>".$sql_sel_events_dados['complement']."</td>
																	<td>".substr($sql_sel_events_dados['event_time'], 0,-3)."</td>
																</tr>";
			
		}
	}else{
		$events[] = array("<tr>
												<td align='center' colspan='9'>".mensagens('Vazio', 'Eventos Confirmados')."</td>
											</tr>");
	}
	
	$sql_sel_delivery_route = "SELECT delivery_route.order_number, users.username, events.id AS idevento, events.cep,events.street, events.number, events.event_date, events.event_time, IFNULL(events.complement, 'Casa') AS complement, events.status, clients.name AS cliente, clients.phone, cities.name AS cidade, districts.cities_id, districts.name AS bairro FROM delivery_route INNER JOIN events ON delivery_route.events_id=events.id INNER JOIN users ON delivery_route.users_id=users.id INNER JOIN clients ON events.clients_id=clients.id INNER JOIN districts ON events.districts_id=districts.id INNER JOIN cities ON districts.cities_id=cities.id WHERE events.status=1".$filtro." ORDER BY order_number";
	$sql_sel_delivery_route_preparado = $conexaobd->prepare($sql_sel_delivery_route);
	$sql_sel_delivery_route_preparado->execute();
	
	$deliveryroute = array();
	if($sql_sel_delivery_route_preparado->rowCount()>0) {
		while ($sql_sel_delivery_route_dados = $sql_sel_delivery_route_preparado->fetch()) {
			$deliveryroute[] = "<tr id='".$sql_sel_delivery_route_dados['idevento']."'>
														<td>".$sql_sel_delivery_route_dados['cliente']."</td>
														<td>".$sql_sel_delivery_route_dados['phone']."</td>
														<td>".$sql_sel_delivery_route_dados['cep']."</td>
														<td>".$sql_sel_delivery_route_dados['cidade']."</td>
														<td>".$sql_sel_delivery_route_dados['bairro']."</td>
														<td>".$sql_sel_delivery_route_dados['street']."</td>
														<td>".$sql_sel_delivery_route_dados['number']."</td>
														<td>".$sql_sel_delivery_route_dados['complement']."</td>
														<td>".substr($sql_sel_delivery_route_dados['event_time'], 0,-3)."</td>
														<td></td>
													</tr>";
		}
	}else{
		$deliveryroute[] = "<tr class='warning'>
												<td align='center' colspan='10'>Não há eventos vinculados a esta rota de entrega.</td>
											</tr>";
	}

	$sql_sel_delivery_users = "SELECT events.event_date, users.username FROM delivery_route INNER JOIN events ON delivery_route.events_id=events.id INNER JOIN users ON delivery_route.users_id=users.id WHERE events.status=1".$filtro." GROUP BY delivery_route.users_id";
	$sql_sel_delivery_users_preparado = $conexaobd->prepare($sql_sel_delivery_users);
	$sql_sel_delivery_users_preparado->execute();

	$sql_sel_delivery_users_dados = $sql_sel_delivery_users_preparado->fetch();

	if($sql_sel_delivery_users_preparado->rowCount()>0){
		$user = "<div style='font-size: 25px;'>".$sql_sel_delivery_users_dados['username']."</div>";
	}else{
		$user = "";
	}

	if($sql_sel_delivery_route_preparado->rowCount() == 0) {

		$botao = '<form id="salvar" name="frmsalvar" method="POST" action="?folder=events_control/deliveryroute/&file=cb_ins_deliveryroute&ext=php" onsubmit="catchDeliveryRoute()">
									<input id="idUsuario" type="hidden" name="hididu" value="">
									<input id="qtd" type="hidden" name="hidqtd" value="">
									<input id="idEvento" type="hidden" name="hidide" value="">
									<button type="submit" name="btnsalvar"><img src="../layout/images/save.png" width="35px" title="Salvar"></button>
								</form>';
	}else {
		$botao = '<form name="frmimprimir" method="POST" onsubmit="catchContent()" action="../addons/php/cb_buildpdf_php.php" id="gerarpdf">
									<input type="hidden" name="dadospdf" id="dadospdf" value="">
									<button type="submit" name="btnimprimir"><img src="../layout/images/print.png" width="25px" title="Imprimir">
									</button>
								</form>';
	}

	if(strtotime($data) < strtotime(date('Y-m-d'))){
		$dataantiga = 1;
	}else{
		$dataantiga = 0;
	}

	if($sql_sel_delivery_users_preparado->rowCount() > 0){
		$bloq_alteração = 1;
	}else{
		$bloq_alteração = 0;
	}

	$qtdE = count($events);
	$qtdR = count($deliveryroute);
	$filtrar = array($events, $deliveryroute, $user, $qtdE, $qtdR, $dataantiga, $bloq_alteração, $botao);

	echo json_encode($filtrar);
?>