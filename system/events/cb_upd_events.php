<?php
    $p_id = $_POST['hidid'];
    $p_cliente = $_POST['hididcliente'];
    $p_kits = $_POST['selkits'];
    $p_quantidadekits = $_POST['txtquantidadekits'];
    $p_itens = $_POST['selitens'];
    $p_quantidadeitens = $_POST['txtquantidadeitens'];
    $p_local = $_POST['sellocal'];
    $p_cep = $_POST['txtcep'];
    $p_cidade = $_POST['selcidade'];
    $p_bairro = $_POST['selbairro'];
    $p_logradouro = $_POST['txtlogradouro'];
    $p_numero = $_POST['txtnumero'];
    $p_complemento = $_POST['txtcomplemento'];
    $p_data_evento = $_POST['txtdata_evento'];
    $p_horario = $_POST['txthorario'];
    $p_taxa_entrega = $_POST['txttaxa_entrega'];
    $p_valor_real = $_POST['txtvalor_real'];
    $p_desconto = $_POST['txtdesconto'];
    $p_valor_final = $_POST['txtvalor_final'];
    $p_observacao = $_POST['txtobservacao'];
    //Estas linhas são responsáveis por receber o cliente, kits, quantidade dos kits, itens, quantidade de itens, local, cep, cidade, bairro, logradouro, numero, complemento, data do evento, horário, taxa de entrega, valor real, desconto, valor final e observação da fmupd via POST.
    $descontobe = explode(',', $p_desconto);
    if(count($descontobe)==1){
        $descontob = $descontobe[0].'.'.'00';
    }else{
        $descontob = $descontobe[0].'.'.$descontobe[1];
    }
    $taxa_entregabe = explode(',', $p_taxa_entrega);
    if(count($taxa_entregabe)==1){
        $taxa_entregab = $taxa_entregabe[0].'.'.'00';
    }else{
        $taxa_entregab = $taxa_entregabe[0].'.'.$taxa_entregabe[1];
    }

    $msg_titulo = "Erro";
    //Esta linha é responsável por definir a variável msg_titulo, com o valor ERRO.
    $mensagem = "";
    //Esta linha é responsável por definir a variável mensagem, com o valor vazio.

    $kit_cont = count($p_kits);
    $item_cont = count($p_itens);
    //Conta a quantidade de kits e itens selecionados e armazena nas variáveis de contagem.
    $data = explode('/', $p_data_evento);
    $data_banco = $data[2]."-".$data[1]."-".$data[0];
    //Define na definição do banco.
    $voltar = "?folder=events/&file=cb_fmupd_events&ext=php&id=".$p_id;
    //Esta linha é responsável por definir a variável voltar, com o valor de voltar para a página fmupd.

    $kit_validacao = true;
    $item_validacao = true;
    $quantidade_validacao_kit = true;
    $quantidade_validacao_item = true;
    //Define as variáveis de validação com verdadeiro.

    //Esta estrutura é responsável por validar os campos de kit.
    for($i=0; $i<$kit_cont; $i++) {
        if ($p_kits[$i] == "") {
            $kit_validacao = false;
            break;
        }
        if (($p_quantidadekits[$i] == "") || ($p_quantidadekits[$i] == 0) || (!valida_numerico($p_quantidadekits[$i], 1, 4))) {
            $quantidade_validacao_kit = false;
            break;
        }
    }

    //Esta estrutura é responsável por validar os campos de item.
    for($i=0; $i<$item_cont; $i++){
        if ($p_itens[$i] == "") {
            $item_validacao = false;
            break;
        }
        if (($p_quantidadeitens[$i] == "") || ($p_quantidadeitens[$i] == 0) || (!valida_numerico($p_quantidadeitens[$i], 1, 4))) {
            $quantidade_validacao_item = false;
            break;
        }
    }

        if($p_cliente==""){
            //Se a variável p_nome for vazia, chama a função mensagens.
            $mensagem = mensagens("Validação", "Cliente");
        }else if((!$kit_validacao) && (!$item_validacao)){
                //Se as duas variáveis forem falsas, mostra a mensagem.
                $mensagem = "Selecione ao menos um kit ou um item!";
            }else if(!$quantidade_validacao_kit){
                    $mensagem = "Alguma quantidade de kit não foi preenchida ou é igual a 0!";
                }else if(!$quantidade_validacao_item){
                        $mensagem = "Alguma quantidade de item não foi preenchida ou é igual a 0!";
                    }else if($p_local==""){
                            //Se a variável p_local for vazia, chama a função mensagens.
                            $mensagem = mensagens("Validação", "Local");
                        }else if($p_cep==""){
                                //Se a variável p_cep for vazia, chama a função mensagens.
                                $mensagem = mensagens("Validação", "CEP");
                            }else if(!valida_numerico($p_cep, 1, 8)){
                                    //Se a variável p_cep possuir letras, caracteres especiais ou passar de 8 caracteres, chama a função mensagens.
                                    $mensagem = mensagens("Validação Numerico", "CEP");
                                }else if($p_cidade==""){
                                        //Se a variável p_cidade for vazia, chama a função mensagens.
                                        $mensagem = mensagens("Validação", "Cidade");
                                    }else if($p_bairro==""){
                                            //Se a variável p_bairro for vazia, chama a função mensagens.
                                            $mensagem = mensagens("Validação", "Bairro");
                                        }else if($p_logradouro==""){
                                                //Se a variável p_logradouro for vazia, chama a função mensagens.
                                                $mensagem = mensagens("Validação", "Logradouro");
                                            }else if(!valida_nome($p_logradouro, 40)){
                                                    //Se a variável p_nome, possuir números, caracteres especiais ou passar de 40 caracteres, chama a função mensagens.
                                                    $mensagem = mensagens("Validação Nome", "Logradouro");
                                                }else if($p_numero==""){
                                                        //Se a variável p_numero for vazia, chama a função mensagens.
                                                        $mensagem = mensagens("Validação", 'Número');
                                                    }else if(!valida_numerico($p_numero, 1, 5)){
                                                            //Se a variável p_cep possuir letras, caracteres especiais ou passar de 5 caracteres, chama a função mensagens.
                                                            $mensagem = mensagens("Validação Numerico", "Número");
                                                        }else if($p_data_evento==""){
                                                                //Se a variável p_data_evento for vazia, chama a função mensagens.
                                                                $mensagem = mensagens("Validação", "Data do Evento");
                                                            }else if(((!isset($data[2])) || (isset($data[3]))) || (!valida_data($data[2], $data[1], $data[0]))){
                                                                    //Se a data não estiver no padrão correto, chama a função mensagem.
                                                                    $mensagem = mensagens("Validação Data");
                                                                }else if(strtotime($p_data_evento)<strtotime(date('d/m/Y'))){
                                                                        $mensagem = "A data escolhida já passou!";
                                                                    }else if($p_horario==""){
                                                                            //Se a variável p_horario for vazia, chama a função mensagens.
                                                                            $mensagem = mensagens("Validação", "Horario");
                                                                        }else if(!valida_horario($p_horario)){
                                                                                //Se a variável p_horario não estiver no padrão correto, chama a função mensagem.
                                                                                $mensagem = mensagens("Validação Horario");
                                                                            }else if($p_taxa_entrega==""){
                                                                                    //Se a variável p_taxa_entrega for vazia, chama a função mensagens.
                                                                                    $mensagem = mensagens("Validação", "Taxa de Entrega");
                                                                                }else if(!valida_decimal($p_taxa_entrega, 1, 6)){
                                                                                        //Se a variável p_taxa_entrega possuir letras, caracteres especiais (exceto vírgula) ou passar de 6 caracteres, chama a função mensagens.
                                                                                        $mensagem = mensagens("Validação Numerico", "Taxa de Entrega");
                                                                                    }else if($p_valor_real==""){
                                                                                            //Se a variável p_valor_real for vazia, chama a função mensagens.
                                                                                            $mensagem = mensagens("Validação", "Valor Real")." Não esqueça-se de apertar no botão Gerar Valor Real!";
                                                                                        }else if(!valida_decimal($p_valor_real, 1, 10)){
                                                                                                //Se a variável p_valor_real possuir letras, caracteres especiais (exceto vírgula) ou passar de 10 caracteres, chama a função mensagens.
                                                                                                $mensagem = mensagens("Validação Numerico", "Valor Real");
                                                                                            }else if($p_desconto==""){
                                                                                                    //Se a variável p_desconto for vazia, chama a função mensagens.
                                                                                                    $mensagem = mensagens("Validação", "Desconto");
                                                                                                }else if(!valida_decimal($p_desconto, 1, 10)){
                                                                                                        //Se a variável p_desconto possuir letras, caracteres especiais (exceto vírgula) ou passar de 10 caracteres, chama a função mensagens.
                                                                                                        $mensagem = mensagens("Validação Numerico", "Desconto");
                                                                                                    }else if($p_valor_final==""){
                                                                                                            //Se a variável p_valor_final for vazia, chama a função mensagens.
                                                                                                            $mensagem = mensagens("Validação", "Valor Final");
                                                                                                        }else if(!valida_decimal($p_valor_final, 1, 10)){
                                                                                                                //Se a variável p_valor_final possuir letras, caracteres especiais (exceto vírgula) ou passar de 10 caracteres, chama a função mensagens.
                                                                                                                $mensagem = mensagens("Validação Numerico", "Valor Final");
                                                                                                            }else{
                                                                                                                //Esta estrutura é responsável por definir os dados que são usados no local na hora de registrar o evento.
                                                                                                                if(($p_local!="cliente") && ($p_local!="outro")){
                                                                                                                    $local_evento = 0;
                                                                                                                    $sql_sel_locals = "SELECT id, rent_value FROM locals WHERE id='".$p_local."'";
                                                                                                                    $sql_sel_locals_preparado = $conexaobd->prepare($sql_sel_locals);
                                                                                                                    $sql_sel_locals_preparado->execute();
                                                                                                                    $sql_sel_locals_dados = $sql_sel_locals_preparado->fetch();
                                                                                                                    $local_empresa = $p_local;
                                                                                                                    //Esta estrutura é responsável por fazer a seleção do id, local e event_date da tabela events (eventos)... Onde o local for igual a vairável local_evento e event_date for igual a variável data_banco e o id for diferente da variável p_id.
                                                                                                                    $sql_sel_events = "SELECT id, locals_id, event_date FROM events WHERE locals_id='".$local_empresa."' AND event_date='".$data_banco."' AND id<>'".$p_id."'";
                                                                                                                    $sql_sel_events_preparado = $conexaobd->prepare($sql_sel_events);
                                                                                                                    $sql_sel_events_preparado->execute();
                                                                                                                    $sql_sel_events_dados = $sql_sel_events_preparado->fetch();

                                                                                                                    //Esta estrutura é responsável por fazer a seleção do id, local e event_date da tabela events (eventos)... Onde o local for igual a vairável local_evento e event_date for igual a variável data_banco e o id for diferente da variável p_id.
                                                                                                                    $sql_sel_eventsrv = "SELECT id, rent_value FROM events WHERE id='".$p_id."'";
                                                                                                                    $sql_sel_eventsrv_preparado = $conexaobd->prepare($sql_sel_eventsrv);
                                                                                                                    $sql_sel_eventsrv_preparado->execute();
                                                                                                                    $sql_sel_eventsrv_dados = $sql_sel_eventsrv_preparado->fetch();
                                                                                                                    if(isset($sql_sel_eventsrv_dados['rent_value'])){
                                                                                                                        $sql_sel_locals_dados['rent_value'] = $sql_sel_eventsrv_dados['rent_value'];
                                                                                                                    }
                                                                                                                    $sql_sel_locals_dados['rent_value'] = $sql_sel_events_dados['rent_value'];
                                                                                                                }else if($p_local=="cliente"){
                                                                                                                        $local_evento = 1;
                                                                                                                        $local_empresa = NULL;
                                                                                                                        $sql_sel_locals_dados['rent_value'] = NULL;
                                                                                                                        //Esta estrutura é responsável por fazer a seleção do id, local e event_date da tabela events (eventos)... Onde o local for igual a vairável local_evento e event_date for igual a variável data_banco.
                                                                                                                        $sql_sel_events = "SELECT id, local, event_date FROM events WHERE local='1' AND clients_id='".$p_cliente."' AND event_date='".$data_banco."'";
                                                                                                                        $sql_sel_events_preparado = $conexaobd->prepare($sql_sel_events);
                                                                                                                        $sql_sel_events_preparado->execute();
                                                                                                                        $sql_sel_events_dados = $sql_sel_events_preparado->fetch();
                                                                                                                    }else{
                                                                                                                        $local_evento = 2;
                                                                                                                        $local_empresa = NULL;
                                                                                                                        $sql_sel_locals_dados['rent_value'] = NULL;
                                                                                                                        $sql_sel_events_preparado = NULL;
                                                                                                                    }
                                                                                                                //Esta estrutura é responsável por fazer a seleção do id, local e event_date da tabela events (eventos)... Onde o local for igual a vairável local_evento e event_date for igual a variável data_banco e o id for diferente da variável p_id.
                                                                                                                /*$sql_sel_events = "SELECT id, local, event_date FROM events WHERE local='".$local_evento."' AND event_date='".$data_banco."' AND id<>'".$p_id."'";
                                                                                                                $sql_sel_events_preparado = $conexaobd->prepare($sql_sel_events);
                                                                                                                $sql_sel_events_preparado->execute();
                                                                                                                $sql_sel_events_dados = $sql_sel_events_preparado->fetch();*/

                                                                                                                //Esta estrutura é reposponsável por verificar se a quantidade de linhas da seleção acima for igual a zero e fazer a contagem de kits e itens pedidos para que esses kits e itens formem uma array.
                                                                                                                if(($sql_sel_events_preparado != NULL && $sql_sel_events_preparado->rowCount()==0) || ($local_evento==2)){
                                                                                                                    //Para i=0 até i ser menor que a contagem de kits, onde o i tem um auto incremento de 1 a cada vez que passa pela estrutura.
                                                                                                                    for($i=0; $i<$kit_cont; $i++) {
                                                                                                                        //Esta estrutura é responsável por fazer a seleção do id, name dos kits, item_quantity, items_id dos itens que compoem os kits da tabela kits, juntando com a tabela kits_has_items... Onde kits.id for igual a array p_kits que vem do formulário, agrupando por items_id.
                                                                                                                        $sql_sel_kits = "SELECT kits.id, kits.name, kits_has_items.item_quantity AS kits_has_itemsitem_quantity, kits_has_items.items_id AS kits_has_itemsitems_id FROM kits INNER JOIN kits_has_items WHERE kits.id=kits_has_items.kits_id AND kits.id='" . $p_kits[$i] . "' GROUP BY kits_has_items.items_id";
                                                                                                                        $sql_sel_kits_preparado = $conexaobd->prepare($sql_sel_kits);
                                                                                                                        $sql_sel_kits_preparado->execute();
                                                                                                                        //Esta estrutura é responsável por exibir os dados contidos na seleção feita acima.
                                                                                                                        while($sql_sel_kits_dados = $sql_sel_kits_preparado->fetch()) {
                                                                                                                            if(isset($pedidos[$sql_sel_kits_dados['kits_has_itemsitems_id']])) {
                                                                                                                                //Se a variável pedidos com a chave do id do item existir. Variável pedidos recebe pedidos + a quantidade de itens presentes nos kits multiplicado pela quantidade do kit.
                                                                                                                                $pedidos[$sql_sel_kits_dados['kits_has_itemsitems_id']] = $pedidos[$sql_sel_kits_dados['kits_has_itemsitems_id']] + $sql_sel_kits_dados['kits_has_itemsitem_quantity'] * $p_quantidadekits[$i];
                                                                                                                            }else{
                                                                                                                                //Se a variável pedidos com a chave do id do item não existir. Variável pedidos recebe a quantidade de itens presentes nos kits multiplicado pela quantidade do kit.
                                                                                                                                $pedidos[$sql_sel_kits_dados['kits_has_itemsitems_id']] = $sql_sel_kits_dados['kits_has_itemsitem_quantity'] * $p_quantidadekits[$i];
                                                                                                                            }
                                                                                                                        }
                                                                                                                    }
                                                                                                                    //Para i=0 até i ser menor que a contagem de itens, onde o i tem um auto incremento de 1 a cada vez que passa pela estrutura.
                                                                                                                    for($i=0; $i<$item_cont; $i++) {
                                                                                                                        //Esta estrutura é responsável por fazer a seleção do id e quantity da tabela items... Onde id for igual a array p_itens que vem do formulário, agrupando por items_id.
                                                                                                                        $sql_sel_items = "SELECT id, quantity FROM items WHERE id='".$p_itens[$i]."' GROUP BY items.id";
                                                                                                                        $sql_sel_items_preparado = $conexaobd->prepare($sql_sel_items);
                                                                                                                        $sql_sel_items_preparado->execute();
                                                                                                                        //Esta estrutura é responsável por exibir os dados contidos na seleção feita acima.
                                                                                                                        while($sql_sel_items_dados = $sql_sel_items_preparado->fetch()){
                                                                                                                            if(isset($pedidos[$sql_sel_items_dados['id']])) {
                                                                                                                                //Se a variável pedidos com a chave do id do item existir. Variável pedidos recebe pedidos + a quantidade de itens.
                                                                                                                                $pedidos[$sql_sel_items_dados['id']] = $pedidos[$sql_sel_items_dados['id']] +  $p_quantidadeitens[$i];
                                                                                                                            }else{
                                                                                                                                //Se a variável pedidos com a chave do id do item não existir. Variável pedidos recebe quantidade de itens
                                                                                                                                $pedidos[$sql_sel_items_dados['id']] = $p_quantidadeitens[$i];
                                                                                                                            }
                                                                                                                        }
                                                                                                                    }
                                                                                                                    //Esta estrutura é responsável por fazer a seleção do id dos itens presentes nos kits, quantidade total dos itens (itemquantity), soma a quantidade de itens presentes nos kits (itemsavaiable) da tabela events_has_kits, juntado com a tabela events, juntando com a tabela kits, juntando com a tabela kits_has_items, juntando com a tabela items... Onde a data do evento (event_date) for igual a variável data_banco (que foi recebida da fmins e formatada no padrão do banco) agrupando por data e id dos items.
                                                                                                                    $sql_sel_events_has_kits = "SELECT kits_has_items.items_id AS kits_has_itemsitems_id, items.quantity AS itemsquantity, SUM(kits_has_items.item_quantity) AS itemsavaiable FROM events_has_kits INNER JOIN events ON events_has_kits.events_id = events.id INNER JOIN kits ON events_has_kits.kits_id = kits.id INNER JOIN kits_has_items ON kits.id = kits_has_items.kits_id INNER JOIN items ON kits_has_items.items_id = items.id WHERE events.event_date = '" . $data_banco . "' (status='0' OR status='1') GROUP BY events.event_date, kits_has_items.items_id";
                                                                                                                    $sql_sel_events_has_kits_preparado = $conexaobd->prepare($sql_sel_events_has_kits);
                                                                                                                    $sql_sel_events_has_kits_preparado->execute();
                                                                                                                    //Esta estrutura é responsável por exibir os dados contidos na seleção feita acima.
                                                                                                                    while ($sql_sel_events_has_kits_dados = $sql_sel_events_has_kits_preparado->fetch()) {
                                                                                                                        $reservados[$sql_sel_events_has_kits_dados['kits_has_itemsitems_id']] = $sql_sel_events_has_kits_dados['itemsavaiable'];
                                                                                                                        $reservados[$sql_sel_events_has_kits_dados['kits_has_itemsitems_id']] = $sql_sel_events_has_kits_dados['itemsquantity'] - $reservados[$sql_sel_events_has_kits_dados['kits_has_itemsitems_id']];
                                                                                                                    }
                                                                                                                    //Esta estrutura é responsável por fazer a seleção dos id's dos itens, a soma da quantidade de itens presentes no evento, quantidade total de itens da tabela events_has_items, juntando com a tabela events, juntando com a tabela items... Onde a data do evento for igual a variável data_banco (que foi recebida da fmins e formatada no padrão do banco), agrupando por data do evento e id dos itens.
                                                                                                                    $sql_sel_events_has_items = "SELECT events_has_items.items_id AS events_has_itemsitems_id, SUM(events_has_items.item_quantity) AS itemsavaiable, items.quantity AS itemsquantity FROM events_has_items INNER JOIN events ON events.id=events_has_items.events_id INNER JOIN items ON events_has_items.items_id=items.id WHERE events.event_date='" . $data_banco . "' (status='0' OR status='1') GROUP BY events.event_date, items.id";
                                                                                                                    $sql_sel_events_has_items_preparado = $conexaobd->prepare($sql_sel_events_has_items);
                                                                                                                    $sql_sel_events_has_items_preparado->execute();

                                                                                                                    //Esta estrutura é responsável por exibir os dados contidos na seleção feita acima.
                                                                                                                    while($sql_sel_events_has_items_dados = $sql_sel_events_has_items_preparado->fetch()){
                                                                                                                        if(isset($reservados[$sql_sel_events_has_items_dados['events_has_itemsitems_id']])) {
                                                                                                                            $reservados[$sql_sel_events_has_items_dados['events_has_itemsitems_id']] = $reservados[$sql_sel_events_has_items_dados['events_has_itemsitems_id']] - $sql_sel_events_has_items_dados['itemsavaiable'];
                                                                                                                        }else {
                                                                                                                            $reservados[$sql_sel_events_has_items_dados['events_has_itemsitems_id']] = 0;
                                                                                                                            $reservados[$sql_sel_events_has_items_dados['events_has_itemsitems_id']] = $sql_sel_events_has_items_dados['itemsquantity'] - $sql_sel_events_has_items_dados['itemsavaiable'];
                                                                                                                        }
                                                                                                                    }

                                                                                                                    //Esta estrutura é responsável por verificar se a contagem de registros do events_has_kits e a contagem de registros do events_has_items for menor ou igual a zero.
                                                                                                                    if(($sql_sel_events_has_kits_preparado->rowCount()<=0) && ($sql_sel_events_has_items_preparado->rowCount()<=0)){
                                                                                                                        //Esta estrutura é responsável por fazer a seleção do id e da quantidade da tabela items (itens).
                                                                                                                        $sql_sel_items = "SELECT id, quantity FROM items";
                                                                                                                        $sql_sel_items_preparado = $conexaobd->prepare($sql_sel_items);
                                                                                                                        $sql_sel_items_preparado->execute();
                                                                                                                        //Esta estrutura é responsável por exibir os dados contidos na seleção feita acima.
                                                                                                                        while($sql_sel_items_dados = $sql_sel_items_preparado->fetch()){
                                                                                                                            $reservados[$sql_sel_items_dados['id']] = $sql_sel_items_dados['quantity'];
                                                                                                                        }
                                                                                                                    }

                                                                                                                    $idpedidos = array_keys($pedidos);
                                                                                                                    //Pega a chave da array pedidos

                                                                                                                    //Para i=0 até i ser menor que a contagem de pedidos, onde o i tem um auto incremento de 1 a cada vez que passa pela estrutura.
                                                                                                                    for($i=0; $i<COUNT($pedidos); $i++){
                                                                                                                        //Esta estrutura é responsável por fazer a seleção do nome e da quantidade da tabela itens onde id é igual a chave tirada da array pedidos.
                                                                                                                        $sql_sel_items = "SELECT name, quantity FROM items WHERE id='".$idpedidos[$i]."'";
                                                                                                                        $sql_sel_items_preparado = $conexaobd->prepare($sql_sel_items);
                                                                                                                        $sql_sel_items_preparado->execute();
                                                                                                                        $sql_sel_items_dados = $sql_sel_items_preparado->fetch();
                                                                                                                        //Esta estrutura é responsável por escrever os itens que não estão disponíveis.
                                                                                                                        if(isset($reservados[$idpedidos[$i]])) {
                                                                                                                            if(($reservados[$idpedidos[$i]]-$pedidos[$idpedidos[$i]])<0){
                                                                                                                                $mensagem .= "- O item ".$sql_sel_items_dados['name']." não está disponível!<br />";
                                                                                                                            }
                                                                                                                        }else{
                                                                                                                            if(($sql_sel_items_dados['quantity'] - $pedidos[$idpedidos[$i]])<0){
                                                                                                                                $mensagem .= "- O item ".$sql_sel_items_dados['name']." não está disponível!<br />";
                                                                                                                            }
                                                                                                                        }
                                                                                                                    }
                                                                                                                }else{
                                                                                                                    //Se a quantidade for diferente de zero, o item é repetido.
                                                                                                                    $mensagem = mensagens("Repetição", "Evento");
                                                                                                                }
                                                                                                            }

                                                                                                            if($mensagem == ""){
                                                                                                                //Se a variável mensagem for igual a vazio.
                                                                                                                $tabela = "events";
                                                                                                                //Define o valor da variável tabela como clients.

                                                                                                                //Este bloco é responsável por colocar os dados recebidos do formulário em um array.
                                                                                                                $dados = array(
                                                                                                                    'clients_id' => $p_cliente,
                                                                                                                    'districts_id' => $p_bairro,
                                                                                                                    'locals_id' => $local_empresa,
                                                                                                                    'local' => $local_evento,
                                                                                                                    'cep' => $p_cep,
                                                                                                                    'street' => $p_logradouro,
                                                                                                                    'number' => $p_numero,
                                                                                                                    'event_date' => $data_banco,
                                                                                                                    'event_time' => $p_horario,
                                                                                                                    'discount' => $descontob,
                                                                                                                    'entry_fee' => '0',
                                                                                                                    'status' => '0',
                                                                                                                    'rent_value' => $sql_sel_locals_dados['rent_value'],
                                                                                                                    'delivery_fee' => $taxa_entregab,
                                                                                                                    'complement' => $p_complemento,
                                                                                                                    'observation' => $p_observacao
                                                                                                                );

                                                                                                                $condicao = "id='".$p_id."'";
                                                                                                                //Condição de o id ser igual a variável p_id.

                                                                                                                $sql_upd_events_resultado = alterar($tabela, $dados, $condicao);
                                                                                                                //Chama a funçao alterar e atribui o valor a variável sql_upd_events_resultado.

                                                                                                                //Este bloco é responsável por verificar se a alteração funcionou ou não.
                                                                                                                if($sql_upd_events_resultado){
                                                                                                                    //Para i=0 até i ser menor que a contagem de kits, onde o i tem um auto incremento de 1 a cada vez que passa pela estrutura.
                                                                                                                    if(($kit_validacao) && ($item_validacao)) {
                                                                                                                        for ($i = 0; $i < $kit_cont; $i++) {
                                                                                                                            //Esta estrutura é responsável por fazer a seleção do valor do kit, por meio de uma conta que multiplica o valor atual do kit pela quantidade de itens menos o desconto da tabela kits, juntando com a tabela kits_has_items... Onde o id do kit é igual a array p_kits agrupando por id do kit.
                                                                                                                            $sql_sel_kits = "SELECT SUM(kits_has_items.actual_value*kits_has_items.item_quantity) - kits.discount AS kitvalue FROM kits INNER JOIN kits_has_items ON kits.id=kits_has_items.kits_id WHERE kits.id='$p_kits[$i]' GROUP BY kits.id";
                                                                                                                            $sql_sel_kits_preparado = $conexaobd->prepare($sql_sel_kits);
                                                                                                                            $sql_sel_kits_preparado->execute();
                                                                                                                            $sql_sel_kits_dados = $sql_sel_kits_preparado->fetch();
                                                                                                                            $tabela = "events_has_kits";
                                                                                                                            //Define o valor da variável tabela como clients.

                                                                                                                            //Este bloco é responsável por colocar os dados recebidos do formulário em um array.
                                                                                                                            $dados = array(
                                                                                                                                'events_id' => $p_id,
                                                                                                                                'kits_id' => $p_kits[$i],
                                                                                                                                'kit_quantity' => $p_quantidadekits[$i],
                                                                                                                                'actual_value' => $sql_sel_kits_dados['kitvalue']
                                                                                                                            );

                                                                                                                            $condicao = "events_id='" . $p_id . "'";
                                                                                                                            //Condição de o events_id ser igual a variável p_id.

                                                                                                                            $sql_upd_events_has_kits_resultado = alterar($tabela, $dados, $condicao);
                                                                                                                            //Chama a funçao alterar e atribui o valor a variável sql_upd_events_has_kits_resultado.
                                                                                                                        }

                                                                                                                        //Este bloco é responsável por verificar se a alteração funcionou ou não.
                                                                                                                        if ($sql_upd_events_has_kits_resultado) {
                                                                                                                            for ($i = 0; $i < $item_cont; $i++) {
                                                                                                                                //Esta estrutura é responsável por fazer a seleção do valor do kit na tabela events_has_items, juntando dando preferencia para a tabela itens... Onde o id dos itens for igual a array de itens, agrupando por id do item.
                                                                                                                                $sql_sel_items = "SELECT items.value AS itemsvalue FROM events_has_items RIGHT JOIN items ON events_has_items.items_id=items.id WHERE items.id='" . $p_itens[$i] . "' GROUP BY items.id";
                                                                                                                                $sql_sel_items_preparado = $conexaobd->prepare($sql_sel_items);
                                                                                                                                $sql_sel_items_preparado->execute();
                                                                                                                                $sql_sel_items_dados = $sql_sel_items_preparado->fetch();

                                                                                                                                $tabela = "events_has_items";
                                                                                                                                //Define o valor da variável tabela como clients.

                                                                                                                                //Este bloco é responsável por colocar os dados recebidos do formulário em um array.
                                                                                                                                $dados = array(
                                                                                                                                    'events_id' => $p_id,
                                                                                                                                    'items_id' => $p_itens[$i],
                                                                                                                                    'item_quantity' => $p_quantidadeitens[$i],
                                                                                                                                    'actual_value' => $sql_sel_items_dados['itemsvalue']
                                                                                                                                );

                                                                                                                                $condicao = "events_id='" . $p_id . "'";
                                                                                                                                //Condição de o events_id ser igual a variável p_id.

                                                                                                                                $sql_upd_events_has_items_resultado = alterar($tabela, $dados, $condicao);
                                                                                                                                //Chama a funçao alterar e atribui o valor a variável sql_upd_events_has_items_resultado.

                                                                                                                                //Este bloco é responsável por verificar se a alteração funcionou ou não.
                                                                                                                                if ($sql_upd_events_has_items_resultado) {
                                                                                                                                    $msg_titulo = "Confirmação";
                                                                                                                                    $mensagem = mensagens("Sucesso", "Evento", "Alteração");
                                                                                                                                    $voltar = "?folder=events_control/control/&file=cb_events_control&ext=php";
                                                                                                                                } else {
                                                                                                                                    $mensagem = mensagens('Erro bd', 'evento', 'alterar');
                                                                                                                                }
                                                                                                                            }
                                                                                                                        } else {
                                                                                                                            $mensagem = mensagens('Erro bd', 'evento', 'alterar');
                                                                                                                        }
                                                                                                                    }else if(($kit_validacao) && (!$item_validacao)){
                                                                                                                            for ($i = 0; $i < $kit_cont; $i++) {
                                                                                                                                //Esta estrutura é responsável por fazer a seleção do valor do kit, por meio de uma conta que multiplica o valor atual do kit pela quantidade de itens menos o desconto da tabela kits, juntando com a tabela kits_has_items... Onde o id do kit é igual a array p_kits agrupando por id do kit.
                                                                                                                                $sql_sel_kits = "SELECT SUM(kits_has_items.actual_value*kits_has_items.item_quantity) - kits.discount AS kitvalue FROM kits INNER JOIN kits_has_items ON kits.id=kits_has_items.kits_id WHERE kits.id='$p_kits[$i]' GROUP BY kits.id";
                                                                                                                                $sql_sel_kits_preparado = $conexaobd->prepare($sql_sel_kits);
                                                                                                                                $sql_sel_kits_preparado->execute();
                                                                                                                                $sql_sel_kits_dados = $sql_sel_kits_preparado->fetch();
                                                                                                                                $tabela = "events_has_kits";
                                                                                                                                //Define o valor da variável tabela como clients.

                                                                                                                                //Este bloco é responsável por colocar os dados recebidos do formulário em um array.
                                                                                                                                $dados = array(
                                                                                                                                    'events_id' => $p_id,
                                                                                                                                    'kits_id' => $p_kits[$i],
                                                                                                                                    'kit_quantity' => $p_quantidadekits[$i],
                                                                                                                                    'actual_value' => $sql_sel_kits_dados['kitvalue']
                                                                                                                                );

                                                                                                                                $condicao = "events_id='" . $p_id . "'";
                                                                                                                                //Condição de o events_id ser igual a variável p_id.

                                                                                                                                $sql_upd_events_has_kits_resultado = alterar($tabela, $dados, $condicao);
                                                                                                                                //Chama a funçao alterar e atribui o valor a variável sql_upd_events_has_kits_resultado.
                                                                                                                            }

                                                                                                                            //Este bloco é responsável por verificar se a alteração funcionou ou não.
                                                                                                                            if ($sql_upd_events_has_kits_resultado) {
                                                                                                                                $msg_titulo = "Confirmação";
                                                                                                                                $mensagem = mensagens("Sucesso", "Evento", "Alteração");
                                                                                                                                $voltar = "?folder=events_control/control/&file=cb_events_control&ext=php";
                                                                                                                            } else {
                                                                                                                                $mensagem = mensagens('Erro bd', 'evento', 'alterar');
                                                                                                                            }
                                                                                                                        }else{
                                                                                                                            for ($i = 0; $i < $item_cont; $i++) {
                                                                                                                                //Esta estrutura é responsável por fazer a seleção do valor do kit na tabela events_has_items, juntando dando preferencia para a tabela itens... Onde o id dos itens for igual a array de itens, agrupando por id do item.
                                                                                                                                $sql_sel_items = "SELECT items.value AS itemsvalue FROM events_has_items RIGHT JOIN items ON events_has_items.items_id=items.id WHERE items.id='" . $p_itens[$i] . "' GROUP BY items.id";
                                                                                                                                $sql_sel_items_preparado = $conexaobd->prepare($sql_sel_items);
                                                                                                                                $sql_sel_items_preparado->execute();
                                                                                                                                $sql_sel_items_dados = $sql_sel_items_preparado->fetch();

                                                                                                                                $tabela = "events_has_items";
                                                                                                                                //Define o valor da variável tabela como clients.

                                                                                                                                //Este bloco é responsável por colocar os dados recebidos do formulário em um array.
                                                                                                                                $dados = array(
                                                                                                                                    'events_id' => $p_id,
                                                                                                                                    'items_id' => $p_itens[$i],
                                                                                                                                    'item_quantity' => $p_quantidadeitens[$i],
                                                                                                                                    'actual_value' => $sql_sel_items_dados['itemsvalue']
                                                                                                                                );

                                                                                                                                $condicao = "events_id='" . $p_id . "'";
                                                                                                                                //Condição de o events_id ser igual a variável p_id.

                                                                                                                                $sql_upd_events_has_items_resultado = alterar($tabela, $dados, $condicao);
                                                                                                                                //Chama a funçao alterar e atribui o valor a variável sql_upd_events_has_items_resultado.

                                                                                                                                //Este bloco é responsável por verificar se a alteração funcionou ou não.
                                                                                                                                if ($sql_upd_events_has_items_resultado) {
                                                                                                                                    $msg_titulo = "Confirmação";
                                                                                                                                    $mensagem = mensagens("Sucesso", "Evento", "Alteração");
                                                                                                                                    $voltar = "?folder=events_control/control/&file=cb_events_control&ext=php";
                                                                                                                                } else {
                                                                                                                                    $mensagem = mensagens('Erro bd', 'evento', 'alterar');
                                                                                                                                }
                                                                                                                            }
                                                                                                                        }
                                                                                                                }else{
                                                                                                                    $mensagem = mensagens('Erro bd', 'evento', 'alterar');
                                                                                                                }
                                                                                                                ?>
                                                                                                                <h1>Aviso</h1>
                                                                                                                <div class="message">
                                                                                                                    <h3><img src="../layout/images/alert.png"><?php echo $msg_titulo; ?></h3>
                                                                                                                    <hr/>
                                                                                                                    <p><?php echo $mensagem ?></p>
                                                                                                                    <a href="<?php echo $voltar; ?>"><img src="../layout/images/back.png">Voltar</a>
                                                                                                                </div>
                                                                                                                <?php
                                                                                                            }else {
                                                                                                                ?>
                                                                                                                <h1>Aviso</h1>
                                                                                                                <div class="message">
                                                                                                                    <h3><img src="../layout/images/alert.png"><?php echo $msg_titulo; ?></h3>
                                                                                                                    <hr/>
                                                                                                                    <p><?php echo $mensagem ?></p>
                                                                                                                    <a href="<?php echo $voltar; ?>"><img src="../layout/images/back.png">Voltar</a>
                                                                                                                </div>
                                                                                                                <?php
                                                                                                            }
?>