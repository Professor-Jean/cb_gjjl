<?php

    include "../../security/database/cb_connection_database.php";

    $p_item = $_POST['item'];
    $p_data = $_POST['datab'];
    //Recebe do ajax.

    //Esta estrutura é responsável por fazer a seleção dos itens presentes nos kits, onde a data for igual à variável p_data e a id do item for igual à variável p_item.
    $sql_sel_events_has_kits = "SELECT kits_has_items.items_id AS kits_has_itemsitems_id, items.quantity AS itemsquantity, items.name AS itemsname, SUM(kits_has_items.item_quantity) AS itemsavaiable FROM events_has_kits INNER JOIN events ON events_has_kits.events_id = events.id INNER JOIN kits ON events_has_kits.kits_id = kits.id INNER JOIN kits_has_items ON kits.id = kits_has_items.kits_id INNER JOIN items ON kits_has_items.items_id = items.id WHERE events.event_date = '" . $p_data . "' AND (status='0' OR status='1') AND items.id='".$p_item."' GROUP BY events.event_date, kits_has_items.items_id";
    $sql_sel_events_has_kits_preparado = $conexaobd->prepare($sql_sel_events_has_kits);
    $sql_sel_events_has_kits_preparado->execute();
    $sql_sel_events_has_kits_dados = $sql_sel_events_has_kits_preparado->fetch();

    $reservados = $sql_sel_events_has_kits_dados['itemsquantity'] - $sql_sel_events_has_kits_dados['itemsavaiable'];

    $sql_sel_events_has_items = "SELECT events_has_items.items_id AS events_has_itemsitems_id, SUM(events_has_items.item_quantity) AS itemsavaiable, items.quantity AS itemsquantity, items.name AS itemsname FROM events_has_items INNER JOIN events ON events.id=events_has_items.events_id INNER JOIN items ON events_has_items.items_id=items.id WHERE events.event_date='" . $p_data . "' AND (status='0' OR status='1') AND items.id='".$p_item."' GROUP BY events.event_date, items.id";
    $sql_sel_events_has_items_preparado = $conexaobd->prepare($sql_sel_events_has_items);
    $sql_sel_events_has_items_preparado->execute();
    $sql_sel_events_has_items_dados = $sql_sel_events_has_items_preparado->fetch();

    $sql_sel_items = "SELECT id, name, quantity FROM items WHERE id='".$p_item."'";
    $sql_sel_items_preparado = $conexaobd->prepare($sql_sel_items);
    $sql_sel_items_preparado->execute();
    $sql_sel_items_dados = $sql_sel_items_preparado->fetch();

    if(($sql_sel_events_has_kits_preparado->rowCount()==0) && ($sql_sel_events_has_items_preparado->rowCount()==0)){
        $quantidade = $sql_sel_items_dados['quantity'];
        $sql_sel_events_has_kits_dados['itemsname'] = $sql_sel_items_dados['name'];
    }else if($sql_sel_events_has_kits_preparado->rowCount()==0){
        $quantidade = $sql_sel_events_has_items_dados['itemsquantity'] - $sql_sel_events_has_items_dados['itemsavaiable'] - $reservados;
        $sql_sel_events_has_kits_dados['itemsname'] = $sql_sel_events_has_items_dados['itemsname'];
        }else {
            $quantidade = $sql_sel_events_has_items_dados['itemsquantity'] - $sql_sel_events_has_items_dados['itemsavaiable'] - $reservados;
        }

    $resultado = array('quantidade'=>abs($quantidade), 'nome'=> $sql_sel_events_has_kits_dados['itemsname']);

    echo json_encode($resultado);

?>
