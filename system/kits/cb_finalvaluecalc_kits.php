<?php

    include "../../security/database/cb_connection_database.php";

    $p_valor_real = $_POST['valor_real_s'];
    $p_desconto = $_POST['desconto_s'];

    $valor_r = explode(',', $p_valor_real);

    $cont_r = count($valor_r);

    for($contadora=0; $contadora<$cont_r; $contadora++){

        $valor_real = 0;

        if($contadora==1){
            $centavos = $valor_r[$contadora];
        }else{
            $centavos = '00';
        }

        $valor_real = $valor_r[0].".".$centavos;

    }

    $valor_d = explode(',', $p_desconto);

    $cont_d = count($valor_d);

    for($contadora=0; $contadora<$cont_d; $contadora++){

        $valor_desconto = 0;

        if($contadora==1){
            $centavos = $valor_d[$contadora];
        }else{
            $centavos = '00';
        }

        $valor_desconto = $valor_d[0].".".$centavos;

    }

    $desconto = $valor_real - $valor_desconto;

    $valor_f = explode('.', $desconto);

    $cont_f = count($valor_f);

    for($contadora=0; $contadora<$cont_f; $contadora++){

        $valor_final = 0;

        if($contadora==1){
            $centavos = $valor_f[$contadora];
        }else{
            $centavos = '00';
        }

        $valor_final = $valor_f[0].",".$centavos;

    }

    $resultado = array('resultado'=>$valor_final);

    echo json_encode($resultado);

?>