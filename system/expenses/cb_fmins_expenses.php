<h1 id="title">Registro de Despesa</h1>
<div id="register"><!--Início do conteúdo do formulário-->
	<h3>Cadastrar Despesa</h3>
	<hr />
	<form name="frmregexpense" method="POST" action="?folder=expenses/&file=cb_ins_expenses&ext=php">
		<h4 style="text-align: center; color: #700;">Campos Não Obrigatórios *</h4>
		<table>
			<tr>
				<td>Tipo:</td>
				<td>
					<?php
						$sql_sel_expenses_types = "SELECT id, name FROM expenses_types ORDER BY name";
						$sql_sel_expenses_types_preparado = $conexaobd->prepare($sql_sel_expenses_types);
						$sql_sel_expenses_types_preparado->execute();
					?>
					<select name="seltipo">
							<option value="">Escolha...</option>
						<?php
							while($sql_sel_expenses_types_dados = $sql_sel_expenses_types_preparado->fetch()){
								$valor_tipo = $sql_sel_expenses_types_dados['id'];
								$nome_tipo = $sql_sel_expenses_types_dados['name'];

								echo '<option value="'.$valor_tipo.'">'.$nome_tipo.'</option>';
							}
						?>
					</select>
				</td>
			</tr>
			<tr>
				<td>Descrição: *</td>
				<td><textarea name="txadescricao" maxlength="255" style="max-width:180px;"></textarea></td>
			</tr>
			<tr>
				<td>Valor:</td>
				<td><input type="text" name="txtvalor" placeholder="Ex.:120,00" maxlength="8"></td>
			</tr>
			<tr>
				<td>Data:</td>
				<td><input type="text" name="txtdata" class="datepicker" placeholder="DD/MM/AAAA" maxlength="10" readonly></td>
			</tr>
			<tr>
				<td><button type="reset" name="btnreset">Limpar</button></td>
				<td><button type="submit" name="btnsubmit">Enviar</button></td>
			</tr>
		</table>
	</form>
</div><!--Fim do conteúdo do formulário-->
<div id="consult"><!--Início da consulta-->
	<h2>Despesas Registradas</h2>
	<div align="center"><!--Início do centro-->
		<div align="right" class="search"><!--Início da pesquisa-->
			<form name="frmpesquisa" method="POST" action="">
				<input type="text" name="txtpesquisa" placeholder="Pesquisar" maxlength="70">
				<button type="submit" name="btnpesquisar"><img src="../layout/images/search.png"></button>
			</form>
		</div><!--Fim da pesquisa-->
		<?php
		$pesquisa = "";
		//Esta linha representa a atribuição de vazio para a variável pesquisa.
		//Este bloco é responsável por verificar se a variável post do campo txtpesquisa existe. Se ela existir verifica se ela é diferente de vazio. Se ela for diferente de vazio atribui ela a variável $p_pesquisa. Atribui a variável pesquisa a sintaxe de pesquisa do banco.
		if(isset($_POST['txtpesquisa'])){
			if($_POST['txtpesquisa']!=""){
				$p_pesquisa = $_POST['txtpesquisa'];
				$pesquisa = " WHERE expenses_types.name LIKE '%".$p_pesquisa."%' OR expenses.description LIKE '%".$p_pesquisa."%' OR expenses.value LIKE '%".$p_pesquisa."%' OR expenses.date LIKE '%".$p_pesquisa."%'";
			}
		}
		$sql_sel_expenses = "SELECT expenses.*, IFNULL(expenses.description, 'Não há descrição!') AS descricao, expenses_types.name FROM expenses INNER JOIN expenses_types on expenses.expenses_types_id=expenses_types.id".$pesquisa." ORDER BY expenses.id";
		$sql_sel_expenses_preparado = $conexaobd->prepare($sql_sel_expenses);
		$sql_sel_expenses_preparado->execute();
	?>
		<table class="consult_table"><!--Início da tabela de consulta-->
			<thead><!--Início do cabeçalho da tabela-->
			<tr>
				<th width="5%">Código</th>
				<th width="20%">Tipo</th>
				<th width="25%">Descrição</th>
				<th width="20%">Valor</th>
				<th width="20%">Data</th>
				<th width="5%">Editar</th>
				<th width="5%">Excluir</th>
			</tr>
			</thead><!--Fim do cabeçalho da tabela-->
			<tbody><!--Início do corpo da tabela-->
			<?php
			if($sql_sel_expenses_preparado->rowCount()>0) {
				while ($sql_sel_expenses_dados = $sql_sel_expenses_preparado->fetch()) {
						$data = explode('-', $sql_sel_expenses_dados['date']);
						$valor = explode('.', $sql_sel_expenses_dados['value']);

						$sql_sel_expenses_dados['date'] = $data[2]."/".$data[1]."/".$data[0];
						$sql_sel_expenses_dados['value'] = $valor[0].",".$valor[1];
					?>
					<tr>
						<td><?php echo $sql_sel_expenses_dados['id']; ?></td>
						<td><?php echo $sql_sel_expenses_dados['name']; ?></td>
						<td><?php echo $sql_sel_expenses_dados['descricao']; ?></td>
						<td>R$<?php echo $sql_sel_expenses_dados['value']; ?></td>
						<td><?php echo $sql_sel_expenses_dados['date']; ?></td>
						<td align="center"><a href="?folder=expenses/&file=cb_fmupd_expenses&ext=php&id=<?php echo $sql_sel_expenses_dados['id']; ?>"><img src="../layout/images/edit.png" width="25px"></a></td>
						<td align="center"><?php echo safedelete($sql_sel_expenses_dados['id'], "", '?folder=expenses/&file=cb_del_expenses&ext=php', 'a despesa', $sql_sel_expenses_dados['name'].', Cod:'.$sql_sel_expenses_dados['id']) ?></td>
					</tr>
					<?php
				}
			}else{
				?>
				<td align="center" colspan="7"><?php echo mensagens('Vazio', 'Despesas') ?></td>
				<?php
			}
			?>
			</tbody><!--Fim do corpo da tabela-->
		</table><!--Fim da tabela de consulta-->
	</div>
</div><!--Fim da consulta-->