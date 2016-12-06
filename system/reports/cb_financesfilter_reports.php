<?php
    include "../../security/database/cb_connection_database.php";
    include "../../addons/php/cb_messagerepository_php.php";
    $filtrogg="";
    $filtrogd="";
    $filtrocg="";
    $filtrocd="";
    if(isset($_POST['ano'])){
        $filtrogg = "AND YEAR(event_date)=".$_POST['ano'];
        $filtrogd = "AND YEAR(date)=".$_POST['ano'];
    }
    if(isset($_POST["datai"])){
        $p_datai = $_POST["datai"];
        $explode_datai = explode("/", $p_datai);
    }
    if(isset($_POST["dataf"])) {
        $p_dataf = $_POST["dataf"];
        $explode_dataf = explode("/", $p_dataf);
    }
    if((isset($explode_datai[2]))&&(!isset($explode_datai[3]))&&(isset($explode_dataf[2]))&&(!isset($explode_dataf[3]))) {
        $filtrocg .= "AND event_date BETWEEN '".$explode_datai[2]."-".$explode_datai[1]."-".$explode_datai[0]."' AND '".$explode_dataf[2]."-".$explode_dataf[1]."-".$explode_dataf[0]."'";
        $filtrocd .= "WHERE expenses.date BETWEEN '".$explode_datai[2]."-".$explode_datai[1]."-".$explode_datai[0]."' AND '".$explode_dataf[2]."-".$explode_dataf[1]."-".$explode_dataf[0]."'";
    }else if((isset($explode_datai[2]))&&(!isset($explode_datai[3]))){
            $filtrocg .= " AND event_date='".$explode_datai[2]."-".$explode_datai[1]."-".$explode_datai[0]."'";
            $filtrocd .= "WHERE expenses.date='".$explode_datai[2]."-".$explode_datai[1]."-".$explode_datai[0]."'";
        }else if((isset($explode_dataf[2]))&&(!isset($explode_dataf[3]))){
                $filtrocg .= "AND event_date='".$explode_dataf[2]."-".$explode_dataf[1]."-".$explode_dataf[0]."'";
                $filtrocd .= "WHERE expenses.date='".$explode_dataf[2]."-".$explode_dataf[1]."-".$explode_dataf[0]."'";
            }
    if((isset($_POST['tipo']))&&($_POST['tipo']!="")) {
        if ($filtrocd==""){
            $filtrocd .= "WHERE expenses_types.id=" . $_POST['tipo'];
        }else{
            $filtrocd .= "AND expenses_types.id=" . $_POST['tipo'];
        }
    }
    if((isset($_POST['cliente']))&&($_POST['cliente']!="")){
        $filtrocg .= "AND clients.name LIKE '%".$_POST['cliente']."%'";
    }

