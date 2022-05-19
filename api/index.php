
<?php

/**************************************************************
 * 
 * objetivo: arquivo principal da API que irá receber a URL requisitada
 * e redirecionar para as APIs (router)
 * 
 * data: 19/05/2022
 * 
 * autora: miryã
 * 
 *versão: 1.0 
 **************************************************************/

//permite ativar quais endereços de sites que poderão fazer requisições na API (* liibera para todos os sites)
header('Acess-Control-Allow-Origin: *');

//permite ativar os metodos de protocolo HTTP que irão requisitar a API
header('Acess-Control-Allow-Methods: GET, POST, DELETE, OPTIONS');

//permite ativar o Content-Type das requisições (forato de dados que sera utilizado (JSON, XML, FORM/DATA, etc..))
header('Acess-Control-Allow-Header: Content-Type');

//permite liberar quais Content-Type serão utlizados na API
header('Content-Type: application/json');

//recebe a URL digitada na requisição
$urlHTTP = (string) $_GET['url'];
var_dump($urlHTTP);
die;

?>