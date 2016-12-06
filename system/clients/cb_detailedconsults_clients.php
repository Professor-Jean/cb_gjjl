<?php
    include "../../security/database/cb_connection_database.php";
    //Incluida a página que faz a conexão com o banco de dados.

    $id = $_POST['id'];
    //Variável id recebe o id do ajax via POST.

    //Este bloco é responsável por fazer a seleção de tudo da tabela clients, o nome do districts, o nome da cities da tabela clients juntando com a tabela districts se o districts_id da clients for igual ao id da districts juntando com a tabela cities se o cities_id da tabela districts for igual ao id da cities, quando o id do clients for igual ao recebido da outra página.
    $sql_sel_clients = "SELECT clients.*, districts.name AS districtsname, cities.name AS citiesname  FROM clients INNER JOIN districts ON clients.districts_id=districts.id INNER JOIN cities ON districts.cities_id=cities.id WHERE clients.id='".$id."'";
    $sql_sel_clients_preparado = $conexaobd->prepare($sql_sel_clients);
    $sql_sel_clients_preparado->execute();
    $sql_sel_clients_dados = $sql_sel_clients_preparado->fetch();

    $data = explode('-', $sql_sel_clients_dados['birthdate']);
    $sql_sel_clients_dados['birthdate'] = $data[2]."/".$data[1]."/".$data[0];
    //Coloca a data no padrão brasileiro.

    echo json_encode($sql_sel_clients_dados);
    //Manda a array pro ajax de volta.
?>