for($contadora=1; $contadora<13; $contadora++) {
    $ganhos = 0;
    $sql_sel_events = "SELECT id, rent_value, status, entry_fee, delivery_fee, discount FROM events WHERE status>0 AND MONTH(event_date)=$contadora ".$filtrogg;
    $sql_sel_events_preparado = $conexaobd->prepare($sql_sel_events);
    $sql_sel_events_preparado->execute();
    $sql_sel_canceled = "SELECT forfeit FROM canceled_events WHERE forfeit!='' AND MONTH(event_date)=$contadora " . $filtrogg;
    $sql_sel_canceled_preparado = $conexaobd->prepare($sql_sel_canceled);
    $sql_sel_canceled_preparado->execute();
    if (($sql_sel_events_preparado->rowCount() > 0)||($sql_sel_canceled_preparado->rowCount() > 0)) {
        while ($sql_sel_events_dados = $sql_sel_events_preparado->fetch()) {
            if ($sql_sel_events_dados['status'] == 1) {
                $ganhos = $ganhos + $sql_sel_events_dados['entry_fee'];
            } else if ($sql_sel_events_dados['status'] == 2) {
                $sql_sel_items = "SELECT SUM((actual_value*item_quantity)) AS valor_itens FROM events_has_items WHERE events_id='" . $sql_sel_events_dados['id'] . "' ";
                $sql_sel_items_preparado = $conexaobd->prepare($sql_sel_items);
                $sql_sel_items_preparado->execute();
                $sql_sel_items_dados = $sql_sel_items_preparado->fetch();
                $sql_sel_kits = "SELECT SUM((actual_value*kit_quantity)) AS valor_kits FROM events_has_kits WHERE events_id='" . $sql_sel_events_dados['id'] . "' ";
                $sql_sel_kits_preparado = $conexaobd->prepare($sql_sel_kits);
                $sql_sel_kits_preparado->execute();
                $sql_sel_kits_dados = $sql_sel_kits_preparado->fetch();
                $ganhos = $ganhos + $sql_sel_items_dados['valor_itens'] + $sql_sel_kits_dados['valor_kits'] + $sql_sel_events_dados['rent_value'] + $sql_sel_events_dados['delivery_fee'] - $sql_sel_events_dados['discount'];
            }
        }
        while($sql_sel_canceled_dados=$sql_sel_canceled_preparado->fetch()) {
            $ganhos = $ganhos + $sql_sel_canceled_dados['forfeit'];
        }
        $gan_a[] = $ganhos;
    }else{
        $gan_a[] = 0;
    }
    $despesas=0;
    $sql_sel_expenses = "SELECT SUM(value) AS valor FROM expenses INNER JOIN expenses_types ON expenses_types.id=expenses.expenses_types_id WHERE MONTH(date)=$contadora ".$filtrogd;
    $sql_sel_expenses_preparado = $conexaobd->prepare($sql_sel_expenses);
    $sql_sel_expenses_preparado->execute();
    if($sql_sel_expenses_preparado->rowCount()>0){
        while($sql_sel_expenses_dados=$sql_sel_expenses_preparado->fetch()){
            $despesas+= $sql_sel_expenses_dados['valor'];
        }
        $des_a[] = $despesas;
    }else {
        $des_a[] = 0;
    }
    $bal_a[] = $ganhos - $despesas;
}

$ganho_aberto=0;
$total_ganhos = 0;
$sql_sel_ganhos="SELECT event_date, clients.name, events.id, rent_value, delivery_fee, entry_fee, discount, status FROM events INNER JOIN clients ON clients.id=events.clients_id WHERE events.status>0 ".$filtrocg." ORDER BY event_date";
$sql_sel_ganhos_preparado=$conexaobd->prepare($sql_sel_ganhos);
$sql_sel_ganhos_preparado->execute();
$sql_sel_cancelado = "SELECT forfeit, clients.name, event_date FROM canceled_events INNER JOIN clients ON clients.id=canceled_events.clients_id WHERE forfeit!='' ". $filtrocg;
$sql_sel_cancelado_preparado = $conexaobd->prepare($sql_sel_cancelado);
$sql_sel_cancelado_preparado->execute();

