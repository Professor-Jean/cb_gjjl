<?php

    $p_nome = $_POST["txtnome"];
    $p_quantidade = $_POST["txtquantidade"];
    $p_valorunitario = $_POST["txtvalorunitario"];
    $p_descricao = $_POST["txtdescricao"];

    $msg_titulo = "Erro";
    $voltar = ' onClick="voltar()"';

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
                        }else{

                                $sql_sel_items = "SELECT * FROM items WHERE name = '".$p_nome."'";

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

                                    $sql_sel_items_resultado = adicionar($tabela, $dados);

                                if($sql_sel_items_resultado){
                                    $voltar = '';
                                    $msg_titulo = "Confirmação";
                                    $mensagem = mensagens("Sucesso", "item", "Registro");
                                }else{
                                        $mensagem = mensagens("Erro bd", "item", "registar");
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
    <p><?php echo $mensagem ?></p>
    <a href="?folder=items/&file=cb_fmins_items&ext=php"<?php echo $voltar;?>><img src="../layout/images/back.png">Voltar</a>
</div>