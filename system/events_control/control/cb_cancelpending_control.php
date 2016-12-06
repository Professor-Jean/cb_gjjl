<?php
    $p_id=$_POST['txtid'];
    $p_motivo=$_POST['selmotivo'];
    $p_comentario=$_POST['txacomentario'];

    $msg_titulo = "Erro";
    $voltar = "?folder=events_control/control/&file=cb_fmcancelpending_control&ext=php&id=".$p_id;

    if($p_id=="") {
        $mensagem = mensagens('Erro bd', 'evento', 'cancelar');
    }else if($p_motivo==""){
            $mensagem = mensagens('Validação', 'motivo');
        }else {
            $sql_sel_events = "SELECT clients_id, locals_id, event_date, local FROM events WHERE id='" . $p_id . "'";
            $sql_sel_events_preparado = $conexaobd->prepare($sql_sel_events);
            $sql_sel_events_preparado->execute();
            $sql_sel_events_dados = $sql_sel_events_preparado->fetch();
            $tabela = "canceled_events";
            $dados = array(
                'clients_id' => $sql_sel_events_dados['clients_id'],
                'locals_id' => $sql_sel_events_dados['locals_id'],
                'event_date' => $sql_sel_events_dados['event_date'],
                'local' => $sql_sel_events_dados['local'],
                'reason' => $p_motivo,
                'repaymant' => "",
                'forfeit' => "",
                'comment' => $p_comentario
            );
            $sql_ins_events_resultado = adicionar($tabela, $dados);
            if ($sql_ins_events_resultado) {
                $sql_sel_eventshk = "SELECT * FROM events_has_kits WHERE events_id='".$p_id."'";
                $sql_sel_eventshk_preparado = $conexaobd->prepare($sql_sel_eventshk);
                $sql_sel_eventshk_preparado->execute();
                if($sql_sel_eventshk_preparado->rowCount()>0) {

                    $tabela = "events_has_kits";
                    $condicao = "events_id = '" . $p_id . "'";
                    $sql_del_eventshk_resultado = deletar($tabela, $condicao);
                }
                $sql_sel_eventshi = "SELECT * FROM events_has_items WHERE events_id='".$p_id."'";
                $sql_sel_eventshi_preparado = $conexaobd->prepare($sql_sel_eventshi);
                $sql_sel_eventshi_preparado->execute();
                if($sql_sel_eventshi_preparado->rowCount()>0) {
                    $tabela = "events_has_items";
                    $condicao = "events_id = '" . $p_id . "'";
                    $sql_del_eventshi_resultado = deletar($tabela, $condicao);
                }
                $tabela = "events";
                $condicao = "id = '".$p_id."'";
                $sql_del_events_resultado = deletar($tabela, $condicao);
                if ($sql_del_events_resultado) {
                    $msg_titulo = "Confirmação";
                    $mensagem = mensagens('Sucesso', 'Evento', 'Cancelamento');
                    $voltar = "?folder=events_control/control/&file=cb_events_control&ext=php";
                } else {
                    $mensagem = mensagens('Erro bd', 'evento', 'cancelar');
                }
            } else {
                $mensagem = mensagens('Erro bd', 'evento', 'cancelar');
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

