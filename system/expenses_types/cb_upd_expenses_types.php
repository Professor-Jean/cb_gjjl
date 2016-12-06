<?php

$p_id = $_POST["hidid"];
$p_nome = $_POST["txtnome"];
$p_descricao = $_POST["txacomentario"];
//Estas linhas são responsáveis por receber os dados da fmupd via POST.

$msg_titulo = "Erro";
//Esta linha é responsável por definir a variável msg_titulo, com o valor ERRO.

$voltar = "?folder=expenses_types/&file=cb_fmupd_expenses_types&ext=php&id=".$p_id;
//Esta linha é responsável por definir a variável voltar, com o valor de voltar para a página fmupd.

if($p_nome == ""){
	$mensagem = mensagens('Validação', 'nome');
	//Se a variável p_usuario for vazia, chama a função mensagens
}else if(!valida_alfanumerico($p_nome, 1, 25)){
	$mensagem = mensagens('Validação Alfanumericos', 'nome');
	//Se a variável p_usuario possuir caracteres especiais ou mais de 20 caracteres, chama a função mensagens.
}else{
	$sql_sel_expenses_types = "SELECT * FROM expenses_types WHERE name='".$p_nome."' AND id <>'".$p_id."'";
	$sql_sel_expenses_types_preparado = $conexaobd->prepare($sql_sel_expenses_types);
	$sql_sel_expenses_types_preparado->execute();

	if($sql_sel_expenses_types_preparado->rowCount()==0){
		$tabela="expenses_types";
		$dados = array(
			'name'=>$p_nome,
			'comment'=>$p_descricao
		);
		$alt_condicao = "id='".$p_id."'";
		$sql_upd_expenses_types_resultado = alterar($tabela, $dados, $alt_condicao);

		if($sql_upd_expenses_types_resultado){
			$msg_titulo = "Confirmação";
			$mensagem = mensagens('Sucesso', 'tipo de despesa', 'Alteração');
			$voltar = "?folder=expenses_types/&file=cb_fmins_expenses_types&ext=php";
		}else {
			$mensagem = mensagens('Erro bd', 'tipo de despesa', 'alterar');
		}
	}else{
		$mensagem = mensagens('Repetição', 'tipo de despesa');
	}
}
?>
<h1>Aviso</h1>
<div class="message">
	<h3><img src="../layout/images/alert.png"><?php echo $msg_titulo; ?></h3>
	<hr />
	<p><?php echo $mensagem; ?></p>
	<a href="<?php echo $voltar; ?>"><img src="../layout/images/back.png">Voltar</a>
</div>
