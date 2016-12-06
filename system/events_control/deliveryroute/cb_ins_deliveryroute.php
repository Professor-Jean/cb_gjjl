<?php
	$p_qtd = $_POST['hidqtd'];
	$p_idUsuario = $_POST['hididu'];
	$p_idEvento = $_POST['hidide'];
	
	$msg_titulo = "erro";

	if($p_qtd == 'warning'){
		$mensagem = "Adicione pelo menos um evento a Rota de Entrega antes de salvá-la";
	}else if(($p_qtd == "") || ($p_idUsuario == "") || ($p_idEvento == "")){
			$mensagem = "Não foi possível salvar a rota de entrega, devido a um erro no recebimento dos dados!";
		}else{
					
			$p_idEvento = explode(',', $p_idEvento);
			$ordem = 0;
			for($aux=0; $aux<$p_qtd; $aux++){
				$ordem++;
				$tabela = "delivery_route";
				$dados = array(
					'users_id' => $p_idUsuario,
					'events_id' => $p_idEvento[$aux],
					'order_number' => $ordem,
				);
				
				$sql_ins_delivery_route_resultado = adicionar($tabela, $dados);
				
				if($sql_ins_delivery_route_resultado){
					$msg_titulo = "Confirmação";
					$mensagem = mensagens('Sucesso', 'Rota de entrega', 'Cadastro');
				}else{
					$mensagem = mensagens('Erro bd', 'Rota de entrega', 'Cadastrar');
				}
			}
		}

?>
<h1>Aviso</h1>
<div class="message">
	<h3><img src="../layout/images/alert.png"><?php echo $msg_titulo; ?></h3>
	<hr />
	<p><?php echo $mensagem; ?></p>
	<a href="?folder=events_control/deliveryroute/&file=cb_view_deliveryroute&ext=php"><img src="../layout/images/back.png">Voltar</a>
</div>
