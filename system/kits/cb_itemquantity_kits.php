<?php

    include "../../security/database/cb_connection_database.php";

    $item = $_POST['item'];



    $sql_sel_items = "SELECT name, quantity FROM items WHERE id='".$item."'";

    $sql_sel_items_preparado = $conexaobd->prepare($sql_sel_items);

    $sql_sel_items_preparado->execute();

    $sql_sel_items_dados = $sql_sel_items_preparado->fetch();

    $quantidade = $sql_sel_items_dados['quantity'];

    $nome = $sql_sel_items_dados['name'];

    $resultado = array('quantidade'=>$quantidade, 'nome'=>$nome);

    echo json_encode($resultado);



?>