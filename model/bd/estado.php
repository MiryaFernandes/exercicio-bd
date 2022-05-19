<?php

/*************************************************************************
 * objetivo: arquivo responsavel por manipular os dados dentro do bd
 *                     (select)
 * 
 * autora: miryã
 * data: 10/05/22
 * versão: 1.0
*/

require_once('conexaoMysql.php');

function selectAllEstado()
{

    //abre a conexao com o bd
    $conexao = conexaoMysql();

    $sql = "select * from tblestados order by nome asc";

    //
    $result = mysqli_query($conexao, $sql);


    //valida se o bd retornou registros
    if($result)
    {
        //mysql_fetch_assoc() - permite converter os dados do bd
        //em um array para manipulaçao no php
        //nesta repetição estamos, convertendo os dados do bd em um array
        //($rsDados), alem de o proprio while conseguir gerenciar a qtde 
        //de vezes que devera ser feita a repetiçao

        $cont = 0;
        while($rsDados = mysqli_fetch_assoc($result)){

            //cria um array com os dados do bd
            $arrayDados[$cont] = array (
                "idestado"        => $rsDados['idestados'],
                "nome"      => $rsDados['nome'],
                "sigla"  => $rsDados['sigla']
                
            );

            $cont++;
        }

        fecharMysql($conexao);

        return $arrayDados;
    }

    

}

//funçao para buscar um contato no bd atarves do id do registro
function selectByIdContato($id)
{
     //abre a conexao com o bd
     $conexao = conexaoMysql();

     $sql = "select * from tblestados where idcontato =".$id;
 
     //
     $result = mysqli_query($conexao, $sql);
 
 
     //valida se o bd retornou registros
     if($result)
     {
         //mysql_fetch_assoc() - permite converter os dados do bd
         //em um array para manipulaçao no php
         //nesta repetição estamos, convertendo os dados do bd em um array
         //($rsDados), alem de o proprio while conseguir gerenciar a qtde 
         //de vezes que devera ser feita a repetiçao
         if($rsDados = mysqli_fetch_assoc($result)){
 
             //cria um array com os dados do bd
             $arrayDados = array (
                 "id"        => $rsDados['idcontato'],
                 "nome"      => $rsDados['nome'],
                 "telefone"  => $rsDados['telefone'],
                 "celular"   => $rsDados['celular'],
                 "email"     => $rsDados['email'],
                 "obs"       => $rsDados['obs']
             );
         }
 
        }
         fecharMysql($conexao);
 
         return $arrayDados;
    
}

?>