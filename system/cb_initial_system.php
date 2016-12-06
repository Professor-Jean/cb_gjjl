<?php
	include "../addons/php/cb_initialcharts_php.php";
	//sistema inclui a página que contem os gráficos
	if(isset($_GET['msg'])){
		echo $_GET['msg'];
	}else {

?>
	<h1 id="title" align="center">Bem Vindo(a), <?php echo $_SESSION['usuario']; ?>!</h1>
	<div id="charts_content1">
		<div id="chart1">
			<canvas id="chart_region" width="400px" height="250px"></canvas>
			<a class="link_pinicial" href="?folder=reports/&file=cb_statistics_reports&ext=php#tabs-regions">Gráfico Completo de Regiões &#8227;</a>
		</div>
		<div id="chart2">
			<canvas id="chart_locals" width="400px" height="250px"></canvas>
			<a class="link_pinicial" href="?folder=reports/&file=cb_statistics_reports&ext=php#tabs-locals">Gráfico Completo de Locais &#8227;</a>
		</div>
		<div id="chart5">
			<canvas id="chart_reasons" width="400px" height="250px"></canvas>
			<a class="link_pinicial" href="?folder=reports/&file=cb_statistics_reports&ext=php#tabs-reasons">Gráfico Completo de Motivos de Cancelamento &#8227;</a>
		</div>
	</div>
	<div id="charts_content2">
		<div id="chart3">
			<canvas id="chart_items" width="400px" height="250px"></canvas>
			<a class="link_pinicial" href="?folder=reports/&file=cb_statistics_reports&ext=php#tabs-items">Gráfico Completo de Itens &#8227;</a>
		</div>
		<div id="chart4">
			<canvas id="chart_kits" width="400px" height="250px"></canvas>
			<a class="link_pinicial" href="?folder=reports/&file=cb_statistics_reports&ext=php#tabs-kits">Gráfico Completo de Kits &#8227;</a>
		</div>
	</div>
		
		<div id="consult"><!--Início da consulta-->
			<h2>Próximos eventos</h2>
			<?php
					
			$sql_sel_events = "SELECT events.id, events.event_date AS data, events.local AS tipo_local, events.event_time AS hora, clients.name AS cliente, (IFNULL(events.delivery_fee, 0.00)+IFNULL(events.rent_value, 0.00)+SUM((IFNULL(events_has_items.actual_value, 0.00)*IFNULL(events_has_items.item_quantity, 0)))+(IFNULL(events_has_kits.actual_value, 0.00)*IFNULL(events_has_kits.kit_quantity, 0))-IFNULL(events.discount, 0.00)) AS valor FROM events INNER JOIN clients ON events.clients_id=clients.id LEFT JOIN events_has_items ON events_has_items.events_id=events.id LEFT JOIN events_has_kits ON events_has_kits.events_id=events.id WHERE events.status=1 GROUP BY events.id ORDER BY data LIMIT 5";
			$sql_sel_events_preparado = $conexaobd->prepare($sql_sel_events);
			$sql_sel_events_preparado->execute();
			?>
		
			<table class="consult_table"><!--Início da tabela de consulta-->
				<thead><!--Início do cabeçalho da tabela-->
				<tr>
					<th width="15%">Data</th>
					<th width="30%">Nome do cliente</th>
					<th width="25%">Local</th>
					<th width="15%">Horário</th>
					<th width="15%">Valor</th>
				</tr>
				</thead><!--Fim do cabeçalho da tabela-->
				<tbody><!--Início do corpo da tabela-->
				<?php
				if($sql_sel_events_preparado->rowCount()>0) {
					while ($sql_sel_events_dados = $sql_sel_events_preparado->fetch()){
						
						$exp_data = explode("-", $sql_sel_events_dados['data']);
						$sql_sel_events_dados['data'] = $exp_data[2]."/".$exp_data[1]."/".$exp_data[0];
						
						//Verirficando o Tipo de Local e Nomeando-o
						switch($sql_sel_events_dados['tipo_local']){
							case 0:
								$sql_sel_events_dados['tipo_local'] = "Local da Empresa";
							break;
							case 1:
								$sql_sel_events_dados['tipo_local'] = "Local do Cliente";
							break;
							case 2:
								$sql_sel_events_dados['tipo_local'] = "Outro Local";
							break;
						}
						
						if($sql_sel_events_dados['valor']<0){
							$sql_sel_events_dados['valor'] = 0;
						}
						?>
						<tr>
							<td><?php echo $sql_sel_events_dados['data']; ?></td>
							<td><?php echo $sql_sel_events_dados['cliente']; ?></td>
							<td><?php echo $sql_sel_events_dados['tipo_local']; ?></td>
							<td><?php echo $sql_sel_events_dados['hora']; ?></td>
							<td>R$<?php echo number_format($sql_sel_events_dados['valor'], 2, ',', '.'); ?></td>
						</tr>
						<?php
					}
				}else{
					?>
					<td align="center" colspan="5"><?php echo mensagens('Vazio', 'eventos') ?></td>
					<?php
				}
				?>
				</tbody><!--Fim do corpo da tabela-->
			</table><!--Fim da tabela de consulta-->
			<div align="center"><!--Início do centro-->
				<div align="right" class="search"><!--Início da pesquisa-->
					<a class="link_pinicial" href="?folder=events_control/deliveryroute/&file=cb_view_deliveryroute&ext=php">Ir para rota de entrega &#8227;</a>
				</div><!--Fim da pesquisa-->
			</div><!--Fim do centro-->
		</div><!--Fim da consulta-->
<?php
	}
?>


