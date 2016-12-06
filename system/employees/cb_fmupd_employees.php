<h1 id="title">Registro de Colaborador</h1>
<div id="register"><!--Início do conteúdo do formulário-->
    <h3>Alterar Colaborador</h3>
    <hr />
<?php
    $g_id = $_GET['id'];
    //Esta linha é responsável por receber o id da fmins via GET.
    //Este bloco é responsável por fazer a seleção dos colaboradores que tenham o id igual ao recebido.
    $sql_sel_employees = "SELECT employees.id, employees.users_id, name, email, phone, birthdate, username FROM employees INNER JOIN users ON employees.users_id=users.id WHERE employees.id='".$g_id."'";
    $sql_sel_employees_preparado = $conexaobd->prepare($sql_sel_employees);
    $sql_sel_employees_preparado->execute();
    $sql_sel_employees_dados = $sql_sel_employees_preparado->fetch();
    $explode_nascimento = explode("-", $sql_sel_employees_dados['birthdate']);
?>
    <form name="frmregemployee" method="POST" action="?folder=employees/&file=cb_upd_employees&ext=php">
        <input type="hidden" name="hidid" value="<?php echo $sql_sel_employees_dados['id']; ?>">
        <input type="hidden" name="hidusersid" value="<?php echo $sql_sel_employees_dados['users_id']; ?>">
        <table>
            <tr>
                <td>Nome Completo:</td>
                <td><input type="text" name="txtnome" placeholder="Ex.: João Silva" maxlength="45" value="<?php echo $sql_sel_employees_dados['name'] ?>"></td>
            </tr>
            <tr>
                <td>E-mail:</td>
                <td><input type="text" name="txtemail" placeholder="Ex.: joao_silva@gmail.com" maxlength="70" value="<?php echo $sql_sel_employees_dados['email'] ?>"></td>
            </tr>
            <tr>
                <td>Telefone:</td>
                <td><input type="text" name="txttelefone" placeholder="Ex.: 11 989302103" maxlength="15" value="<?php echo $sql_sel_employees_dados['phone'] ?>"></td>
            </tr>
            <tr>
                <td>Data de Nascimento:</td>
                <td><input type="text" readonly class="datepicker" name="txtnascimento" placeholder="DD/MM/AAAA" maxlength="10" value="<?php echo $explode_nascimento[2]."/".$explode_nascimento[1]."/".$explode_nascimento[0]?>"></td>
            </tr>
            <tr>
                <td>Nome de Usuário:</td>
                <td><input type="text" name="txtusuario" placeholder="Ex.:João12" maxlength="20"value="<?php echo $sql_sel_employees_dados['username'] ?>"></td>
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

