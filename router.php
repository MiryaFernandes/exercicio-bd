<?php
/****************************************************************************
 * objetivo: arquivo de rota, para segmentar as açoes encaminhadas pela view
 *    (dados de um form, listagem de dados, ação de excluir ou atualizar).
 *    esse arquivo será responsavel por encaminhar as solicitações para a
 *                               controller
 * 
 * autora: miryã
 * data: 04/03/2022
 * versão: 1.0
 * 
******************************************************************************/

    $action = (string) null;
    $component = (string) null;

   //validação para verificar se a requisiçao é um POST de um formulario 
   if($_SERVER['REQUEST_METHOD'] == 'POST' || $_SERVER['REQUEST_METHOD'] == 'GET')
   {

      //recebendo dados via URL para saber quem esta solicitando e qual 
      //ação será realizada
      $component = strtoupper($_GET['component']);
      $action = strtoupper($_GET['action']);

      //estrutura condicional para validar quem esta solicitando algo para o router 
      switch($component)
      {
 
         case 'CONTATOS':
            //import da controller contatos
            require_once('controller/controllerContatos.php');

            //validaçao par identificar o tipo de açao que sera realizada
            if($action == 'INSERIR')
            {
              
               if(isset($_FILES) && !empty($_FILES))
                 {
                    //chama a funçao de inserir na controller
                    $resposta = inserirContato($_POST, $_FILES);

                 } else {

                  $resposta = insertContato($_POST, null);

                 }
              //valida o tipo de dados que a controller retornou
              if(is_bool($resposta)) //se for booleano
              {
                 //verificar se o retorno foi verdadeiro
                 if($resposta)
                     echo("<script> alert('registro inserido com sucesso!');
                     window.location.href = 'index.php';
                     </script>");
                
               //se o retorno for um array significa que houve erro no processo de inserçao      
              } elseif (is_array($resposta))
                     echo("<script> alert('".$resposta['message']."');
                     window.history.back();
                     </script>");

            } elseif($action == 'DELETAR') 
            {
               //recebe o id do registro que devera ser excluido,
               //que  foi enviado pela url no link da imagem do
               //excluir que foi acionado no index 
               $idcontato = $_GET['id'];
               $foto = $_GET['foto'];


               //criamos um array para encaminhar os valores do id e da foto
               //para a controller
               $arrayDados = array (

                  "id" => $idcontato,
                  "foto" => $foto

               );

               //chama a função de excluir na conta controller
               $resposta = excluirContato($arrayDados);

               if(is_bool($resposta))
               {

                  if($resposta)
                  {

                     echo("<script> 
                        alert('registro excluido com sucesso!');
                        window.location.href = 'index.php';
                     </script>");
                      
                  } elseif (is_array($resposta))
                  {

                     echo("<script> 
                        alert('".$resposta['message']."');
                        window.history.back();
                     </script>");
                     
                  }

               }
            } elseif ($action == 'BUSCAR')
            {

               //recebe o id do registro que devera ser editado,
               //que  foi enviado pela url no link da imagem do
               //excluir que foi acionado no index 
               $idcontato = $_GET['id'];

               //chama a funçao de excluir na controller
               $dados = buscarContato($idcontato);

               session_start();

               //guarda em uma variavel de sessao os dados que o BD retornou para  busca do id
               //obs: essa variavel de sessao sera sera utilizada na index.php, para colocar
               //os dados na caixa de texto 
               $_SESSION['dadosContato'] = $dados;

               //utilizando o header tambem poderemos chamar a index.php,
               //porem havera uma ação de carregamento no navegador
               //(piscando a tela novamente)

               //header('location: index.php');

               //utilizandoo o require iremos apenas importar a tela index,
               //assim não havendo um novo carregamento da pagina
               require_once('index.php');

            } elseif ($action == 'EDITAR')
            {

                    $idcontato = $_GET['id'];
                    $foto = $_GET['foto'];


                     //crria um array contendo o id e o nome da foto parar enviar a controller
                    $arrayDados = array (

                        "id" => $idcontato,
                        "foto" => $foto
                    );
      
                    //chama a funçao de editar na controller
                    $resposta = atualizarContato($_POST, $arrayDados);

                    //valida o tipo de dados que a controller retornou
                    if(is_bool($resposta)) //se for booleano
                    {

                       //verificar se o retorno foi verdadeiro
                       if($resposta)
                           echo("<script> alert('registro inserido com sucesso!');
                           window.location.href = 'index.php';
                           </script>");
                      
                     //se o retorno for um array significa que houve erro no processo de inserçao      
                    } elseif (is_array($resposta))
                           echo("<script> 
                                    alert('".$resposta['message']."');
                                    window.history.back();
                                 </script>");

            }


              
         break;

      }
   }

?>