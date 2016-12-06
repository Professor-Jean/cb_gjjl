<h1 id="title">Controle de Eventos</h1>
<div id="consult">
    <h2>Filtro de Eventos <img src="../layout/images/search.png" class="filter_icon"></h2>
    <div class="filter"><!--Início do filtro-->
        <h3>Filtrar Eventos</h3>
        <hr />
        <form class="filter_form" name="frmfiltep" method="POST" action="?folder=events_control/control/&file=cb_events_control&ext=php">
            <table>
                <tr>
                    <td>Data: De</td>
                    <td><input type="text" readonly class="datepicker" name="txtdatai" placeholder="DD/MM/AAAA" maxlength="10"></td>
                    <td>Até</td>
                    <td><input type="text" readonly class="datepicker" name="txtdataf" placeholder="DD/MM/AAAA" maxlength="10"></td>
                </tr>
                <tr>
                    <td>Local:</td>
                    <td colspan="3">
                        <?php
                        $sql_sel_locals = "SELECT id, name FROM locals ORDER BY name";
                        $sql_sel_locals_preparado = $conexaobd->prepare($sql_sel_locals);
                        $sql_sel_locals_preparado ->execute();
                        ?>
                        <select name="sellocal" style="width:100%;">
                            <option value="">Escolha</option>
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
                    <td>Cliente:</td>
                    <td colspan="3"><input type="text" name="txtcliente" placeholder="José Silveira" maxlength="45" style="width:100%;"> </td>
                </tr>
                <td colspan="4" style="align: right;"   ><button type="submit" name="btnpesquisar">Pesquisar</button></td>
            </table>
        </form>
    </div><!--Fim do filtro-->
    <h2 style="margin-top: 75px;">Eventos Pendentes</h2>

    <?php
    $filtro = "";
    if(isset($_POST["txtdatai"])){
        $p_datai = $_POST["txtdatai"];
        $explode_datai = explode("/", $p_datai);
    }
    if(isset($_POST["txtdataf"])) {
        $p_dataf = $_POST["txtdataf"];
        $explode_dataf = explode("/", $p_dataf);
    }
    if((isset($explode_datai[2]))&&(!isset($explode_datai[3]))&&(isset($explode_dataf[2]))&&(!isset($explode_dataf[3]))) {
        $filtro .= "AND events.event_date BETWEEN '".$explode_datai[2]."-".$explode_datai[1]."-".$explode_datai[0]."' AND '".$explode_dataf[2]."-".$explode_dataf[1]."-".$explode_dataf[0]."'";
    }else if((isset($explode_datai[2]))&&(!isset($explode_datai[3]))){
        $filtro .= " AND events.event_date LIKE '".$explode_datai[2]."-".$explode_datai[1]."-".$explode_datai[0]."'";
    }else if((isset($explode_dataf[2]))&&(!isset($explode_dataf[3]))){
        $filtro .= "AND events.event_date LIKE '".$explode_dataf[2]."-".$explode_dataf[1]."-".$explode_dataf[0]."'";
    }
    if(isset($_POST['sellocal'])){
        $p_local =  $_POST['sellocal'];
        if(is_numeric($p_local)){
            $filtro .="AND events.locals_id LIKE '".$p_local."'";
        }else if($p_local=="cliente"){
            $filtro .="AND events.local='1'";
        }else if($p_local=="externo"){
            $filtro .="AND events.local='2'";
        }
    }
    if(isset($_POST['txtcliente'])){
        $filtro .= "AND clients.name LIKE '%".$_POST['txtcliente']."%'";
    }


    ?>

    <table class="consult_table"><!--Início da tabela de consulta-->
        <thead><!--Início do cabeçalho da tabela-->
        <tr>
            <th width="10%">Data</th>
            <th width="6%">Horário</th>
            <th width="12%">Local</th>
            <th width="15%">Cliente</th>
            <th width="10%">Telefone</th>
            <th width="19%">E-mail</th>
            <th width="9%">Valor</th>
            <th width="7%">Editar</th>
            <th width="7%">Confirmar</th>
            <th width="7%">Cancelar</th>
        </tr>
        </thead><!--Fim do cabeçalho da tabela-->
        <tbody><!--Início do corpo da tabela-->
        <?php
        $sql_sel_events = "SELECT events.id, event_date, event_time, local, locals_id, rent_value, delivery_fee, discount, clients.name, clients.phone, clients.email FROM events INNER JOIN clients ON clients.id=events.clients_id WHERE status='0' ".$filtro." ORDER BY event_date";
        $sql_sel_events_preparado = $conexaobd->prepare($sql_sel_events);
        $sql_sel_events_preparado->execute();
        if($sql_sel_events_preparado->rowCount()>0) {
            while ($sql_sel_events_dados = $sql_sel_events_preparado->fetch()) {
                $data = explode("-", $sql_sel_events_dados['event_date']);
                $sql_sel_events_dados['event_time'] = substr($sql_sel_events_dados['event_time'], 0 , -3);
                $sql_sel_items = "SELECT SUM((actual_value*item_quantity)) AS valor_itens FROM events_has_items WHERE events_id='".$sql_sel_events_dados['id']."' ";
                $sql_sel_items_preparado = $conexaobd->prepare($sql_sel_items);
                $sql_sel_items_preparado->execute();
                $sql_sel_items_dados=$sql_sel_items_preparado->fetch();
                $sql_sel_kits = "SELECT SUM((actual_value*kit_quantity)) AS valor_kits FROM events_has_kits WHERE events_id='".$sql_sel_events_dados['id']."' ";
                $sql_sel_kits_preparado = $conexaobd->prepare($sql_sel_kits);
                $sql_sel_kits_preparado->execute();
                $sql_sel_kits_dados=$sql_sel_kits_preparado->fetch();
                $valor = $sql_sel_items_dados['valor_itens'] + $sql_sel_kits_dados['valor_kits'] + $sql_sel_events_dados['rent_value'] + $sql_sel_events_dados['delivery_fee'] - $sql_sel_events_dados['discount'];
                $explode_valor = explode(".", $valor);
                if(!isset($explode_valor['1'])){
                    $explode_valor['1']="00";
                }

                if($sql_sel_events_dados['local']=='0'){
                    $sql_sel_locals = "SELECT name FROM locals WHERE id='".$sql_sel_events_dados['locals_id']."'";
                    $sql_sel_locals_preparado=$conexaobd->prepare($sql_sel_locals);
                    $sql_sel_locals_preparado->execute();
                    $sql_sel_locals_dados=$sql_sel_locals_preparado->fetch();
                    $local=$sql_sel_locals_dados['name'];
                }else if($sql_sel_events_dados['local']=='1') {
                    $local = "Local do Cliente";
                }else{
                    $local="Local Externo";
                }
                ?>
                <tr>
                    <td><a name="modal_orcados" class="#modalwindow" href="<?php echo $sql_sel_events_dados['id']; ?>"><?php echo $data['2']."/".$data['1']."/".$data['0'];?></a></td>
                    <td><a name="modal_orcados" class="#modalwindow" href="<?php echo $sql_sel_events_dados['id']; ?>"><?php echo $sql_sel_events_dados['event_time'] ?></a></td>
                    <td><a name="modal_orcados" class="#modalwindow" href="<?php echo $sql_sel_events_dados['id']; ?>"><?php echo $local ?></td>
                    <td><a name="modal_orcados" class="#modalwindow" href="<?php echo $sql_sel_events_dados['id']; ?>"><?php echo $sql_sel_events_dados['name'] ?></a></td>
                    <td><a name="modal_orcados" class="#modalwindow" href="<?php echo $sql_sel_events_dados['id']; ?>"><?php echo $sql_sel_events_dados['phone'] ?></a></td>
                    <td><a name="modal_orcados" class="#modalwindow" href="<?php echo $sql_sel_events_dados['id']; ?>"><?php echo $sql_sel_events_dados['email'] ?></a></td>
                    <td><a name="modal_orcados" class="#modalwindow" href="<?php echo $sql_sel_events_dados['id']; ?>">R$<?php echo $explode_valor['0'].",".$explode_valor['1'] ?></a></td>
                    <td align="center"><a href="?folder=events/&file=cb_fmupd_events&ext=php&id=<?php echo $sql_sel_events_dados['id']; ?>"><img src="../layout/images/edit.png" width="25px"></a></td>
                    <td align="center"><a href="?folder=events_control/control/&file=cb_fmconfirm_control&ext=php&id=<?php echo $sql_sel_events_dados['id']; ?>"><img src="../layout/images/confirm.png" width="25px"></a></td>
                    <td align="center"><a href="?folder=events_control/control/&file=cb_fmcancelpending_control&ext=php&id=<?php echo $sql_sel_events_dados['id']; ?>"><img src="../layout/images/close.png" width="25px"></a></td>

                </tr>
                <?php
            }
        }else{
            ?>
            <td align="center" colspan="10"><?php echo mensagens('Vazio', 'eventos pendentes') ?></td>
            <?php
        }
        ?>
        </tbody><!--Fim do corpo da tabela-->
    </table><!--Fim da tabela de consulta-->
