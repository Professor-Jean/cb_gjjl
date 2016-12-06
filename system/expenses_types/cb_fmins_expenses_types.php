<h1 id="title">Registro de Tipo de Despesa</h1>
<div id="register"><!--Início do conteúdo do formulário-->
	<h3>Cadastrar Tipo de Despesa</h3>
	<hr />
	<form name="frmregexpensetype" method="POST" action="?folder=expenses_types/&file=cb_ins_expenses_types&ext=php">
		<h4 style="text-align: center; color: #700;">Campos Não Obrigatórios *</h4>
		<table>
			<tr>
				<td>Nome:</td>
				<td><input type="text" name="txtnome" placeholder="Ex.:Conta Luz" maxlength="25"></td>
			</tr>
			<tr>
				<td>Comentário: *</td>
				<td><textarea name="txacomentario" maxlength="255" style="max-width:180px;"></textarea></td>
			</tr>
			<tr>
				<td><button type="reset" name="btnreset">Limpar</button></td>
				<td><button type="submit" name="btnsubmit">Enviar</button></td>
			</tr>
		</table>
	</form>
</div><!--Fim do conteúdo do formulário-->
<div id="consult"><!--Início da consulta-->
	<h2>Tipos de Despesa Registrados</h2>
	<?php
	$sql_sel_expenses_types = "SELECT id, name, IFNULL(comment, 'Não há descrição!') AS comentario FROM expenses_types";
	$sql_sel_expenses_types_preparado = $conexaobd->prepare($sql_sel_expenses_types);
	$sql_sel_expenses_types_preparado->execute();
	?>

	<table class="consult_table"><!--Início da tabela de consulta-->
		<thead><!--Início do cabeçalho da tabela-->
		<tr>
			<th width="30%">Nome</th>
			<th width="50%">Comentário</th>
			<th width="10%">Editar</th>
			<th width="10%">Excluir</th>
		</tr>
		</thead><!--Fim do cabeçalho da tabela-->
		<tbody><!--Início do corpo da tabela-->
		<?php
		if($sql_sel_expenses_types_preparado->rowCount()>0) {
			while ($sql_sel_expenses_types_dados = $sql_sel_expenses_types_preparado->fetch()) {
				?>
				<tr>
					<td><?php echo $sql_sel_expenses_types_dados['name']; ?></td>
					<td><?php echo $sql_sel_expenses_types_dados['comentario']; ?></td>
					<td align="center"><a href="?folder=expenses_types/&file=cb_fmupd_expenses_types&ext=php&id=<?php echo $sql_sel_expenses_types_dados['id']; ?>"><img src="../layout/images/edit.png" width="25px"></a></td>
					<td align="center"><?php echo safedelete($sql_sel_expenses_types_dados['id'], "", '?folder=expenses_types/&file=cb_del_expenses_types&ext=php', 'o tipo de despesa', $sql_sel_expenses_types_dados['name']) ?></td>
				</tr>
				<?php
			}
		}else{
			?>
			<td align="center" colspan="4"><?php echo mensagens('Vazio', 'Tipos de Despesas') ?></td>
			<?php
		}
		?>
		</tbody><!--Fim do corpo da tabela-->
	</table><!--Fim da tabela de consulta-->
</div><!--Fim da consulta-->