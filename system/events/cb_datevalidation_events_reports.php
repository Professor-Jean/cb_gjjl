<?php

    include "../../security/database/cb_connection_database.php";

    $datai = $_POST['datai'];
    $dataf = $_POST['dataf'];

    $data_i_explode = explode('/', $datai);
    $data_f_explode = explode('/', $dataf);

    $resultado_data = $data_f_explode[2] - $data_i_explode[2];

    $resultado = array('resultado'=>$resultado_data);

    echo json_encode($resultado);



?>