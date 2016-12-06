<?php
    $p_id = $_POST['hidid'];
    $p_nome = $_POST['txtnome'];
    //Estas linhas são responsáveis por receber o id e o nome da fmupd via POST.

    $msg_titulo = "Erro";
    //Esta linha é responsável por definir a variável msg_titulo, com o valor ERRO.
    $voltar = "?folder=cities/&file=cb_fmupd_cities&ext=php&id=".$p_id;
    //Esta linha é responsável por definir a variável voltar, com o valor de voltar para a página fmupd.

    if($p_nome==""){
        //Se a variável p_nome for vazia, chama a função mensagens.
        $mensagem = mensagens('Validação', 'nome');
    }else if(!valida_nome($p_nome, 30)){
            //Se a variável p_nome, possuir números, chama a função mensagens.
            $mensagem = mensagens('Validação Nome', 'nome');
        }else{
            //Este bloco é responsável por fazer a seleção das cidades que tenham o nome igual ao da variável p_nome e o id diferente do da variável p_id.
            $sql_sel_cities = "SELECT * FROM cities WHERE name='".$p_nome."' AND id<>'".$p_id."'";
            $sql_sel_cities_preparado = $conexaobd->prepare($sql_sel_cities);
            $sql_sel_cities_preparado->execute();

            //Este bloco é responsável por verificar se a contagem de registros com a condição acima é zero, então faz a alteração, se não, diz que a cidade já existe.
            if($sql_sel_cities_preparado->rowCount()==0){
                $tabela = "cities";
                //Define o valor da variável tabela como cities.

                //Este bloco é responsável por colocar os dados recebidos do formulário em um array.
                $dados = array(
                    'name' => $p_nome
                );

                $condicao = "id='".$p_id."'";
                //Condição de o id ser igual a variável p_id.

                $sql_upd_cities_resultado = alterar($tabela, $dados, $condicao);
                //Chama a funçao alterar e atribui o valor a variável sql_upd_cities_resultado.

                //Este bloco é responsável por exibir se a alteração funcionou ou não.
                if($sql_upd_cities_resultado){
                    $msg_titulo = "Confirmação";
                    $mensagem = mensagens('Sucesso', 'Cidade', 'Alteração');
                    $voltar = "?folder=cities/&file=cb_fmins_cities&ext=php";
                }else{
                    $mensagem = mensagens('Erro bd', 'cidade', 'alterar');
                }
            }else{
                $mensagem = mensagens('Repetição', 'cidade');
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