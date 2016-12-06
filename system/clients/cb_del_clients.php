<?php
    $p_id = $_POST['id1'];
    //Esta linha é responsável por receber o id da safedelete via POST.

    $msg_titulo = "Erro";
    //Esta linha é responsável por definir a variável msg_titulo, com o valor ERRO.

    if($p_id==""){
        //Se a variável p_id for vazia, chama a função mensagens.
        $mensagem = mensagens('Vazio', 'Cliente');
    }else {
        $sql_sel_events = "SELECT clients_id FROM events WHERE MD5(clients_id)='" . $p_id . "'";
        $sql_sel_events_preparado = $conexaobd->prepare($sql_sel_events);
        $sql_sel_events_preparado->execute();

        $rowCount_events = $sql_sel_events_preparado->rowCount();

        if ($rowCount_events>0) {
            $mensagem = mensagens('Integridade', 'Evento');
        } else {
            $tabela = "clients";
            //Define o valor da variável tabela como clients.

            $condicao = "MD5(id)='" . $p_id . "'";
            //Condição de o id com MD5 (usa o tempo como salt) ser igual a variável p_id.

            $sql_del_clients_resultado = deletar($tabela, $condicao);
            //Chama a função deletar e atribui o valor a variável sql_del_clients_resultado.

            //Este bloco é responsável por exibir se a exclusão funcionou ou não.
            if ($sql_del_clients_resultado) {
                $msg_titulo = "Confirmação";
                $mensagem = mensagens('Sucesso', 'cliente', 'Exclusão');
            } else {
                $mensagem = mensagens('Erro bd', 'cliente', 'excluir');
            }
        }
    }
?>
    <h1>Aviso</h1>
    <div class="message">
        <h3><img src="../layout/images/alert.png"><?php echo $msg_titulo; ?></h3>
        <hr />
        <p><?php echo $mensagem; ?></p>
        <a href="?folder=clients/&file=cb_fmins_clients&ext=php"><img src="../layout/images/back.png">Voltar</a>
    </div>