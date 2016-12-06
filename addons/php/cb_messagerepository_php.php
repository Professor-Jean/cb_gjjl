<?php
/***********************************************************************************************************************************************
 *Autores: Gabriel Dezan;
           João Santucci;
           João Spieker;
           Lucas Janning;
 *Data de Criação: 02/10/2016
 *Data de Modificação: 16/10/2016
 *Descrição: Esta página contém o código responsável por conter todas as mensagem do software, para que sejam carregadas dinamicamente.
 ***********************************************************************************************************************************************/

 /*****************
   #tipos:
    *Validação
    *Erro bd
    *Repetição
    *Sucesso
    *Vazio
    *Integridade
 *****************/

  //Esta estrutura é responsável pelo repositório de mensagem, onde todas as mensagens estão criadas com um padrão para aceitarem vários tipos de situações.
  function mensagens($tipo, $assunto=NULL, $acao=NULL){
      //Esta estrutura é responsável pela escolha de cada situação possível.
    switch($tipo) {
      case 'Validação':
        return 'O campo '.$assunto.' não foi preenchido!';
        break;
      case 'Validação Nome':
        return 'O campo '.$assunto.' não foi preenchido corretamente, use somente letras!';
      break;
      case 'Validação Numerico':
        return 'O campo '.$assunto.' não foi preenchido corretamente, use somente números!';
        break;
      case 'Validação Decimal':
        return 'O campo '.$assunto.' não foi preenchido corretamente, use somente números, caso seja número decimal use uma vírgula para separar, Ex: 10,50!';
        break;
      case 'Validação Alfanumericos':
        return 'O campo '.$assunto.' não foi preenchido corretamente, use somente letras e/ou números!';
        break;
      case 'Validação Email':
        return 'O campo Email não foi preenchido corretamente!';
        break;
      case 'Validação Fone':
        return 'O campo Telefone não foi preenchido corretamente!';
        break;
      case 'Validação Data':
        return 'O campo Data não foi preenchido corretamente, use DD/MM/AAAA!';
        break;
      case 'Validação Horario':
        return 'O campo Horário não foi preenchido corretamente, verifique se você preencheu o seu horario de nascimento corretamente, use HH:MM!';
        break;
      case 'Erro bd':
        return 'Erro ao '.$acao.' o/a '.$assunto.'!';
      break;
      case 'Repetição':
        return 'Este(a) '.$assunto.' já foi registrado(a)!';
      break;
      case 'Sucesso':
        return $acao.' de '.$assunto.' realizado(a) com sucesso!';
      break;
      case 'Vazio':
        return 'Não há registros de '.$assunto.' no sistema!';
      break;
      case 'Integridade':
        return 'Há registro(s) de '.$assunto.' associado(s) a este registro, portanto exclua-o(s) e refeça a operação!';
      break;
      default:
        return 'Erro na mensagem: Tipo informado não existe.';
      break;
    }
  }

 ?>
