<?php

include "../../security/database/cb_connection_database.php";
//Incluida a página que faz a conexão com o banco de dados.

$id = $_POST['id'];
//Variável id recebe o id do ajax via POST.

//Este é responsável por fazer a seleção de tudo da tabela clients, o nome do districts, o nome da cities da tabela clients juntando com a tabela districts se o districts_id da clients for igual ao id da districts juntando com a tabela cities se o cities_id da tabela districts for igual ao id da cities, quando o id do clients for igual ao recebido da outra página.
$sql_sel_events = "SELECT events.*, events.clients_id, (clients.name) AS nome_cliente, clients.email, clients.phone, clients.rg, clients.birthdate, clients.cpf, (cities.name) AS cidade_nome, districts.name AS bairro_nome FROM events INNER JOIN clients ON events.clients_id=clients.id INNER JOIN districts ON events.districts_id=districts.id INNER JOIN cities ON districts.cities_id=cities.id WHERE events.id='".$id."' GROUP BY events.id";

$sql_sel_events_preparado = $conexaobd->prepare($sql_sel_events);

$sql_sel_events_preparado->execute();

$sql_sel_events_dados = $sql_sel_events_preparado->fetch();

$nome = $sql_sel_events_dados['nome_cliente'];

$email = $sql_sel_events_dados['email'];

$fone = $sql_sel_events_dados['phone'];

if($sql_sel_events_dados['observation']==NULL){
    $observacao = "Não há observação!";
}else{
    $observacao = $sql_sel_events_dados['observation'];
}

if($sql_sel_events_dados['local']==1){
    $local = "Local do Cliente";
}else if($sql_sel_events_dados['local']==2){
    $local = "Local Externo";
}else{

    $sql_sel_locals = "SELECT name FROM locals WHERE id='".$sql_sel_events_dados['locals_id']."'";

    $sql_sel_locals_preparado = $conexaobd->prepare($sql_sel_locals);

    $sql_sel_locals_preparado->execute();

    $sql_sel_locals_dados = $sql_sel_locals_preparado->fetch();

    $local = $sql_sel_locals_dados['name'];

}

$cep = $sql_sel_events_dados['cep'];

$cidade = $sql_sel_events_dados['cidade_nome'];

$bairro = $sql_sel_events_dados['bairro_nome'];

$logradouro = $sql_sel_events_dados['street'];

$num = $sql_sel_events_dados['number'];

if($sql_sel_events_dados['complement']==NULL){
    $complemento = 'Não há complemento!';
}else{
    $complemento = $sql_sel_events_dados['complement'];
}

$data_explode = explode('-', $sql_sel_events_dados['event_date']);

$data = $data_explode[2]."/".$data_explode[1]."/".$data_explode[0];

$horario_explode = explode(':', $sql_sel_events_dados['event_time']);

$horario = $horario_explode[0].":".$horario_explode[1];

$sql_sel_events_has_kits = "SELECT events_has_kits.kits_id, events_has_kits.kit_quantity, events_has_kits.actual_value, kits.name, kits.discount FROM events_has_kits INNER JOIN kits ON events_has_kits.kits_id=kits.id WHERE events_id='".$id."'";

$sql_sel_events_has_kits_preparado = $conexaobd->prepare($sql_sel_events_has_kits);

$sql_sel_events_has_kits_preparado->execute();

$contadora_kit = $sql_sel_events_has_kits_preparado->rowCount();

$resultado_k2 = "";

$valor_kit = 0;

$desconto = 0;

if($contadora_kit==0){
    $resultado_k2 = "Não há kits!";
}else{


while($sql_sel_events_has_kits_dados = $sql_sel_events_has_kits_preparado->fetch()){

    $kit = $sql_sel_events_has_kits_dados['name'];

    $quantidade_k = $sql_sel_events_has_kits_dados['kit_quantity'];

    $resultado_k = '<tr><td>'.$kit.'('.$quantidade_k.')</td></tr>';

    $resultado_k2 = $resultado_k.$resultado_k2;

    $valor_k = $quantidade_k * $sql_sel_events_has_kits_dados['actual_value'];

    $valor_kit = $valor_k + $valor_kit;

}
}
$resultado_kit = array('kit'=>$resultado_k2);

$sql_sel_events_has_items = "SELECT events_has_items.items_id, events_has_items.item_quantity, events_has_items.actual_value, items.name FROM events_has_items INNER JOIN items ON events_has_items.items_id=items.id WHERE events_id='".$id."'";

$sql_sel_events_has_items_preparado = $conexaobd->prepare($sql_sel_events_has_items);

$sql_sel_events_has_items_preparado->execute();

$contadora_itens = $sql_sel_events_has_items_preparado->rowCount();

$resultado_i2 = "";

$valor_item = 0;

if($contadora_itens==0){
    $resultado_i2 = "Não há kits!";
}else {


    while ($sql_sel_events_has_items_dados = $sql_sel_events_has_items_preparado->fetch()) {

        $item = $sql_sel_events_has_items_dados['name'];

        $quantidade_i = $sql_sel_events_has_items_dados['item_quantity'];

        $resultado_i = '<tr><td>' . $item . '(' . $quantidade_i . ')</td></tr>';

        $resultado_i2 = $resultado_i . $resultado_i2;

        $valor_i = $quantidade_i * $sql_sel_events_has_items_dados['actual_value'];

        $valor_item = $valor_i + $valor_item;

    }
}
$resultado_item = array('item'=>$resultado_i2);

$valor_real_resultado = $valor_kit + $valor_item;

$valor_real_explode = explode('.', $valor_real_resultado);

$cont = count($valor_real_explode);

for($contadora=0; $contadora<$cont; $contadora++){

    $valor_real = 0;

    if($contadora==1){
        if($valor_real_explode[$contadora]<10){
            $centavos = "".$valor_real_explode[$contadora]."0";
        }else{
            $centavos = $valor_real_explode[$contadora];
        }
    }else{
        $centavos = '00';
    }


    $valor_real = "R$".$valor_real_explode[0].",".$centavos;

}

$valor_final_resultado = ($valor_real_resultado + $sql_sel_events_dados['delivery_fee'] + $sql_sel_events_dados['rent_value']) - $sql_sel_events_dados['discount'];

$valor_final_explode = explode('.', $valor_final_resultado);

$cont_f = count($valor_final_explode);

for($contadora=0; $contadora<$cont_f; $contadora++){

    $valor_final = 0;

    if($contadora==1){
        if($valor_final_explode[$contadora]<10){
            $centavos = "".$valor_final_explode[$contadora]."0";
        }else{
            $centavos = $valor_final_explode[$contadora];
        }
    }else{
        $centavos = '00';
    }


    $valor_final = "R$".$valor_final_explode[0].",".$centavos;

}

$resultado = array(

    'nome'=>$nome,
    'email'=>$email,
    'fone'=>$fone,
    'local'=>$local,
    'cep'=>$cep,
    'cidade'=>$cidade,
    'bairro'=>$bairro,
    'logradouro'=>$logradouro,
    'num'=>$num,
    'complemento'=>$complemento,
    'data'=> $data,
    'horario'=> $horario,
    'valor_real'=>$valor_real,
    'valor_final'=>$valor_final,
    'observacao'=>$observacao
);

$valor = $resultado + $resultado_kit + $resultado_item;

echo json_encode($valor);
//Manda a array pro ajax de volta.

?>