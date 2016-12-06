<h1 id="title">Registro de Tipo de Despesa</h1>
<div id="register"><!--Início do conteúdo do formulário-->
	<h3>Alterar Tipo de Despesa</h3>
	<hr />
	<?php
		$g_id = $_GET['id'];

		$sql_sel_expenses_types = "SELECT * FROM expenses_types WHERE id='".$g_id."'";
		$sql_sel_expenses_types_preparado = $conexaobd->prepare($sql_sel_expenses_types);
		$sql_sel_expenses_types_preparado->execute();

		$sql_sel_expenses_types_dados = $sql_sel_expenses_types_preparado->fetch();

	?>
	<form name="frmregexpensetype" method="POST" action="?folder=expenses_types/&file=cb_upd_expenses_types&ext=php">
		<h4 style="text-align: center; color: #700;">Campos Não Obrigatórios *</h4>
		<input type="hidden" name="hidid" value="<?php echo $sql_sel_expenses_types_dados['id']; ?>">
		<table>
			<tr>
				<td>Nome:</td>
				<td><input type="text" name="txtnome" placeholder="Ex.:Conta Luz" maxlength="25" value="<?php echo $sql_sel_expenses_types_dados['name']; ?>"></td>
			</tr>
			<tr>
				<td>Comentário: *</td>
				<td><textarea name="txacomentario" maxlength="255" style="max-width:180px;"><?php echo $sql_sel_expenses_types_dados['comment']; ?></textarea></td>
			</tr>
			<tr>
				<td><button type="reset" name="btnreset">Limpar</button></td>
				<td><button type="submit" name="btnsubmit">Enviar</button></td>
			</tr>
		</table>
	</form>
</div><!--Fim do conteúdo do formulário-->