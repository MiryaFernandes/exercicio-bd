<?php

/******************************************************
 * objetivo: arquivo para criar a conexão com o bd mysql
 * autor: marcel
 * data: 25/02/2022
 * versão
 *****************************************************/

 //constantes para reestabelecer a conexão com bd (local do bd, usuario, senha e database)
 const SERVER = 'localhost'; 
 const USER = 'root';
 const PASSWORD = 'bcd127'; 
 const DATABASE = 'dbcontatos';

$resultado = conexaoMysql();

 //abre a conexão com o BD mysql
 function conexaoMysql ()
 {        
     $conexao = array();

     //se a conexão estabelecida com o bd, iremos ter um array de dados sobre a conexão
     $conexao = mysqli_connect(SERVER, USER, PASSWORD, DATABASE);

     if($conexao)
        return $conexao;
     else
        return false;    
 }
 
 //solicita o fechamento da conexao com o banco de dados
 function fecharMysql($conexao){

    mysqli_close($conexao);
        

 }
 /*
   exitem tres formas de criar a conexão com o bd my sql
       mysql_connect() - versao antiga do php de fazer a conexão com bd
           (não oferece perfomance de segurança)
       mysqli_connect() - versão mais atualizada do php de fazer a conexão com bd
           (ela permite ser utilizada para programação estruturada e PDO)
       PDB() - versão mais completa e eficiente para conexão com bd
           (é indicada pela segurança e PDO)
 */
?>