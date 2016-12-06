<?php

    include "../../security/database/cb_connection_database.php";
    //Incluida a página que faz a conexão com o banco de dados.

    $id = $_POST['id'];
    //Variável id recebe o id do ajax via POST.

    //Este é responsável por fazer a seleção de tudo da tabela clients, o nome do districts, o nome da cities da tabela clients juntando com a tabela districts se o districts_id da clients for igual ao id da districts juntando com a tabela cities se o cities_id da tabela districts for igual ao id da cities, quando o id do clients for igual ao recebido da outra página.
    $sql_sel_canceled_events = "SELECT canceled_events.*, (clients.name) AS nome_cliente, clients.email, clients.phone FROM canceled_events INNER JOIN clients ON canceled_events.clients_id=clients.id WHERE canceled_events.id='".$id."' GROUP BY canceled_events.id";

    $sql_sel_canceled_events_preparado = $conexaobd->prepare($sql_sel_canceled_events);

    $sql_sel_canceled_events_preparado->execute();

    $sql_sel_canceled_events_dados = $sql_sel_canceled_events_preparado->fetch();

    $nome = $sql_sel_canceled_events_dados['nome_cliente'];

    $email = $sql_sel_canceled_events_dados['email'];

    $fone = $sql_sel_canceled_events_dados['phone'];

    if($sql_sel_canceled_events_dados['local']==1){
        $local = "Local do Cliente";
    }else if($sql_sel_canceled_events_dados['local']==2){
        $local = "Local Externo";
    }else{

        $sql_sel_locals = "SELECT name FROM locals WHERE id='".$sql_sel_canceled_events_dados['locals_id']."'";

        $sql_sel_locals_preparado = $conexaobd->prepare($sql_sel_locals);

        $sql_sel_locals_preparado->execute();

        $sql_sel_locals_dados = $sql_sel_locals_preparado->fetch();

        $local = $sql_sel_locals_dados['name'];

    }

    if($sql_sel_canceled_events_dados['repaymant']!=NULL){
        $ressarcimento_valor = $sql_sel_canceled_events_dados['repaymant'];
    }else{
        $ressarcimento_valor = 0;
    }

    $ressarcimento_resultado = $ressarcimento_valor;

    $ressarcimento_explode = explode('.', $ressarcimento_resultado);

    $cont_r = count($ressarcimento_explode);

    for($contadora=0; $contadora<$cont_r; $contadora++){

        $ressarcimento = 0;

        if($contadora==1){
            if(($ressarcimento_explode[$contadora]<10)&&($ressarcimento_explode[$contadora]!=00)){
                $centavos = "".$ressarcimento_explode[$contadora]."0";
            }else{
                $centavos = $ressarcimento_explode[$contadora];
            }
        }else{
            $centavos = '00';
        }


        $ressarcimento = "R$".$ressarcimento_explode[0].",".$centavos;

    }

    if($sql_sel_canceled_events_dados['forfeit']!=NULL){
        $multa_valor = $sql_sel_canceled_events_dados['forfeit'];
    }else{
        $multa_valor = 0;
    }

    $multa_resultado = $multa_valor;

    $multa_explode = explode('.', $multa_resultado);

    $cont_m = count($multa_explode);

    for($contadora=0; $contadora<$cont_m; $contadora++){

        $multa = 0;

        if($contadora==1){
            if(($multa_explode[$contadora]<10)&&($multa_explode[$contadora]!=00)){
                $centavos = "".$multa_explode[$contadora]."0";
            }else{
                $centavos = $multa_explode[$contadora];
            }
        }else{
            $centavos = '00';
        }


        $multa = "R$".$multa_explode[0].",".$centavos;

    }



    if($sql_sel_canceled_events_dados['comment']==NULL){
        $comentario = "Não há descrição!";
    }else{
        $comentario = $sql_sel_canceled_events_dados['comment'];
    }

    $razao_resultado = $sql_sel_canceled_events_dados['reason'];

    if($razao_resultado=="FI"){
        $razao = "Financeiro";
    }else if($razao_resultado=="IN"){
            $razao = "Insatisfação";
        }else if($razao_resultado=="EI"){
                $razao = "Evento mais importante";
            }else if($razao_resultado=="AF"){
                    $razao = "Adversidade familiar";
                }else if($razao_resultado=="OT"){
                        $razao = "Outros";
                    }

    $data_explode = explode('-', $sql_sel_canceled_events_dados['event_date']);

    $data = $data_explode[2]."/".$data_explode[1]."/".$data_explode[0];

    $valor = array(
        'nome'=>$nome,
        'email'=>$email,
        'fone'=>$fone,
        'local'=>$local,
        'comentario'=>$comentario,
        'razao'=>$razao,
        'data'=> $data,
        'ressarcimento'=> $ressarcimento,
        'multa'=>$multa
    );

    echo json_encode($valor);
    //Manda a array pro ajax de volta.


?>