<?php
session_start();

if(!isset($_SESSION['idSessao'])){
    header("Location: ".BASE_URL."security/authentication/cb_logout_authentication.php");
    exit;
}else if($_SESSION['idSessao'] != session_id()){
    header("Location: ".BASE_URL."security/authentication/cb_logout_authentication.php");
    exit;
}
?>