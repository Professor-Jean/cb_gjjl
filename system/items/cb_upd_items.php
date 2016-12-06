<?php

    $p_id = $_POST['hidid'];
    $p_nome = $_POST['txtnome'];
    $p_quantidade = $_POST['txtquantidade'];
    $p_valorunitario = $_POST['txtvalorunitario'];
    $p_descricao = $_POST['txtdescricao'];

    $msg_titulo = "Erro";

    $voltar = "?folder=items/&file=cb_fmupd_items&ext=php&id=".$p_id;

    $valor_unitario = explode(',', $p_valorunitario);

    $cont = count($valor_unitario);

    for($contadora=0; $contadora<$cont; $contadora++){

        $valor = 0;

        if($contadora==1){
            $centavos = $valor_unitario[$contadora];
        }else{
            $centavos = '00';
        }

        $valor = $valor_unitario[0].".".$centavos;

    }

    $sql_sel_events_has_items = "SELECT events.status, kits_has_items.items_id, events_has_items.items_id FROM events_has_kits INNER JOIN kits_has_items ON events_has_kits.kits_id=kits_has_items.kits_id INNER JOIN events_has_items ON events_has_items.events_id=events_has_kits.events_id INNER JOIN events ON events_has_kits.events_id=events.id WHERE (status='0' AND (kits_has_items.items_id='".$p_id."' OR events_has_items.items_id='".$p_id."')) OR (status='1' AND (kits_has_items.items_id='".$p_id."' OR events_has_items.items_id='".$p_id."'))";

    $sql_sel_events_has_items_preparado = $conexaobd->prepare($sql_sel_events_has_items);

    $sql_sel_events_has_items_preparado->execute();

    $cont = $sql_sel_events_has_items_preparado->rowCount();

    /////

    $sql_sel_items = "SELECT quantity, name FROM items WHERE id='".$p_id."'";

    $sql_sel_items_preparado = $conexaobd->prepare($sql_sel_items);

    $sql_sel_items_preparado->execute();

    $sql_sel_items_dados = $sql_sel_items_preparado->fetch();

    if($p_nome==""){
        $mensagem = mensagens("Validação", "Nome");
    }else if($p_quantidade==""){
            $mensagem = mensagens("Validação", "Quantidade");
        }else if(!valida_numerico($p_quantidade, 1, 3)){
                $mensagem = mensagens("Validação Numerico", "Quantidade");
            }else if(($p_quantidade<0)||($p_quantidade==0)){
                    $mensagem = "A quantidade não pode ser igual ou menor que 0!";
                }else if($p_valorunitario==""){
                        $mensagem = mensagens("Validação", "Valor Unitário");
                    }else if(!valida_decimal($p_valorunitario , 1, 7)){
                            $mensagem = mensagens("Validação Decimal", "Valor Unitário");
                        }else if(($cont>0)&&($p_quantidade<$sql_sel_items_dados['quantity'])){
                                $mensagem = "Você não pode alterar a quantidade do item ".$sql_sel_items_dados['name']." para menos que ".$sql_sel_items_dados['quantity'].", pois há Eventos Pendentes e/ou Eventos Confirmados associados a esse item, para alterar a quantidade desse item os eventos terão que ser realizados ou cancelados.";
                            }else{

                            $sql_sel_items = "SELECT * FROM items WHERE name = '".$p_nome."' AND id<>'".$p_id."'";

                            $sql_sel_items_preparado = $conexaobd->prepare($sql_sel_items);

                            $sql_sel_items_preparado->execute();

                            if($sql_sel_items_preparado->rowCount()==0){

                                $tabela = "items";

                                $dados = array(
                                    "name" => $p_nome,
                                    "quantity" => $p_quantidade,
                                    "value" => $valor,
                                    "description" => $p_descricao
                                );

                                $condicao = "id='".$p_id."'";

                                $sql_sel_items_resultado = alterar($tabela, $dados, $condicao);

                                if($sql_sel_items_resultado){
                                    $msg_titulo = "Confirmação";
                                    $mensagem = mensagens("Sucesso", "item", "Alteração");
                                    $voltar = "?folder=items/&file=cb_fmins_items&ext=php";
                                }else{
                                    $mensagem = mensagens("Erro bd", "item", "alterar");
                                }


                            }else{
                                $mensagem = mensagens("Repetição", "item");
                            }


                         }

?>
<h1>Aviso</h1>
<div class="message">
    <h3><img src="../layout/images/alert.png"><?php echo $msg_titulo; ?></h3>
    <hr />
    <p><?php echo $mensagem; ?></p>
    <a href="<?php echo $voltar; ?>"><img src="../layout/images/back.png">Voltar</a>
</div>