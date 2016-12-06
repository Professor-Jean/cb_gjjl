<?php
if($_SESSION['permissao'] != $permissao_acesso){
    if($_SESSION['permissao'] == 0){
        header("Location: ".BASE_URL."system/cb_mainadm_system.php?msg=Você não tem permissão para ver esta página!");
        exit;
    }else if($_SESSION['permissao'] == 1){
        header("Location: ".BASE_URL."system/cb_mainemp_system.php?msg=Você não tem permissão para ver esta página!");
        exit;
    }else{
        header("Location: ".BASE_URL."security/authentication/cb_logout_authentication.php");
        exit;
    }
}
?>