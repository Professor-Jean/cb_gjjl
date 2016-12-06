<h1 id="title">Registro de Bairro</h1>
<div id="register"><!--Início do conteúdo do formulário-->
    <h3>Cadastrar Bairro</h3>
    <hr />
    <form name="frmregbairros" method="POST" action="?folder=districts/&file=cb_ins_districts&ext=php">
        <table>
            <tr>
                <td>Cidade:</td>
                <td>
                    <?php
                    //Este bloco é responsável por fazer a seleção de todos os dados da tabela cities (cidades).
                    $sql_sel_cities = "SELECT * FROM cities ORDER BY name";
                    $sql_sel_cities_preparado = $conexaobd->prepare($sql_sel_cities);
                    $sql_sel_cities_preparado->execute();
                    ?>
                    <select name="selcidade">
                        <option value="">Escolha...</option>
                        <?php
                        //Este bloco é responsável por exibir os dados contidos na tabela cities em options que apareceram para o usuário.
                        while($sql_sel_cities_dados = $sql_sel_cities_preparado->fetch()){
                            $valor_cidade = $sql_sel_cities_dados['id'];
                            $nome_cidade = $sql_sel_cities_dados['name'];

                            echo "<option value='".$valor_cidade."'>".$nome_cidade."</option>";
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Bairro:</td>
                <td><input type="text" name="txtbairro" placeholder="Ex.: Aventureiro" maxlength="25"></td>
            </tr>
            <tr>
                <td><button type="reset" name="btnlimpar">Limpar</button></td>
                <td><button type="submit" name="btnenviar">Enviar</button></td>
            </tr>
        </table>
    </form>
</div><!--Fim do conteúdo do formulário-->
<div id="consult"><!--Início da consulta-->
    <h2>Bairros Registrados</h2>
    <div align="center"><!--Início do centro-->
        <div align="right" class="search"><!--Início da pesquisa-->
            <form name="frmpesquisa" method="POST" action="">
                <input type="text" name="txtpesquisa" placeholder="Pesquisar" maxlength="70">
                <button type="submit" name="btnpesquisar"><img src="../layout/images/search.png"></button>
            </form>
        </div><!--Fim da pesquisa-->
        <?php
            $pesquisa = "";
            //Esta linha representa a atribuição de vazio para a variável pesquisa.
            //Este bloco é responsável por verificar se a variável post do campo txtpesquisa existe. Se ela existir verifica se ela é diferente de vazio. Se ela for diferente de vazio atribui ela a variável $p_pesquisa. Atribui a variável pesquisa a sintaxe de pesquisa do banco.
            if(isset($_POST['txtpesquisa'])){
                if($_POST['txtpesquisa']!=""){
                    $p_pesquisa = $_POST['txtpesquisa'];
                    $pesquisa = "WHERE cities.name LIKE '%".$p_pesquisa."%' OR districts.name LIKE '%".$p_pesquisa."%'";
                }
            }
            //Este bloco é responsável por fazer a seleção dos dados id, nome do bairro, nome da cidade da tabela districts juntando com a tabela cities. E executa a pesquisa se houver.
            $sql_sel_districts = "SELECT districts.id, districts.name, cities.name AS citiesname FROM districts INNER JOIN cities ON districts.cities_id=cities.id ".$pesquisa." ORDER BY citiesname, name";
            $sql_sel_districts_preparado = $conexaobd->prepare($sql_sel_districts);
            $sql_sel_districts_preparado->execute();
        ?>
    </div>
    <table class="consult_table"><!--Início da tabela de consulta-->
        <thead><!--Início do cabeçalho da tabela-->
        <tr>
            <th width="45%">Cidade</th>
            <th width="45%">Bairro</th>
            <th width="5%">Editar</th>
            <th width="5%">Excluir</th>
        </tr>
        </thead><!--Fim do cabeçalho da tabela-->
        <tbody><!--Início do corpo da tabela-->
        <?php
        //Este bloco é responsável por exibir os dados contidos na tabela districts.
        if($sql_sel_districts_preparado->rowCount()>0){
            while($sql_sel_districts_dados = $sql_sel_districts_preparado->fetch()) {
                ?>
                <tr>
                    <td><?php echo $sql_sel_districts_dados['citiesname']; ?></td>
                    <td><?php echo $sql_sel_districts_dados['name']; ?></td>
                    <td align="center"><a href="?folder=districts/&file=cb_fmupd_districts&ext=php&id=<?php echo $sql_sel_districts_dados['id']; ?>"><img src="../layout/images/edit.png" width="25px"></a></td>
                    <td align="center"><?php echo safedelete($sql_sel_districts_dados['id'], "", '?folder=districts/&file=cb_del_districts&ext=php', 'o bairro', $sql_sel_districts_dados['name']) ?></td>
                </tr>
                <?php
            }
        }else {
            ?>
            <tr>
                <td align="center" colspan="6"><?php echo mensagens('Vazio', 'bairros'); ?></td>
            </tr>
            <?php
        }
        ?>
        </tbody><!--Fim do corpo da tabela-->
    </table><!--Fim da tabela de consulta-->
</div><!--Fim da consulta-->