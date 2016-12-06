<h1 id="title">Registro de Administrador</h1>
<div id="register"><!--Início do conteúdo do formulário-->
    <h3>Cadastrar Administrador</h3>
    <hr />
    <form name="frmreguser" method="POST" action="?folder=users/&file=cb_ins_users&ext=php">
        <table>
            <tr>
                <td>Nome de Usuário:</td>
                <td><input type="text" name="txtusuario" placeholder="Ex.:João12" maxlength="20"></td>
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
<div id="consult"><!--Início da consulta-->
    <h2>Administradores Registrados</h2>
    <?php
        $sql_sel_users = "SELECT id, username FROM users WHERE permission='0'";
        $sql_sel_users_preparado = $conexaobd->prepare($sql_sel_users);
        $sql_sel_users_preparado->execute();
    ?>

    <table class="consult_table"><!--Início da tabela de consulta-->
        <thead><!--Início do cabeçalho da tabela-->
        <tr>
            <th width="70%">Usuário</th>
            <th width="15%">Editar</th>
            <th width="15%">Excluir</th>
        </tr>
        </thead><!--Fim do cabeçalho da tabela-->
        <tbody><!--Início do corpo da tabela-->
        <?php
            if($sql_sel_users_preparado->rowCount()>0) {
                while ($sql_sel_users_dados = $sql_sel_users_preparado->fetch()) {
                    ?>
                    <tr>
                        <td><?php echo $sql_sel_users_dados['username']; ?></td>
                        <td align="center"><a href="?folder=users/&file=cb_fmupd_users&ext=php&id=<?php echo $sql_sel_users_dados['id']; ?>"><img src="../layout/images/edit.png" width="25px"></a></td>
                        <td align="center"><?php echo safedelete($sql_sel_users_dados['id'], "", '?folder=users/&file=cb_del_users&ext=php', 'o usuário', $sql_sel_users_dados['username']) ?></td>
                    </tr>
        <?php
                }
            }else{
        ?>
                <td align="center" colspan="3"><?php echo mensagens('Vazio', 'administradores') ?></td>
        <?php
            }
        ?>
        </tbody><!--Fim do corpo da tabela-->
    </table><!--Fim da tabela de consulta-->
</div><!--Fim da consulta-->