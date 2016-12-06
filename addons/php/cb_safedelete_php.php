<?php
/***********************************************************************************************************************************************
 *Autores: Gabriel Dezan;
           João Santucci;
           João Spieker;
           Lucas Janning;
 *Data de Criação: 09/10/2016
 *Data de Modificação: 09/10/2016
 *Descrição: Esta página contém o código responsável por dar mais segurança no momento da exclusão do registros.
 ***********************************************************************************************************************************************/

function safedelete($id1, $id2, $action, $oc1, $oc2){
    //Criptografando o nome do formulário, o id1 e o id2
    $nomeForm = md5($id1.time());
    $criptoId1 = md5($id1);
    $criptoId2 = md5($id2);

    $linkSeguro = "<form name='".$nomeForm."' action='".$action."' method='POST'>";
    //Linha responsável por armazenar o Inicio formulário na variavel
    $linkSeguro .= "<input type='hidden' name='id1' value='".$criptoId1."'/>";
    //Linha responsável por continuar a varial, armazenado o Input hidden 1
    //Este bloco é responsável por verificar se id2 é vazio
    if($id2!=""){
        $linkSeguro .= "<input type='hidden' name='id2' value='".$criptoId2."'/>";
        //Linha responsável por continuar a varial, armazenado o Input hidden 2
    }
    $linkSeguro .= "<input type='image' src='../layout/images/trash.png' style='width:25px; heigh:25px; padding: 0; background: none;' onClick='return confirmacao(\"$oc1\", \"$oc2\")' title='Excluir Registro'/>";
    //Linha responsável por continuar a varial, armazenado a imagem
    $linkSeguro .= "</form>";
    //Linha responsável por continuar a varial, armazenado o final do formulário

    return $linkSeguro;
    //Linha responsável por retornar o formulário criado e armazenado na variavel
}
?>