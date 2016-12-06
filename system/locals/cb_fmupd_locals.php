<?php

    $g_id = $_GET['id'];

    $sql_sel_locals = "SELECT locals.id, locals.name, locals.area, locals.height, locals.description, locals.cep, locals.street, locals.number, locals.rent_value, locals.complement, locals.districts_id, districts.cities_id, (districts.name) AS bairro_nome, (cities.name) AS cidade_nome FROM locals INNER JOIN districts ON locals.districts_id=districts.id INNER JOIN cities ON districts.cities_id=cities.id WHERE locals.id='".$g_id."'";

    $sql_sel_locals_preparado = $conexaobd->prepare($sql_sel_locals);

    $sql_sel_locals_preparado->execute();

    $sql_sel_locals_dados = $sql_sel_locals_preparado->fetch();

    //

    $valor_a = explode('.', $sql_sel_locals_dados['area']);

    $cont = count($valor_a);

    for($contadora=0; $contadora<$cont; $contadora++){

        $valor_area = 0;

        if($contadora==1){
            $centimetros = $valor_a[$contadora];
        }else{
            $centimetros = '00';
        }

        $valor_area = $valor_a[0].",".$centimetros;

    }

    //

    $valor_al = explode('.', $sql_sel_locals_dados['height']);

    $cont = count($valor_al);

    for($contadora=0; $contadora<$cont; $contadora++){

        $valor_altura = 0;

        if($contadora==1){
            $centimetros = $valor_al[$contadora];
        }else{
            $centimetros = '00';
        }

        $valor_altura = $valor_al[0].",".$centimetros;

    }

    //

    $valor_alg = explode('.', $sql_sel_locals_dados['rent_value']);

    $cont = count($valor_alg);

    for($contadora=0; $contadora<$cont; $contadora++){

        $valor_aluguel = 0;

        if($contadora==1){
            $centavos = $valor_alg[$contadora];
        }else{
            $centavos = '00';
        }

        $valor_aluguel = $valor_alg[0].",".$centavos;

    }


?>
<h1 id="title">Registro de Local para Eventos</h1>
<div id="register"><!--Início do conteúdo do formulário-->
    <h3>Alterar Local para Evento</h3>
    <hr />
    <form name="frmreglocals" method="POST" action="?folder=locals/&file=cb_upd_locals&ext=php">
        <h4 style="text-align: center; color: #700;">Campos Não Obrigatórios *</h4>
        <input type="hidden" name="hidid" value="<?php echo $sql_sel_locals_dados['id']; ?>">
        <table>
            <tr>
                <td>
                    <table>
                        <tr>
                            <td>Nome:</td>
                            <td><input type="text" name="txtnome" value="<?php echo $sql_sel_locals_dados['name']; ?>" placeholder="Ex.: Espaço 1" maxlength="30"></td>
                        </tr>
                        <tr>
                            <td>Área (m²):</td>
                            <td><input type="text" name="txtarea" value="<?php echo $valor_area; ?>" placeholder="Ex.: 10" maxlength="8"></td>
                        </tr>
                        <tr>
                            <td>Altura (m):</td>
                            <td><input type="text" name="txtaltura" value="<?php echo $valor_altura; ?>" placeholder="Ex.: 3" maxlength="5"></td>
                        </tr>
                        <tr rowspan="3">
                            <td>Descrição: *</td>
                            <td><textarea name="txtdescricao" maxlength="255" style="height: 100px;"><?php echo $sql_sel_locals_dados['description']; ?></textarea></td>
                        </tr>
                    </table>
                </td>
                <td>
                    <table>
                        <tr>
                            <td>CEP:</td>
                            <td><input type="text" name="txtcep" value="<?php echo $sql_sel_locals_dados['cep']; ?>" placeholder="Ex.: 89556226" maxlength="8"></td>
                        </tr>
                        <tr>
                            <td>Cidade:</td>
                            <td>
                                <?php
                                //Este bloco é responsável por fazer a seleção de todos os dados da tabela cities (cidades).
                                $sql_sel_cities = "SELECT * FROM cities WHERE id<>'".$sql_sel_locals_dados['cities_id']."' ORDER BY name";
                                $sql_sel_cities_preparado = $conexaobd->prepare($sql_sel_cities);
                                $sql_sel_cities_preparado->execute();
                                ?>
                                <select name="selcidade" onChange="mostraBairro()">
                                    <?php

                                    echo "<option value='".$sql_sel_locals_dados['cities_id']."'>".$sql_sel_locals_dados['cidade_nome']."</option>";

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
                            <td>
                                <?php

                                    $sql_sel_districts = "SELECT * FROM districts WHERE cities_id='".$sql_sel_locals_dados['cities_id']."' AND id<>'".$sql_sel_locals_dados['districts_id']."' ORDER BY name";
                                    $sql_sel_districts_preparado = $conexaobd->prepare($sql_sel_districts);
                                    $sql_sel_districts_preparado->execute();

                                ?>
                                <select name="selbairro">
                                    <?php

                                    echo "<option value='".$sql_sel_locals_dados['districts_id']."'>".$sql_sel_locals_dados['bairro_nome']."</option>";

                                    while($sql_sel_districts_dados = $sql_sel_districts_preparado->fetch()){
                                        $valor_bairro = $sql_sel_districts_dados['id'];
                                        $nome_bairro = $sql_sel_districts_dados['name'];

                                        echo "<option value='".$valor_bairro."'>".$nome_bairro."</option>";
                                    }

                                    ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Logradouro:</td>
                            <td><input type="text" name="txtlogradouro" value="<?php echo $sql_sel_locals_dados['street']; ?>" placeholder="Ex.: Rua Iririú" maxlength="40"></td>
                        </tr>
                        <tr>
                            <td>Número:</td>
                            <td><input type="text" name="txtnumero" value="<?php echo $sql_sel_locals_dados['number']; ?>" placeholder="Ex.: 459" maxlength="5"></td>
                        </tr>
                        <tr>
                            <td>Valor para Aluguel:</td>
                            <td><input type="text" name="txtvalor_aluguel" value="<?php echo $valor_aluguel; ?>" placeholder="Ex.: 100" maxlength="8"></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="2">Complemento: *<input type="text" name="txtcomplemento" value="<?php echo $sql_sel_locals_dados['complement']; ?>" placeholder="Ex.: casa" maxlength="20" style="width:525px;"></td>
            </tr>
            <tr>
                <td align="right"><button type="reset" name="btnreset">Limpar</button></td>
                <td align="right"><button type="submit" name="btnsubmit">Enviar</button></td>
            </tr>
        </table>
    </form>
</div><!--Fim do conteúdo do formulário-->