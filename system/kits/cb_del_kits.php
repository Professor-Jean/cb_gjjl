<?php

    $p_id = $_POST['id1'];

    $msg_titulo = "Erro";

    if($p_id == ""){
        $mensagem = mensagens("Erro bd", "item", "excluir");
    }else{

        $sql_sel_events_has_kits = "SELECT events_has_kits.kits_id, events.status FROM events_has_kits INNER JOIN events ON events_has_kits.events_id=events.id WHERE (status='0' AND MD5(kits_id)='".$p_id."') OR (status='1' AND MD5(kits_id)='".$p_id."')";

        $sql_sel_events_has_kits_preparado = $conexaobd->prepare($sql_sel_events_has_kits);

        $sql_sel_events_has_kits_preparado->execute();

        if($sql_sel_events_has_kits_preparado->rowCount()==0){

            $tabela = "kits_has_items";

            $condicao = "MD5(kits_id)='".$p_id."'";

            $sql_del_kits_has_items_resultado = deletar($tabela, $condicao);

            if($sql_del_kits_has_items_resultado){

                $tabela = "events_has_kits";

                $condicao = "MD5(kits_id)='".$p_id."'";

                $sql_del_kits_resultado = deletar($tabela, $condicao);

                if($sql_del_kits_resultado){

                    $tabela = "kits";

                    $condicao = "MD5(id)='".$p_id."'";

                    $sql_del_kits_resultado = deletar($tabela, $condicao);

                    if($sql_del_kits_resultado){
                        $mensagem = mensagens("Sucesso", "kit", "Exclusão");
                        $msg_titulo = "Confirmação";
                    }else{
                        $mensagem = mensagens("Erro bd", "kit", "excluir");
                    }
                }else{
                    $mensagem = mensagens("Erro bd", "kit", "excluir");
                }

            }else{
                $mensagem = mensagens("Erro bd", "kit", "excluir");
            }

        }else{
            $mensagem = "Há registro(s) de evento associado(s) a este registro, portanto cancele-o(s) ou realize-o(s) e refeça a operação!";
        }
}


?>
<h1>Aviso</h1>
<div class="message">
    <h3><img src="../layout/images/alert.png"><?php echo $msg_titulo; ?></h3>
    <hr />
    <p><?php echo $mensagem ?></p>
    <a href="?folder=kits/&file=cb_fmins_kits&ext=php"><img src="../layout/images/back.png">Voltar</a>
