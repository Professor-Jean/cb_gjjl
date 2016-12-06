<?php
    $p_nome = $_POST['txtnome'];
    //Esta linha é responsável por receber o nome da fmins via POST.

    $msg_titulo = "Erro";
    //Esta linha é responsável por definir a variável msg_titulo, com o valor ERRO.

    if($p_nome==""){
        //Se a variável p_nome for vazia, chama a função mensagens.
        $mensagem = mensagens('Validação', 'nome');
    }else if(!valida_nome($p_nome, 30)){
            //Se a variável p_nome, possuir números ou passar de 30 caracteres, chama a função mensagens.
            $mensagem = mensagens('Validação Nome', 'nome');
        }else{
            //Este bloco é responsável por fazer a seleção das cidades que tenham o nome igual a variável p_nome.
            $sql_sel_cities = "SELECT * FROM cities WHERE name='".$p_nome."'";
            $sql_sel_cities_preparado = $conexaobd->prepare($sql_sel_cities);
            $sql_sel_cities_preparado->execute();

            //Este bloco é responsável por verificar se a contagem de registros com a condição acima é zero, então faz a inserção, se não, diz que a cidade já existe.
            if($sql_sel_cities_preparado->rowCount()==0){
                $tabela = "cities";
                //Define o valor da variável tabela como cities.

                //Este bloco é responsável por colocar os dados recebidos do formulário em um array.
                $dados = array(
                    'name' => $p_nome
                );

                $sql_ins_cities_resultado = adicionar($tabela, $dados);
                //Chama a funçao adicionar e atribui o valor a variável sql_ins_cities_resultado.

                //Este bloco é responsável por exibir se a inserção funcionou ou não.
                if($sql_ins_cities_resultado){
                    $msg_titulo = "Confirmação";
                    $mensagem = mensagens('Sucesso', 'Cidade', 'Cadastro');
                }else{
                    $mensagem = mensagens('Erro bd', 'cidade', 'cadastrar');
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
    <a href="?folder=cities/&file=cb_fmins_cities&ext=php"><img src="../layout/images/back.png">Voltar</a>
</div>