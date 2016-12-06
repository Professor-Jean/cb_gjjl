<h1 id="title">Registro de Administrador</h1>
<div id="register"><!--Início do conteúdo do formulário-->
    <h3>Alterar Administrador</h3>
    <hr />
    <?php
        $g_id = $_GET['id'];
        //Esta linha é responsável por receber o id da fmins via GET.
        //Este bloco é responsável por fazer a seleção dos usuários que tenham o id igual ao recebido.
        $sql_sel_users = "SELECT * FROM users WHERE id='".$g_id."'";
        $sql_sel_users_preparado = $conexaobd->prepare($sql_sel_users);
        $sql_sel_users_preparado->execute();
        $sql_sel_users_dados = $sql_sel_users_preparado->fetch();
    ?>
    <form name="frmreguser" method="POST" action="?folder=users/&file=cb_upd_users&ext=php">
        <input type="hidden" name="hidid" value="<?php echo $sql_sel_users_dados['id']; ?>">
        <table>
            <tr>
                <td>Nome de Usuário:</td>
                <td><input type="text" name="txtusuario" placeholder="Ex.:João1234" maxlength="20" value="<?php echo $sql_sel_users_dados['username']; ?>"</td>
            </tr>
            <tr>
                <td>Senha:</td>
                <td><input type="password" name="pwdsenha" placeholder="Ex.:1234" maxlength="20"></td>
            </tr>
            <tr>
                <td><button type="reset" name="btnreset">Limpar</button></td>
                <td><button type="submit" name="btnsubmit">Enviar</button></td>
            </tr>
        </table>
    </form>
</div><!--Fim do conteúdo do formulário-->
