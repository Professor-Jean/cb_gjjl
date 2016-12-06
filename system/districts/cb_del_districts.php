<?php
    $p_id = $_POST['id1'];
    //Esta linha é responsável por receber o id da safedelete via POST.

    $msg_titulo = "Erro";
    //Esta linha é responsável por definir a variável msg_titulo, com o valor ERRO.

    if($p_id==""){
        //Se a variável p_id for vazia, chama a função mensagens.
        $mensagem = mensagens('Vazio', 'Bairro');
    }else {
        $sql_sel_clients = "SELECT districts_id FROM clients WHERE MD5(districts_id)='" . $p_id . "'";
        $sql_sel_clients_preparado = $conexaobd->prepare($sql_sel_clients);
        $sql_sel_clients_preparado->execute();

        $sql_sel_locals = "SELECT districts_id FROM locals WHERE MD5(districts_id)='" . $p_id . "'";
        $sql_sel_locals_preparado = $conexaobd->prepare($sql_sel_locals);
        $sql_sel_locals_preparado->execute();

        $sql_sel_events = "SELECT districts_id FROM events WHERE MD5(districts_id)='" . $p_id . "'";
        $sql_sel_events_preparado = $conexaobd->prepare($sql_sel_events);
        $sql_sel_events_preparado->execute();

        $rowCount_clients = $sql_sel_clients_preparado->rowCount();
        $rowCount_locals = $sql_sel_locals_preparado->rowCount();
        $rowCount_events = $sql_sel_events_preparado->rowCount();

        if (($rowCount_clients > 0) && ($rowCount_locals > 0) && ($rowCount_events > 0)) {
            $mensagem = mensagens('Integridade', 'Cliente, Local e Evento');
        } else if (($rowCount_clients > 0) && ($rowCount_locals > 0)) {
                $mensagem = mensagens('Integridade', 'Cliente e Local');
            } else if (($rowCount_clients > 0) && ($rowCount_events > 0)) {
                    $mensagem = mensagens('Integridade', 'Cliente e Evento');
                } else if (($rowCount_locals > 0) && ($rowCount_events > 0)) {
                        $mensagem = mensagens('Integridade', 'Local e Evento');
                    } else if ($rowCount_clients > 0) {
                            $mensagem = mensagens('Integridade', 'Cliente');
                        } else if ($rowCount_locals > 0) {
                                $mensagem = mensagens('Integridade', 'Local');
                            } else if ($rowCount_events > 0) {
                                    $mensagem = mensagens('Integridade', 'Evento');
                                } else {
                                    $tabela = "districts";
                                    //Define o valor da variável tabela como districts.

                                    $condicao = "MD5(id)='" . $p_id . "'";
                                    //Condição de o id com MD5 (usa o tempo como salt) ser igual a variável p_id.

                                    $sql_del_districts_resultado = deletar($tabela, $condicao);
                                    //Chama a função deletar e atribui o valor a variável sql_del_cities_resultado.

                                    //Este bloco é responsável por exibir se a exclusão funcionou ou não.
                                    if ($sql_del_districts_resultado) {
                                        $msg_titulo = "Confirmação";
                                        $mensagem = mensagens('Sucesso', 'bairro', 'Exclusão');
                                    } else {
                                        $mensagem = mensagens('Erro bd', 'bairro', 'excluir');
                                    }
                                }
    }
?>
<h1>Aviso</h1>
<div class="message">
    <h3><img src="../layout/images/alert.png"><?php echo $msg_titulo; ?></h3>
    <hr />
    <p><?php echo $mensagem; ?></p>
    <a href="?folder=districts/&file=cb_fmins_districts&ext=php"><img src="../layout/images/back.png">Voltar</a>
</div>