</div>





<div id="consult">
    <h2>Eventos Confirmados</h2>
    <table class="consult_table"><!--Início da tabela de consulta-->
        <thead><!--Início do cabeçalho da tabela-->
        <tr>
            <th width="10%">Data</th>
            <th width="6%">Horário</th>
            <th width="12%">Local</th>
            <th width="15%">Cliente</th>
            <th width="10%">Telefone</th>
            <th width="19%">E-mail</th>
            <th width="9%">Valor</th>
            <th width="7%">Entrada</th>
            <th width="7%">Realizar</th>
            <th width="7%">Cancelar</th>
        </tr>
        </thead><!--Fim do cabeçalho da tabela-->
        <tbody><!--Início do corpo da tabela-->
        <?php
        $sql_sel_events = "SELECT events.id, event_date, event_time, local, locals_id, rent_value, delivery_fee, entry_fee, discount, clients.name, clients.phone, clients.email FROM events INNER JOIN clients ON clients.id=events.clients_id WHERE status='1' ".$filtro." ORDER BY event_date";
        $sql_sel_events_preparado = $conexaobd->prepare($sql_sel_events);
        $sql_sel_events_preparado->execute();
        if($sql_sel_events_preparado->rowCount()>0) {
            while ($sql_sel_events_dados = $sql_sel_events_preparado->fetch()) {
                $data = explode("-", $sql_sel_events_dados['event_date']);
                $sql_sel_events_dados['event_time'] = substr($sql_sel_events_dados['event_time'], 0 , -3);
                $sql_sel_items = "SELECT SUM((actual_value*item_quantity)) AS valor_itens FROM events_has_items WHERE events_id='".$sql_sel_events_dados['id']."' ";
                $sql_sel_items_preparado = $conexaobd->prepare($sql_sel_items);
                $sql_sel_items_preparado->execute();
                $sql_sel_items_dados=$sql_sel_items_preparado->fetch();
                $sql_sel_kits = "SELECT SUM((actual_value*kit_quantity)) AS valor_kits FROM events_has_kits WHERE events_id='".$sql_sel_events_dados['id']."' ";
                $sql_sel_kits_preparado = $conexaobd->prepare($sql_sel_kits);
                $sql_sel_kits_preparado->execute();
                $sql_sel_kits_dados=$sql_sel_kits_preparado->fetch();
                $valor = $sql_sel_items_dados['valor_itens'] + $sql_sel_kits_dados['valor_kits'] + $sql_sel_events_dados['rent_value'] + $sql_sel_events_dados['delivery_fee'] - $sql_sel_events_dados['discount'];
                $explode_valor = explode(".", $valor);
                if(!isset($explode_valor['1'])){
                    $explode_valor['1']="00";
                }
                $explode_entrada = explode(".", $sql_sel_events_dados['entry_fee']);
                if($sql_sel_events_dados['local']=='0'){
                    $sql_sel_locals = "SELECT name FROM locals WHERE id='".$sql_sel_events_dados['locals_id']."'";
                    $sql_sel_locals_preparado=$conexaobd->prepare($sql_sel_locals);
                    $sql_sel_locals_preparado->execute();
                    $sql_sel_locals_dados=$sql_sel_locals_preparado->fetch();
                    $local=$sql_sel_locals_dados['name'];
                }else if($sql_sel_events_dados['local']=='1') {
                    $local = "Local do Cliente";
                }else{
                    $local="Local Externo";
                }
                ?>
                <tr>
                    <td><a name="modal_eventos" class="#modalwindow" href="<?php echo $sql_sel_events_dados['id']; ?>"><?php echo $data['2']."/".$data['1']."/".$data['0'];?></a></td>
                    <td><a name="modal_eventos" class="#modalwindow" href="<?php echo $sql_sel_events_dados['id']; ?>"><?php echo $sql_sel_events_dados['event_time'] ?></a></td>
                    <td><a name="modal_eventos" class="#modalwindow" href="<?php echo $sql_sel_events_dados['id']; ?>"><?php echo $local ?></a></td>
                    <td><a name="modal_eventos" class="#modalwindow" href="<?php echo $sql_sel_events_dados['id']; ?>"><?php echo $sql_sel_events_dados['name'] ?></a></td>
                    <td><a name="modal_eventos" class="#modalwindow" href="<?php echo $sql_sel_events_dados['id']; ?>"><?php echo $sql_sel_events_dados['phone'] ?></a></td>
                    <td><a name="modal_eventos" class="#modalwindow" href="<?php echo $sql_sel_events_dados['id']; ?>"><?php echo $sql_sel_events_dados['email'] ?></a></td>
                    <td><a name="modal_eventos" class="#modalwindow" href="<?php echo $sql_sel_events_dados['id']; ?>">R$<?php echo $explode_valor['0'].",".$explode_valor['1'] ?></a></td>
                    <td><a name="modal_eventos" class="#modalwindow" href="<?php echo $sql_sel_events_dados['id']; ?>">R$<?php echo $explode_entrada['0'].",".$explode_entrada['1'] ?></a></td>
                    <td align="center"><a href="?folder=events_control/control/&file=cb_confirmrealization_control&ext=php&id=<?php echo $sql_sel_events_dados['id']; ?>"><img src="../layout/images/confirm.png" width="25px"></a></td>
                    <td align="center"><a href="?folder=events_control/control/&file=cb_fmcancelconfirmed_control&ext=php&id=<?php echo $sql_sel_events_dados['id']; ?>"><img src="../layout/images/close.png" width="25px"></a></td>

                </tr>
                <?php
            }
        }else{
            ?>
            <td align="center" colspan="10"><?php echo mensagens('Vazio', 'eventos confirmados') ?></td>
            <?php
        }
        ?>
        </tbody><!--Fim do corpo da tabela-->
    </table><!--Fim da tabela de consulta-->
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