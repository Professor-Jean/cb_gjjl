<?php
    $p_id = $_POST['id1'];
    //Esta linha é responsável por receber o id da safedelete via POST.

    $msg_titulo = "Erro";
    //Esta linha é responsável por definir a variável msg_titulo, com o valor ERRO.

    if($p_id == ""){
        //Se a variável p_id for vazia, chama a função mensagens.
        $mensagem = mensagens('Vazio', 'Usuário');
    }else {
        $sql_sel_users = "SELECT * FROM users WHERE permission='0'";
        $sql_sel_users_preparado = $conexaobd->prepare($sql_sel_users);
        $sql_sel_users_preparado->execute();

        if ($sql_sel_users_preparado->rowCount() == 1) {
            $mensagem = "Você não pode se excluir sendo o último administrador cadastrado.";
        } else {
            $tabela = "users";
            $condicao = "MD5(id)='" . $p_id . "'";

            //Chamando a função e armazenando o resultado em uma variavel
            $sql_del_users_resultado = deletar($tabela, $condicao);

            if ($sql_del_users_resultado) {
                $msg_titulo = "Confirmação";
                $mensagem = mensagens('Sucesso', 'usuário', 'Exclusão');
                if ($p_id == MD5($_SESSION['idUsuario'])) {
                    header('Location:../security/authentication/cb_logout_authentication.php');
                }
            } else {
                $mensagem = mensagens('Erro bd', 'usuário', 'excluir');
            }
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
