<?php //Evento Orçado=0, Evento confirmado=1, evento realizado=2 ?>
    <div id="consult">
        <h1 id="title">Consulta de Eventos <img src="../layout/images/search.png" class="filter_icon"></h1>
        <div class="filter"><!--Início do filtro-->
            <h3 style="align:left;">Filtrar Eventos</h3>
            <hr />
            <form class="filter_form" name="frmfiltep" method="POST" id="form2" action="?folder=reports/&file=cb_events_reports&ext=php">
                <form class="filter_form" name="frmfiltep" method="POST" id="form" action="?folder=addons/php/&file=cb_eventscharts_php&ext=php">
                    <table>
                        <tr>
                            <td colspan="3"><input type="text" name="txtcliente" placeholder="Cliente" maxlength="45" style="width:200px;"></td>
                            <td>Data:</td>
                            <td><input type="text" readonly class="datepicker" style="width:100px;" name="txtdatai" id="datai" placeholder="De" maxlength="10"></td>
                            <td><input type="text" readonly class="datepicker" style="width:100px;" name="txtdataf" id="dataf" placeholder="Até" maxlength="10"></td>
                        </tr>
                        <tr>
                            <td><input type="text" name="txtemail" placeholder="E-mail" maxlength="45" style="width:200px;"></td>
                            <td colspan="6" align="right">
                                <?php

                                $sql_sel_locals = "SELECT id, name FROM locals ORDER BY name";

                                $sql_sel_locals_preparado = $conexaobd->prepare($sql_sel_locals);

                                $sql_sel_locals_preparado->execute();

                                ?>
                                <select name="sellocal" style="width:258px;">
                                    <option value="">Local</option>
                                    <?php

                                    while($sql_sel_locals_dados = $sql_sel_locals_preparado->fetch()){
                                        $valor_local = $sql_sel_locals_dados['id'];
                                        $nome_local = $sql_sel_locals_dados['name'];

                                        echo "<option value='".$valor_local."'>".$nome_local."</option>";
                                    }
                                    ?>
                                    <option value="cliente">Local do Cliente</option>
                                    <option value="externo">Local Externo</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="6" align="right"><button type="submit" name="btnpesquisar_events_reports">Pesquisar</button></td>
                        </tr>
                    </table>
                </form>
            </form>
        </div><!--Fim do filtro-->
        <?php
        $filtro = "";
        $filtro_ce = "";
        $filtro_data = "";

        if(isset($_POST["txtdatai"])){
            $p_datai = $_POST["txtdatai"];
            $explode_datai = explode("/", $p_datai);
        }
        if(isset($_POST["txtdataf"])) {
            $p_dataf = $_POST["txtdataf"];
            $explode_dataf = explode("/", $p_dataf);
        }
        if((isset($explode_datai[2]))&&(!isset($explode_datai[3]))&&(isset($explode_dataf[2]))&&(!isset($explode_dataf[3]))) {
            $filtro_data .= "AND event_date BETWEEN '".$explode_datai[2]."-".$explode_datai[1]."-".$explode_datai[0]."' AND '".$explode_dataf[2]."-".$explode_dataf[1]."-".$explode_dataf[0]."'";
        }else if((isset($explode_datai[2]))&&(!isset($explode_datai[3]))){
            $filtro_data .= " AND event_date LIKE '".$explode_datai[2]."-".$explode_datai[1]."-".$explode_datai[0]."'";
        }else if((isset($explode_dataf[2]))&&(!isset($explode_dataf[3]))){
            $filtro_data .= "AND event_date LIKE '".$explode_dataf[2]."-".$explode_dataf[1]."-".$explode_dataf[0]."'";
        }

        if(isset($_POST['sellocal'])){
            $p_local =  $_POST['sellocal'];
            if(is_numeric($p_local)){
                $filtro .=" AND locals_id LIKE '".$p_local."'";
                $filtro_ce .="AND canceled_events.locals_id LIKE '".$p_local."'";
            }else if($p_local=="cliente"){
                $filtro .=" AND local='1'";
                $filtro_ce .="AND canceled_events.local='1'";
            }else if($p_local=="externo"){
                $filtro .="AND local='2'";
                $filtro_ce .="AND canceled_events.local='2'";
            }
        }
        if(isset($_POST['txtcliente'])){
            $filtro .= "AND clients.name LIKE '%".$_POST['txtcliente']."%'";
            $filtro_ce .= "AND clients.name LIKE '%".$_POST['txtcliente']."%'";
        }
        if(isset($_POST['txtemail'])){
            $filtro .= "AND clients.email LIKE '%".$_POST['txtemail']."%'";
            $filtro_ce .= "AND clients.email LIKE '%".$_POST['txtemail']."%'";
        }
        ?>
        <div style="margin-top: 75px;">
            <h3>Gráfico Mensal de Realização e Cancelamento de Eventos</h3>
            <div style="width: 94.3%; margin:auto; margin-top: 15px;">
                <canvas id="chart_events" width="100px" height="25px"></canvas>
            </div>
            <div class="legend">
                <table>
                    <tr>
                        <td align="right" width="25%"><div class="label_legend confirmados"></div></td>
                        <td align="left" width="25%">Realizados</td>
                        <td align="right" width="25%"><div class="label_legend cancelados"></div></td>
                        <td align="left" width="25%">Cancelados</td>
                    </tr>
                </table>
            </div>
        </div>
        <div id="accordion" style="width: 90%; margin:auto; margin-top:75px;">
            <?php

            $sql_sel_events_status0 = "SELECT events.*, clients.name, clients.email FROM events INNER JOIN clients ON events.clients_id=clients.id WHERE events.status='0' ".$filtro.$filtro_data." ORDER BY events.event_date";

            $sql_sel_events_status0_preparado = $conexaobd->prepare($sql_sel_events_status0);

            $sql_sel_events_status0_preparado->execute();

            $quantidade_0 = $sql_sel_events_status0_preparado->rowCount();

            if(($quantidade_0==0)||($quantidade_0==1)){
                $altura_tabela_0 = 63;
            }else{
                $altura_tabela_0 = ($quantidade_0 * 31.5) + 31.5;
            }

            ?>
            <h3 align="left">Eventos Orçados(<?php echo $quantidade_0; ?>)</h3>
            <div style="padding:0; margin:0; max-height: <?php echo $altura_tabela_0;?>px">
                <table class="consult_table" style="width:100%; margin:0; padding: 0; max-width: 100%;"><!--Início da tabela de consulta-->
                    <thead><!--Início do cabeçalho da tabela-->
                    <tr>
                        <th width="10%">Data</th>
                        <th width="15%">Local</th>
                        <th width="40%">Cliente</th>
                        <th width="20%">E-mail</th>
                        <th width="15%">Valor Final</th>
                    </tr>
                    </thead><!--Fim do cabeçalho da tabela-->
                    <tbody><!--Início do corpo da tabela-->
                    <?php

                    if($sql_sel_events_status0_preparado->rowCount()>0){

                        while($sql_sel_events_status0_dados = $sql_sel_events_status0_preparado->fetch()){

                            $sql_sel_events_0 = "SELECT events.id, events.rent_value, events.event_date, events.discount, events.delivery_fee, events.locals_id, events.local, clients.name, clients.email, (events_has_items.item_quantity * events_has_items.actual_value) AS soma_item, SUM(events_has_kits.kit_quantity * events_has_kits.actual_value) AS soma_kit, SUM(events_has_kits.kit_quantity * kits.discount) AS desconto_kit FROM events INNER JOIN clients ON events.clients_id=clients.id INNER JOIN events_has_items ON events.id=events_has_items.events_id INNER JOIN events_has_kits ON events.id=events_has_kits.events_id INNER JOIN kits ON events_has_kits.kits_id=kits.id WHERE status='0' AND events.id='".$sql_sel_events_status0_dados['id']."' ".$filtro.$filtro_data;

                            $sql_sel_events_0_preparado = $conexaobd->prepare($sql_sel_events_0);

                            $sql_sel_events_0_preparado->execute();

                            while($sql_sel_events_0_dados = $sql_sel_events_0_preparado->fetch()){

                                $data_0 = explode('-', $sql_sel_events_0_dados['event_date']);

                                $valor_total_0_resultado = ($sql_sel_events_0_dados['soma_item'] + $sql_sel_events_0_dados['soma_kit'] + $sql_sel_events_0_dados['delivery_fee'] + $sql_sel_events_0_dados['rent_value']) - $sql_sel_events_0_dados['discount'];

                                $valor_total_0_explode = explode('.', $valor_total_0_resultado);

                                $cont_0 = count($valor_total_0_explode);

                                for($contadora=0; $contadora<$cont_0; $contadora++){

                                    $valor_total_0 = 0;

                                    if($contadora==1){
                                        if($valor_total_0_explode[$contadora]<10){
                                            $centavos = "".$valor_total_0_explode[$contadora]."0";
                                        }else{
                                            $centavos = $valor_total_0_explode[$contadora];
                                        }
                                    }else{
                                        $centavos = '00';
                                    }

                                    $valor_total_0 = $valor_total_0_explode[0].",".$centavos;

                                }

                                $local_0 = $sql_sel_events_0_dados['local'];

                                if($local_0==1){
                                    $nome_local_0 = "Local do Cliente";
                                }else if($local_0==2){
                                    $nome_local_0 = "Local Externo";
                                }else{

                                    $sql_sel_locals_0 = "SELECT name FROM locals WHERE id='".$sql_sel_events_0_dados['locals_id']."'";

                                    $sql_sel_locals_preparado_0 = $conexaobd->prepare($sql_sel_locals_0);

                                    $sql_sel_locals_preparado_0->execute();

                                    $sql_sel_locals_dados_0 = $sql_sel_locals_preparado_0->fetch();

                                    $nome_local_0 = $sql_sel_locals_dados_0['name'];

                                }

                                ?>
                                <tr>
                                    <td><a name="modal_orcados" class="#modalwindow" href="<?php echo $sql_sel_events_0_dados['id']; ?>"><?php echo $data_0[2]."/".$data_0[1]."/".$data_0[0]; ?></a></td>
                                    <td><a name="modal_orcados" class="#modalwindow" href="<?php echo $sql_sel_events_0_dados['id']; ?>"><?php echo $nome_local_0; ?></a></td>
                                    <td><a name="modal_orcados" class="#modalwindow" href="<?php echo $sql_sel_events_0_dados['id']; ?>"><?php echo $sql_sel_events_0_dados['name']; ?></a></td>
                                    <td><a name="modal_orcados" class="#modalwindow" href="<?php echo $sql_sel_events_0_dados['id']; ?>"><?php echo $sql_sel_events_0_dados['email']; ?></a></td>
                                    <td><a name="modal_orcados" class="#modalwindow" href="<?php echo $sql_sel_events_0_dados['id']; ?>">R$<?php echo $valor_total_0; ?></a></td>
                                </tr>
                                <?php

                            }

                        }

                    }else{
                        ?>
                        <tr>
                            <td colspan="5" align="center">
                                <?php echo mensagens('Vazio', 'Eventos Orçados'); ?>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                    </tbody><!--Fim do corpo da tabela-->
                </table>
            </div>
            <?php

            $sql_sel_events_status1 = "SELECT events.*, clients.name, clients.email FROM events INNER JOIN clients ON events.clients_id=clients.id WHERE events.status='1' ".$filtro.$filtro_data." ORDER BY events.event_date";

            $sql_sel_events_status1_preparado = $conexaobd->prepare($sql_sel_events_status1);

            $sql_sel_events_status1_preparado->execute();

            $quantidade_1 = $sql_sel_events_status1_preparado->rowCount();

            if(($quantidade_1==0)||($quantidade_1==1)){
                $altura_tabela_1 = 63;
            }else{
                $altura_tabela_1 = ($quantidade_1 * 31.5) + 31.5;
            }

            ?>
            <h3 align="left">Eventos Confirmados(<?php echo $quantidade_1; ?>)</h3>
            <div style="padding:0; margin:0; max-height: <?php echo $altura_tabela_1; ?>px;">
                <table class="consult_table" style="width:100%; margin:0; padding: 0; max-width: 100%;"><!--Início da tabela de consulta-->
                    <thead><!--Início do cabeçalho da tabela-->
                    <tr>
                        <th width="10%">Data</th>
                        <th width="15%">Local</th>
                        <th width="40%">Cliente</th>
                        <th width="20%">E-mail</th>
                        <th width="15%">Valor Final</th>
                    </tr>
                    </thead><!--Fim do cabeçalho da tabela-->
                    <tbody><!--Início do corpo da tabela-->
                    <?php

                    if($sql_sel_events_status1_preparado->rowCount()>0){

                        while($sql_sel_events_status1_dados = $sql_sel_events_status1_preparado->fetch()){

                            $sql_sel_events_1 = "SELECT events.id, events.rent_value, events.event_date, events.discount, events.entry_fee, events.delivery_fee, events.locals_id, events.local, clients.name, clients.email, (events_has_items.item_quantity * events_has_items.actual_value) AS soma_item, SUM(events_has_kits.kit_quantity * events_has_kits.actual_value) AS soma_kit, SUM(events_has_kits.kit_quantity * kits.discount) AS desconto_kit FROM events INNER JOIN clients ON events.clients_id=clients.id INNER JOIN events_has_items ON events.id=events_has_items.events_id INNER JOIN events_has_kits ON events.id=events_has_kits.events_id INNER JOIN kits ON events_has_kits.kits_id=kits.id WHERE status='1' AND events.id='".$sql_sel_events_status1_dados['id']."' ".$filtro.$filtro_data;

                            $sql_sel_events_1_preparado = $conexaobd->prepare($sql_sel_events_1);

                            $sql_sel_events_1_preparado->execute();

                            while($sql_sel_events_1_dados = $sql_sel_events_1_preparado->fetch()){

                                $data_1 = explode('-', $sql_sel_events_1_dados['event_date']);

                                $valor_total_1_resultado = ($sql_sel_events_1_dados['soma_item'] + $sql_sel_events_1_dados['soma_kit'] + $sql_sel_events_1_dados['delivery_fee'] + $sql_sel_events_1_dados['rent_value']) - $sql_sel_events_1_dados['discount'];

                                $valor_total_1_explode = explode('.', $valor_total_1_resultado);

                                $cont_1 = count($valor_total_1_explode);

                                for($contadora=0; $contadora<$cont_1; $contadora++){

                                    $valor_total_1 = 0;

                                    if($contadora==1){
                                        if($valor_total_1_explode[$contadora]<10){
                                            $centavos = "".$valor_total_1_explode[$contadora]."0";
                                        }else{
                                            $centavos = $valor_total_1_explode[$contadora];
                                        }
                                    }else{
                                        $centavos = '00';
                                    }

                                    $valor_total_1 = $valor_total_1_explode[0].",".$centavos;

                                }

                                $local_1 = $sql_sel_events_1_dados['local'];

                                if($local_1==1){
                                    $nome_local_1 = "Local do Cliente";
                                }else if($local_1==2){
                                    $nome_local_1 = "Local Externo";
                                }else{

                                    $sql_sel_locals_1 = "SELECT name FROM locals WHERE id='".$sql_sel_events_1_dados['locals_id']."'";

                                    $sql_sel_locals_preparado_1 = $conexaobd->prepare($sql_sel_locals_1);

                                    $sql_sel_locals_preparado_1->execute();

                                    $sql_sel_locals_dados_1 = $sql_sel_locals_preparado_1->fetch();

                                    $nome_local_1 = $sql_sel_locals_dados_1['name'];

                                }

                                ?>
                                <tr>
                                    <td><a name="modal_eventos" class="#modalwindow" href="<?php echo $sql_sel_events_1_dados['id']; ?>"><?php echo $data_1[2]."/".$data_1[1]."/".$data_1[0]; ?></a></td>
                                    <td><a name="modal_eventos" class="#modalwindow" href="<?php echo $sql_sel_events_1_dados['id']; ?>"><?php echo $nome_local_1; ?></a></td>
                                    <td><a name="modal_eventos" class="#modalwindow" href="<?php echo $sql_sel_events_1_dados['id']; ?>"><?php echo $sql_sel_events_1_dados['name']; ?></a></td>
                                    <td><a name="modal_eventos" class="#modalwindow" href="<?php echo $sql_sel_events_1_dados['id']; ?>"><?php echo $sql_sel_events_1_dados['email']; ?></a></td>
                                    <td><a name="modal_eventos" class="#modalwindow" href="<?php echo $sql_sel_events_1_dados['id']; ?>">R$<?php echo $valor_total_1; ?></a></td>
                                </tr>
                                <?php

                            }

                        }

                    }else{
                        ?>
                        <tr>
                            <td colspan="5" align="center">
                                <?php echo mensagens('Vazio', 'Eventos Confirmados'); ?>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                    </tbody><!--Fim do corpo da tabela-->
                </table>
            </div>
            <?php

            $sql_sel_canceled_events = "SELECT canceled_events.*, clients.name, clients.email FROM canceled_events INNER JOIN clients ON canceled_events.clients_id=clients.id WHERE canceled_events.id=canceled_events.id ".$filtro_ce.$filtro_data." ORDER BY canceled_events.event_date";

            $sql_sel_canceled_events_preparado = $conexaobd->prepare($sql_sel_canceled_events);

            $sql_sel_canceled_events_preparado->execute();

            $quantidade_ce = $sql_sel_canceled_events_preparado->rowCount();

            if(($quantidade_ce==0)||($quantidade_ce==1)){
                $altura_tabela_ce = 63;
            }else{
                $altura_tabela_ce = ($quantidade_ce * 31.5) + 31.5;
            }

            ?>
            <h3 align="left">Eventos Cancelados(<?php echo $quantidade_ce;?>)</h3>
            <div style="padding:0; margin:0; max-height: <?php echo $altura_tabela_ce;?>px">
                <table class="consult_table" style="width:100%; margin:0; padding: 0; max-width: 100%;"><!--Início da tabela de consulta-->
                    <thead><!--Início do cabeçalho da tabela-->
                    <tr>
                        <th width="10%">Data</th>
                        <th width="15%">Local</th>
                        <th width="35%">Cliente</th>
                        <th width="20%">E-mail</th>
                        <th width="10%">Ressarcimento</th>
                        <th width="10%">Multa</th>
                    </tr>
                    </thead><!--Fim do cabeçalho da tabela-->
                    <tbody><!--Início do corpo da tabela-->
                    <?php

                    if($sql_sel_canceled_events_preparado->rowCount()>0){

                        while($sql_sel_canceled_events_dados = $sql_sel_canceled_events_preparado->fetch()){

                            $data_ce = explode('-', $sql_sel_canceled_events_dados['event_date']);

                            $local_ce = $sql_sel_canceled_events_dados['local'];

                            if($local_ce==1){
                                $nome_local_ce = "Local do Cliente";
                            }else if($local_ce==2){
                                $nome_local_ce = "Local Externo";
                            }else{

                                $sql_sel_locals_ce = "SELECT name FROM locals WHERE id='".$sql_sel_canceled_events_dados['locals_id']."'";

                                $sql_sel_locals_preparado_ce = $conexaobd->prepare($sql_sel_locals_ce);

                                $sql_sel_locals_preparado_ce->execute();

                                $sql_sel_locals_dados_ce = $sql_sel_locals_preparado_ce->fetch();

                                $nome_local_ce = $sql_sel_locals_dados_ce['name'];

                            }

                            if($sql_sel_canceled_events_dados['repaymant']==NULL){
                                $ressarcimento = "0,00";
                            }else{

                                $ressarcimento_e = explode('.', $sql_sel_canceled_events_dados['repaymant']);

                                $cont = count($ressarcimento_e);

                                for($contadora=0; $contadora<$cont; $contadora++){

                                    $ressarcimento = 0;

                                    if($contadora==1){
                                        $centavos = $ressarcimento_e[$contadora];
                                    }else{
                                        $centavos = '00';
                                    }

                                    $ressarcimento = $ressarcimento_e[0].",".$centavos;

                                }

                            }


                            if($sql_sel_canceled_events_dados['forfeit']==NULL){
                                $multa = "0,00";
                            }else{

                                $multa_e = explode('.', $sql_sel_canceled_events_dados['forfeit']);

                                $cont = count($multa_e);

                                for($contadora=0; $contadora<$cont; $contadora++){

                                    $multa = 0;

                                    if($contadora==1){
                                        $centavos = $multa_e[$contadora];
                                    }else{
                                        $centavos = '00';
                                    }

                                    $multa = $multa_e[0].",".$centavos;

                                }
                            }


                            ?>
                            <tr>
                                <td><a name="modal_cancelados" class="#modalwindow" href="<?php echo $sql_sel_canceled_events_dados['id']; ?>"><?php echo $data_ce[2]."/".$data_ce[1]."/".$data_ce[0]; ?></a></td>
                                <td><a name="modal_cancelados" class="#modalwindow" href="<?php echo $sql_sel_canceled_events_dados['id']; ?>"><?php echo $nome_local_ce; ?></a></td>
                                <td><a name="modal_cancelados" class="#modalwindow" href="<?php echo $sql_sel_canceled_events_dados['id']; ?>"><?php echo $sql_sel_canceled_events_dados['name']; ?></a></td>
                                <td><a name="modal_cancelados" class="#modalwindow" href="<?php echo $sql_sel_canceled_events_dados['id']; ?>"><?php echo $sql_sel_canceled_events_dados['email']; ?></a></td>
                                <td><a name="modal_cancelados" class="#modalwindow" href="<?php echo $sql_sel_canceled_events_dados['id']; ?>">R$<?php echo $ressarcimento; ?></a></td>
                                <td><a name="modal_cancelados" class="#modalwindow" href="<?php echo $sql_sel_canceled_events_dados['id']; ?>">R$<?php echo $multa; ?></a></td>
                            </tr>
                            <?php

                        }
                    }else{
                        ?>
                        <tr>
                            <td colspan="6" align="center">
                                <?php echo mensagens('Vazio', 'Eventos Cancelados'); ?>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                    </tbody><!--Fim do corpo da tabela-->
                </table>
            </div>
            <?php

            $sql_sel_events_status2 = "SELECT events.*, clients.name, clients.email FROM events INNER JOIN clients ON events.clients_id=clients.id WHERE events.status='2' ".$filtro.$filtro_data." ORDER BY events.event_date";

            $sql_sel_events_status2_preparado = $conexaobd->prepare($sql_sel_events_status2);

            $sql_sel_events_status2_preparado->execute();

            $quantidade_2 = $sql_sel_events_status2_preparado->rowCount();

            if(($quantidade_2==0)||($quantidade_2==1)){
                $altura_tabela_2 = 63;
            }else{
                $altura_tabela_2 = ($quantidade_2 * 31.5) + 31.5;
            }

            ?>
            <h3 align="left">Eventos Realizados(<?php echo $quantidade_2; ?>)</h3>
            <div style="padding:0; margin:0; max-height: <?php echo $altura_tabela_2;?>px;">
                <table class="consult_table" style="width:100%; margin:0; padding: 0; max-width: 100%;"><!--Início da tabela de consulta-->
                    <thead><!--Início do cabeçalho da tabela-->
                    <tr>
                        <th width="10%">Data</th>
                        <th width="15%">Local</th>
                        <th width="40%">Cliente</th>
                        <th width="20%">E-mail</th>
                        <th width="15%">Valor Final</th>
                    </tr>
                    </thead><!--Fim do cabeçalho da tabela-->
                    <tbody><!--Início do corpo da tabela-->
                    <?php

                    if($sql_sel_events_status2_preparado->rowCount()>0){

                        while($sql_sel_events_status2_dados = $sql_sel_events_status2_preparado->fetch()){

                            $sql_sel_events_2 = "SELECT events.id, events.rent_value, events.event_date, events.discount, events.entry_fee, events.delivery_fee, events.locals_id, events.local, clients.name, clients.email, (events_has_items.item_quantity * events_has_items.actual_value) AS soma_item, SUM(events_has_kits.kit_quantity * events_has_kits.actual_value) AS soma_kit, SUM(events_has_kits.kit_quantity * kits.discount) AS desconto_kit FROM events INNER JOIN clients ON events.clients_id=clients.id INNER JOIN events_has_items ON events.id=events_has_items.events_id INNER JOIN events_has_kits ON events.id=events_has_kits.events_id INNER JOIN kits ON events_has_kits.kits_id=kits.id WHERE status='2' AND events.id='".$sql_sel_events_status2_dados['id']."' ".$filtro.$filtro_data;

                            $sql_sel_events_2_preparado = $conexaobd->prepare($sql_sel_events_2);

                            $sql_sel_events_2_preparado->execute();

                            while($sql_sel_events_2_dados = $sql_sel_events_2_preparado->fetch()){

                                $data_2 = explode('-', $sql_sel_events_2_dados['event_date']);

                                $valor_total_2_resultado = ($sql_sel_events_2_dados['soma_item'] + $sql_sel_events_2_dados['soma_kit'] + $sql_sel_events_2_dados['delivery_fee'] + $sql_sel_events_2_dados['rent_value']) - $sql_sel_events_2_dados['discount'];

                                $valor_total_2_explode = explode('.', $valor_total_2_resultado);

                                $cont_2 = count($valor_total_2_explode);

                                for($contadora=0; $contadora<$cont_2; $contadora++){

                                    $valor_total_2 = 0;

                                    if($contadora==1){
                                        if($valor_total_2_explode[$contadora]<10){
                                            $centavos = "".$valor_total_2_explode[$contadora]."0";
                                        }else{
                                            $centavos = $valor_total_2_explode[$contadora];
                                        }
                                    }else{
                                        $centavos = '00';
                                    }

                                    $valor_total_2 = $valor_total_2_explode[0].",".$centavos;

                                }

                                $local_2 = $sql_sel_events_2_dados['local'];

                                if($local_2==1){
                                    $nome_local_2 = "Local do Cliente";
                                }else if($local_2==2){
                                    $nome_local_2 = "Local Externo";
                                }else{

                                    $sql_sel_locals_2 = "SELECT name FROM locals WHERE id='".$sql_sel_events_2_dados['locals_id']."'";

                                    $sql_sel_locals_preparado_2 = $conexaobd->prepare($sql_sel_locals_2);

                                    $sql_sel_locals_preparado_2->execute();

                                    $sql_sel_locals_dados_2 = $sql_sel_locals_preparado_2->fetch();

                                    $nome_local_2 = $sql_sel_locals_dados_2['name'];

                                }

                                ?>
                                <tr>
                                    <td><a name="modal_eventos" class="#modalwindow" href="<?php echo $sql_sel_events_2_dados['id']; ?>"><?php echo $data_2[2]."/".$data_2[1]."/".$data_2[0]; ?></a></td>
                                    <td><a name="modal_eventos" class="#modalwindow" href="<?php echo $sql_sel_events_2_dados['id']; ?>"><?php echo $nome_local_2; ?></a></td>
                                    <td><a name="modal_eventos" class="#modalwindow" href="<?php echo $sql_sel_events_2_dados['id']; ?>"><?php echo $sql_sel_events_2_dados['name']; ?></a></td>
                                    <td><a name="modal_eventos" class="#modalwindow" href="<?php echo $sql_sel_events_2_dados['id']; ?>"><?php echo $sql_sel_events_2_dados['email']; ?></a></td>
                                    <td><a name="modal_eventos" class="#modalwindow" href="<?php echo $sql_sel_events_2_dados['id']; ?>">R$<?php echo $valor_total_2; ?></a></td>
                                </tr>
                                <?php

                            }

                        }

                    }else{
                        ?>
                        <tr>
                            <td colspan="5" align="center">
                                <?php echo mensagens('Vazio', 'Eventos Realizados'); ?>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                    </tbody><!--Fim do corpo da tabela-->
                </table>
            </div>
        </div>
    </div>
    <div id="modal"><!--Começo Janela Modal-->
        <div id="modalwindow" class="window">
            <div id="headermodal">
                <h1>Consulta Detalhada de Evento</h1>
                <a href="#" class="close"><img src="../layout/images/close.png"></a>
            </div>
            <div id="contentmodal">
                <table class="consult_table"><!--Início da tabela de consulta-->
                    <tbody class="modal_tbody"><!--Início do corpo da tabela-->
                    </tbody><!--Fim do corpo da tabela-->
                </table><!--Fim da tabela de consulta-->
            </div>
        </div>
        <div id="mask"></div>
    </div><!--Fim Janela Modal de Eventos Cancelados-->
<?php
include "../addons/php/cb_eventscharts_php.php";
//Inclusão da página dos gráficos!
?>