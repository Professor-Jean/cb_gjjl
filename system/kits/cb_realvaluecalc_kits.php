<?php

    include "../../security/database/cb_connection_database.php";

    $item_s = $_POST['item_s'];
    $quantidade_s = $_POST['quantidade_s'];
    $id_quantidade = count($item_s);
    $resultado = 0;

        for($contadora=0; $contadora<$id_quantidade; $contadora++){

            $sql_sel_items = "SELECT value, quantity FROM items WHERE id='".$item_s[$contadora]."'";

            $sql_sel_items_preparado = $conexaobd->prepare($sql_sel_items);

            $sql_sel_items_preparado->execute();

            $sql_sel_items_dados = $sql_sel_items_preparado->fetch();

            $valor[$contadora] = $sql_sel_items_dados['value'];
            $quantidade[$contadora] = $quantidade_s[$contadora];

            $resultado = $resultado + ($valor[$contadora] * $quantidade[$contadora]);

        }

    $resultado_e = explode('.', $resultado);

    $cont = count($resultado_e);

    for($contadora=0; $contadora<$cont; $contadora++){

        $valor = 0;

        if($contadora==1){
            $centavos = $resultado_e[$contadora];
        }else{
            $centavos = '00';
        }

        $valor = $resultado_e[0].",".$centavos;

    }

    $resultado = array('resultado'=>$valor);

    echo json_encode($resultado);

?>