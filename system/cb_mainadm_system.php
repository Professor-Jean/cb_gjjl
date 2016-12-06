<!DOCTYPE html>
<?php
  $permissao_acesso = 0;
  /****************************************************************************
    Estas linhas são responsáveis por realizar
    a inclusão das respectivas funções:* Setup de segurança
                                       * Conexão com o Bd
                                       * Repositório de mensagens
                                       * Operações SQL
                                       * Safe Delete
                                       * Validations

   !IMPORTANTE! ATUALIZAR SEMPRE QUE FOR ADICIONADO NOVO INCLUDE !IMPORTANTE!
  ****************************************************************************/
  include "../security/cb_setup_security.php";
  include "../security/database/cb_connection_database.php";
  include "../addons/php/cb_messagerepository_php.php";
  include "../addons/php/cb_operationsdb_php.php";
  include "../addons/php/cb_safedelete_php.php";
  include "../addons/php/cb_validations_php.php";


?>
<html>
  <head>
    <title>Cris Blau | Admin</title>
    <meta name="authors" content="Gabriel Dezan, João Santucci, João Spieker, Lucas Janning"/>
    <meta name="description" content="Websoftware desenvolvido para uma empresa de festas sob medida." />
    <meta name="keywords" content="Websoftware, festas, festas sob medida." />
    <meta charset="utf-8" />
    <!-- Estilos -->
    <link rel="stylesheet" type="text/css" href="../layout/css/cb_reset_css.css">
    <link rel="stylesheet" type="text/css" href="../layout/css/cb_style_css.css">
    <link href="../layout/css/cb_jquery-ui_css.css" rel="stylesheet">
    <link href="../addons/plugins/slick/slick.css" rel="stylesheet">
    <link href="../addons/plugins/slick/slick-theme.css" rel="stylesheet">
    <link href="../layout/css/cb_select2.min_css.css" rel="stylesheet">
    <link href="../layout/css/fullcalendar.min.css" rel="stylesheet">
    <!-- Scripts -->
      <!-- Plugins/Libraries -->
    <script src="../addons/js/cb_jquery-3.1.0.min_js.js"></script>
    <script src="../addons/js/cb_jquery-ui.min_js.js"></script>
    <script src="../addons/js/cb_datepicker-pt-BR_js.js"></script>
    <script src="../addons/js/cb_masterdetails_js.js"></script>
    <script src="../addons/plugins/slick/slick.min.js"></script>
    <script src="../addons/js/cb_select2.min_js.js"></script>
    <script src="../addons/js/moment.min.js"></script>
    <script src='../addons/js/fullcalendar.min.js'></script>
    <script src='../addons/js/cb_fullcalendar-pt-BR_js.js'></script>
    <script src='../addons/js/cb_listjs.min_js.js'></script>
    <script src='../addons/js/cb_listpagination.min_js.js'></script>
      <!-- Nossas Funções -->
    <script src="../addons/js/cb_deliveryroute_js.js"></script>
    <script src="../addons/js/cb_confirmdelete_js.js"></script>
    <script src="../addons/js/cb_chartjs_js.js"></script>
    <script src="../addons/js/cb_modalwindow_js.js"></script>
    <script src="../addons/js/cb_modalcontent_js.js"></script>
    <script src="../addons/js/cb_dynamicselect_js.js"></script>
    <script src="../addons/js/cb_helpers_js.js"></script>
    <script src="../addons/js/cb_finances_js.js"></script>
    <script src="../addons/js/cb_eventscontrol_js.js"></script>
  </head>
  <body><!--Início do corpo-->
    <header><!--Início do cabeçalho-->
      <img src="../layout/images/menu.png" id="menu">
      <nav><!--Início do menu-->
        <ul>
          <li class="menu_title">Registros</li>
          <li><a href="?folder=users/&file=cb_fmins_users&ext=php">Registro de Administrador</a></li>
          <li><a href="?folder=employees/&file=cb_fmins_employees&ext=php">Registro de Colaborador</a></li>
          <li><a href="?folder=cities/&file=cb_fmins_cities&ext=php">Registro de Cidade</a></li>
          <li><a href="?folder=districts/&file=cb_fmins_districts&ext=php">Registro de Bairro</a></li>
          <li><a href="?folder=clients/&file=cb_fmins_clients&ext=php">Registro de Cliente</a></li>
          <li><a href="?folder=items/&file=cb_fmins_items&ext=php">Registro de Item</a></li>
          <li><a href="?folder=kits/&file=cb_fmins_kits&ext=php">Registro de Kit</a></li>
          <li><a href="?folder=locals/&file=cb_fmins_locals&ext=php">Registro de Local para Eventos</a></li>
          <li><a href="?folder=expenses_types/&file=cb_fmins_expenses_types&ext=php">Registro de Tipo de Despesa</a></li>
          <li><a href="?folder=expenses/&file=cb_fmins_expenses&ext=php">Registro de Despesa</a></li>
          <li><a href="?folder=events/&file=cb_fmins_events&ext=php">Registro de Orçamento de evento</a></li>
        </ul>
        <ul>
          <li class="menu_title">Controle</li>
          <li><a href="?folder=events_control/deliveryroute/&file=cb_view_deliveryroute&ext=php">Elaborar Rota de Entrega</a></li>
          <li><a href="?folder=events_control/control/&file=cb_events_control&ext=php">Controle de Eventos</a></li>
        </ul>
        <ul>
          <li class="menu_title">Relatórios/Consultas</li>
          <li><a href="?folder=reports/&file=cb_events_reports&ext=php">Consulta de Eventos</a></li>
          <li><a href="?folder=reports/&file=cb_statistics_reports&ext=php">Estatísticas</a></li>
          <li><a href="?folder=reports/&file=cb_finances_reports&ext=php">Relatório Financeiro</a></li>
        </ul>
      </nav><!--Fim do menu-->
      <a href="cb_mainadm_system.php"><img src="../layout/images/logo.png" id="header_logo"></a>
      <h1>Cris Blau</h1>
      <div id="user_area"><!--Início da área de usuário-->
        <a href="?folder=users/&file=cb_fmupd_users&ext=php&id=<?php echo $_SESSION['idUsuario']?>;"><?php echo $_SESSION['usuario'] ?></a>
        <a href="../security/authentication/cb_logout_authentication.php"><img src="../layout/images/quit.png" id="quit"></a>
      </div><!--Fim da área de usuário-->
    </header><!--Fim do cabeçalho-->
    <div id="content"><!--Início do conteúdo-->
      <?php
        //Esta estrutura é responsável pelo carregamento dinâmico.
        if(isset($_GET['folder'])&&isset($_GET['file'])&&isset($_GET['ext'])){
          //Se as variáveis folder, file e ext vindas por get existirem...
          if(!include $_GET['folder'].$_GET['file'].".".$_GET['ext']){
            //Se o include dessas variáveis for falso...
            echo "<h1>Página não encontrada!</h1>";
            //Sistema exibe mensagem de página não encontrada
          }
        }else{
          //Se as variáveis não existirem...
          include "cb_initial_system.php";
          //Sistema exibe (inclui) a página cb_initial_system.php.
        }
      ?>
    </div><!--Fim do conteúdo-->
    <footer><!--Início do rodapé-->
      <p>Cris Blau - Todos os Direitos Reservados© 2016</p>
    </footer><!--Fim do rodapé-->
  </body><!--Fim do corpo-->
</html>
<script src="../addons/js/cb_setup_js.js"></script>
