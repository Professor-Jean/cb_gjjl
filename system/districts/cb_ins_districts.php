<?php
    $p_cidade = $_POST['selcidade'];
    $p_bairro = $_POST['txtbairro'];
    //Estas linhas são responsáveis por receber a cidade e o bairro da fmins via POST.

    $msg_titulo = "Erro";
    //Esta linha é responsável por definir a variável msg_titulo, com o valor ERRO.

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
                //Este bloco é responsável por fazer a seleção dos bairros que tenham nome igual a variável p_bairro.
                $sql_sel_districts = "SELECT * FROM districts WHERE name='".$p_bairro."' AND cities_id='".$p_cidade."'";
                $sql_sel_districts_preparado = $conexaobd->prepare($sql_sel_districts);
                $sql_sel_districts_preparado->execute();

                //Este bloco é responsável por verificar se a contagem de registros com a condição acima é zero, então faz a inserção, se não, diz que o bairro já existe.
                if($sql_sel_districts_preparado->rowCount()==0){
                    $tabela = "districts";
                    //Define o valor da variável tabela como districts.

                    //Este bloco é responsável por colocar os dados recebidos do formulário em um array.
                    $dados = array(
                        'cities_id' => $p_cidade,
                        'name' => $p_bairro
                    );

                    $sql_ins_districts_resultado = adicionar($tabela, $dados);
                    //Chama a funçao adicionar e atribui o valor a variável sql_ins_districts_resultado.

                    //Este bloco é responsável por exibir se a inserção funcionou ou não.
                    if($sql_ins_districts_resultado){
                        $msg_titulo = "Confirmação";
                        $mensagem = mensagens('Sucesso', 'Bairro', 'Cadastro');
                    }else{
                        $mensagem = mensagens('Erro bd', 'bairro', 'cadastrar');
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
    <a href="?folder=districts/&file=cb_fmins_districts&ext=php"><img src="../layout/images/back.png">Voltar</a>
</div>