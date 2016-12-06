<?php
/***********************************************************************************************************************************************
 *Autores: Gabriel Dezan;
           João Santucci;
           João Spieker;
           Lucas Janning;
 *Data de Criação: 17/10/2016
 *Data de Modificação: 18/10/2016
 *Descrição: Esta página contém o código responsável por conter todas as mensagem do software, para que sejam carregadas dinamicamente.
 ***********************************************************************************************************************************************/
    include "../../security/database/cb_connection_database.php";
    //Está linha representa a inclusão do arquivo que faz a conexão com o banco de dados.

    $cod = $_POST['cod'];
    //Variável recebida da página cb_fmins_clients via jquerycommands.

    if($cod==""){
        //Se a variável cod for vazia, escreva o option. Caso ele não tenha selecionado nenhuma cidade
        echo "<option value=''>Selecione uma cidade...</option>";
    }else{
        //Este bloco é responsável por fazer a seleção de todos os dados da tabela districts (bairros).
        $sql_sel_districts = "SELECT * FROM districts WHERE cities_id='$cod'";
        $sql_sel_districts_preparado = $conexaobd->prepare($sql_sel_districts);
        $sql_sel_districts_preparado->execute();
        echo "<option value=''>Escolha...</option>";
        //Devolve para a página o option com Escolha..., caso ele já tenha selecionado uma cidade.
        while($sql_sel_districts_dados = $sql_sel_districts_preparado->fetch()){
            //Escreve as cidades.
            echo "<option value=".$sql_sel_districts_dados['id'].">".$sql_sel_districts_dados['name']."</option>";
        }
    }
?>