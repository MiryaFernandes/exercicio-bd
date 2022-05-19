<?php

/************************************************************************
 * objetivo: arquivo responsavel pela manipulação de dados de contato
 * obs: (este arquivo fará a ponte entre a view e a model)
 * 
 * autora: miryã
 * data: 10/05/2022
 * versão: 1.0
 * 
*/


require_once('modulo/config.php');

function listarEstados()
{

    //import do arquivo que vai buscar os dados no bd
    require_once('model/bd/estado.php');

    //import do arquivo que vai buscar os dados no bd
    $dados = selectAllEstado();  

    if(!empty($dados))
        return $dados;
    else
        return false;    

}


?>