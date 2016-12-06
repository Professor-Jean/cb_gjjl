<h1 id="title">Registro de Cidade</h1>
<div id="register"><!--Início do conteúdo do formulário-->
    <h3>Alterar Cidade</h3>
    <hr />
    <?php
        $g_id = $_GET['id'];
        //Esta linha é responsável por receber o id da fmins via GET.
        //Este bloco é responsável por fazer a seleção das cidades que tenham o id igual ao recebido.
        $sql_sel_cities = "SELECT * FROM cities WHERE id='".$g_id."'";
        $sql_sel_cities_preparado = $conexaobd->prepare($sql_sel_cities);
        $sql_sel_cities_preparado->execute();
        $sql_sel_cities_dados = $sql_sel_cities_preparado->fetch();
    ?>
    <form name="frmregcidades" method="POST" action="?folder=cities/&file=cb_upd_cities&ext=php">
        <input type="hidden" name="hidid" value="<?php echo $sql_sel_cities_dados['id']; ?>">
        <table>
            <tr>
                <td>Nome:</td>
                <td><input type="text" name="txtnome" placeholder="Ex.: Joinville" maxlength="30" value="<?php echo $sql_sel_cities_dados['name']; ?>"></td>
            </tr>
            <tr>
                <td><button type="reset" name="btnlimpar">Limpar</button></td>
                <td><button type="submit" name="btnenviar">Enviar</button></td>
            </tr>
        </table>
    </form>
</div><!--Fim do conteúdo do formulário-->