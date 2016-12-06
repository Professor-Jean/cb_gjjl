<script>
	$(document).ready(function(){
		filtrarRota();
	});
</script>
<div id="consult" style="margin-top: 0;"><!--Início da consulta-->
	<div style="width: 100%;" align="right">
		<select name="seldata" id="seldata"  onChange="filtrarRota()" style="margin-right: 25px; width: 165px;">
			<option value="<?php echo date("d/m/Y"); ?>"><?php echo date("d/m/Y"); ?></option>
			<?php
				$sql_sel_events = "SELECT event_date FROM events WHERE status=1 GROUP BY event_date ORDER BY event_date";
				$sql_sel_events_preparado = $conexaobd->prepare($sql_sel_events);
				$sql_sel_events_preparado->execute();

				while($sql_sel_events_dados = $sql_sel_events_preparado->fetch()){

					$data = explode('-', $sql_sel_events_dados['event_date']);
					$sql_sel_events_dados['date'] = $data[2]."/".$data[1]."/".$data[0];
					
					$data_evento = $sql_sel_events_dados['date'];

						if(($_POST['seldata'] == $data_evento) && ($data_evento != date('d/m/Y'))) {
							echo '<option value="'.$data_evento.'" selected>'.$data_evento.'</option>';
						}else if($data_evento != date('d/m/Y')){
							echo '<option value="'.$data_evento.'">'.$data_evento.'</option>';
						}
				}
			?>
		</select>
	</div>
	
	<h1>Rota de Entrega <img src="../layout/images/search.png" class="filter_icon"></h1>
	<div class="filter"><!--Início do filtro-->
		<h3>Filtrar Eventos</h3>
		<hr />
		<table>
			<tr>
				<td>
					<?php

						//Este bloco é responsável por fazer a seleção de todos os dados da tabela cities (cidades).
						$sql_sel_cities = "SELECT * FROM cities ORDER BY name";
						$sql_sel_cities_preparado = $conexaobd->prepare($sql_sel_cities);
						$sql_sel_cities_preparado->execute();
					?>
					<select name="selcidade" id="selcidade" onChange="mostraBairro()">
						<option value="">Cidade</option>
						<?php
						//Este bloco é responsável por exibir os dados contidos na tabela cities em options que aparecerão para o usuário.
						while($sql_sel_cities_dados = $sql_sel_cities_preparado->fetch()){
							$valor_cidade = $sql_sel_cities_dados['id'];
							$nome_cidade = $sql_sel_cities_dados['name'];
							
							echo "<option value='".$valor_cidade."'>".$nome_cidade."</option>";
						}
						?>
					</select>
				</td>
				<td>Horário:</td>
				<td><input type="text" name="txthorade" id="txthorade" placeholder="De" maxlength="10" style="width:80px;"></td>
				<td><input type="text" name="txthoraate" id="txthoraate" placeholder="Até" maxlength="10" style="width:80px;"></td>
			</tr>
			<tr>
				<td>
					<select name="selbairro" id="selbairro">
						<option value="">Bairro</option>
					</select>
				</td>
				<td colspan="3" align="right"><button type="submit" name="btnpesquisar" onclick="filtrarRota()">Pesquisar</button></td>
			</tr>
		</table>
	</div><!--Fim do filtro-->
	<table class="consult_table events"><!--Início da tabela de consulta-->
		<thead><!--Início do cabeçalho da tabela-->
			<tr>
				<th width="20%">Cliente</th>
				<th width="5%">Telefone</th>
				<th width="5%">CEP</th>
				<th width="10%">Cidade</th>
				<th width="10%">Bairro</th>
				<th width="20%">Logradouro</th>
				<th width="5%">Nº</th>
				<th width="20%">Complemento</th>
				<th width="5%">Horário</th>
			</tr>
		</thead><!--Fim do cabeçalho da tabela-->
		<tbody><!--Início do corpo da tabela-->
		</tbody><!--Fim do corpo da tabela-->
	</table><!--Fim da tabela de consulta-->
		<section class="center slider">
			<?php
				$sql_sel_users = "SELECT * FROM users ORDER BY username ASC";
				$sql_sel_users_preparado = $conexaobd->prepare($sql_sel_users);
				$sql_sel_users_preparado->execute();
			
				while($sql_sel_users_dados = $sql_sel_users_preparado->fetch()){
					echo "<div id='".$sql_sel_users_dados['id']."'>".$sql_sel_users_dados['username']."</div>";
				}
			?>
		</section>
	<span class="imprimir">
		<table class="consult_table delivery_route">
			<thead><!--Início do cabeçalho da tabela-->
			<tr>
				<th width="20%">Cliente</th>
				<th width="5%">Telefone</th>
				<th width="5%">CEP</th>
				<th width="10%">Cidade</th>
				<th width="5%">Bairro</th>
				<th width="20%">Logradouro</th>
				<th width="2.5%">Nº</th>
				<th width="20%">Complemento</th>
				<th width="5%">Horário</th>
				<th width="5%"></th>
			</tr>
			</thead><!--Fim do cabeçalho da tabela-->
			<tbody id="sortable"><!--Início do corpo da tabela-->
			</tbody><!--Fim do corpo da tabela-->
		</table><!--Fim da tabela de consulta-->
	</span>
	<div align="center"><!--Início do centro-->
		<div align="right" class="search">
		</div>
	</div><!--Fim do centro-->
</div><!--Fim da consulta-->