<?php
$g_id = $_GET['id'];
$msg_titulo = "Erro";
if($g_id==""){
    $mensagem = mensagens('Erro bd','evento', 'confirmar');
}else{
    $tabela="events";
    $dados=array(
        'status'=>2
    );
    $condicao = "id='".$g_id."'";
    $sql_upd_events_resultado = alterar($tabela, $dados, $condicao);
    if($sql_upd_events_resultado){
        $msg_titulo = "Confirmação";
        $mensagem = "Evento realizado com sucesso!";
    }else{
        $mensagem = mensagens('Erro bd', 'evento', 'confirmar');
    }
}
?>
<h1>Aviso</h1>
<div class="message">
    <h3><img src="../layout/images/alert.png"><?php echo $msg_titulo; ?></h3>
    <hr />
    <p><?php echo $mensagem; ?></p>
    <a href="?folder=events_control/control/&file=cb_events_control&ext=php"><img src="../layout/images/back.png">Voltar</a>
</div>