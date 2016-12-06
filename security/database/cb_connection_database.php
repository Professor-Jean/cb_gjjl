<?php
/***********************************************************************************************************************************************
 *Autores: Gabriel Dezan;
           João Santucci;
           João Spieker;
           Lucas Janning;
 *Data de Criação: 29/09/2016
 *Data de Modificação: 29/09/2016
 *Descrição: Esta página contém o código responsável por realizar a conexão com o banco de dados.
 ***********************************************************************************************************************************************/

include "cb_configuration_database.php";
//Esta linha é responsável por incluir a página de configuração do bd.

try{
	$conexaobd = new PDO("mysql:host=".$servidor.";dbname=".$banco.";charset=utf8", $usuario, $senha);
    //Esta linha é responsável por realizar a conexão com o bd.
}catch(PDOException $e){
	die ("Erro ao se conectar com o banco de dados: ".$e->getMessage());
    //Esta linha é responsável por não permitir que o programa continue e exibe uma mensagem de erro.
}

?>
