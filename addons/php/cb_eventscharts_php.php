<?php

    $filtro_grafico = "";
    $data = '';
    $quantidade_r = '';
    $quantidade_c = '';

    if(isset($_POST["txtdatai"])){
        $p_datai = $_POST["txtdatai"];
        $explode_datai = explode("/", $p_datai);
    }
    if(isset($_POST["txtdataf"])) {
        $p_dataf = $_POST["txtdataf"];
        $explode_dataf = explode("/", $p_dataf);
    }
    if((!isset($_POST["txtdatai"]))&&(!isset($_POST["txtdataf"]))){
        $p_datai = "01/01/".date("Y")."";
        $explode_datai = explode("/", $p_datai);
        $p_dataf = "31/12/".date("Y")."";
        $explode_dataf = explode("/", $p_dataf);
    }
    if((isset($_POST["txtdatai"]))&&(isset($_POST["txtdataf"]))){
        if(($_POST["txtdatai"]=='')&&($_POST["txtdataf"])==''){
            $p_datai = "01/01/".date("Y")."";
            $explode_datai = explode("/", $p_datai);
            $p_dataf = "31/12/".date("Y")."";
            $explode_dataf = explode("/", $p_dataf);
        }
    }

    if((isset($explode_datai[2]))&&(!isset($explode_datai[3]))&&(isset($explode_dataf[2]))&&(!isset($explode_dataf[3]))) {

                    $ano_comparador = $explode_dataf[2] - $explode_datai[2];

                    if($ano_comparador>2){
                        $p_datai = "01/01/".date("Y")."";
                        $explode_datai = explode("/", $p_datai);
                        $p_dataf = "31/12/".date("Y")."";
                        $explode_dataf = explode("/", $p_dataf);
                    }else if($ano_comparador<0){
                            $p_datai = "01/01/".date("Y")."";
                            $explode_datai = explode("/", $p_datai);
                            $p_dataf = "31/12/".date("Y")."";
                            $explode_dataf = explode("/", $p_dataf);
                    }

                    $mes_ate = $explode_datai[2] - $explode_dataf[2];

                    $ano_meio = ($explode_datai[2] + $explode_dataf[2]) / 2;

                    if(is_int($ano_meio)){
                        $mes_ate_ano_meio = 12;
                    }else{
                        $mes_ate_ano_meio = 0;
                    }
                    if($mes_ate<0){
                        $mes_ate = 12 + $explode_dataf[1] + $mes_ate_ano_meio;
                    }else{
                        $mes_ate = $explode_dataf[1];
                    }
                    $mes_de = $explode_datai[1];
                    $ano = $explode_datai[2];
                for($contadora=$mes_de; $contadora<$mes_ate+1;$contadora++){
                    if($contadora>12){
                        if(is_int($ano_meio)){
                            $ano = $ano_meio;
                        }else{
                            $ano = $explode_dataf[2];
                        }
                    }
                    if($contadora>24){
                        $ano = $explode_dataf[2];
                    }
                    if($ano_comparador>0){
                        $mes_ano = " - ".$ano;
                    }else{
                        $mes_ano = '';
                    }
                    if(($contadora=="01")||($contadora=="13")||($contadora=="25")){
                        $dia_de = 01;
                        $dia_ate = 31;
                        if($contadora==$explode_datai[1]){
                            $dia_de = $explode_datai[0];
                        }
                        if($contadora==$mes_ate){
                            $dia_ate = $explode_dataf[0];
                        }

                            $data .= '"Janeiro'.$mes_ano.'",';
                            $filtro_grafico = " AND event_date BETWEEN '".$ano."-01-".$dia_de."' AND '".$ano."-01-".$dia_ate."'";

                            $sql_sel_events_r = "SELECT event_date, clients.name, clients.email FROM events INNER JOIN clients ON events.clients_id=clients.id WHERE status='2' ".$filtro_grafico.$filtro;

                            $sql_sel_events_r_preparado = $conexaobd->prepare($sql_sel_events_r);

                            $sql_sel_events_r_preparado->execute();

                            $cont = $sql_sel_events_r_preparado->rowCount();

                            $quantidade_r .= '"'.$cont.'",';

                            $sql_sel_events_c = "SELECT event_date, clients.name, clients.email FROM canceled_events INNER JOIN clients ON canceled_events.clients_id=clients.id WHERE canceled_events.id=canceled_events.id ".$filtro_grafico.$filtro_ce;

                            $sql_sel_events_c_preparado = $conexaobd->prepare($sql_sel_events_c);

                            $sql_sel_events_c_preparado->execute();

                            $cont = $sql_sel_events_c_preparado->rowCount();

                            $sql_sel_events_c_dados = $sql_sel_events_c_preparado->fetch();

                            $quantidade_c .= '"'.$cont.'",';

                        }else if(($contadora=="02")||($contadora=="14")||($contadora=="26")){
                                $dia_de = 01;
                                $dia_ate = 31;
                                if($contadora==$explode_datai[1]){
                                    $dia_de = $explode_datai[0];
                                }
                                if($contadora==$mes_ate){
                                    $dia_ate = $explode_dataf[0];
                                }

                                $data .= '"Fevereiro'.$mes_ano.'",';

                                $filtro_grafico = " AND event_date BETWEEN '".$ano."-02-".$dia_de."' AND '".$ano."-02-".$dia_ate."'";

                                $sql_sel_events_r = "SELECT event_date, clients.name, clients.email FROM events INNER JOIN clients ON events.clients_id=clients.id WHERE status='2' ".$filtro_grafico.$filtro;

                                $sql_sel_events_r_preparado = $conexaobd->prepare($sql_sel_events_r);

                                $sql_sel_events_r_preparado->execute();

                                $cont = $sql_sel_events_r_preparado->rowCount();

                                $quantidade_r .= '"'.$cont.'",';

                                $sql_sel_events_c = "SELECT event_date, clients.name, clients.email FROM canceled_events INNER JOIN clients ON canceled_events.clients_id=clients.id WHERE canceled_events.id=canceled_events.id ".$filtro_grafico.$filtro_ce;

                                $sql_sel_events_c_preparado = $conexaobd->prepare($sql_sel_events_c);

                                $sql_sel_events_c_preparado->execute();

                                $cont = $sql_sel_events_c_preparado->rowCount();

                                $sql_sel_events_c_dados = $sql_sel_events_c_preparado->fetch();

                                $quantidade_c .= '"'.$cont.'",';

                            }else if(($contadora=="03")||($contadora=="15")||($contadora=="27")){
                                    $dia_de = 01;
                                    $dia_ate = 31;
                                    if($contadora==$explode_datai[1]){
                                        $dia_de = $explode_datai[0];
                                    }
                                    if($contadora==$mes_ate){
                                        $dia_ate = $explode_dataf[0];
                                    }

                                    $data .= '"Março'.$mes_ano.'",';

                                    $filtro_grafico = " AND event_date BETWEEN '".$ano."-03-".$dia_de."' AND '".$ano."-03-".$dia_ate."'";

                                    $sql_sel_events_r = "SELECT event_date, clients.name, clients.email FROM events INNER JOIN clients ON events.clients_id=clients.id WHERE status='2' ".$filtro_grafico.$filtro;

                                    $sql_sel_events_r_preparado = $conexaobd->prepare($sql_sel_events_r);

                                    $sql_sel_events_r_preparado->execute();

                                    $cont = $sql_sel_events_r_preparado->rowCount();

                                    $quantidade_r .= '"'.$cont.'",';

                                    $sql_sel_events_c = "SELECT event_date, clients.name, clients.email FROM canceled_events INNER JOIN clients ON canceled_events.clients_id=clients.id WHERE canceled_events.id=canceled_events.id ".$filtro_grafico.$filtro_ce;

                                    $sql_sel_events_c_preparado = $conexaobd->prepare($sql_sel_events_c);

                                    $sql_sel_events_c_preparado->execute();

                                    $cont = $sql_sel_events_c_preparado->rowCount();

                                    $sql_sel_events_c_dados = $sql_sel_events_c_preparado->fetch();

                                    $quantidade_c .= '"'.$cont.'",';


                                }else if(($contadora=="04")||($contadora=="16")||($contadora=="28")){
                                        $dia_de = 01;
                                        $dia_ate = 31;
                                        if($contadora==$explode_datai[1]){
                                            $dia_de = $explode_datai[0];
                                        }
                                        if($contadora==$mes_ate){
                                            $dia_ate = $explode_dataf[0];
                                        }

                                        $data .= '"Abril'.$mes_ano.'",';

                                        $filtro_grafico = " AND event_date BETWEEN '".$ano."-04-".$dia_de."' AND '".$ano."-04-".$dia_ate."'";

                                        $sql_sel_events_r = "SELECT event_date, clients.name, clients.email FROM events INNER JOIN clients ON events.clients_id=clients.id WHERE status='2' ".$filtro_grafico.$filtro;

                                        $sql_sel_events_r_preparado = $conexaobd->prepare($sql_sel_events_r);

                                        $sql_sel_events_r_preparado->execute();

                                        $cont = $sql_sel_events_r_preparado->rowCount();

                                        $quantidade_r .= '"'.$cont.'",';

                                        $sql_sel_events_c = "SELECT event_date, clients.name, clients.email FROM canceled_events INNER JOIN clients ON canceled_events.clients_id=clients.id WHERE canceled_events.id=canceled_events.id ".$filtro_grafico.$filtro_ce;

                                        $sql_sel_events_c_preparado = $conexaobd->prepare($sql_sel_events_c);

                                        $sql_sel_events_c_preparado->execute();

                                        $cont = $sql_sel_events_c_preparado->rowCount();

                                        $sql_sel_events_c_dados = $sql_sel_events_c_preparado->fetch();

                                        $quantidade_c .= '"'.$cont.'",';


                                    }else if(($contadora=="05")||($contadora=="17")||($contadora=="29")){
                                            $dia_de = 01;
                                            $dia_ate = 31;
                                            if($contadora==$explode_datai[1]){
                                                $dia_de = $explode_datai[0];
                                            }
                                            if($contadora==$mes_ate){
                                                $dia_ate = $explode_dataf[0];
                                            }

                                            $data .= '"Maio'.$mes_ano.'",';

                                            $filtro_grafico = " AND event_date BETWEEN '".$ano."-05-".$dia_de."' AND '".$ano."-05-".$dia_ate."'";

                                            $sql_sel_events_r = "SELECT event_date, clients.name, clients.email FROM events INNER JOIN clients ON events.clients_id=clients.id WHERE status='2' ".$filtro_grafico.$filtro;

                                            $sql_sel_events_r_preparado = $conexaobd->prepare($sql_sel_events_r);

                                            $sql_sel_events_r_preparado->execute();

                                            $cont = $sql_sel_events_r_preparado->rowCount();

                                            $quantidade_r .= '"'.$cont.'",';

                                            $sql_sel_events_c = "SELECT event_date, clients.name, clients.email FROM canceled_events INNER JOIN clients ON canceled_events.clients_id=clients.id WHERE canceled_events.id=canceled_events.id ".$filtro_grafico.$filtro_ce;

                                            $sql_sel_events_c_preparado = $conexaobd->prepare($sql_sel_events_c);

                                            $sql_sel_events_c_preparado->execute();

                                            $cont = $sql_sel_events_c_preparado->rowCount();

                                            $sql_sel_events_c_dados = $sql_sel_events_c_preparado->fetch();

                                            $quantidade_c .= '"'.$cont.'",';

                                        }else if(($contadora=="06")||($contadora=="18")||($contadora=="30")){
                                                $dia_de = 01;
                                                $dia_ate = 31;
                                                if($contadora==$explode_datai[1]){
                                                    $dia_de = $explode_datai[0];
                                                }
                                                if($contadora==$mes_ate){
                                                    $dia_ate = $explode_dataf[0];
                                                }

                                                $data .= '"Junho'.$mes_ano.'",';

                                                $filtro_grafico = " AND event_date BETWEEN '".$ano."-06-".$dia_de."' AND '".$ano."-06-".$dia_ate."'";

                                                $sql_sel_events_r = "SELECT event_date, clients.name, clients.email FROM events INNER JOIN clients ON events.clients_id=clients.id WHERE status='2' ".$filtro_grafico.$filtro;

                                                $sql_sel_events_r_preparado = $conexaobd->prepare($sql_sel_events_r);

                                                $sql_sel_events_r_preparado->execute();

                                                $cont = $sql_sel_events_r_preparado->rowCount();

                                                $quantidade_r .= '"'.$cont.'",';

                                                $sql_sel_events_c = "SELECT event_date, clients.name, clients.email FROM canceled_events INNER JOIN clients ON canceled_events.clients_id=clients.id WHERE canceled_events.id=canceled_events.id ".$filtro_grafico.$filtro_ce;

                                                $sql_sel_events_c_preparado = $conexaobd->prepare($sql_sel_events_c);

                                                $sql_sel_events_c_preparado->execute();

                                                $cont = $sql_sel_events_c_preparado->rowCount();

                                                $sql_sel_events_c_dados = $sql_sel_events_c_preparado->fetch();

                                                $quantidade_c .= '"'.$cont.'",';

                                            }else if(($contadora=="07")||($contadora=="19")||($contadora=="31")){
                                                    $dia_de = 01;
                                                    $dia_ate = 31;
                                                    if($contadora==$explode_datai[1]){
                                                        $dia_de = $explode_datai[0];
                                                    }
                                                    if($contadora==$mes_ate){
                                                        $dia_ate = $explode_dataf[0];
                                                    }

                                                    $data .= '"Julho'.$mes_ano.'",';

                                                    $filtro_grafico = " AND event_date BETWEEN '".$ano."-07-".$dia_de."' AND '".$ano."-07-".$dia_ate."'";

                                                    $sql_sel_events_r = "SELECT event_date, clients.name, clients.email FROM events INNER JOIN clients ON events.clients_id=clients.id WHERE status='2' ".$filtro_grafico.$filtro;

                                                    $sql_sel_events_r_preparado = $conexaobd->prepare($sql_sel_events_r);

                                                    $sql_sel_events_r_preparado->execute();

                                                    $cont = $sql_sel_events_r_preparado->rowCount();

                                                    $quantidade_r .= '"'.$cont.'",';

                                                    $sql_sel_events_c = "SELECT event_date, clients.name, clients.email FROM canceled_events INNER JOIN clients ON canceled_events.clients_id=clients.id WHERE canceled_events.id=canceled_events.id ".$filtro_grafico.$filtro_ce;

                                                    $sql_sel_events_c_preparado = $conexaobd->prepare($sql_sel_events_c);

                                                    $sql_sel_events_c_preparado->execute();

                                                    $cont = $sql_sel_events_c_preparado->rowCount();

                                                    $sql_sel_events_c_dados = $sql_sel_events_c_preparado->fetch();

                                                    $quantidade_c .= '"'.$cont.'",';

                                                }else if(($contadora=="08")||($contadora=="20")||($contadora=="32")){
                                                        $dia_de = 01;
                                                        $dia_ate = 31;
                                                        if($contadora==$explode_datai[1]){
                                                            $dia_de = $explode_datai[0];
                                                        }
                                                        if($contadora==$mes_ate){
                                                            $dia_ate = $explode_dataf[0];
                                                        }

                                                        $data .= '"Agosto'.$mes_ano.'",';

                                                        $filtro_grafico = " AND event_date BETWEEN '".$ano."-08-".$dia_de."' AND '".$ano."-08-".$dia_ate."'";

                                                        $sql_sel_events_r = "SELECT event_date, clients.name, clients.email FROM events INNER JOIN clients ON events.clients_id=clients.id WHERE status='2' ".$filtro_grafico.$filtro;

                                                        $sql_sel_events_r_preparado = $conexaobd->prepare($sql_sel_events_r);

                                                        $sql_sel_events_r_preparado->execute();

                                                        $cont = $sql_sel_events_r_preparado->rowCount();

                                                        $quantidade_r .= '"'.$cont.'",';

                                                        $sql_sel_events_c = "SELECT event_date, clients.name, clients.email FROM canceled_events INNER JOIN clients ON canceled_events.clients_id=clients.id WHERE canceled_events.id=canceled_events.id ".$filtro_grafico.$filtro_ce;

                                                        $sql_sel_events_c_preparado = $conexaobd->prepare($sql_sel_events_c);

                                                        $sql_sel_events_c_preparado->execute();

                                                        $cont = $sql_sel_events_c_preparado->rowCount();

                                                        $sql_sel_events_c_dados = $sql_sel_events_c_preparado->fetch();

                                                        $quantidade_c .= '"'.$cont.'",';

                                                    }else if(($contadora=="09")||($contadora=="21")||($contadora=="33")){
                                                            $dia_de = 01;
                                                            $dia_ate = 31;
                                                            if($contadora==$explode_datai[1]){
                                                                $dia_de = $explode_datai[0];
                                                            }
                                                            if($contadora==$mes_ate){
                                                                $dia_ate = $explode_dataf[0];
                                                            }

                                                            $data .= '"Setembro'.$mes_ano.'",';

                                                            $filtro_grafico = " AND event_date BETWEEN '".$ano."-09-".$dia_de."' AND '".$ano."-09-".$dia_ate."'";

                                                            $sql_sel_events_r = "SELECT event_date, clients.name, clients.email FROM events INNER JOIN clients ON events.clients_id=clients.id WHERE status='2' ".$filtro_grafico.$filtro;

                                                            $sql_sel_events_r_preparado = $conexaobd->prepare($sql_sel_events_r);

                                                            $sql_sel_events_r_preparado->execute();

                                                            $cont = $sql_sel_events_r_preparado->rowCount();

                                                            $quantidade_r .= '"'.$cont.'",';

                                                            $sql_sel_events_c = "SELECT event_date, clients.name, clients.email FROM canceled_events INNER JOIN clients ON canceled_events.clients_id=clients.id WHERE canceled_events.id=canceled_events.id ".$filtro_grafico.$filtro_ce;

                                                            $sql_sel_events_c_preparado = $conexaobd->prepare($sql_sel_events_c);

                                                            $sql_sel_events_c_preparado->execute();

                                                            $cont = $sql_sel_events_c_preparado->rowCount();

                                                            $sql_sel_events_c_dados = $sql_sel_events_c_preparado->fetch();

                                                            $quantidade_c .= '"'.$cont.'",';

                                                        }else if(($contadora=="10")||($contadora=="22")||($contadora=="34")){
                                                                $dia_de = 01;
                                                                $dia_ate = 31;
                                                                if($contadora==$explode_datai[1]){
                                                                    $dia_de = $explode_datai[0];
                                                                }
                                                                if($contadora==$mes_ate){
                                                                    $dia_ate = $explode_dataf[0];
                                                                }

                                                                $data .= '"Outubro'.$mes_ano.'",';

                                                                $filtro_grafico = " AND event_date BETWEEN '".$ano."-10-".$dia_de."' AND '".$ano."-10-".$dia_ate."'";

                                                                $sql_sel_events_r = "SELECT event_date, clients.name, clients.email FROM events INNER JOIN clients ON events.clients_id=clients.id WHERE status='2' ".$filtro_grafico.$filtro;

                                                                $sql_sel_events_r_preparado = $conexaobd->prepare($sql_sel_events_r);

                                                                $sql_sel_events_r_preparado->execute();

                                                                $cont = $sql_sel_events_r_preparado->rowCount();

                                                                $quantidade_r .= '"'.$cont.'",';

                                                                $sql_sel_events_c = "SELECT event_date, clients.name, clients.email FROM canceled_events INNER JOIN clients ON canceled_events.clients_id=clients.id WHERE canceled_events.id=canceled_events.id ".$filtro_grafico.$filtro_ce;

                                                                $sql_sel_events_c_preparado = $conexaobd->prepare($sql_sel_events_c);

                                                                $sql_sel_events_c_preparado->execute();

                                                                $cont = $sql_sel_events_c_preparado->rowCount();

                                                                $sql_sel_events_c_dados = $sql_sel_events_c_preparado->fetch();

                                                                $quantidade_c .= '"'.$cont.'",';

                                                            }else if(($contadora=="11")||($contadora=="23")||($contadora=="35")){
                                                                    $dia_de = 01;
                                                                    $dia_ate = 31;
                                                                    if($contadora==$explode_datai[1]){
                                                                        $dia_de = $explode_datai[0];
                                                                    }
                                                                    if($contadora==$mes_ate){
                                                                        $dia_ate = $explode_dataf[0];
                                                                    }

                                                                    $data .= '"Novembro'.$mes_ano.'",';

                                                                    $filtro_grafico = " AND event_date BETWEEN '".$ano."-11-".$dia_de."' AND '".$ano."-11-".$dia_ate."'";

                                                                    $sql_sel_events_r = "SELECT event_date, clients.name, clients.email FROM events INNER JOIN clients ON events.clients_id=clients.id WHERE status='2' ".$filtro_grafico.$filtro;

                                                                    $sql_sel_events_r_preparado = $conexaobd->prepare($sql_sel_events_r);

                                                                    $sql_sel_events_r_preparado->execute();

                                                                    $cont = $sql_sel_events_r_preparado->rowCount();

                                                                    $quantidade_r .= '"'.$cont.'",';

                                                                    $sql_sel_events_c = "SELECT event_date, clients.name, clients.email FROM canceled_events INNER JOIN clients ON canceled_events.clients_id=clients.id WHERE canceled_events.id=canceled_events.id ".$filtro_grafico.$filtro_ce;

                                                                    $sql_sel_events_c_preparado = $conexaobd->prepare($sql_sel_events_c);

                                                                    $sql_sel_events_c_preparado->execute();

                                                                    $cont = $sql_sel_events_c_preparado->rowCount();

                                                                    $sql_sel_events_c_dados = $sql_sel_events_c_preparado->fetch();

                                                                    $quantidade_c .= '"'.$cont.'",';

                                                                }else if(($contadora=="12")||($contadora=="24")||($contadora=="36")){
                                                                        $dia_de = 01;
                                                                        $dia_ate = 31;
                                                                        if($contadora==$explode_datai[1]){
                                                                            $dia_de = $explode_datai[0];
                                                                        }
                                                                        if($contadora==$mes_ate){
                                                                            $dia_ate = $explode_dataf[0];
                                                                        }

                                                                        $data .= '"Dezembro'.$mes_ano.'",';

                                                                        $filtro_grafico = " AND event_date BETWEEN '".$ano."-12-".$dia_de."' AND '".$ano."-12-".$dia_ate."'";

                                                                        $sql_sel_events_r = "SELECT event_date, clients.name, clients.email FROM events INNER JOIN clients ON events.clients_id=clients.id WHERE status='2' ".$filtro_grafico.$filtro;

                                                                        $sql_sel_events_r_preparado = $conexaobd->prepare($sql_sel_events_r);

                                                                        $sql_sel_events_r_preparado->execute();

                                                                        $cont = $sql_sel_events_r_preparado->rowCount();

                                                                        $quantidade_r .= '"'.$cont.'",';

                                                                        $sql_sel_events_c = "SELECT event_date, clients.name, clients.email FROM canceled_events INNER JOIN clients ON canceled_events.clients_id=clients.id WHERE canceled_events.id=canceled_events.id ".$filtro_grafico.$filtro_ce;

                                                                        $sql_sel_events_c_preparado = $conexaobd->prepare($sql_sel_events_c);

                                                                        $sql_sel_events_c_preparado->execute();

                                                                        $cont = $sql_sel_events_c_preparado->rowCount();

                                                                        $sql_sel_events_c_dados = $sql_sel_events_c_preparado->fetch();

                                                                        $quantidade_c .= '"'.$cont.'",';
                                                                    }
                }


        }else if((isset($explode_datai[2]))&&(!isset($explode_datai[3]))){
        for($contadora=$explode_datai[1]; $contadora<$explode_datai[1]+1;$contadora++){
            if($contadora=="01"){
                $data .= '"Janeiro",';
                $filtro_grafico = " AND event_date LIKE '".$explode_datai[2]."-01-".$explode_datai[0]."'";

                $sql_sel_events_r = "SELECT event_date, clients.name, clients.email FROM events INNER JOIN clients ON events.clients_id=clients.id WHERE status='2' ".$filtro_grafico.$filtro;

                $sql_sel_events_r_preparado = $conexaobd->prepare($sql_sel_events_r);

                $sql_sel_events_r_preparado->execute();

                $cont = $sql_sel_events_r_preparado->rowCount();

                $quantidade_r .= '"'.$cont.'",';

                $sql_sel_events_c = "SELECT event_date, clients.name, clients.email FROM canceled_events INNER JOIN clients ON canceled_events.clients_id=clients.id WHERE canceled_events.id=canceled_events.id ".$filtro_grafico.$filtro_ce;

                $sql_sel_events_c_preparado = $conexaobd->prepare($sql_sel_events_c);

                $sql_sel_events_c_preparado->execute();

                $cont = $sql_sel_events_c_preparado->rowCount();

                $sql_sel_events_c_dados = $sql_sel_events_c_preparado->fetch();

                $quantidade_c .= '"'.$cont.'",';

            }else if($contadora=="02"){
                $data .= '"Fevereiro",';
                $filtro_grafico = " AND event_date LIKE '".$explode_datai[2]."-02-".$explode_datai[0]."'";

                $sql_sel_events_r = "SELECT event_date, clients.name, clients.email FROM events INNER JOIN clients ON events.clients_id=clients.id WHERE status='2' ".$filtro_grafico.$filtro;

                $sql_sel_events_r_preparado = $conexaobd->prepare($sql_sel_events_r);

                $sql_sel_events_r_preparado->execute();

                $cont = $sql_sel_events_r_preparado->rowCount();

                $quantidade_r .= '"'.$cont.'",';

                $sql_sel_events_c = "SELECT event_date, clients.name, clients.email FROM canceled_events INNER JOIN clients ON canceled_events.clients_id=clients.id WHERE canceled_events.id=canceled_events.id ".$filtro_grafico.$filtro_ce;

                $sql_sel_events_c_preparado = $conexaobd->prepare($sql_sel_events_c);

                $sql_sel_events_c_preparado->execute();

                $cont = $sql_sel_events_c_preparado->rowCount();

                $sql_sel_events_c_dados = $sql_sel_events_c_preparado->fetch();

                $quantidade_c .= '"'.$cont.'",';

            }else if($contadora=="03"){
                $data .= '"Março",';
                $filtro_grafico = " AND event_date LIKE '".$explode_datai[2]."-03-".$explode_datai[0]."'";

                $sql_sel_events_r = "SELECT event_date, clients.name, clients.email FROM events INNER JOIN clients ON events.clients_id=clients.id WHERE status='2' ".$filtro_grafico.$filtro;

                $sql_sel_events_r_preparado = $conexaobd->prepare($sql_sel_events_r);

                $sql_sel_events_r_preparado->execute();

                $cont = $sql_sel_events_r_preparado->rowCount();

                $quantidade_r .= '"'.$cont.'",';

                $sql_sel_events_c = "SELECT event_date, clients.name, clients.email FROM canceled_events INNER JOIN clients ON canceled_events.clients_id=clients.id WHERE canceled_events.id=canceled_events.id ".$filtro_grafico.$filtro_ce;

                $sql_sel_events_c_preparado = $conexaobd->prepare($sql_sel_events_c);

                $sql_sel_events_c_preparado->execute();

                $cont = $sql_sel_events_c_preparado->rowCount();

                $sql_sel_events_c_dados = $sql_sel_events_c_preparado->fetch();

                $quantidade_c .= '"'.$cont.'",';


            }else if($contadora=="04"){
                $data .= '"Abril",';
                $filtro_grafico = " AND event_date LIKE '".$explode_datai[2]."-04-".$explode_datai[0]."'";

                $sql_sel_events_r = "SELECT event_date, clients.name, clients.email FROM events INNER JOIN clients ON events.clients_id=clients.id WHERE status='2' ".$filtro_grafico.$filtro;

                $sql_sel_events_r_preparado = $conexaobd->prepare($sql_sel_events_r);

                $sql_sel_events_r_preparado->execute();

                $cont = $sql_sel_events_r_preparado->rowCount();

                $quantidade_r .= '"'.$cont.'",';

                $sql_sel_events_c = "SELECT event_date, clients.name, clients.email FROM canceled_events INNER JOIN clients ON canceled_events.clients_id=clients.id WHERE canceled_events.id=canceled_events.id ".$filtro_grafico.$filtro_ce;

                $sql_sel_events_c_preparado = $conexaobd->prepare($sql_sel_events_c);

                $sql_sel_events_c_preparado->execute();

                $cont = $sql_sel_events_c_preparado->rowCount();

                $sql_sel_events_c_dados = $sql_sel_events_c_preparado->fetch();

                $quantidade_c .= '"'.$cont.'",';


            }else if($contadora=="05"){
                $data .= '"Maio",';
                $filtro_grafico = " AND event_date LIKE '".$explode_datai[2]."-05-".$explode_datai[0]."'";

                $sql_sel_events_r = "SELECT event_date, clients.name, clients.email FROM events INNER JOIN clients ON events.clients_id=clients.id WHERE status='2' ".$filtro_grafico.$filtro;

                $sql_sel_events_r_preparado = $conexaobd->prepare($sql_sel_events_r);

                $sql_sel_events_r_preparado->execute();

                $cont = $sql_sel_events_r_preparado->rowCount();

                $quantidade_r .= '"'.$cont.'",';

                $sql_sel_events_c = "SELECT event_date, clients.name, clients.email FROM canceled_events INNER JOIN clients ON canceled_events.clients_id=clients.id WHERE canceled_events.id=canceled_events.id ".$filtro_grafico.$filtro_ce;

                $sql_sel_events_c_preparado = $conexaobd->prepare($sql_sel_events_c);

                $sql_sel_events_c_preparado->execute();

                $cont = $sql_sel_events_c_preparado->rowCount();

                $sql_sel_events_c_dados = $sql_sel_events_c_preparado->fetch();

                $quantidade_c .= '"'.$cont.'",';

            }else if($contadora=="06"){
                $data .= '"Junho",';
                $filtro_grafico = " AND event_date LIKE '".$explode_datai[2]."-06-".$explode_datai[0]."'";

                $sql_sel_events_r = "SELECT event_date, clients.name, clients.email FROM events INNER JOIN clients ON events.clients_id=clients.id WHERE status='2' ".$filtro_grafico.$filtro;

                $sql_sel_events_r_preparado = $conexaobd->prepare($sql_sel_events_r);

                $sql_sel_events_r_preparado->execute();

                $cont = $sql_sel_events_r_preparado->rowCount();

                $quantidade_r .= '"'.$cont.'",';

                $sql_sel_events_c = "SELECT event_date, clients.name, clients.email FROM canceled_events INNER JOIN clients ON canceled_events.clients_id=clients.id WHERE canceled_events.id=canceled_events.id ".$filtro_grafico.$filtro_ce;

                $sql_sel_events_c_preparado = $conexaobd->prepare($sql_sel_events_c);

                $sql_sel_events_c_preparado->execute();

                $cont = $sql_sel_events_c_preparado->rowCount();

                $sql_sel_events_c_dados = $sql_sel_events_c_preparado->fetch();

                $quantidade_c .= '"'.$cont.'",';

            }else if($contadora=="07"){
                $data .= '"Julho",';
                $filtro_grafico = " AND event_date LIKE '".$explode_datai[2]."-07-".$explode_datai[0]."'";

                $sql_sel_events_r = "SELECT event_date, clients.name, clients.email FROM events INNER JOIN clients ON events.clients_id=clients.id WHERE status='2' ".$filtro_grafico.$filtro;

                $sql_sel_events_r_preparado = $conexaobd->prepare($sql_sel_events_r);

                $sql_sel_events_r_preparado->execute();

                $cont = $sql_sel_events_r_preparado->rowCount();

                $quantidade_r .= '"'.$cont.'",';

                $sql_sel_events_c = "SELECT event_date, clients.name, clients.email FROM canceled_events INNER JOIN clients ON canceled_events.clients_id=clients.id WHERE canceled_events.id=canceled_events.id ".$filtro_grafico.$filtro_ce;

                $sql_sel_events_c_preparado = $conexaobd->prepare($sql_sel_events_c);

                $sql_sel_events_c_preparado->execute();

                $cont = $sql_sel_events_c_preparado->rowCount();

                $sql_sel_events_c_dados = $sql_sel_events_c_preparado->fetch();

                $quantidade_c .= '"'.$cont.'",';

            }else if($contadora=="08"){
                $data .= '"Agosto",';
                $filtro_grafico = " AND event_date LIKE '".$explode_datai[2]."-08-".$explode_datai[0]."'";

                $sql_sel_events_r = "SELECT event_date, clients.name, clients.email FROM events INNER JOIN clients ON events.clients_id=clients.id WHERE status='2' ".$filtro_grafico.$filtro;

                $sql_sel_events_r_preparado = $conexaobd->prepare($sql_sel_events_r);

                $sql_sel_events_r_preparado->execute();

                $cont = $sql_sel_events_r_preparado->rowCount();

                $quantidade_r .= '"'.$cont.'",';

                $sql_sel_events_c = "SELECT event_date, clients.name, clients.email FROM canceled_events INNER JOIN clients ON canceled_events.clients_id=clients.id WHERE canceled_events.id=canceled_events.id ".$filtro_grafico.$filtro_ce;

                $sql_sel_events_c_preparado = $conexaobd->prepare($sql_sel_events_c);

                $sql_sel_events_c_preparado->execute();

                $cont = $sql_sel_events_c_preparado->rowCount();

                $sql_sel_events_c_dados = $sql_sel_events_c_preparado->fetch();

                $quantidade_c .= '"'.$cont.'",';

            }else if($contadora=="09"){
                $data .= '"Setembro",';
                $filtro_grafico = " AND event_date LIKE '".$explode_datai[2]."-09-".$explode_datai[0]."'";
                $sql_sel_events_r = "SELECT event_date, clients.name, clients.email FROM events INNER JOIN clients ON events.clients_id=clients.id WHERE status='2' ".$filtro_grafico.$filtro;

                $sql_sel_events_r_preparado = $conexaobd->prepare($sql_sel_events_r);

                $sql_sel_events_r_preparado->execute();

                $cont = $sql_sel_events_r_preparado->rowCount();

                $quantidade_r .= '"'.$cont.'",';

                $sql_sel_events_c = "SELECT event_date, clients.name, clients.email FROM canceled_events INNER JOIN clients ON canceled_events.clients_id=clients.id WHERE canceled_events.id=canceled_events.id ".$filtro_grafico.$filtro_ce;

                $sql_sel_events_c_preparado = $conexaobd->prepare($sql_sel_events_c);

                $sql_sel_events_c_preparado->execute();

                $cont = $sql_sel_events_c_preparado->rowCount();

                $sql_sel_events_c_dados = $sql_sel_events_c_preparado->fetch();

                $quantidade_c .= '"'.$cont.'",';

            }else if($contadora=="10"){
                $data .= '"Outubro",';
                $filtro_grafico = " AND event_date LIKE '".$explode_datai[2]."-10-".$explode_datai[0]."'";
                $sql_sel_events_r = "SELECT event_date, clients.name, clients.email FROM events INNER JOIN clients ON events.clients_id=clients.id WHERE status='2' ".$filtro_grafico.$filtro;

                $sql_sel_events_r_preparado = $conexaobd->prepare($sql_sel_events_r);

                $sql_sel_events_r_preparado->execute();

                $cont = $sql_sel_events_r_preparado->rowCount();

                $quantidade_r .= '"'.$cont.'",';

                $sql_sel_events_c = "SELECT event_date, clients.name, clients.email FROM canceled_events INNER JOIN clients ON canceled_events.clients_id=clients.id WHERE canceled_events.id=canceled_events.id ".$filtro_grafico.$filtro_ce;

                $sql_sel_events_c_preparado = $conexaobd->prepare($sql_sel_events_c);

                $sql_sel_events_c_preparado->execute();

                $cont = $sql_sel_events_c_preparado->rowCount();

                $sql_sel_events_c_dados = $sql_sel_events_c_preparado->fetch();

                $quantidade_c .= '"'.$cont.'",';

            }else if($contadora=="11"){
                $data .= '"Novembro",';
                $filtro_grafico = " AND event_date LIKE '".$explode_datai[2]."-11-".$explode_datai[0]."'";

                $sql_sel_events_r = "SELECT event_date, clients.name, clients.email FROM events INNER JOIN clients ON events.clients_id=clients.id WHERE status='2' ".$filtro_grafico.$filtro;

                $sql_sel_events_r_preparado = $conexaobd->prepare($sql_sel_events_r);

                $sql_sel_events_r_preparado->execute();

                $cont = $sql_sel_events_r_preparado->rowCount();

                $quantidade_r .= '"'.$cont.'",';

                $sql_sel_events_c = "SELECT event_date, clients.name, clients.email FROM canceled_events INNER JOIN clients ON canceled_events.clients_id=clients.id WHERE canceled_events.id=canceled_events.id ".$filtro_grafico.$filtro_ce;

                $sql_sel_events_c_preparado = $conexaobd->prepare($sql_sel_events_c);

                $sql_sel_events_c_preparado->execute();

                $cont = $sql_sel_events_c_preparado->rowCount();

                $sql_sel_events_c_dados = $sql_sel_events_c_preparado->fetch();

                $quantidade_c .= '"'.$cont.'",';

            }else if($contadora=="12"){
                $data .= '"Dezembro",';
                $filtro_grafico = " AND event_date LIKE '".$explode_datai[2]."-12-".$explode_datai[0]."'";

                $sql_sel_events_r = "SELECT event_date, clients.name, clients.email FROM events INNER JOIN clients ON events.clients_id=clients.id WHERE status='2' ".$filtro_grafico.$filtro;

                $sql_sel_events_r_preparado = $conexaobd->prepare($sql_sel_events_r);

                $sql_sel_events_r_preparado->execute();

                $cont = $sql_sel_events_r_preparado->rowCount();

                $quantidade_r .= '"'.$cont.'",';

                $sql_sel_events_c = "SELECT event_date, clients.name, clients.email FROM canceled_events INNER JOIN clients ON canceled_events.clients_id=clients.id WHERE canceled_events.id=canceled_events.id ".$filtro_grafico.$filtro_ce;

                $sql_sel_events_c_preparado = $conexaobd->prepare($sql_sel_events_c);

                $sql_sel_events_c_preparado->execute();

                $cont = $sql_sel_events_c_preparado->rowCount();

                $sql_sel_events_c_dados = $sql_sel_events_c_preparado->fetch();

                $quantidade_c .= '"'.$cont.'",';
            }
        }
            }else if((isset($explode_dataf[2]))&&(!isset($explode_dataf[3]))){
        for($contadora=$explode_dataf[1]; $contadora<$explode_dataf[1]+1;$contadora++){
            if($contadora=="01"){
                $data .= '"Janeiro",';
                $filtro_grafico = " AND event_date LIKE '".$explode_dataf[2]."-01-".$explode_dataf[0]."'";

                $sql_sel_events_r = "SELECT event_date, clients.name, clients.email FROM events INNER JOIN clients ON events.clients_id=clients.id WHERE status='2' ".$filtro_grafico.$filtro;

                $sql_sel_events_r_preparado = $conexaobd->prepare($sql_sel_events_r);

                $sql_sel_events_r_preparado->execute();

                $cont = $sql_sel_events_r_preparado->rowCount();

                $quantidade_r .= '"'.$cont.'",';

                $sql_sel_events_c = "SELECT event_date, clients.name, clients.email FROM canceled_events INNER JOIN clients ON canceled_events.clients_id=clients.id WHERE canceled_events.id=canceled_events.id ".$filtro_grafico.$filtro_ce;

                $sql_sel_events_c_preparado = $conexaobd->prepare($sql_sel_events_c);

                $sql_sel_events_c_preparado->execute();

                $cont = $sql_sel_events_c_preparado->rowCount();

                $sql_sel_events_c_dados = $sql_sel_events_c_preparado->fetch();

                $quantidade_c .= '"'.$cont.'",';

            }else if($contadora=="02"){
                $data .= '"Fevereiro",';
                $filtro_grafico = " AND event_date LIKE '".$explode_dataf[2]."-02-".$explode_dataf[0]."'";

                $sql_sel_events_r = "SELECT event_date, clients.name, clients.email FROM events INNER JOIN clients ON events.clients_id=clients.id WHERE status='2' ".$filtro_grafico.$filtro;

                $sql_sel_events_r_preparado = $conexaobd->prepare($sql_sel_events_r);

                $sql_sel_events_r_preparado->execute();

                $cont = $sql_sel_events_r_preparado->rowCount();

                $quantidade_r .= '"'.$cont.'",';

                $sql_sel_events_c = "SELECT event_date, clients.name, clients.email FROM canceled_events INNER JOIN clients ON canceled_events.clients_id=clients.id WHERE canceled_events.id=canceled_events.id ".$filtro_grafico.$filtro_ce;

                $sql_sel_events_c_preparado = $conexaobd->prepare($sql_sel_events_c);

                $sql_sel_events_c_preparado->execute();

                $cont = $sql_sel_events_c_preparado->rowCount();

                $sql_sel_events_c_dados = $sql_sel_events_c_preparado->fetch();

                $quantidade_c .= '"'.$cont.'",';

            }else if($contadora=="03"){
                $data .= '"Março",';
                $filtro_grafico = " AND event_date LIKE '".$explode_dataf[2]."-03-".$explode_dataf[0]."'";

                $sql_sel_events_r = "SELECT event_date, clients.name, clients.email FROM events INNER JOIN clients ON events.clients_id=clients.id WHERE status='2' ".$filtro_grafico.$filtro;

                $sql_sel_events_r_preparado = $conexaobd->prepare($sql_sel_events_r);

                $sql_sel_events_r_preparado->execute();

                $cont = $sql_sel_events_r_preparado->rowCount();

                $quantidade_r .= '"'.$cont.'",';

                $sql_sel_events_c = "SELECT event_date, clients.name, clients.email FROM canceled_events INNER JOIN clients ON canceled_events.clients_id=clients.id WHERE canceled_events.id=canceled_events.id ".$filtro_grafico.$filtro_ce;

                $sql_sel_events_c_preparado = $conexaobd->prepare($sql_sel_events_c);

                $sql_sel_events_c_preparado->execute();

                $cont = $sql_sel_events_c_preparado->rowCount();

                $sql_sel_events_c_dados = $sql_sel_events_c_preparado->fetch();

                $quantidade_c .= '"'.$cont.'",';


            }else if($contadora=="04"){
                $data .= '"Abril",';
                $filtro_grafico = " AND event_date LIKE '".$explode_dataf[2]."-04-".$explode_dataf[0]."'";

                $sql_sel_events_r = "SELECT event_date, clients.name, clients.email FROM events INNER JOIN clients ON events.clients_id=clients.id WHERE status='2' ".$filtro_grafico.$filtro;

                $sql_sel_events_r_preparado = $conexaobd->prepare($sql_sel_events_r);

                $sql_sel_events_r_preparado->execute();

                $cont = $sql_sel_events_r_preparado->rowCount();

                $quantidade_r .= '"'.$cont.'",';

                $sql_sel_events_c = "SELECT event_date, clients.name, clients.email FROM canceled_events INNER JOIN clients ON canceled_events.clients_id=clients.id WHERE canceled_events.id=canceled_events.id ".$filtro_grafico.$filtro_ce;

                $sql_sel_events_c_preparado = $conexaobd->prepare($sql_sel_events_c);

                $sql_sel_events_c_preparado->execute();

                $cont = $sql_sel_events_c_preparado->rowCount();

                $sql_sel_events_c_dados = $sql_sel_events_c_preparado->fetch();

                $quantidade_c .= '"'.$cont.'",';


            }else if($contadora=="05"){
                $data .= '"Maio",';
                $filtro_grafico = " AND event_date LIKE '".$explode_dataf[2]."-05-".$explode_dataf[0]."'";

                $sql_sel_events_r = "SELECT event_date, clients.name, clients.email FROM events INNER JOIN clients ON events.clients_id=clients.id WHERE status='2' ".$filtro_grafico.$filtro;

                $sql_sel_events_r_preparado = $conexaobd->prepare($sql_sel_events_r);

                $sql_sel_events_r_preparado->execute();

                $cont = $sql_sel_events_r_preparado->rowCount();

                $quantidade_r .= '"'.$cont.'",';

                $sql_sel_events_c = "SELECT event_date, clients.name, clients.email FROM canceled_events INNER JOIN clients ON canceled_events.clients_id=clients.id WHERE canceled_events.id=canceled_events.id ".$filtro_grafico.$filtro_ce;

                $sql_sel_events_c_preparado = $conexaobd->prepare($sql_sel_events_c);

                $sql_sel_events_c_preparado->execute();

                $cont = $sql_sel_events_c_preparado->rowCount();

                $sql_sel_events_c_dados = $sql_sel_events_c_preparado->fetch();

                $quantidade_c .= '"'.$cont.'",';

            }else if($contadora=="06"){
                $data .= '"Junho",';
                $filtro_grafico = " AND event_date LIKE '".$explode_dataf[2]."-06-".$explode_dataf[0]."'";

                $sql_sel_events_r = "SELECT event_date, clients.name, clients.email FROM events INNER JOIN clients ON events.clients_id=clients.id WHERE status='2' ".$filtro_grafico.$filtro;

                $sql_sel_events_r_preparado = $conexaobd->prepare($sql_sel_events_r);

                $sql_sel_events_r_preparado->execute();

                $cont = $sql_sel_events_r_preparado->rowCount();

                $quantidade_r .= '"'.$cont.'",';

                $sql_sel_events_c = "SELECT event_date, clients.name, clients.email FROM canceled_events INNER JOIN clients ON canceled_events.clients_id=clients.id WHERE canceled_events.id=canceled_events.id ".$filtro_grafico.$filtro_ce;

                $sql_sel_events_c_preparado = $conexaobd->prepare($sql_sel_events_c);

                $sql_sel_events_c_preparado->execute();

                $cont = $sql_sel_events_c_preparado->rowCount();

                $sql_sel_events_c_dados = $sql_sel_events_c_preparado->fetch();

                $quantidade_c .= '"'.$cont.'",';

            }else if($contadora=="07"){
                $data .= '"Julho",';
                $filtro_grafico = " AND event_date LIKE '".$explode_dataf[2]."-07-".$explode_dataf[0]."'";

                $sql_sel_events_r = "SELECT event_date, clients.name, clients.email FROM events INNER JOIN clients ON events.clients_id=clients.id WHERE status='2' ".$filtro_grafico.$filtro;

                $sql_sel_events_r_preparado = $conexaobd->prepare($sql_sel_events_r);

                $sql_sel_events_r_preparado->execute();

                $cont = $sql_sel_events_r_preparado->rowCount();

                $quantidade_r .= '"'.$cont.'",';

                $sql_sel_events_c = "SELECT event_date, clients.name, clients.email FROM canceled_events INNER JOIN clients ON canceled_events.clients_id=clients.id WHERE canceled_events.id=canceled_events.id ".$filtro_grafico.$filtro_ce;

                $sql_sel_events_c_preparado = $conexaobd->prepare($sql_sel_events_c);

                $sql_sel_events_c_preparado->execute();

                $cont = $sql_sel_events_c_preparado->rowCount();

                $sql_sel_events_c_dados = $sql_sel_events_c_preparado->fetch();

                $quantidade_c .= '"'.$cont.'",';

            }else if($contadora=="08"){
                $data .= '"Agosto",';
                $filtro_grafico = " AND event_date LIKE '".$explode_dataf[2]."-08-".$explode_dataf[0]."'";

                $sql_sel_events_r = "SELECT event_date, clients.name, clients.email FROM events INNER JOIN clients ON events.clients_id=clients.id WHERE status='2' ".$filtro_grafico.$filtro;

                $sql_sel_events_r_preparado = $conexaobd->prepare($sql_sel_events_r);

                $sql_sel_events_r_preparado->execute();

                $cont = $sql_sel_events_r_preparado->rowCount();

                $quantidade_r .= '"'.$cont.'",';

                $sql_sel_events_c = "SELECT event_date, clients.name, clients.email FROM canceled_events INNER JOIN clients ON canceled_events.clients_id=clients.id WHERE canceled_events.id=canceled_events.id ".$filtro_grafico.$filtro_ce;

                $sql_sel_events_c_preparado = $conexaobd->prepare($sql_sel_events_c);

                $sql_sel_events_c_preparado->execute();

                $cont = $sql_sel_events_c_preparado->rowCount();

                $sql_sel_events_c_dados = $sql_sel_events_c_preparado->fetch();

                $quantidade_c .= '"'.$cont.'",';

            }else if($contadora=="09"){
                $data .= '"Setembro",';
                $filtro_grafico = " AND event_date LIKE '".$explode_dataf[2]."-09-".$explode_dataf[0]."'";
                $sql_sel_events_r = "SELECT event_date, clients.name, clients.email FROM events INNER JOIN clients ON events.clients_id=clients.id WHERE status='2' ".$filtro_grafico.$filtro;

                $sql_sel_events_r_preparado = $conexaobd->prepare($sql_sel_events_r);

                $sql_sel_events_r_preparado->execute();

                $cont = $sql_sel_events_r_preparado->rowCount();

                $quantidade_r .= '"'.$cont.'",';

                $sql_sel_events_c = "SELECT event_date, clients.name, clients.email FROM canceled_events INNER JOIN clients ON canceled_events.clients_id=clients.id WHERE canceled_events.id=canceled_events.id ".$filtro_grafico.$filtro_ce;

                $sql_sel_events_c_preparado = $conexaobd->prepare($sql_sel_events_c);

                $sql_sel_events_c_preparado->execute();

                $cont = $sql_sel_events_c_preparado->rowCount();

                $sql_sel_events_c_dados = $sql_sel_events_c_preparado->fetch();

                $quantidade_c .= '"'.$cont.'",';

            }else if($contadora=="10"){
                $data .= '"Outubro",';
                $filtro_grafico = " AND event_date LIKE '".$explode_dataf[2]."-10-".$explode_dataf[0]."'";
                $sql_sel_events_r = "SELECT event_date, clients.name, clients.email FROM events INNER JOIN clients ON events.clients_id=clients.id WHERE status='2' ".$filtro_grafico.$filtro;

                $sql_sel_events_r_preparado = $conexaobd->prepare($sql_sel_events_r);

                $sql_sel_events_r_preparado->execute();

                $cont = $sql_sel_events_r_preparado->rowCount();

                $quantidade_r .= '"'.$cont.'",';

                $sql_sel_events_c = "SELECT event_date, clients.name, clients.email FROM canceled_events INNER JOIN clients ON canceled_events.clients_id=clients.id WHERE canceled_events.id=canceled_events.id ".$filtro_grafico.$filtro_ce;

                $sql_sel_events_c_preparado = $conexaobd->prepare($sql_sel_events_c);

                $sql_sel_events_c_preparado->execute();

                $cont = $sql_sel_events_c_preparado->rowCount();

                $sql_sel_events_c_dados = $sql_sel_events_c_preparado->fetch();

                $quantidade_c .= '"'.$cont.'",';

            }else if($contadora=="11"){
                $data .= '"Novembro",';

                $filtro_grafico = " AND event_date LIKE '".$explode_dataf[2]."-11-".$explode_dataf[0]."'";

                $sql_sel_events_r = "SELECT event_date, clients.name, clients.email FROM events INNER JOIN clients ON events.clients_id=clients.id WHERE status='2' ".$filtro_grafico.$filtro;

                $sql_sel_events_r_preparado = $conexaobd->prepare($sql_sel_events_r);

                $sql_sel_events_r_preparado->execute();

                $cont = $sql_sel_events_r_preparado->rowCount();

                $quantidade_r .= '"'.$cont.'",';

                $sql_sel_events_c = "SELECT event_date, clients.name, clients.email FROM canceled_events INNER JOIN clients ON canceled_events.clients_id=clients.id WHERE canceled_events.id=canceled_events.id ".$filtro_grafico.$filtro_ce;

                $sql_sel_events_c_preparado = $conexaobd->prepare($sql_sel_events_c);

                $sql_sel_events_c_preparado->execute();

                $cont = $sql_sel_events_c_preparado->rowCount();

                $sql_sel_events_c_dados = $sql_sel_events_c_preparado->fetch();

                $quantidade_c .= '"'.$cont.'",';

            }else if($contadora=="12"){
                $data .= '"Dezembro",';

                $filtro_grafico = " AND event_date LIKE '".$explode_dataf[2]."-12-".$explode_dataf[0]."'";

                $sql_sel_events_r = "SELECT event_date, clients.name, clients.email FROM events INNER JOIN clients ON events.clients_id=clients.id WHERE status='2' ".$filtro_grafico.$filtro;

                $sql_sel_events_r_preparado = $conexaobd->prepare($sql_sel_events_r);

                $sql_sel_events_r_preparado->execute();

                $cont = $sql_sel_events_r_preparado->rowCount();

                $quantidade_r .= '"'.$cont.'",';

                $sql_sel_events_c = "SELECT event_date, clients.name, clients.email FROM canceled_events INNER JOIN clients ON canceled_events.clients_id=clients.id WHERE canceled_events.id=canceled_events.id ".$filtro_grafico.$filtro_ce;

                $sql_sel_events_c_preparado = $conexaobd->prepare($sql_sel_events_c);

                $sql_sel_events_c_preparado->execute();

                $cont = $sql_sel_events_c_preparado->rowCount();

                $sql_sel_events_c_dados = $sql_sel_events_c_preparado->fetch();

                $quantidade_c .= '"'.$cont.'",';
            }
        }
    }

