<?php
    include "../../security/database/cb_connection_database.php";

    $p_kits = $_POST['kit_s'];
    $p_itens = $_POST['item_s'];
    $p_quantidadekits = $_POST['quantidadekit_s'];
    $p_quantidadeitems = $_POST['quantidadeitem_s'];
    $contkits = count($p_kits);
    $contitens = count($p_itens);
    $resultado = 0;
    $resultadokits = 0;
    $resultadoitens = 0;

    for ($i = 0; $i < $contkits; $i++) {
        $sql_sel_kits = "SELECT SUM(kits_has_items.actual_value*kits_has_items.item_quantity) - kits.discount AS kitvalue FROM kits INNER JOIN kits_has_items ON kits.id=kits_has_items.kits_id WHERE kits.id='" . $p_kits[$i] . "'";
        $sql_sel_kits_preparado = $conexaobd->prepare($sql_sel_kits);
        $sql_sel_kits_preparado->execute();
        $sql_sel_kits_dados = $sql_sel_kits_preparado->fetch();

        $valor[$i] = $sql_sel_kits_dados['kitvalue'];
        $quantidade[$i] = $p_quantidadekits[$i];

        $resultadokits = $resultadokits + ($valor[$i] * $quantidade[$i]);

    }

    for ($i = 0; $i < $contitens; $i++) {
        $sql_sel_items = "SELECT value FROM items WHERE id='" . $p_itens[$i] . "'";
        $sql_sel_items_preparado = $conexaobd->prepare($sql_sel_items);
        $sql_sel_items_preparado->execute();
        $sql_sel_items_dados = $sql_sel_items_preparado->fetch();

        $valor[$i] = $sql_sel_items_dados['value'];
        $quantidade[$i] = $p_quantidadeitems[$i];

        $resultadoitens = $resultadoitens + ($valor[$i] * $quantidade[$i]);
    }

    $resultados = $resultadokits + $resultadoitens;

    $valor = number_format($resultados, 2, ',', '.');

    $resultado = array('resultado' => $valor);

    echo json_encode($resultado);

?>