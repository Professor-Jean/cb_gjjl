<h1 id="title">Registro de Bairro</h1>
<div id="register"><!--Início do conteúdo do formulário-->
    <h3>Alterar Bairro</h3>
    <hr />
    <?php
        $g_id = $_GET['id'];
        //Esta linha é responsável por receber o id da fmins via GET.
        //Este bloco é responsável por fazer a seleção dos bairros que tenham o id igual ao recebido.
        $sql_sel_districts = "SELECT * FROM districts WHERE id='".$g_id."'";
        $sql_sel_districts_preparado = $conexaobd->prepare($sql_sel_districts);
        $sql_sel_districts_preparado->execute();
        $sql_sel_districts_dados = $sql_sel_districts_preparado->fetch();
    ?>
    <form name="frmregbairros" method="POST" action="?folder=districts/&file=cb_upd_districts&ext=php">
        <input type="hidden" name="hidid" value="<?php echo $sql_sel_districts_dados['id']; ?>">
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

                                if($valor_cidade == $sql_sel_districts_dados['cities_id']){
                                    echo "<option value='".$valor_cidade."' selected>".$nome_cidade."</option>";
                                }else {
                                    echo "<option value='" . $valor_cidade . "'>" . $nome_cidade . "</option>";
                                }
                            }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Bairro:</td>
                <td><input type="text" name="txtbairro" placeholder="Ex.: Aventureiro" maxlength="25" value="<?php echo $sql_sel_districts_dados['name']; ?>"></td>
            </tr>
            <tr>
                <td><button type="reset" name="btnlimpar">Limpar</button></td>
                <td><button type="submit" name="btnenviar">Enviar</button></td>
            </tr>
        </table>
    </form>
</div><!--Fim do conteúdo do formulário-->