?>
<script>
    $( document ).ready(function() {
        var ctx = document.getElementById("chart_events");
        var chart_events = new Chart(ctx, {
            type: 'line',
            data: {
                labels: [<?php echo $data;?>],
                datasets: [{
                    label: 'Quantidade de Eventos Cancelados',
                    data: [<?php echo $quantidade_c;?>],
                    backgroundColor: 'rgba(54, 162, 235, 0)',
                    borderColor: '#FF0000',
                    borderWidth: 2,
                    pointBorderColor: "#B7B7B7",
                    pointBackgroundColor: "#FF0000",
                    pointBorderWidth: 2,
                    pointHoverRadius: 2,
                    pointHoverBackgroundColor: "#FF0000",
                    pointHoverBorderColor: "#B7B7B7",
                    pointRadius: 3,
                    pointHitRadius: 3,
                }, {
                    label: 'Quantidade de Eventos Realizados',
                    data: [<?php echo $quantidade_r;?>],
                    backgroundColor: 'rgba(54, 162, 235, 0)',
                    borderColor: '#00CC00',
                    borderWidth: 3,
                    pointBorderColor: "#fff",
                    pointBackgroundColor: "#00CC00",
                    pointBorderWidth: 3,
                    pointHoverRadius: 3,
                    pointHoverBackgroundColor: "#00CC00",
                    pointHoverBorderColor: "#fff",
                    pointRadius: 4,
                    pointHitRadius: 4,
                }, ]
            },
            options: {
                legend: {
                    display: false,
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero:true,
                            stepSize:1
                        }
                    }]
                }
            }
        });


    });

</script>