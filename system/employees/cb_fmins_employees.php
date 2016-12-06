<h1 id="title">Registro de Colaborador</h1>
<div id="register"><!--Início do conteúdo do formulário-->
    <h3>Cadastrar Colaborador</h3>
    <hr />
    <form name="frmregemployee" method="POST" action="?folder=employees/&file=cb_ins_employees&ext=php">
        <table>
            <tr>
                <td>Nome Completo:</td>
                <td><input type="text" name="txtnome" placeholder="Ex.: João Silva" maxlength="45" ></td>
            </tr>
            <tr>
                <td>E-mail:</td>
                <td><input type="text" name="txtemail" placeholder="Ex.: joao_silva@gmail.com" maxlength="70"></td>
            </tr>
            <tr>
                <td>Telefone:</td>
                <td><input type="text" name="txttelefone" placeholder="Ex.: 11 989302103" maxlength="15"></td>
            </tr>
            <tr>
                <td>Data de Nascimento:</td>
                <td><input type="text" readonly class="datepicker" name="txtnascimento" placeholder="DD/MM/AAAA" maxlength="10"></td>
            </tr>
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
    <h2>Colaboradores Registrados</h2>
    <?php
    $sql_sel_employees = "SELECT employees.id, name, email, username, users_id FROM employees INNER JOIN users ON users.id=employees.users_id WHERE permission='1'";
    $sql_sel_employees_preparado = $conexaobd->prepare($sql_sel_employees);
    $sql_sel_employees_preparado->execute();
    ?>

    <table class="consult_table"><!--Início da tabela de consulta-->
        <thead><!--Início do cabeçalho da tabela-->
        <tr>
            <th width="25%">Nome Completo</th>
            <th width="35%">E-mail</th>
            <th width="20%">Usuário</th>
            <th width="10%">Editar</th>
            <th width="10%">Excluir</th>
        </tr>
        </thead><!--Fim do cabeçalho da tabela-->
        <tbody><!--Início do corpo da tabela-->
        <?php
        if($sql_sel_employees_preparado->rowCount()>0) {
            while ($sql_sel_employees_dados = $sql_sel_employees_preparado->fetch()) {
                ?>
                <tr>
                    <td><?php echo $sql_sel_employees_dados['name']; ?></td>
                    <td><?php echo $sql_sel_employees_dados['email']; ?></td>
                    <td><?php echo $sql_sel_employees_dados['username']; ?></td>
                    <td align="center"><a href="?folder=employees/&file=cb_fmupd_employees&ext=php&id=<?php echo $sql_sel_employees_dados['id']; ?>"><img src="../layout/images/edit.png" width="25px"></a></td>
                    <td align="center"><?php echo safedelete($sql_sel_employees_dados['id'], $sql_sel_employees_dados['users_id'], '?folder=employees/&file=cb_del_employees&ext=php', 'o colaborador', $sql_sel_employees_dados['name']) ?></td>
                </tr>
                <?php
            }
        }else{
            ?>
            <td align="center" colspan="5"><?php echo mensagens('Vazio', 'colaboradores') ?></td>
            <?php
        }
        ?>
        </tbody><!--Fim do corpo da tabela-->
    </table><!--Fim da tabela de consulta-->
</div><!--Fim da consulta-->