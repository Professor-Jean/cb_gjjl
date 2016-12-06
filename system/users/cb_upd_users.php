<?php

    $p_id = $_POST["hidid"];
    $p_usuario = $_POST["txtusuario"];
    $p_senha = $_POST["pwdsenha"];
    $hash_senha = md5($salt.$p_senha);
    //Estas linhas são responsáveis por receber os dados da fmupd via POST.


    $msg_titulo = "Erro";
    //Esta linha é responsável por definir a variável msg_titulo, com o valor ERRO.
    $voltar = "?folder=users/&file=cb_fmupd_users&ext=php&id=".$p_id;
    //Esta linha é responsável por definir a variável voltar, com o valor de voltar para a página fmupd.



if($p_usuario == ""){
    $mensagem = mensagens('Validação', 'usuário');
    //Se a variável p_usuario for vazia, chama a função mensagens
}else if(!valida_alfanumerico($p_usuario, 1, 20)){
        $mensagem = mensagens('Validação Alfanumericos', 'Usuário');
        //Se a variável p_usuario possuir caracteres especiais ou mais de 20 caracteres, chama a função mensagens.
    }else if($p_senha == ""){
            $mensagem = mensagens('Validação', 'senha');
            //Se a variável p_senha for vazia, chama a função mensagens
        }else{
            //Este bloco é responsável por fazer a seleção dos usuários que tenham o nome de usuário igual ao da variável p_usuario e o id diferente do da variável p_id.
            $sql_sel_users = "SELECT * FROM users WHERE username='".$p_usuario."' AND id <>'".$p_id."'";
            $sql_sel_users_preparado = $conexaobd->prepare($sql_sel_users);
            $sql_sel_users_preparado->execute();
            //Este bloco é responsável por verificar se a contagem de registros com a condição acima é zero, então faz a alteração, se não, diz que o usuário já existe.
            if($sql_sel_users_preparado->rowCount()==0){
                $tabela="users";
                //Define o valor da variável tabela como users.

                //Este bloco é responsável por colocar os dados recebidos do formulário em um array.
                $dados = array(
                    'username'=>$p_usuario,
                    'password'=>$hash_senha
                );
                $condicao = "id='".$p_id."'";
                //Condição para que a alteração ocorra que a ID seja a mesma que a variavel p_id

                $sql_upd_users_resultado = alterar($tabela, $dados, $condicao);
                //Chama a função alterar e atribui o valor a variável sql_upd_users_resultado.

                //Este bloco é responsável por informar se a alteração funcionou ou não.
                if($sql_upd_users_resultado){
                        $msg_titulo = "Confirmação";
                        $mensagem = mensagens('Sucesso', 'Usuário', 'Alteração');
                        $voltar = "?folder=users/&file=cb_fmins_users&ext=php";
                    }else {
                        $mensagem = mensagens('Erro bd', 'usuário', 'alterar');
                    }
                }else{
                    $mensagem = mensagens('Repetição', 'usuário');
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
