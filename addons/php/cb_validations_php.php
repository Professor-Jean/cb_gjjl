<?php
/***********************************************************************************************************************************************
 *Autores: Gabriel Dezan;
           João Santucci;
           João Spieker;
           Lucas Janning;
 *Data de Criação: 04/10/2016
 *Data de Modificação: 11/10/2016
 *Descrição: Esta página contem o código responsável por validar todos os campos do software utilizando preg_match.
 ***********************************************************************************************************************************************/

    /* Validação dos campos de Nome de usuário. Não permite:
     * Caracteres especiais
     * Espaços
     * Mais de 20 caracteres
    */
    function valida_usuario($campo){
        return preg_match("/^([a-zA-Z0-9]{4, 20})$/", $campo);
    }

    /*  Validação dos campos de Nome. Não permite:
     * Números
     * Caracteres especiais
     */
    function valida_nome($campo, $max){
        return preg_match("/^(([a-zA-ZÀ-ú ]){1,".$max."})$/", $campo);
    }

    /* Validação dos campos alfanumericos. Não Permite:
     * Caracteres Especiais
    */
    function valida_alfanumerico($campo, $min, $max){
        return preg_match("/^([À-ú+[:alnum:]+[:space:]]{".$min.",".$max."})$/", $campo);
    }

    /* Validação dos campos numéricos. Não Permite:
     * Letras
     * Caracteres Especiais
     * Espaços
    */
    function valida_numerico($campo, $min, $max){
        return preg_match("/^([0-9]{".$min.",".$max."})$/", $campo);
    }

    /* Validação dos campos com horário. Não Permite:
     * Letras
     * Caracteres Especias(exceto ':')
     * Espaços
     * Horários Inválidos(ex.: '28:75')
     * Mais de 5 caracteres
    */
    function valida_horario($campo){
        return preg_match("/^(((([0-1]{1}+[0-9]{1})||([2]{1}+[0-3]{1}))+[:]{1}+([0-5]{1}+[0-9]{1}))||(((([0-1]{1}+[0-9]{1})||([2]{1}+[0-3]{1}))+[:]{1}+([0-5]{1}+[0-9]{1}))+[:]{1}+([0-5]{1}+[0-9]{1})))$/", $campo);
    }

    /* Validação dos campos com data. Não Permite:
     * Letras
     * Caracteres Epeciais(exceto '/')
     * Espaços
     * Datas Inválidas(ex.: '30/02/2222')
    */
    function valida_data($ano, $mes, $dia){
        return checkdate(is_numeric($mes), is_numeric($dia), is_numeric($ano));
    }

    /* Validação de campos com valores decimais. Não permite:
     * Letras
     * Caracteres Especiais(exceto ',')
     * Espaços
     * Mais de 2 casas depois da vírgula
     * Menos de 2 casas depois da vírgula
    */
    function valida_decimal($campo, $min, $max){
        return preg_match("/^(([0-9])||([0-9]+[,]{1}+[0-9]{1})){".$min.",".$max."}$/", $campo);
        //return preg_match("/^(([0-9])||([0-9]+[,]{1}+[0-9]{2})){" . $min . "," . $max . "}$/", $campo);
        // /\ !!!!Verificar!!!! /\
        //Quando for validar um campo com dinheiro não esquecer de dar explode, pois está no modo brasileiro com vírgula
    }

    /* Validação de campos com email. Não Permite:
     * Email Inválido(ex.: joaozinhos.batman@ligadajustiça)
    */
    function valida_email($campo){
      return filter_var($campo ,FILTER_VALIDATE_EMAIL);
    }

    /* Validação de número de telefone. Não Permite:
     * Letras
     * Mais de 15 caracteres
     * Caracteres especias(Exceto '-')
    */
    function valida_telefone($campo){
        return preg_match("/^(([1-9]{1,2}[ ])?[0-9]{1,3}[ ])?[0-9]{3,5}([-])?[0-9]{4,5}$/", $campo);
    }
 ?>
