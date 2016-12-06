<?php

    $p_id = $_POST['hidid'];
    $p_nome = $_POST['txtnome'];
    $p_descricao = $_POST['txtdescricao'];
    $p_itens = $_POST['selitens'];
    $p_quantidade = $_POST['txtquantidade'];
    $p_valor_real = $_POST['txtvalor_real'];
    $p_desconto = $_POST['txtdesconto'];

    $msg_titulo = "Erro";
    $voltar = "?folder=kits/&file=cb_fmupd_kits&ext=php&id=".$p_id;

    $valor_d = explode(',', $p_desconto);

    $cont = count($valor_d);

    for($contadora=0; $contadora<$cont; $contadora++){

        $desconto = 0;

        if($contadora==1){
            $centavos = $valor_d[$contadora];
        }else{
            $centavos = '00';
        }

        $desconto = $valor_d[0].".".$centavos;

    }
    $valor_real_d = explode(',', $p_valor_real);

    $cont_vr = count($valor_real_d);

    for($contadora=0; $contadora<$cont_vr; $contadora++){

        $valor_real = 0;

        if($contadora==1){
            $centavos = $valor_real_d[$contadora];
        }else{
            $centavos = '00';
        }

        $valor_real = $valor_real_d[0].".".$centavos;

    }

    $linhas_cont = count($p_itens);

    $itens_validacao = true;
    $erro_repeticao_item = true;
    $quantidade_validacao = 0;

    for($contadora=0; $contadora<$linhas_cont; $contadora++){

        if($p_itens[$contadora]==""){
            $itens_validacao =  false;
            break;
        }

        $erro_repeticao_item_cont = 0;

        for($cont=0; $cont<$linhas_cont; $cont++){

            if($p_itens[$contadora]==$p_itens[$cont]){
                $erro_repeticao_item_cont = $erro_repeticao_item_cont +1;
            }

            if($erro_repeticao_item_cont>1){
                $erro_repeticao_item = false;
                break;
            }

        }

        $sql_sel_items = "SELECT name, quantity FROM items WHERE id='".$p_itens[$contadora]."'";

        $sql_sel_items_preparado = $conexaobd->prepare($sql_sel_items);

        $sql_sel_items_preparado->execute();

        $sql_sel_items_dados = $sql_sel_items_preparado->fetch();


        if($p_quantidade[$contadora]==""){
                $quantidade_validacao =  1;
                break;
            }else if(($p_quantidade[$contadora]<0)||($p_quantidade[$contadora]==0)){
                    $quantidade_validacao =  2;
                    break;
                }else if(!valida_numerico($p_quantidade[$contadora], 1, 4)){
                        $quantidade_validacao =  3;
                        break;
                    }else if($p_quantidade[$contadora]>$sql_sel_items_dados['quantity']){
                            $quantidade_validacao =  4;
                            break;
                        }
    }

    if($p_nome==""){
        $mensagem = mensagens("Validação", "Nome");
    }else if(!$itens_validacao){
                $mensagem = "Algum item não foi selecionado!";
            }else if(!$erro_repeticao_item){
                    $mensagem = "Algum item foi escolhido mais que uma vez!";
                }else if($quantidade_validacao==1){
                        $mensagem = "Alguma quantidade não foi preenchida!";
                    }else if($quantidade_validacao==2){
                            $mensagem = "A quantidade não pode ser menor ou igual a 0!";
                        }else if($quantidade_validacao==3){
                                $mensagem = mensagens("Validação Numericos", "Quantidade");
                            }else if($quantidade_validacao==4){
                                    $mensagem = "Você não pode registrar mais que ".$sql_sel_items_dados['quantity']." ".$sql_sel_items_dados['name'].".";
                                }else if($p_valor_real==""){
                                         $mensagem = mensagens("Validação", "Valor Real");
                                    }else if($p_desconto==""){
                                            $mensagem = mensagens("Validação", "Desconto");
                                        }else if($p_desconto<0){
                                                $mensagem = "O desconto não pode ser menor que 0!";
                                            }else if($p_desconto>$valor_real){
                                                    $mensagem = "O desconto não pode ser maior que o valor real";
                                                }else if(!valida_decimal($p_desconto, 1, 4)){
                                                        $mensagem = mensagens("Validação Decimal", "Desconto");
                                                    }else{

                                                        $sql_sel_kits = "SELECT * FROM kits WHERE name = '".$p_nome."' AND id<>'".$p_id."'";

                                                        $sql_sel_kits_preparado = $conexaobd->prepare($sql_sel_kits);

                                                        $sql_sel_kits_preparado->execute();

                                                        if($sql_sel_kits_preparado->rowCount()==0){

                                                            $tabela = "kits";

                                                            $dados = array(
                                                                "name" => $p_nome,
                                                                "discount" => $desconto,
                                                                "description" => $p_descricao
                                                            );

                                                            $condicao = "id='".$p_id."'";

                                                            $sql_sel_kits_resultado = alterar($tabela, $dados, $condicao);

                                                            if($sql_sel_kits_resultado){

                                                                $tabela = "kits_has_items";

                                                                $condicao = "kits_id='".$p_id."'";

                                                                $sql_del_kits_has_items_resultado = deletar($tabela, $condicao);

                                                                for($contadora=0; $contadora<$linhas_cont; $contadora++){

                                                                    $sql_sel_items_value = "SELECT value FROM items WHERE id='".$p_itens[$contadora]."'";

                                                                    $sql_sel_items_value_preparado = $conexaobd->prepare($sql_sel_items_value);

                                                                    $sql_sel_items_value_preparado->execute();

                                                                    $sql_sel_items_value_dados = $sql_sel_items_value_preparado->fetch();

                                                                    $tabela = "kits_has_items";

                                                                    $dados = array(
                                                                        "kits_id" => $p_id,
                                                                        "items_id" => $p_itens[$contadora],
                                                                        "item_quantity" => $p_quantidade[$contadora],
                                                                        "actual_value" => $sql_sel_items_value_dados['value']
                                                                    );

                                                                    $sql_sel_items_resultado = adicionar($tabela, $dados);

                                                                    if($sql_sel_items_resultado){
                                                                        $msg_titulo = "Confirmação";
                                                                        $mensagem = mensagens("Sucesso", "kit", "Alteração");
                                                                        $voltar = "?folder=kits/&file=cb_fmins_kits&ext=php";
                                                                    }else{
                                                                        $mensagem = mensagens("Erro bd", "kit", "Alterar");
                                                                        $msg_titulo = "Erro";
                                                                    }


                                                                }

                                                            }else{
                                                                $mensagem = mensagens("Erro bd", "kit", "alterar");
                                                            }


                                                        }else{
                                                            $mensagem = mensagens("Repetição", "kit");
                                                        }

                                                    }




    ?>
    <h1>Aviso</h1>
    <div class="message">
        <h3><img src="../layout/images/alert.png"><?php echo $msg_titulo; ?></h3>
        <hr />
        <p><?php echo $mensagem ?></p>
        <a href="<?php echo $voltar; ?>"><img src="../layout/images/back.png">Voltar</a>
    </div>