//Este bloco é responsável por exibir os dados contidos na tabela de ganhos.
$consultag = array();
if(($sql_sel_ganhos_preparado->rowCount()>0)||($sql_sel_cancelado_preparado->rowCount()>0)) {
    while ($sql_sel_ganhos_dados = $sql_sel_ganhos_preparado->fetch()) {
        $exp_data = explode("-", $sql_sel_ganhos_dados['event_date']);
        $data = $exp_data[2] . "/" . $exp_data[1] . "/" . $exp_data[0];
        /*if($sql_sel_ganhos_dados['status']==1){
            $ganho = $sql_sel_ganhos_dados['entry_fee'];
            $total_ganhos+=$ganho;
            $ganho=number_format($ganho,2,',','.');
        }else if($sql_sel_ganhos_dados['status']==2){*/
        $sql_sel_items = "SELECT SUM((actual_value*item_quantity)) AS valor_itens FROM events_has_items WHERE events_id='" . $sql_sel_ganhos_dados['id'] . "' ";
        $sql_sel_items_preparado = $conexaobd->prepare($sql_sel_items);
        $sql_sel_items_preparado->execute();
        $sql_sel_items_dados = $sql_sel_items_preparado->fetch();
        $sql_sel_kits = "SELECT SUM((actual_value*kit_quantity)) AS valor_kits FROM events_has_kits WHERE events_id='" . $sql_sel_ganhos_dados['id'] . "' ";
        $sql_sel_kits_preparado = $conexaobd->prepare($sql_sel_kits);
        $sql_sel_kits_preparado->execute();
        $sql_sel_kits_dados = $sql_sel_kits_preparado->fetch();
        if ($sql_sel_ganhos_dados['status'] == 1) {
            $ganho = $sql_sel_ganhos_dados['entry_fee'];
            $ganho_aberto = $sql_sel_items_dados['valor_itens'] + $sql_sel_kits_dados['valor_kits'] + $sql_sel_ganhos_dados['rent_value'] + $sql_sel_ganhos_dados['delivery_fee'] - $sql_sel_ganhos_dados['discount'] - $sql_sel_ganhos_dados['entry_fee'];
            $total_ganhos += $ganho;
            $ganho = number_format($ganho, 2, ',', '.');
            $ganho_aberto = number_format($ganho_aberto, 2, ',', '.');
        } else if ($sql_sel_ganhos_dados['status'] == 2) {
            $ganho = $sql_sel_items_dados['valor_itens'] + $sql_sel_kits_dados['valor_kits'] + $sql_sel_ganhos_dados['rent_value'] + $sql_sel_ganhos_dados['delivery_fee'] - $sql_sel_ganhos_dados['discount'];
            $total_ganhos += $ganho;
            $ganho = number_format($ganho, 2, ',', '.');
        }
        $consultag[]="<tr>
            <td class='ganho'>".$data."</td>
            <td>".$sql_sel_ganhos_dados['name']."</td>
            <td>R$ ".$ganho."</td>
        </tr>";
    }
    while ($sql_sel_cancelado_dados = $sql_sel_cancelado_preparado->fetch()) {
        $exp_data = explode("-", $sql_sel_cancelado_dados['event_date']);
        $data = $exp_data[2] . "/" . $exp_data[1] . "/" . $exp_data[0];
        $ganho = number_format($sql_sel_cancelado_dados['forfeit'], 2, ',', '.');
        $total_ganhos += $ganho;
        $consultag[]="<tr>
            <td class='ganho'>".$data."</td>
            <td>".$sql_sel_cancelado_dados['name']."</td>
            <td>R$ ".$ganho."</td>
        </tr>";
    }
}else {
       $consultag[] = "<tr>
            <td align='center' colspan='3'>".mensagens('Vazio', 'ganhos')."</td>
        </tr>";
}
$total_despesa = 0;
$sql_sel_despesas = "SELECT expenses.date, expenses_types.name, expenses.value FROM expenses INNER JOIN expenses_types ON expenses.expenses_types_id=expenses_types.id ".$filtrocd." ORDER BY date";
$sql_sel_despesas_preparado=$conexaobd->prepare($sql_sel_despesas);
$sql_sel_despesas_preparado->execute();
//Este bloco é responsável por exibir os dados contidos na tabela de despesas.
$consultad = array();
if($sql_sel_despesas_preparado->rowCount()>0){
    while($sql_sel_despesas_dados = $sql_sel_despesas_preparado->fetch()) {
        $exp_data = explode("-", $sql_sel_despesas_dados['date']);
        $data = $exp_data[2] . "/" . $exp_data[1] . "/" . $exp_data[0];
        $exp_despesa = explode(".", $sql_sel_despesas_dados['value']);
        $despesa = $exp_despesa[0] . "," . $exp_despesa[1];
        $total_despesa += $sql_sel_despesas_dados['value'];
        $consultad[]="<tr>
            <td class='despesa'>".$data."</td>
            <td>".$sql_sel_despesas_dados['name']."</td>
            <td>R$ ".$despesa."</td>
        </tr>";
    }
}else {
    $consultad[] = "<tr>
        <td align='center' colspan='3'>".mensagens('Vazio', 'despesas')."</td>
    </tr>";
}

$balanco = $total_ganhos - $total_despesa;
if($balanco<0){
    $balanco = $balanco*(-1);
    $cor = "#F00";
}else{
    $cor = '#3bba00';
}
$balanco = number_format($balanco,2,',','.');
$total_despesa = number_format($total_despesa,2,',','.');
$total_ganhos=number_format($total_ganhos,2,',','.');

$consultab="<tr>
        <td align='center'>R$ ".$total_ganhos."</td>
        <td align='center'>R$ ".$total_despesa. "</td>
        <td align='center' style=' color:".$cor."'>R$ " .$balanco."</td>
</tr>";
$consultaa="<tr>
        <td align='center'> R$ ".$ganho_aberto."</td>
</tr>";

$desp = json_encode($des_a);
$ganh = json_encode($gan_a);
$bal = json_encode($bal_a);

$qtdG = count($consultag);
$qtdD = count($consultad);
$filtrar = array($consultag, $consultad, $consultab, $consultaa, $desp, $ganh, $qtdG, $qtdD, $bal);
echo json_encode($filtrar);
?>
