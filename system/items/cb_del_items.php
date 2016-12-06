<?php

    $p_id = $_POST['id1'];

    $msg_titulo = "Erro";

    if($p_id == ""){
        $mensagem = mensagens("Erro bd", "item", "excluir");
    }else{

            $sql_sel_kits_has_items = "SELECT * FROM kits_has_items WHERE MD5(items_id)='".$p_id."'";

            $sql_sel_kits_has_items_preparado = $conexaobd->prepare($sql_sel_kits_has_items);

            $sql_sel_kits_has_items_preparado->execute();

        if($sql_sel_kits_has_items_preparado->rowCount()==0){

            $sql_sel_events_has_items = "SELECT events_has_items.items_id, events.status FROM events_has_items INNER JOIN events ON events_has_items.events_id=events.id WHERE (status='0' AND MD5(items_id)='".$p_id."') OR (status='1' AND MD5(items_id)='".$p_id."')";

            $sql_sel_events_has_items_preparado = $conexaobd->prepare($sql_sel_events_has_items);

            $sql_sel_events_has_items_preparado->execute();

            if($sql_sel_events_has_items_preparado->rowCount()==0){

                $tabela = "kits_has_items";

                $condicao = "MD5(items_id)='".$p_id."'";

                $sql_del_item_resultado = deletar($tabela, $condicao);

                if($sql_del_item_resultado==true){

                    $tabela = "events_has_items";

                    $condicao = "MD5(items_id)='".$p_id."'";

                    $sql_del_item_resultado = deletar($tabela, $condicao);

                    if($sql_del_item_resultado==true){

                        $tabela = "items";

                        $condicao = "MD5(id)='".$p_id."'";

                        $sql_del_item_resultado = deletar($tabela, $condicao);

                        if($sql_del_item_resultado){
                            $mensagem = mensagens("Sucesso", "item", "Exclusão");
                            $msg_titulo = "Confirmação";
                        }else{
                            $mensagem = mensagens("Erro bd", "item", "excluir");
                        }

                    }else{
                        $mensagem = mensagens("Erro bd", "item", "excluir");
                    }
                }


            }else{
                $mensagem = "Há registro(s) de evento associado(s) a este registro, portanto cancele-o(s) ou realize-o(s) e refeça a operação!";
            }

        }else{
            $mensagem = mensagens("Integridade", "kit");
        }
    }

?>
<h1>Aviso</h1>
<div class="message">
    <h3><img src="../layout/images/alert.png"><?php echo $msg_titulo; ?></h3>
    <hr />
    <p><?php echo $mensagem ?></p>
    <a href="?folder=items/&file=cb_fmins_items&ext=php"><img src="../layout/images/back.png">Voltar</a>
</div>