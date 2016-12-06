<h1 id="title">Registro de Orçamento de Evento</h1>
<div class="cupdate"><div id="calendar"></div></div>
<div id="register" class="update"><!--Início do conteúdo do formulário-->
    <h3>Alterar Orçamento de Evento</h3>
    <hr />
    <?php
    $g_id = $_GET['id'];
    //Esta linha é responsável por receber o id da fmins via GET.
    //Este bloco é responsável por fazer a seleção dos eventos que tenham o id igual ao recebido.
    $sql_sel_events = "SELECT * FROM events WHERE id='".$g_id."'";
    $sql_sel_events_preparado = $conexaobd->prepare($sql_sel_events);
    $sql_sel_events_preparado->execute();
    $sql_sel_events_dados = $sql_sel_events_preparado->fetch();
    $data = explode("-", $sql_sel_events_dados['event_date']);
    $datab = $data[2]."/".$data[1]."/".$data[0];
    //Data no padrão do banco.

    //Este bloco é responsável por fazer a seleção do valor real dos kits... Onde o id do evento for igual ao id recebido por get.
    $sql_sel_events_has_kits = "SELECT SUM(kit_quantity*actual_value) AS realvalue FROM events_has_kits WHERE events_id='".$g_id."'";
    $sql_sel_events_has_kits_preparado = $conexaobd->prepare($sql_sel_events_has_kits);
    $sql_sel_events_has_kits_preparado->execute();
    $sql_sel_events_has_kits_dados = $sql_sel_events_has_kits_preparado->fetch();

    //Este bloco é responsável por fazer a seleção do valor real dos itens... Onde o id do evento for igual ao id recebido por get.
    $sql_sel_events_has_items = "SELECT SUM(item_quantity*actual_value) AS realvalue FROM events_has_items WHERE events_id='".$g_id."'";
    $sql_sel_events_has_items_preparado = $conexaobd->prepare($sql_sel_events_has_items);
    $sql_sel_events_has_items_preparado->execute();
    $sql_sel_events_has_items_dados = $sql_sel_events_has_items_preparado->fetch();

    $valor_real = $sql_sel_events_has_kits_dados['realvalue'] + $sql_sel_events_has_items_dados['realvalue'] + $sql_sel_events_dados['delivery_fee'] + $sql_sel_events_dados['rent_value'];
    //Calcula o valor real.
    $valor_reale = explode('.', $valor_real);
    if(count($valor_reale)==1){
        $valor_real = $valor_reale[0].','.'00';
    }else{
        if(strlen($valor_reale[1])==1){
            $valor_real .= '0';
        }else{
            $valor_real = $valor_reale[0].','.$valor_reale[1];
        }
    }

    $valor_final = $valor_real - $sql_sel_events_dados['discount'];
    $valor_finale = explode('.', $valor_final);
    if(count($valor_finale)==1){
        $valor_final = $valor_finale[0].','.'00';
    }else{
        if(strlen($valor_finale[1])==1){
            $valor_final .= '0';
        }else {
            $valor_final = $valor_finale[0].'.'.$valor_finale[1];
        }
    }
    $valor_real = str_replace('.',',', $valor_real);
    $valor_final = str_replace('.',',', $valor_final);
    //Calcula o valor final.
    ?>
    <form name="frmregeventos" method="POST" action="?folder=events/&file=cb_upd_events&ext=php">
        <h4 style="text-align: center; color: #700;">Campos Não Obrigatórios *</h4>
        <h4 style="text-align: center; color: #700;">Caso mudar os kits, os itens ou o local, favor gerar o valor real, colocar a taxa de entrega e o desconto novamente!</h4>
        <input type="hidden" name="hidid" value="<?php echo $sql_sel_events_dados['id']; ?>">
        <table>
            <tr>
                <td>Cliente:</td>
                <?php
                    //Este bloco é responsável por fazer a seleção do id e nome da tabela clients (clientes).
                    $sql_sel_clients = "SELECT id, name FROM clients WHERE id='".$sql_sel_events_dados['clients_id']."'";
                    $sql_sel_clients_preparado = $conexaobd->prepare($sql_sel_clients);
                    $sql_sel_clients_preparado->execute();
                    $sql_sel_clients_dados = $sql_sel_clients_preparado->fetch();
                ?>
                <td colspan="3"><input type="text" name="txtcliente" placeholder="Ex.: João da Silva" maxlength="6" style="width: 485px;" value="<?php echo $sql_sel_clients_dados['name']; ?>" readonly><input type="hidden" name="hididcliente" value="<?php echo $sql_sel_clients_dados['id']; ?>"></td>
            </tr>
            <tr>
                <td colspan="2">Kits:</td>
                <td colspan="2">Quantidade: <a href="#" title="Adicionar item" class="adicionarCampo"><img width="25px" heigth="25px" src="../layout/images/plus.png" border="0"/></a>
                </td>
            </tr>
            <?php
                //Este bloco é responsável por fazer a seleção do id do kit, quantidade do kit da tabela events_has_kits, juntando com a tabela events, juntando com a tabela kits... Onde o id do evento for igual a variável recebida por get, agrupando por id dos eventos e kits.
                $sql_sel_events_has_kits = "SELECT events_has_kits.kits_id AS events_has_kitskits_id, events_has_kits.kit_quantity AS events_has_kitskit_quantity FROM events_has_kits INNER JOIN events ON events_has_kits.events_id = events.id INNER JOIN kits ON events_has_kits.kits_id = kits.id WHERE events.id = '".$g_id."' GROUP BY events.id, events_has_kits.kits_id";
                $sql_sel_events_has_kits_preparado = $conexaobd->prepare($sql_sel_events_has_kits);
                $sql_sel_events_has_kits_preparado->execute();

                //Este bloco é responsável por exibir os dados contidos na tabela events_has_kits em options que apareceram para o usuário.
                while($sql_sel_events_has_kits_dados = $sql_sel_events_has_kits_preparado->fetch()){
                    //Este bloco é responsável por fazer a seleção do id e do nome da tabela kits.
                    $sql_sel_kits = "SELECT id, name FROM kits";
                    $sql_sel_kits_preparado = $conexaobd->prepare($sql_sel_kits);
                    $sql_sel_kits_preparado->execute();
            ?>
            <tr class="linhas">

                <td colspan="2">
                    <select name="selkits[]" class='kits' style="width: 250px;" onchange="achaprecoek(this.value)">
                        <option value="">Escolha...</option>
            <?php
                    //Este bloco é responsável por exibir os dados contidos na tabela kits em options que apareceram para o usuário.
                    while($sql_sel_kits_dados = $sql_sel_kits_preparado->fetch()){
                        $valor_kits = $sql_sel_kits_dados['id'];
                        $nome_kits = $sql_sel_kits_dados['name'];

                        if($valor_kits == $sql_sel_events_has_kits_dados['events_has_kitskits_id']) {
                            echo "<option value='" . $valor_kits . "' selected>" . $nome_kits . "</option>";
                        }else{
                            echo "<option value='" . $valor_kits . "'>" . $nome_kits . "</option>";
                        }
                    }
            ?>
                    </select>
                </td>
                <td colspan="2"><input type="text" name="txtquantidadekits[]" class='quantidadekits' maxlength="4" placeholder="Ex.:2" style="width: 250px;" value="<?php echo $sql_sel_events_has_kits_dados['events_has_kitskit_quantity']; ?>"><a href="#" title="Remover Item" class="removerCampo"><img width="25px" heigth="25px" src="../layout/images/less.png" border="0"/></a></td>
            </tr>
            <?php
                }
            ?>
            <tr>
                <td colspan="2">Itens:</td>
                <td colspan="2">Quantidade: <a href="#" title="Adicionar item" class="adicionarCampo1"><img width="25px" heigth="25px" src="../layout/images/plus.png" border="0"/></a>
                </td>
            </tr>
            <?php
                //Este bloco é responsável por fazer a selecção do id e da quantidade do item na tabela events_has_items, juntando com a tabela events... Onde o id do evento for igual a variável recebida por get.
                $sql_sel_events_has_items = "SELECT events_has_items.items_id AS events_has_itemsitems_id, events_has_items.item_quantity AS evetns_has_itemsitem_quantity FROM events_has_items INNER JOIN events ON events.id=events_has_items.events_id INNER JOIN items ON events_has_items.items_id=items.id WHERE events.id='".$g_id."' GROUP BY events.id, items.id";
                $sql_sel_events_has_items_preparado = $conexaobd->prepare($sql_sel_events_has_items);
                $sql_sel_events_has_items_preparado->execute();


                if($sql_sel_events_has_items_preparado->rowCount()==0){
                    ?>
                    <tr class="linhas1">
                        <td colspan="2">
                            <?php
                            //Este bloco é responsável por fazer a seleção do id e o nome da tabela items (itens).
                            $sql_sel_items = "SELECT id, name FROM items";
                            $sql_sel_items_preparado = $conexaobd->prepare($sql_sel_items);
                            $sql_sel_items_preparado->execute();
                            ?>
                            <select name="selitens[]" class='itens' style="width: 250px;" onchange="achaprecoei(this.value)">
                                <option value="">Escolha...</option>
                                <?php
                                //Este bloco é responsável por exibir os dados contidos na tabela items em options que aparecerão para o usuário.
                                while($sql_sel_items_dados = $sql_sel_items_preparado->fetch()){
                                    $valor_itens = $sql_sel_items_dados['id'];
                                    $nome_itens = $sql_sel_items_dados['name'];

                                    echo "<option value='".$valor_itens."'>".$nome_itens."</option>";
                                }
                                ?>
                            </select>
                        </td>
                        <td colspan="2"><input type="text" name="txtquantidadeitens[]" class='quantidadeitens' maxlength="4" placeholder="Ex.:2" style="width: 250px;"><a href="#" title="Remover Item" class="removerCampo1"><img width="25px" heigth="25px" src="../layout/images/less.png" border="0"/></a></td>
                    </tr>
                    <?php
                }else{
                //Este bloco é responsável por exibir os dados contidos na tabela events_has_items em options que apareceram para o usuário.
                    while($sql_sel_events_has_items_dados = $sql_sel_events_has_items_preparado->fetch()) {
                        //Este bloco é responsável por fazer a seleção do id e do nome dos items (itens).
                        $sql_sel_items = "SELECT id, name FROM items";
                        $sql_sel_items_preparado = $conexaobd->prepare($sql_sel_items);
                        $sql_sel_items_preparado->execute();
            ?>
            <tr class="linhas1">
                    <td colspan="2">
                        <select name="selitens[]" class='itens' style="width: 250px;" onchange="achaprecoei(this.value)">
                            <option value="">Escolha...</option>
            <?php
                        //Este bloco é responsável por exibir os dados contidos na tabela items em options que apareceram para o usuário.
                        while ($sql_sel_items_dados = $sql_sel_items_preparado->fetch()) {
                            $valor_itens = $sql_sel_items_dados['id'];
                            $nome_itens = $sql_sel_items_dados['name'];

                            if($valor_itens == $sql_sel_events_has_items_dados['events_has_itemsitems_id']){
                                echo "<option value='" . $valor_itens . "' selected>" . $nome_itens . "</option>";
                            }else {
                                echo "<option value='" . $valor_itens . "'>" . $nome_itens . "</option>";
                            }
                        }
            ?>
                        </select>
                    </td>
                    <td colspan="2"><input type="text" name="txtquantidadeitens[]" class='quantidadeitens' maxlength="4" placeholder="Ex.:2" style="width: 250px;" value="<?php echo $sql_sel_events_has_items_dados['evetns_has_itemsitem_quantity']; ?>"><a href="#" title="Remover Item" class="removerCampo1"><img width="25px" heigth="25px" src="../layout/images/less.png" border="0"/></a></td>
            </tr>
            <?php
                    }
                }
            ?>
            <tr>
                <td colspan="4"><button type="button" name="btncalculare" id="valor_real_calc" style="width: 650px;">Calcular Valor Real</button></td>
            </tr>
            <tr>
                <td>Local:</td>
                <td>
                    <?php
                        //Este bloco é responsável por fazer a seleção do id e do nome da tabela locals (locais);
                        $sql_sel_locals = "SELECT id, name FROM locals";
                        $sql_sel_locals_preparado = $conexaobd->prepare($sql_sel_locals);
                        $sql_sel_locals_preparado->execute();
                    ?>
                    <select name="sellocal" id="local">
                        <option value="">Escolha...</option>
                        <?php
                            //Este bloco é responsável por exibir os dados contidos na tabela locals em options que apareceram para o usuário.
                            while($sql_sel_locals_dados = $sql_sel_locals_preparado->fetch()) {
                                $valor_local = $sql_sel_locals_dados['id'];
                                $nome_local = $sql_sel_locals_dados['name'];

                                if ($sql_sel_events_dados['local'] == 0) {
                                    if($valor_local == $sql_sel_events_dados['locals_id']) {
                                        echo "<option value='" . $valor_local . "' selected>" . $nome_local . "</option>";
                                    }
                                    } else{
                                        echo "<option value='" . $valor_local . "'>" . $nome_local . "</option>";
                                    }
                            }

                        if ($sql_sel_events_dados['local'] == 1) {
                            echo "<option value='cliente' selected>Local do Cliente</option>";
                        } else{
                        ?>
                            <option value='cliente'>Local do Cliente</option>;
                        <?php
                        }
                        if ($sql_sel_events_dados['local'] == 2) {
                            echo "<option value='outro' selected>Outro Local</option>";
                        }else{
                        ?>
                            <option value='outro'>Local Externo</option>
                        <?php
                        }

                        ?>
                    </select>
                </td>
                <input type="hidden" name="hidlocal" value="<?php echo $sql_sel_events_dados['rent_value']; ?>">
                <td>CEP:</td>
                <td><input type="text" name="txtcep" placeholder="Ex.: 86559557" maxlength="8" value="<?php echo $sql_sel_events_dados['cep'] ?>" class="inativou"></td>
            </tr>
            <tr>
                <td>Cidade:</td>
                <td>
                    <?php
                        $sql_sel_cities = "SELECT * FROM cities ORDER BY name";
                        $sql_sel_cities_preparado = $conexaobd->prepare($sql_sel_cities);
                        $sql_sel_cities_preparado->execute();

                        $sql_sel_citiesw = "SELECT cities.name AS citiesname, districts.cities_id AS citiesid FROM cities INNER JOIN districts ON cities.id=districts.cities_id WHERE districts.id='".$sql_sel_events_dados['districts_id']."' GROUP BY cities.id";
                        $sql_sel_citiesw_preparado = $conexaobd->prepare($sql_sel_citiesw);
                        $sql_sel_citiesw_preparado->execute();
                        $sql_sel_citiesw_dados = $sql_sel_citiesw_preparado->fetch();
                    ?>
                    <select name="selcidade" onChange="mostraBairro()">
                        <option value="">Escolha...</option>
                        <?php
                            //Este bloco é responsável por exibir os dados contidos na tabela cities em options que apareceram para o usuário.
                            while($sql_sel_cities_dados = $sql_sel_cities_preparado->fetch()){
                                $valor_cidade = $sql_sel_cities_dados['id'];
                                $nome_cidade = $sql_sel_cities_dados['name'];

                                if($valor_cidade == $sql_sel_citiesw_dados['citiesid']){
                                    echo "<option value='".$sql_sel_citiesw_dados['citiesid']."' selected>".$sql_sel_citiesw_dados['citiesname']."</option>";
                                }else{
                                    echo "<option value='".$valor_cidade."'>".$nome_cidade."</option>";
                                }

                            }
                        ?>
                    </select>
                </td>
                <td>Bairro:</td>
                <td>
                    <?php
                        //Este bloco é responsável por fazer a seleção de todos os dados da tabela districts (bairros).
                        $sql_sel_districts = "SELECT * FROM districts ORDER BY name";
                        $sql_sel_districts_preparado = $conexaobd->prepare($sql_sel_districts);
                        $sql_sel_districts_preparado->execute();
                    ?>
                    <select name="selbairro">
                        <option value="">Selecione uma cidade...</option>
                        <?php
                        //Este bloco é responsável por exibir os dados contidos na tabela districts em options que apareceram para o usuário.
                        while($sql_sel_districts_dados = $sql_sel_districts_preparado->fetch()){
                            $valor_bairro = $sql_sel_districts_dados['id'];
                            $nome_bairro = $sql_sel_districts_dados['name'];

                            if($valor_bairro == $sql_sel_events_dados['districts_id']){
                                //Se à variável valor_dates for igual a dates_id da tabela availabletickets, mostre a mesagem
                                echo "<option value='".$valor_bairro."' selected>".$nome_bairro."</option>";
                            }
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Logradouro:</td>
                <td><input type="text" name="txtlogradouro" placeholder="Ex.: Rua Pica-Pau" maxlength="40" value="<?php echo $sql_sel_events_dados['street']; ?>" class="inativou"></td>
                <td>Número:</td>
                <td><input type="text" name="txtnumero" placeholder="Ex.: 158" maxlength="5" value="<?php echo $sql_sel_events_dados['number']; ?>" class="inativou"></td>
            </tr>
            <tr>
                <td>Complemento: *</td>
                <td colspan="3"><input type="text" name="txtcomplemento" placeholder="Ex.: casa" maxlength="20" style="width: 485px;" value="<?php echo $sql_sel_events_dados['complement']; ?>" class="inativou"></td>
            </tr>
            <tr>
                <td>Data do Evento:</td>
                <td colspan="3"><input id="data" type="text" name="txtdata_evento" placeholder="Ex.: DD/MM/AAAA" maxlength="10" style="width: 460px;" value="<?php echo $datab; ?>"><img id="calendario" src="../layout/images/edit.png" width="25px" style="cursor: pointer;"></td>
            </tr>
            <tr>
                <td>Horário:</td>
                <td colspan="3"><input type="text" name="txthorario" placeholder="Ex.: HH:MM" maxlength="5" style="width: 485px;" value="<?php echo $sql_sel_events_dados['event_time'];?>"></td>
            </tr>
            <tr>
                <td>Taxa de Entrega:</td>
                <td colspan="3"><input type="text" name="txttaxa_entrega" class="taxa_entrega" placeholder="Ex.: 15" maxlength="6" style="width: 485px;" value="<?php echo number_format($sql_sel_events_dados['delivery_fee'],2,',','.');?>"></td>
            </tr>
            <tr>
                <td>Valor Real:</td>
                <td><input type="text" name="txtvalor_real" class="valor_real" placeholder="Ex.: 1500" maxlength="10" value="<?php echo $valor_real;?>" readonly></td>
                <td>Desconto:</td>
                <td><input type="text" name="txtdesconto"  class="descontoe" placeholder="Ex.: 50" maxlength="10" value="<?php echo number_format($sql_sel_events_dados['discount'],2,',','.'); ?>"></td>
            </tr>
            <tr>
                <td>Valor Final:</td>
                <td colspan="3"><input type="text" name="txtvalor_final" class="valor_final" placeholder="Ex.: 1450" maxlength="10" style="width: 485px;" value="<?php echo $valor_final; ?>" readonly></td>
            </tr>
            <tr>
                <td>Observação: *</td>
                <td colspan="3"><textarea name="txtobservacao" maxlength="255" style="width: 485px; max-width: 485px;"><?php echo $sql_sel_events_dados['observation']; ?></textarea></td>
            </tr>
            <tr>
                <td colspan="1" align="left"><button type="reset" name="btnreset">Limpar</button></td>
                <td colspan="3" align="right"><button type="submit" name="btnsubmit">Enviar</button></td>
            </tr>
        </table>
    </form>
</div><!--Fim do conteúdo do formulário-->