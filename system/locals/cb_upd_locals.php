<?php

    $p_id = $_POST['hidid'];
    $p_nome = $_POST['txtnome'];
    $p_area = $_POST['txtarea'];
    $p_altura = $_POST['txtaltura'];
    $p_descricao = $_POST['txtdescricao'];
    $p_cidade = $_POST['selcidade'];
    $p_cep = $_POST['txtcep'];
    $p_bairro = $_POST['selbairro'];
    $p_logradouro = $_POST['txtlogradouro'];
    $p_numero = $_POST['txtnumero'];
    $p_valor_aluguel = $_POST['txtvalor_aluguel'];
    $p_complemento = $_POST['txtcomplemento'];

    $msg_titulo = "Erro";

    $voltar = "?folder=locals/&file=cb_fmupd_locals&ext=php&id=".$p_id;

    //

    $valor_a = explode(',', $p_area);

    $cont = count($valor_a);

    for($contadora=0; $contadora<$cont; $contadora++){

        $valor_area = 0;

        if($contadora==1){
            $centimetros = $valor_a[$contadora];
        }else{
            $centimetros = '00';
        }

        $valor_area = $valor_a[0].".".$centimetros;

    }

    //

    $valor_al = explode(',', $p_altura);

    $cont = count($valor_al);

    for($contadora=0; $contadora<$cont; $contadora++){

        $valor_altura = 0;

        if($contadora==1){
            $centimetros = $valor_al[$contadora];
        }else{
            $centimetros = '00';
        }

        $valor_altura = $valor_al[0].".".$centimetros;

    }

    //

    $valor_alg = explode(',', $p_valor_aluguel);

    $cont = count($valor_alg);

    for($contadora=0; $contadora<$cont; $contadora++){

        $valor_aluguel = 0;

        if($contadora==1){
            $centavos = $valor_alg[$contadora];
        }else{
            $centavos = '00';
        }

        $valor_aluguel = $valor_alg[0].".".$centavos;

    }

    if($p_nome==""){
        $mensagem = mensagens("Validação", "nome");
    }else if($p_area==""){
            $mensagem = mensagens("Validação", "área");
        }else if(!valida_decimal($p_area, 1, 8)){
                $mensagem = mensagens("Validação Decimal", "área");
            }else if($p_altura==""){
                    $mensagem = mensagens("Validação", "altura");
                }else if(!valida_decimal($p_altura, 1, 5)){
                        $mensagem = mensagens("Validação Decimal", "altura");
                    }else if($p_cep==""){
                            $mensagem = mensagens("Validação", "CEP");
                        }else if(!valida_numerico($p_cep, 1, 8)){
                                $mensagem = mensagens("Validação Numerico", "CEP");
                            }else if($p_cidade==""){
                                    $mensagem = mensagens("Validação", "cidade");
                                }else if($p_bairro==""){
                                        $mensagem = mensagens("Validação", "bairro");
                                    }else if($p_logradouro==""){
                                            $mensagem = mensagens("Validação", "logradouro");
                                        }else if(!valida_alfanumerico($p_logradouro, 1, 40)){
                                                $mensagem = mensagens("Validação Alfanumericos", "logradouro");
                                            }else if($p_numero==""){
                                                    $mensagem = mensagens("Validação", "número");
                                                }else if(!valida_numerico($p_numero, 1, 5)){
                                                        $mensagem = mensagens("Validação Decimal", "número");
                                                    }else if($p_valor_aluguel==""){
                                                            $mensagem = mensagens("Validação", "valor do aluguel");
                                                        }else if(!valida_decimal($p_valor_aluguel, 1, 8)){
                                                                $mensagem = mensagens("Validação Decimal", "valor do alguel");
                                                            }else{

                                                                    $sql_sel_locals = "SELECT * FROM locals WHERE name='".$p_nome."' AND id<>'".$p_id."'";

                                                                    $sql_sel_locals_preparado = $conexaobd->prepare($sql_sel_locals);

                                                                    $sql_sel_locals_preparado->execute();

                                                                    if($sql_sel_locals_preparado->rowCount()==0){

                                                                        $tabela = "locals";

                                                                        $dados = array(
                                                                            "districts_id" => $p_bairro,
                                                                            "name" => $p_nome,
                                                                            "area" => $valor_area,
                                                                            "height" => $valor_altura,
                                                                            "cep" => $p_cep,
                                                                            "street" => $p_logradouro,
                                                                            "number" => $p_numero,
                                                                            "rent_value" => $valor_aluguel,
                                                                            "description" => $p_descricao,
                                                                            "complement" => $p_complemento
                                                                        );

                                                                        $condicao = "id='".$p_id."'";

                                                                        $sql_sel_locals_resultado = alterar($tabela, $dados, $condicao);

                                                                        if($sql_sel_locals_resultado){
                                                                            $msg_titulo = "Confirmação";
                                                                            $mensagem = mensagens("Sucesso", "local", "Alteração");
                                                                            $voltar = "?folder=locals/&file=cb_fmins_locals&ext=php";
                                                                        }else{
                                                                            $mensagem = mensagens("Erro bd", "local", "alterar");
                                                                        }

                                                                    }else{
                                                                        $mensagem = mensagens("Repetição", "local");
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
