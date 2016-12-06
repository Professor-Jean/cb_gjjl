<?php
/***********************************************************************************************************************************************
 *Autores: Gabriel Dezan;
           João Santucci;
           João Spieker;
           Lucas Janning;
 *Data de Criação: 04/10/2016
 *Data de Modificação: 03/11/2016
 *Descrição: Esta página é responsável por realizar as operações SQL dinâmicamente.
 ***********************************************************************************************************************************************/

//Esta função é responsável por criar a sintaxe de inserção dos dados no Bd.
function adicionar($adc_tabela, $adc_dados){

  $adc_campos = array_keys($adc_dados);
  //Linha responsável por armazenar apenas as chaves dos arrays
  $adc_n_campos = count($adc_campos);
  //Linha responsável por contar e armazer a quantidade de campos no array

  $adc_sintaxe = "INSERT INTO ".$adc_tabela." (";
  //Linha responsável por iniciar a sintaxe de inserção

  //Este bloco é responsável por armazer os campos necessários na variavel
  for($adc_aux=0; $adc_aux<$adc_n_campos; $adc_aux++){
    	$adc_sintaxe.= $adc_campos[$adc_aux].", ";
  }

  $adc_sintaxe = substr($adc_sintaxe, 0, -2);
  //Linha responsável por retirar os dois últimos caracteres da sintaxe ', '
  $adc_sintaxe.= ") VALUES (";
  //Linha responsável por continuar a sintaxe

  //Bloco responsável por
      for($adc_aux=0; $adc_aux<$adc_n_campos; $adc_aux++){
          $adc_sintaxe.= ":".$adc_campos[$adc_aux].", ";
      }
      $adc_sintaxe = substr($adc_sintaxe, 0, -2);
      $adc_sintaxe.= ")";

      $adc_sintaxe = htmlspecialchars($adc_sintaxe);
      global $conexaobd;
      $adc_preparado = $conexaobd->prepare($adc_sintaxe);
      for($adc_aux=0; $adc_aux<$adc_n_campos; $adc_aux++){
          if($adc_dados[$adc_campos[$adc_aux]]=="") {
              $adc_dados[$adc_campos[$adc_aux]] = NULL;
          }
          $adc_preparado->bindParam(":" .$adc_campos[$adc_aux], $adc_dados[$adc_campos[$adc_aux]]);
      }
      $adc_resultado = $adc_preparado->execute();

      return $adc_resultado;
}

function alterar($alt_tabela, $alt_dados, $alt_condicao){

    $alt_campos = array_keys($alt_dados);
    $alt_n_campos = count($alt_dados);

    $alt_sintaxe = "UPDATE ".$alt_tabela." SET ";

    for($alt_aux=0; $alt_aux<$alt_n_campos; $alt_aux++){
        $alt_sintaxe.= $alt_campos[$alt_aux]."=";
        $alt_sintaxe.= ":".$alt_campos[$alt_aux].", ";
    }

    $alt_sintaxe = substr($alt_sintaxe, 0, -2);
    $alt_sintaxe.= " WHERE ". $alt_condicao;

    $alt_sintaxe = htmlspecialchars($alt_sintaxe);
    global $conexaobd;
    $alt_preparado = $conexaobd->prepare($alt_sintaxe);
    for($alt_aux=0; $alt_aux<$alt_n_campos; $alt_aux++){
        if(!$alt_dados[$alt_campos[$alt_aux]]){
            $alt_dados[$alt_campos[$alt_aux]] = NULL;
        }
        $alt_preparado -> bindParam(":".$alt_campos[$alt_aux], $alt_dados[$alt_campos[$alt_aux]]);
    }

    $alt_resultado = $alt_preparado->execute();

    return $alt_resultado;
}

function deletar($del_tabela, $del_condicao){

    $del_sintaxe = "DELETE FROM ".$del_tabela." WHERE ". $del_condicao;

    global $conexaobd;

    $del_preparado = $conexaobd->prepare($del_sintaxe);
    $del_resultado = $del_preparado->execute();

    return $del_resultado;
}

 ?>
