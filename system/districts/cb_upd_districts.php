<?php
    $p_id = $_POST['hidid'];
    $p_cidade = $_POST['selcidade'];
    $p_bairro = $_POST['txtbairro'];
    //Estas linhas são responsáveis por receber a cidade e o bairro da fmupd via POST.

    $msg_titulo = "Erro";
    //Esta linha é responsável por definir a variável msg_titulo, com o valor ERRO.

    $voltar = "?folder=districts/&file=cb_fmupd_districts&ext=php&id=".$p_id;
    //Esta linha é responsável por definir a variável voltar, com o valor de voltar para a página fmupd.

    if($p_cidade==""){
        //Se a variável p_cidade for vazia, chama a função mensagens.
        $mensagem = mensagens('Validação', 'cidade');
    }else if($p_bairro==""){
            //Se a variável p_bairro for vazia, chama a função mensagens.
            $mensagem = mensagens('Validação', 'bairro');
        }else if(!valida_nome($p_bairro, 25)){
                //Se a variável p_bairro, possuir números, caracteres especiais ou passar de 25 caracteres, chama a função mensagens.
                $mensagem = mensagens('Validação Nome', 'bairro');
            }else{
                //Este bloco é responsável por fazer a seleção dos bairros com o nome igual a variável p_bairro e id diferente da variável p_id.
                $sql_sel_districts = "SELECT * FROM districts WHERE name='".$p_bairro."' AND cities_id='".$p_cidade."' AND id<>'".$p_id."'";
                $sql_sel_districts_preparado = $conexaobd->prepare($sql_sel_districts);
                $sql_sel_districts_preparado->execute();

                //Este bloco é responsável por verificar se a contagem de registros com a condição acima é zero, então faz a alteração, se não, diz que o bairro já existe.
                if($sql_sel_districts_preparado->rowCount()==0){
                    $tabela = "districts";
                    //Define o valor da variável tabela como clients.

                    //Este bloco é responsável por colocar os dados recebidos do formulário em um array.
                    $dados = array(
                        'cities_id' => $p_cidade,
                        'name' => $p_bairro
                    );

                    $condicao = "id='".$p_id."'";
                    //Condição de o id ser igual a variável p_id.

                    $sql_upd_districts_resultado = alterar($tabela, $dados, $condicao);
                    //Chama a funçao alterar e atribui o valor a variável sql_upd_districts_resultado.

                    //Este bloco é responsável por exibir se a alteração funcionou ou não.
                    if($sql_upd_districts_resultado){
                        $msg_titulo = "Confirmação";
                        $mensagem = mensagens('Sucesso', 'Bairro', 'Alteração');
                        $voltar = "?folder=districts/&file=cb_fmins_districts&ext=php";
                    }else{
                        $mensagem = mensagens('Erro bd', 'bairro', 'alterar');
                    }
                }else{
                    $mensagem = mensagens('Repetição', 'bairro');
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