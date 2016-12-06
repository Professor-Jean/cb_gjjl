<?php
    function autenticar($usuario, $senha){
        $salt = "(^&*vgfbgf1szZA-5k5#:";
        $hash_senha = MD5($salt.$senha);

        global $conexaobd;

        $sql_sel_users = "SELECT * FROM users WHERE username='".$usuario."' AND password='".$hash_senha."'";
        $sql_sel_users_preparado = $conexaobd->prepare($sql_sel_users);
        $sql_sel_users_preparado->execute();

        $sql_sel_users_dados = $sql_sel_users_preparado->fetch();

        if($sql_sel_users_preparado->rowCount() > 0){
            session_start();

            $_SESSION['idUsuario'] = $sql_sel_users_dados['id'];
            $_SESSION['usuario'] = $sql_sel_users_dados['username'];
            $_SESSION['permissao'] = $sql_sel_users_dados['permission'];
            $_SESSION['idSessao'] = session_id();

            if($_SESSION['permissao'] == 0){
                header("Location: ../../system/cb_mainadm_system.php");
            }else if($_SESSION['permissao'] == 1){
                header("Location: ../../system/cb_mainemp_system.php");
            }else{
                return "Erro de permissão";
            }

        }else{
            return "Usuário e/ou Senha incorretos.";
        }
    }
?>