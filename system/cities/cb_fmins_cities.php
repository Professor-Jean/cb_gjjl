<h1 id="title">Registro de Cidade</h1>
<div id="register"><!--Início do conteúdo do formulário-->
    <h3>Cadastrar Cidade</h3>
    <hr />
    <form name="frmregcidades" method="POST" action="?folder=cities/&file=cb_ins_cities&ext=php">
        <table>
            <tr>
                <td>Nome:</td>
                <td><input type="text" name="txtnome" placeholder="Ex.: Joinville" maxlength="30"></td>
            </tr>
            <tr>
                <td><button type="reset" name="btnlimpar">Limpar</button></td>
                <td><button type="submit" name="btnenviar">Enviar</button></td>
            </tr>
        </table>
    </form>
</div><!--Fim do conteúdo do formulário-->
<div id="consult"><!--Início da consulta-->
    <h2>Cidades Registradas</h2>
    <?php
        //Este bloco é responsável por fazer a seleção de todos os dados da tabela cities (cidade).
        $sql_sel_cities = "SELECT * FROM cities";
        $sql_sel_cities_preparado = $conexaobd->prepare($sql_sel_cities);
        $sql_sel_cities_preparado->execute();
    ?>
    <table class="consult_table"><!--Início da tabela de consulta-->
        <thead><!--Início do cabeçalho da tabela-->
            <tr>
                <th width="80%">Nome</th>
                <th width="10%">Editar</th>
                <th width="10%">Excluir</th>
            </tr>
        </thead><!--Fim do cabeçalho da tabela-->
        <tbody><!--Início do corpo da tabela-->
    <?php
        //Este bloco é responsável por exibir os dados contidos na tabela cities.
        if($sql_sel_cities_preparado->rowCount()>0){
            while($sql_sel_cities_dados = $sql_sel_cities_preparado->fetch()) {
    ?>
                <tr>
                    <td><?php echo $sql_sel_cities_dados['name']; ?></td>
                    <td align="center"><a href="?folder=cities/&file=cb_fmupd_cities&ext=php&id=<?php echo $sql_sel_cities_dados['id']; ?>"><img src="../layout/images/edit.png" width="25px"></a></td>
                    <td align="center"><?php echo safedelete($sql_sel_cities_dados['id'], "", '?folder=cities/&file=cb_del_cities&ext=php', 'a cidade', $sql_sel_cities_dados['name']) ?></td>
                </tr>
    <?php
            }
        }else {
    ?>
            <tr>
                <td align="center" colspan="3"><?php echo mensagens('Vazio', 'cidades') ?></td>
            </tr>
    <?php
        }
    ?>
        </tbody><!--Fim do corpo da tabela-->
    </table><!--Fim da tabela de consulta-->
</div><!--Fim da consulta-->