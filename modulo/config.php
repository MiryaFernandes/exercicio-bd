<?php

/************************************************************
 * objetivo: arquivo responsavel pela criaçao de variaveis e constantes
 * autora: mirya
 * data: 25/04/2022
 * versao: 1.0
 */

 /**************************************variaveis e constantes gkobais do projeto*************************************/

 const MAX_FILE_UPLOAD = 5120;

 const EXT_FILE_UPLOAD = array("image/jpg", "image/jpeg", "image/gif", "image/png");

 const DIRETORIO_FILE_UPLOAD ="arquivo/";

 define('SRC', $_SERVER['DOCUMENT_ROOT'].'/mirya/aula7/');
 
 /********************************funçoes globais para o projeto*******************************/
 function createJSON($arrayDados){


    if(!empty($arrayDados)){
    //configura o padrão da conversa par o formato JSON
    header('Content-Type: application/json');
    $dadosJSON = json_encode($arrayDados);

    //json_encode() = converte um array para json
    //json_decode() = converte um json para array

    return $dadosJSON;

    } else {

        return false;
    }


 }
 ?>