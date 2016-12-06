<?php
$p_nome = $_POST["txtnome"];
$p_comentario = $_POST["txacomentario"];

$msg_titulo = "Erro";

if($p_nome == ""){
	$mensagem = mensagens('Validação', 'nome');
}else{
		$sql_sel_expenses_types = "SELECT * FROM expenses_types WHERE name = '".$p_nome."'";
		$sql_sel_expenses_types_preparado = $conexaobd->prepare($sql_sel_expenses_types);
		$sql_sel_expenses_types_preparado->execute();

		if($sql_sel_expenses_types_preparado->rowCount()==0){

			$msg_titulo="Sucesso";
			$mensagem = mensagens('Sucesso', 'Tipo de Despesa', 'Registro');
			$tabela = "expenses_types";
			$dados = array(
				'name' => $p_nome,
				'comment' => $p_comentario,
			);
			$sql_ins_expenses_types_resultado = adicionar($tabela, $dados);
			if($sql_ins_expenses_types_resultado) {
				$msg_titulo = "Confirmação";
				$mensagem = mensagens('Sucesso', 'Tipo de despesa', 'Cadastro');
			}else{
				$mensagem = mensagens('Erro bd', 'Tipo de despesa', 'cadastrar');
			}
		}else{
			$mensagem = mensagens('Repetição', 'Tipo de despesa');
		}
}
?>

<h1>Aviso</h1>
<div class="message">
	<h3><img src="../layout/images/alert.png"><?php echo $msg_titulo; ?></h3>
	<hr />
	<p><?php echo $mensagem; ?></p>
	<a href="?folder=expenses_types/&file=cb_fmins_expenses_types&ext=php"><img src="../layout/images/back.png">Voltar</a>
</div>





