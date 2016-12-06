<?php
    $p_usuario = $_POST["txtusuario"];
    $p_senha = $_POST["pwdsenha"];
    $hash_senha = md5($salt.$p_senha);


    $msg_titulo = "Erro";
    //Esta linha é responsável por definir a variável msg_titulo, com o valor ERRO.


if($p_usuario == ""){
    //Se a variável p_usuario for vazia, chama a função mensagens.
    $mensagem = mensagens('Validação', 'usuário');
}else if(!valida_alfanumerico($p_usuario, 1, 20)){
        //Se a variável p_usuario possuir caracteres especiais, chama a função mensagens.
        $mensagem = mensagens('Validação Alfanumericos', 'Usuário');
    }else if($p_senha == ""){
            //Se a variável p_senha for vazia, chama a função mensagens.
             $mensagem = mensagens('Validação', 'senha');
        }else{
            //Este bloco é responsável por fazer a seleção dos usuários que tenham o nome de usuário igual a variável p_usuario.
            $sql_sel_users = "SELECT * FROM users WHERE username = '".$p_usuario."'";
            $sql_sel_users_preparado = $conexaobd->prepare($sql_sel_users);
            $sql_sel_users_preparado->execute();

            //Este bloco é responsável por verificar se a contagem de registros com a condição acima é zero, então faz a inserção, se não, diz que o usuário já existe.
            if($sql_sel_users_preparado->rowCount()==0){
                $tabela = "users";
                //Define que a tabela que a inserção deve ser feita é a users

                //Este bloco é responsável por colocar os dados recebidos do formulário em um array.
                $dados = array(
                    'username' => $p_usuario,
                    'password' => $hash_senha,
                    'permission' => '0'
                );
                $sql_ins_users_resultado = adicionar($tabela, $dados);
                if($sql_ins_users_resultado) {
                    $msg_titulo = "Confirmação";
                    $mensagem = mensagens('Sucesso', 'Usuário', 'Cadastro');
                }else{
                    $mensagem = mensagens('Erro bd', 'Usuário', 'cadastrar');
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
    <a href="?folder=users/&file=cb_fmins_users&ext=php"><img src="../layout/images/back.png">Voltar</a>
</div>





