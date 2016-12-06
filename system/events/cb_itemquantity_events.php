<?php
    include "../../security/database/cb_connection_database.php";
    $p_data = $_POST['data'];
    $data = explode('/', $p_data);
    $data_banco = $data[2]."-".$data[1]."-".$data[0];
    $reservados[] = 0;
    $resultado[] = 0;

    $sql_sel_events_has_kits = "SELECT kits_has_items.items_id AS kits_has_itemsitems_id, items.quantity AS itemsquantity, SUM(kits_has_items.item_quantity) AS itemsavaiable FROM events_has_kits INNER JOIN events ON events_has_kits.events_id = events.id INNER JOIN kits ON events_has_kits.kits_id = kits.id INNER JOIN kits_has_items ON kits.id = kits_has_items.kits_id INNER JOIN items ON kits_has_items.items_id = items.id WHERE events.event_date = '" . $data_banco . "' AND (status='0' OR status='1') GROUP BY events.event_date, kits_has_items.items_id";
    $sql_sel_events_has_kits_preparado = $conexaobd->prepare($sql_sel_events_has_kits);
    $sql_sel_events_has_kits_preparado->execute();

    while ($sql_sel_events_has_kits_dados = $sql_sel_events_has_kits_preparado->fetch()) {
        $reservados[$sql_sel_events_has_kits_dados['kits_has_itemsitems_id']] = $sql_sel_events_has_kits_dados['itemsavaiable'];
        $reservados[$sql_sel_events_has_kits_dados['kits_has_itemsitems_id']] = $sql_sel_events_has_kits_dados['itemsquantity'] - $reservados[$sql_sel_events_has_kits_dados['kits_has_itemsitems_id']];
    }

    $sql_sel_events_has_items = "SELECT events_has_items.items_id AS events_has_itemsitems_id, SUM(events_has_items.item_quantity) AS itemsavaiable, items.quantity AS itemsquantity FROM events_has_items INNER JOIN events ON events.id=events_has_items.events_id INNER JOIN items ON events_has_items.items_id=items.id WHERE events.event_date='" . $data_banco . "' AND (status='0' OR status='1') GROUP BY events.event_date, items.id";
    $sql_sel_events_has_items_preparado = $conexaobd->prepare($sql_sel_events_has_items);
    $sql_sel_events_has_items_preparado->execute();

    while($sql_sel_events_has_items_dados = $sql_sel_events_has_items_preparado->fetch()){
        if(isset($reservados[$sql_sel_events_has_items_dados['events_has_itemsitems_id']])) {
            $reservados[$sql_sel_events_has_items_dados['events_has_itemsitems_id']] = $reservados[$sql_sel_events_has_items_dados['events_has_itemsitems_id']] - $sql_sel_events_has_items_dados['itemsavaiable'];
        }else {
            $reservados[$sql_sel_events_has_items_dados['events_has_itemsitems_id']] = 0;
            $reservados[$sql_sel_events_has_items_dados['events_has_itemsitems_id']] = $sql_sel_events_has_items_dados['itemsquantity'] - $sql_sel_events_has_items_dados['itemsavaiable'];
        }
    }

    if(!isset($reservados)) {
        $sql_sel_items = "SELECT id, quantity FROM items";
        $sql_sel_items_preparado = $conexaobd->prepare($sql_sel_items);
        $sql_sel_items_preparado->execute();

        while ($sql_sel_items_dados = $sql_sel_items_preparado->fetch()) {
            if ((!isset($reservados[$sql_sel_items_dados['id']]))) {
                $reservados[$sql_sel_items_dados['id']] = $sql_sel_items_dados['quantity'];
            }
        }
    }
    $a=0;
    for($i=0; $i<COUNT($reservados); $i++){
        $sql_sel_kits_has_items = "SELECT kits_has_items.items_id AS itemsid, kits_has_items.kits_id AS kitsid, kits_has_items.item_quantity AS itemquantity FROM kits_has_items INNER JOIN kits ON kits_has_items.kits_id=kits.id GROUP BY kits_has_items.kits_id, kits_has_items.items_id";
        $sql_sel_kits_has_items_preparado = $conexaobd->prepare($sql_sel_kits_has_items);
        $sql_sel_kits_has_items_preparado->execute();
        $sql_sel_kits_has_items_dados = $sql_sel_kits_has_items_preparado->fetchAll();

        if(isset($reservados[$sql_sel_kits_has_items_dados[$i]['itemsid']])) {
            if (($reservados[$sql_sel_kits_has_items_dados[$i]['itemsid']] == 0) || ($reservados[$sql_sel_kits_has_items_dados[$i]['itemsid']] - $sql_sel_kits_has_items_dados[$i]['itemquantity'] < 0)) {
                $a++;
                $resultado[$a] = $sql_sel_kits_has_items_dados[$i]['itemsid'];
            }
        }
    }

    echo json_encode($resultado);
?>