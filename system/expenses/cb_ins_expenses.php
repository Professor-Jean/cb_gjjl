<?php
$p_tipo = $_POST["seltipo"];
$p_descricao = $_POST["txadescricao"];
$p_valor = $_POST["txtvalor"];
$p_data = $_POST["txtdata"];

$data = explode('/', $p_data);
$valor = explode(',', $p_valor);

$msg_titulo = "Erro";

if($p_tipo == ""){
	$mensagem = mensagens('Validação', 'tipo');
}else if($p_valor == ""){
		$mensagem = mensagens('Validação', 'valor');
	}else if(!valida_decimal($p_valor, 1, 5)) {
			$mensagem = mensagens('Validação Numerico', 'valor');
		}else if($p_data == "") {
				$mensagem = mensagens('Validação', 'data');
			}else if((!isset($data[2]) || (isset($data[3]))) || (!valida_data($data[2], $data[1], $data[0]))){
					$mensagem = mensagens('Validação Data');
				}else{
					$p_data = $data[2]."-".$data[1]."-".$data[0];
					if(isset($valor[1])){
						$p_valor = $valor[0].".".$valor[1];
					}else{
						$p_valor = $valor[0];
					}


					$tabela = "expenses";
					$dados = array(
						'expenses_types_id' => $p_tipo,
						'description' => $p_descricao,
						'value' => $p_valor,
						'date' => $p_data
					);

					$sql_ins_expenses_resultado = adicionar($tabela, $dados);

					if($sql_ins_expenses_resultado) {
						$msg_titulo = "Confirmação";
						$mensagem = mensagens('Sucesso', 'despesa', 'Cadastro');
					}else{
						$mensagem = mensagens('Erro bd', 'despesa', 'cadastrar');
					}
	}
?>

<h1>Aviso</h1>
<div class="message">
	<h3><img src="../layout/images/alert.png"><?php echo $msg_titulo; ?></h3>
	<hr />
	<p><?php echo $mensagem; ?></p>
	<a href="?folder=expenses/&file=cb_fmins_expenses&ext=php"><img src="../layout/images/back.png">Voltar</a>
</div>





