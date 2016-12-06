<!-- Estilos -->
<link rel="stylesheet" type="text/css" href="../../layout/css/cb_reset_css.css">
<link rel="stylesheet" type="text/css" href="../../layout/css/cb_style_css.css">

<?php
    include "../database/cb_connection_database.php";
    include "../../addons/php/cb_messagerepository_php.php";
    include "../../addons/php/cb_authentication_php.php";

    $p_usuario = $_POST["txtusuario"];
    $p_senha = $_POST["pwdsenha"];

    if($p_usuario == ""){
        $alerta = mensagens('Validação', 'Usuário');
    }else if($p_senha == ""){
            $alerta = mensagens('Validação', 'Senha');
        }else{
            $alerta = autenticar($p_usuario, $p_senha);
        }
?>
<div id="login_msg"><!--Começo do conteúdo-->
    <h1>Aviso</h1>
    <div class="message">
        <h3><img src="../../layout/images/alert.png">Confirmação/Erro</h3>
        <hr />
        <p><?php echo $alerta; ?></p>
        <a href="../../index.php"><img src="../../layout/images/back.png">Voltar</a>
    </div>
</div><!--Fim do conteúdo-->

