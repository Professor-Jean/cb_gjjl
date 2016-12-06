<?php

    $p_id = $_POST['id1'];

    $msg_titulo = "Erro";

    if($p_id == ""){
        $mensagem = mensagens("Erro bd", "local", "excluir");
    }else{

        $sql_sel_events = "SELECT * FROM events WHERE MD5(locals_id)='".$p_id."'";

        $sql_sel_events_preparado = $conexaobd->prepare($sql_sel_events);

        $sql_sel_events_preparado->execute();

        if($sql_sel_events_preparado->rowCount()==0){

            $tabela = "locals";

            $condicao = "MD5(id)='".$p_id."'";

            $sql_sel_locals_resultado = deletar($tabela, $condicao);

            if($sql_sel_locals_resultado){
                $mensagem = mensagens("Sucesso", "local", "Exclusão");
                $msg_titulo = "Confirmação";
            }else{
                $mensagem = mensagens("Erro bd", "local", "excluir");
            }

        }else{
            $mensagem = mensagens("Integridade", "evento");
        }

    }

?>
<h1>Aviso</h1>
<div class="message">
    <h3><img src="../layout/images/alert.png"><?php echo $msg_titulo; ?></h3>
    <hr />
    <p><?php echo $mensagem ?></p>
    <a href="?folder=locals/&file=cb_fmins_locals&ext=php"><img src="../layout/images/back.png">Voltar</a>
</div>