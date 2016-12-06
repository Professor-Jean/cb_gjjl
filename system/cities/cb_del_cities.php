<?php
    $p_id = $_POST['id1'];
    //Esta linha é responsável por receber o id da safedelete via POST.

    $msg_titulo = "Erro";
    //Esta linha é responsável por definir a variável msg_titulo, com o valor ERRO.

    if($p_id==""){
        //Se a variável p_id for vazia, chama a função mensagens.
        $mensagem = mensagens('Vazio', 'Cidade');
    }else{
        $sql_sel_districts = "SELECT cities_id FROM districts WHERE MD5(cities_id)='" . $p_id . "'";
        $sql_sel_districts_preparado = $conexaobd->prepare($sql_sel_districts);
        $sql_sel_districts_preparado->execute();

        $rowCount_districts = $sql_sel_districts_preparado->rowCount();

        if($rowCount_districts>0){
            $mensagem = mensagens('Integridade', 'Bairro');
        }else {
            $tabela = "cities";
            //Define o valor da variável tabela como cities.

            $condicao = "MD5(id)='" . $p_id . "'";
            //Condição de o id com MD5 (usa o tempo como salt) ser igual a variável p_id.

            $sql_del_cities_resultado = deletar($tabela, $condicao);
            //Chama a função deletar e atribui o valor a variável sql_del_cities_resultado.

            //Este bloco é responsável por exibir se a exclusão funcionou ou não.
            if ($sql_del_cities_resultado) {
                $msg_titulo = "Confirmação";
                $mensagem = mensagens('Sucesso', 'cidade', 'Exclusão');
            } else {
                $mensagem = mensagens('Erro bd', 'cidade', 'excluir');
            }
        }
    }
?>
    <h1>Aviso</h1>
    <div class="message">
        <h3><img src="../layout/images/alert.png"><?php echo $msg_titulo; ?></h3>
        <hr />
        <p><?php echo $mensagem; ?></p>
        <a href="?folder=cities/&file=cb_fmins_cities&ext=php"><img src="../layout/images/back.png">Voltar</a>
    </div>