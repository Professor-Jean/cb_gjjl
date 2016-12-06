<?php
    $p_id = $_POST['id1'];
    $p_usersid = $_POST['id2'];
    //Esta linha é responsável por receber os ids da safedelete via POST.

    $msg_titulo = "Erro";
    //Esta linha é responsável por definir a variável msg_titulo, com o valor ERRO.
    if(($p_id == "")||($p_usersid=="")){
        //Se a variável p_id for vazia, chama a função mensagens.
        $mensagem = mensagens('Vazio', 'Colaborador');
    }else {

        $tabela = "employees";
        $condicao = "MD5(id)='".$p_id."'";

        //Chamando a função e armazenando o resultado em uma variavel
        $sql_del_employees_resultado = deletar($tabela, $condicao);

        if($sql_del_employees_resultado){
            $tabela = "users";
            $condicao = "MD5(id)='".$p_usersid."'";

            //Chamando a função e armazenando o resultado em uma variavel
            $sql_del_users_resultado = deletar($tabela, $condicao);

            if($sql_del_users_resultado){
                $msg_titulo = "Confirmação";
                $mensagem = mensagens('Sucesso', 'colaborador', 'Exclusão');

            }else {
                $mensagem = mensagens('Erro bd', 'colaborador', 'excluir');
            }
        }else {
            $mensagem = mensagens('Erro bd', 'colaborador', 'excluir');
        }
    }
?>
<h1>Aviso</h1>
<div class="message">
    <h3><img src="../layout/images/alert.png"><?php echo $msg_titulo; ?></h3>
    <hr />
    <p><?php echo $mensagem; ?></p>
    <a href="?folder=employees/&file=cb_fmins_employees&ext=php"><img src="../layout/images/back.png">Voltar</a>
</div>
