<?php

/*************************************************************************
 * objetivo: arquivo responsavel por manipular os dados dentro do bd
 *                     (insert, update, select e delete)
 * 
 * autora: miryã
 * data: 11/03/22
 * versão: 1.0
*/
//import do arquivo que estabelece a conexão com o BD  
require_once('conexaoMysql.php');

//função para realizar o insrt no bd
function insertContato($dadosContato)
{

    //declaração de variavel parautilizar o return desta função
    $statusResposta = (boolean) false;

    //abre a conexao com o bd
    $conexao = conexaoMysql();

    $sql = "insert into tblcontatos
                (nome,
                telefone,
                celular,
                email,
                obs, 
                foto,
                idestado)
             
            values
                ('".$dadosContato['nome']."',
                '".$dadosContato['telefone']."',
                '".$dadosContato['celular']."',
                '".$dadosContato['email']."',
                '".$dadosContato['obs']."',
                '".$dadosContato['foto']."',
                '".$dadosContato['idestado']."');";

  
    //executa o script no bd
    //validaçao para verificar se o script sql esta correto
    if (mysqli_query($conexao, $sql))
    {
        //validaçao para verificar se uma linha foi acrescentada no bd
        if(mysqli_affected_rows($conexao))
                $statusResposta = true;
        else    
            $statusResposta = false;        
    }
    else {

        $statusResposta = false;
    }    
    
    fecharMysql($conexao);
    return $statusResposta;
                        
}



//função para realizar o update no bd
function updateContato($dadosContato)
{

    $statusResposta = (boolean) false;

    //abre a conexao com o bd
    $conexao = conexaoMysql();

    $sql = "update tblcontatos set
                (nome = '".$dadosContato['nome']."',
                telefone ='".$dadosContato['telefone']."',
                celular = '".$dadosContato['celular']."',
                email = '".$dadosContato['email']."',
                obs = '".$dadosContato['obs']."',
                foto = '".$dadosContato['foto']."',
                idestado = '".$dadosContato['idestado']."'
                
                
            where idcontato =".$dadosContato['id'];

        
    //executa o script no bd
    //validaçao para verificar se o script sql esta correto
    if (mysqli_query($conexao, $sql))
    {
        //validaçao para verificar se uma linha foi acrescentada no bd
        if(mysqli_affected_rows($conexao))
                $statusResposta = true;
        else    
            $statusResposta = false;        
    }
    else {

        $statusResposta = false;
    }    
    
    fecharMysql($conexao);
    return $statusResposta;

}



//função para realizar o excluir no bd
function deleteContato($id)
{

    $statusResposta = (boolean) false;

    //abre a conexao com o bd
    $conexao = conexaoMysql();


    //script para deletar um registro do bd
    $sql = "delete from tblcontatos where idcontato=".$id;

    //valida se o script esta correto, sem erro de sintaxe e executa no bd
    if(mysqli_query($conexao, $sql)){

        //valida se o bd teve sucesso na execução do script
       if(mysqli_affected_rows($conexao))
            $statusResposta = true;

        } 

    //fecha a conexão com o b mysql    
    fecharMysql($conexao);

    return $statusResposta;    

}



//função para realizar o selecionar todos os contatos no bd
function selectAllContato()
{
    //abre a conexao com o bd
    $conexao = conexaoMysql();

    $sql = "select * from tblcontatos order by idcontato desc";

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
                "id"        => $rsDados['idcontato'],
                "nome"      => $rsDados['nome'],
                "telefone"  => $rsDados['telefone'],
                "celular"   => $rsDados['celular'],
                "email"     => $rsDados['email'],
                "obs"       => $rsDados['obs'],
                "foto"      => $rsDados['foto']
            );

            $cont++;
        }

        fecharMysql($conexao);
        if(isset($arrayDados)){
            return $arrayDados;
        } else {
            return false;
        }
    }

    

}

//funçao para buscar um contato no bd atarves do id do registro
 function selectByIdContato($id)
 {
      //abre a conexao com o bd
      $conexao = conexaoMysql();

      $sql = "select * from tblcontatos where idcontato =".$id;
 
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
                  "obs"       => $rsDados['obs'],
                  "idestado"  => $rsDados['idestado']
              );
        }
 
         }
         fecharMysql($conexao);
 
          return $arrayDados;
    
 }
?>