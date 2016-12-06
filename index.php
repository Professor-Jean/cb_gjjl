<!DOCTYPE html>
<?php
  /****************************************************************************
    Estas linhas são responsáveis por realizar
    a inclusão das respectivas funções:* Conexão com o Bd
                                       * Operações Bd
                                       * Validações
                                       * Repositório de mensagens

   !IMPORTANTE! ATUALIZAR SEMPRE QUE FOR ADICIONADO NOVO INCLUDE !IMPORTANTE!
  ****************************************************************************/
  include "security/database/cb_connection_database.php";
  include "addons/php/cb_operationsdb_php.php";
  include "addons/php/cb_validations_php.php";
  include "addons/php/cb_messagerepository_php.php";

?>
<html lang="pt-BR">
  <head>
    <title>Cris Blau | Index</title>
    <meta charset="utf-8">
    <!--Estilos-->
    <link rel="stylesheet" href="layout/css/cb_reset_css.css">
    <link rel="stylesheet" href="layout/css/cb_style_css.css">
    <!--Scripts-->
  </head>
  <body id="index_body"><!--Início do corpo-->
      <div id="index_content" class="center_absolute"><!--Início do conteúdo da index-->
        <div id="logo"><!--Início da logo-->
          <img src="layout/images/logo.png" class="center_absolute">
        </div><!--Fim da logo-->
        <div class="vertical_line"></div><!--Div responsável pela linha vertical que separa a logo do formulário de autenticação-->
        <div id="content_form"><!--Início do conteúdo do formulário-->
          <div id="login_form" class="center_absolute"><!--Início do formulário de login-->
            <form name="frmlogin" method="POST" action="security/authentication/cb_login_authentication.php">
              <h1>Login</h1>
              <input type="text" name="txtusuario" placeholder="Nome de Usuário"><br>
              <input type="password" name="pwdsenha" placeholder="Senha"><br>
              <button type="submit" name="btnentrar">Entrar</button>
            </form>
          </div><!--Fim do formulário de login-->
        </div><!--Fim do conteúdo do formulário-->
      </div><!--Fim do conteúdo da index-->
    <footer><!--Início do rodapé-->
      <p>GJJL - Todos os Direitos Reservados© 2016</p>
    </footer><!--Início do rodapé-->
  </body><!--Fim do corpo-->
</html>
