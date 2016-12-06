<h1 id="title">Registro de Despesa</h1>
<div id="register"><!--Início do conteúdo do formulário-->
	<h3>Alterar Despesa</h3>
	<hr />
	<?php
		$g_id = $_GET['id'];

		$sql_sel_expenses = "SELECT * FROM expenses WHERE id='".$g_id."'";
		$sql_sel_expenses_preparado = $conexaobd->prepare($sql_sel_expenses);
		$sql_sel_expenses_preparado->execute();

		$sql_sel_expenses_dados = $sql_sel_expenses_preparado->fetch();

		$data = explode('-', $sql_sel_expenses_dados['date']);
		$valor = explode('.', $sql_sel_expenses_dados['value']);

		$sql_sel_expenses_dados['date'] = $data[2]."/".$data[1]."/".$data[0];
		$sql_sel_expenses_dados['value'] = $valor[0].",".$valor[1];
	?>
	<form name="frmregexpense" method="POST" action="?folder=expenses/&file=cb_upd_expenses&ext=php">
		<h4 style="text-align: center; color: #700;">Campos Não Obrigatórios *</h4>
		<input type="hidden" name="hidid" value="<?php echo $g_id; ?>">
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

							if($valor_tipo == $sql_sel_expenses_types_dados['id']){
								echo '<option value="'.$valor_tipo.'" selected>'.$nome_tipo.'</option>';
							}else{
								echo '<option value="'.$valor_tipo.'">'.$nome_tipo.'</option>';
							}
						}
						?>
					</select>
				</td>
			</tr>
			<tr>
				<td>Descrição: *</td>
				<td><textarea name="txadescricao" maxlength="255" style="max-width:180px;"><?php echo $sql_sel_expenses_dados['description'] ?></textarea></td>
			</tr>
			<tr>
				<td>Valor:</td>
				<td><input type="text" name="txtvalor" placeholder="Ex.:120,00" maxlength="8" value="<?php echo $sql_sel_expenses_dados['value'] ?>"></td>
			</tr>
			<tr>
				<td>Data:</td>
				<td><input type="text" name="txtdata" class="date" placeholder="DD/MM/AAAA" maxlength="10" value="<?php echo $sql_sel_expenses_dados['date']; ?>" readonly></td>
			</tr>
			<tr>
				<td><button type="reset" name="btnreset">Limpar</button></td>
				<td><button type="submit" name="btnsubmit">Enviar</button></td>
			</tr>
		</table>
	</form>
</div><!--Fim do conteúdo do formulário-->