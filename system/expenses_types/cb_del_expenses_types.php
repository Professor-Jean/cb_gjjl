<?php
$p_id = $_POST['id1'];
//Esta linha é responsável por receber o id da safedelete via POST.

$msg_titulo = "Erro";
//Esta linha é responsável por definir a variável msg_titulo, com o valor ERRO.

if($p_id == ""){
	//Se a variável p_id for vazia, chama a função mensagens.
	$mensagem = mensagens('Vazio', 'Tipo de Despesa');
}else{

	$sql_sel_expenses = "SELECT * FROM expenses WHERE MD5(expenses_types_id)='".$p_id."'";
	$sql_sel_expenses_preparado= $conexaobd->prepare($sql_sel_expenses);
	$sql_sel_expenses_preparado->execute();

	if($sql_sel_expenses_preparado->rowCount() > 0){
		$mensagem = mensagens('Integridade', 'Despesas');
	}else{
		$tabela = "expenses_types";
		$condicao = "MD5(id)='" . $p_id . "'";

		//Chamando a função e armazenando o resultado em uma variavel
		$sql_del_expenses_types_resultado = deletar($tabela, $condicao);

		if ($sql_del_expenses_types_resultado) {
			$msg_titulo = "Confirmação";
			$mensagem = mensagens('Sucesso', 'Tipo de despesa', 'Exclusão');
		} else {
			$mensagem = mensagens('Erro bd', 'Tipo de despesa', 'excluir');
		}
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
