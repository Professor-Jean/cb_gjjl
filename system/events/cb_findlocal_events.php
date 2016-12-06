<?php
    include "../../security/database/cb_connection_database.php";
    //Incluida a página que faz a conexão com o banco de dados.
    if(($_POST['local']!="cliente") && ($_POST['local']!="outro")){
        //Se o local for diferente de cliente e diferente de outro.
        $p_local = $_POST['local'];
        //Recebe do ajax as variáveis por POST.

        //Este bloco é responsável por fazer a seleção do cep do local da empresa, o id da cidade, o id do bairro, a rua, o numero e o complemento do local da empresa, nome do bairro, da tabela locals juntando com a tabela districts, juntando com a tabela cities... Onde o id do local for igual a variável p_local.
        $sql_sel_locals = "SELECT locals.cep, locals.rent_value, cities.id AS citiesid, cities.name AS citiesname, districts.id AS districtsid, locals.street, locals.number, locals.complement, districts.name AS districtsname FROM locals INNER JOIN districts ON locals.districts_id=districts.id INNER JOIN cities ON districts.cities_id=cities.id WHERE locals.id='".$p_local."'";
        $sql_sel_locals_preparado = $conexaobd->prepare($sql_sel_locals);
        $sql_sel_locals_preparado->execute();
        $sql_sel_locals_dados = $sql_sel_locals_preparado->fetch();
        if(isset($_POST['evento'])){
            //Esta estrutura é responsável por fazer a seleção do id, local e event_date da tabela events (eventos)... Onde o local for igual a vairável local_evento e event_date for igual a variável data_banco e o id for diferente da variável p_id.
            $sql_sel_events = "SELECT id, rent_value FROM events WHERE id='".$_POST['evento']."'";
            $sql_sel_events_preparado = $conexaobd->prepare($sql_sel_events);
            $sql_sel_events_preparado->execute();
            $sql_sel_events_dados = $sql_sel_events_preparado->fetch();
            if(isset($sql_sel_events_dados['rent_value'])){
                $sql_sel_locals_dados['rent_value'] = $sql_sel_events_dados['rent_value'];
            }
        }
        echo json_encode($sql_sel_locals_dados);
        //Devolve para o ajax.
    }else if($_POST['local']=="cliente"){
        //Se não, se o local for igual a cliente.
        $p_local = $_POST['local'];
        $p_cliente = $_POST['idcliente'];
        //Recebe do ajax as variáveis por POST.

        //Este bloco é responsável por fazer a seleção do cep do local do cliente, id da cidade, id do bairro, a rua, o número e o complemento do local do cliente, o nome do bairro, da tabela clients juntando com a tabela districts, juntando com a tabela cities... Onde o id do cliente for igual a variável p_cliente.
        $sql_sel_clients = "SELECT clients.cep, cities.id AS citiesid, districts.id AS districtsid, clients.street, clients.number, clients.complement, districts.name AS districtsname FROM clients INNER JOIN districts ON clients.districts_id=districts.id INNER JOIN cities ON districts.cities_id=cities.id WHERE clients.id='".$p_cliente."'";
        $sql_sel_clients_preparado = $conexaobd->prepare($sql_sel_clients);
        $sql_sel_clients_preparado->execute();
        $sql_sel_clients_dados = $sql_sel_clients_preparado->fetch();

        echo json_encode($sql_sel_clients_dados);
        //Devolve para o ajax.
    }

?>