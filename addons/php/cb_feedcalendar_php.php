<?php
    include "../../security/database/cb_connection_database.php";

    $sql_sel_events = "SELECT local AS title, event_date AS start, locals_id FROM events WHERE status='0' OR status='1'";
    $sql_sel_events_preparado = $conexaobd->prepare($sql_sel_events);
    $sql_sel_events_preparado->execute();
    $linhas = $sql_sel_events_preparado->rowCount();
    $sql_sel_events_dados = $sql_sel_events_preparado->fetchAll(PDO::FETCH_ASSOC);
    for($i=0;$i<$linhas;$i++){
        if($sql_sel_events_dados[$i]['title']==0){
            $sql_sel_locals = "SELECT name FROM locals WHERE id='".$sql_sel_events_dados[$i]['locals_id']."'";
            $sql_sel_locals_preparado = $conexaobd->prepare($sql_sel_locals);
            $sql_sel_locals_preparado->execute();
            $sql_sel_locals_dados = $sql_sel_locals_preparado->fetch();
            $sql_sel_events_dados[$i]['title'] = $sql_sel_locals_dados['name'];
        }else if($sql_sel_events_dados[$i]['title']==1){
            $sql_sel_events_dados[$i]['title'] = "Local do Cliente";
        }else{
            $sql_sel_events_dados[$i]['title'] = "Local Externo";
        }
    }
    echo json_encode($sql_sel_events_dados);
?>