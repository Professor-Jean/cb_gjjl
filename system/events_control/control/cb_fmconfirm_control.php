<h1 id="title">Confirmação de Evento</h1>
<div id="register"><!--Início do conteúdo do formulário-->
    <h3>Confirmar Evento</h3>
    <hr />
    <?php
        $g_id = $_GET['id'];

        $sql_sel_events = "SELECT clients.name as cliente, events.local, events.cep, events.discount, cities.name as cidade, districts.name as bairro, events.street, events.number, events.complement, events.event_date, events.event_time, events.entry_fee, events.rent_value, events.delivery_fee, events.observation FROM events INNER JOIN clients ON clients.id=events.clients_id INNER JOIN districts ON districts.id=events.districts_id INNER JOIN cities ON cities.id=districts.cities_id WHERE events.id='".$g_id."'";
        $sql_sel_events_preparado = $conexaobd->prepare($sql_sel_events);
        $sql_sel_events_preparado->execute();
        $sql_sel_events_dados=$sql_sel_events_preparado->fetch();
        if($sql_sel_events_dados['local']=='0'){
            $sql_sel_local = "SELECT name FROM locals INNER JOIN events ON locals.id=events.locals_id WHERE events.id='".$g_id."'";
            $sql_sel_local_preparado = $conexaobd->prepare($sql_sel_local);
            $sql_sel_local_preparado->execute();
            $sql_sel_local_dados = $sql_sel_local_preparado->fetch();
            $local=$sql_sel_local_dados['name'];
        }else if($sql_sel_events_dados['local']=='1'){
                $local = "Local do Cliente";
            }else if($sql_sel_events_dados['local']=='2'){
                    $local = "Local Externo";
                }
        if(!isset($sql_sel_events_dados['complement'])) {
            $sql_sel_events_dados['complement'] = "Não há complemento.";
        }
        $data = explode("-", $sql_sel_events_dados['event_date']);
        $desconto = explode(".", $sql_sel_events_dados['discount']);
        $sql_sel_events_dados['event_time'] = substr($sql_sel_events_dados['event_time'], 0 , -3);
        $taxaentrega = explode(".", $sql_sel_events_dados['delivery_fee']);
        if(!isset($sql_sel_events_dados['observation'])){
            $sql_sel_events_dados['observation'] = "Não há observação.";
        }
        $sql_sel_kits = "SELECT events_has_kits.kit_quantity, kits.name FROM events_has_kits INNER JOIN kits ON events_has_kits.kits_id=kits.id WHERE events_id='".$g_id."'";
        $sql_sel_kits_preparado = $conexaobd->prepare($sql_sel_kits);
        $sql_sel_kits_preparado->execute();
        $sql_sel_itens = "SELECT events_has_items.item_quantity, items.name FROM events_has_items INNER JOIN items ON events_has_items.items_id=items.id WHERE events_id='".$g_id."'";
        $sql_sel_itens_preparado = $conexaobd->prepare($sql_sel_itens);
        $sql_sel_itens_preparado->execute();
        $sql_sel_valoritens = "SELECT SUM((actual_value*item_quantity)) AS valor_itens FROM events_has_items WHERE events_id='".$g_id."' ";
        $sql_sel_valoritens_preparado = $conexaobd->prepare($sql_sel_valoritens);
        $sql_sel_valoritens_preparado->execute();
        $sql_sel_valoritens_dados=$sql_sel_valoritens_preparado->fetch();
        $sql_sel_valorkits = "SELECT SUM((actual_value*kit_quantity)) AS valor_kits FROM events_has_kits WHERE events_id='".$g_id."' ";
        $sql_sel_valorkits_preparado = $conexaobd->prepare($sql_sel_valorkits);
        $sql_sel_valorkits_preparado->execute();
        $sql_sel_valorkits_dados=$sql_sel_valorkits_preparado->fetch();
        $valor_real = $sql_sel_valoritens_dados['valor_itens'] + $sql_sel_valorkits_dados['valor_kits'] +  $sql_sel_events_dados['rent_value'] + $sql_sel_events_dados['delivery_fee'];
        $valor_final = $valor_real - $sql_sel_events_dados['discount'];
        $explode_real = explode(".", $valor_real);
        if(!isset($explode_valor['1'])){
            $explode_real['1']="00";
        }
        $explode_final = explode(".", $valor_final);
        if(!isset($explode_final['1'])){
            $explode_final['1']="00";
        }

    ?>
    <form name="frmconfeventos" method="POST" action="?folder=events_control/control/&file=cb_confirm_control&ext=php">
        <table>
            <tr>
                <td>Código do Evento:</td>
                <td colspan="3"><input type="text" readonly name="txtid" value="<?php echo $g_id ?>" style="width: 485px;"></td>
            </tr>
            <tr>
                <td>Cliente:</td>
                <td colspan="3"><input type="text" readonly name="txtcliente" maxlength="45" style="width: 485px;" value="<?php echo $sql_sel_events_dados['cliente']?>"></td>
            </tr>
            <tr>
                <td>Kits(Quantidade):</td>

                <?php
                    if($sql_sel_kits_preparado->rowCount()>0) {
                ?>
                    <td colspan="3" style="width:485px;">
                    <table style="background: #eee; border: 1px solid #ddd;">
                        <?php
                        while ($sql_sel_kits_dados = $sql_sel_kits_preparado->fetch()) {
                            ?>
                            <tr>
                                <td colspan="3" style="width:485px;"><?php echo $sql_sel_kits_dados['name']."(".$sql_sel_kits_dados['kit_quantity'].")"?></td>
                            </tr>
                            <?php
                        }
                        ?>
                    </table>
                    <?php
                        }else{
                    ?>
                            <td colspan="3" ><input readonly value="Não há kits registrados nesse evento." style="width: 485px;"></td>
                    <?php
                        }
                    ?>
                </td>
            </tr>
            <tr>
                <td>Itens(Quantidade):</td>

                <?php
                    if($sql_sel_itens_preparado->rowCount()>0) {
                ?>
                    <td colspan="3" style="width:485px;">
                        <table style="background: #eee; border: 1px solid #ddd;">
                            <?php
                            while ($sql_sel_itens_dados = $sql_sel_itens_preparado->fetch()) {
                                ?>
                                <tr>
                                    <td colspan="3" style="width:485px;"><?php echo $sql_sel_itens_dados['name']."(".$sql_sel_itens_dados['item_quantity'].")"?></td>
                                </tr>
                            <?php
                            }
                            ?>
                        </table>
                        <?php
                    }else{
                        ?>
                        <td colspan="3" ><input readonly value="Não há itens registrados nesse evento." style="width: 485px;"></td>
                        <?php
                    }
                        ?>

                </td>
            </tr>
            <tr>
                <td>Local:</td>
                <td><input type="text" readonly name="txtlocal" value="<?php echo $local ?>"></td>
                <td>CEP:</td>
                <td><input type="text" readonly name="txtcep" maxlength="8" value="<?php echo $sql_sel_events_dados['cep'] ?>"></td>
            </tr>
            <tr>
                <td>Cidade:</td>
                <td><input type="text" readonly name="txtcidade" maxlength="30" value="<?php echo $sql_sel_events_dados['cidade'] ?>"></td>
                <td>Bairro:</td>
                <td><input type="text" readonly name="txtbairro" maxlength="25" value="<?php echo $sql_sel_events_dados['bairro'] ?>"></td>
            </tr>
            <tr>
                <td>Logradouro:</td>
                <td><input type="text" name="txtlogradouro" readonly maxlength="40" value="<?php echo $sql_sel_events_dados['street'] ?>"></td>
                <td>Número:</td>
                <td><input type="text" name="txtnumber" readonly maxlength="5" value="<?php echo $sql_sel_events_dados['number'] ?>"></td>
            </tr>
            <tr>
                <td>Complemento:</td>
                <td colspan="3"><input type="text" readonly name="txtcomplemento" maxlength="20" style="width: 485px;" value="<?php echo $sql_sel_events_dados['complement'] ?>"></td>
            </tr>
            <tr>
                <td>Data do Evento:</td>
                <td colspan="3"><input type="text" name="txtdata_evento" readonly maxlength="10" style="width: 485px;" value="<?php echo $data['2']."/".$data['1']."/".$data['0'] ?>"></td>
            </tr>
            <tr>
                <td>Horário:</td>
                <td colspan="3"><input type="text" name="txthorario" readonly maxlength="5" style="width: 485px;" value="<?php echo $sql_sel_events_dados['event_time'] ?>"></td>
            </tr>
            <tr>
                <td>Taxa de Entrega:</td>
                <td colspan="3"><input type="text" name="txttaxa_entrega" readonly maxlength="6" style="width: 485px;" value="R$ <?php echo $taxaentrega['0'].",".$taxaentrega['1']?>"></td>
            </tr>
            <tr>
                <td>Valor Real:</td>
                <td><input type="text" name="txtvalor_real" readonly maxlength="10" value="R$ <?php echo $explode_real[0].",".$explode_real[1] ?>"></td>
                <td>Desconto:</td>
                <td><input type="text" name="txtdesconto" readonly maxlength="10" value="R$ <?php echo  $desconto[0].",".$desconto[1]?>"></td>
            </tr>
            <tr>
                <td>Valor Final:</td>
                <td colspan="3"><input type="text" name="txtvalor_final" readonly maxlength="45" value="R$ <?php echo $explode_final[0].",".$explode_final[1]?>" style="width: 485px;"></td>
            </tr>
            <tr>
                <td>Entrada:</td>
                <td colspan="3"><input type="text" name="txtentrada" maxlength="7" placeholder="Ex: 20,00" style="width: 485px;"></td>
            </tr>
            <tr>
                <td>Observação:</td>
                <td colspan="3"><input name="txtdescricao" readonly maxlength="255" style="width: 485px;" value="<?php echo $sql_sel_events_dados['observation'] ?>"></td>
            </tr>
            <tr>
                <td colspan="2" align="right"><button type="reset" name="btnreset" >Limpar</button></td>
                <td colspan="2" align="right"><button type="submit" name="btnsubmit">Enviar</button></td>
            </tr>
        </table>
    </form>
</div><!--Fim do conteúdo do formulário-->