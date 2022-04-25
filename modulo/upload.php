<?php

/************************************************************
 * objetivo: arquivo responsavel em realizar upload de arquivos
 * autora: mirya
 * data: 25/04/2022
 * versao: 1.0
 */

 //funçao para realizar upload de imagens
 function uploadFile($arrayFile){

    require_once('modulo/config.php');

    $arquivo = $arrayFile;
    $sizeFile = (int) 0; 
    $typeFile = (string) null;
    $nameFile = (string) null;

    //validação para identificar se existe um arquivo valido (maior que 0 e que tenha uma extensão)
    if($arquivo['size'] > 0 && $arquivo['type'] != "")
    {
        //recupera o tamanho do arquivo que é em bytes e converte para kb ( /1024)
        $sizeFile = $arquivo['size']/1024;

        //recupera o tipo do arquivo
        $typeFile = $arquivo['type'];

        //recupera o nome do arquivo
        $nameFile = $arquivo['name'];

        //validaçao para permitir o upload apenas de arquivos de no maximo 5mb
        if($sizeFile <= MAX_FILE_UPLOAD)
        {
            if(in_array($typeFile, EXT_FILE_UPLOAD))
            {

                //separa somente o nome do arquivo sem a sua extensão
                $nome = pathinfo($nameFile, PATHINFO_FILENAME);

                $extensao = pathinfo($nameFile, PATHINFO_FILENAME);

            } else {

                return array('idErro' => 12,
                         'message' => 'a extensão do arquivo selecionado não é permitida no upload');
            }
        } else {
            return array('idErro' => 10,
                         'message' => 'tamanho de arquivo invalido no upload');
        } 

    } else {

        return array('idErro' => 11,
                         'message' => 'não é possivel realizar o upload sem um arquivo selecionado');

    }

 }

?>

