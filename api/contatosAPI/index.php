<?php

    /**************************************************************************************
     * 
     *  $request - recebe dados do corpo da requisição (JSON, FORM/DATA, XML, etc..)
     * 
     *  $response - envia dados de retorno da API
     * 
     *  $args - permite receber dados de atributos na API
     * 
     **************************************************************************************/

    //import do arquivo autoload, que fará as instâncias do slim
    require_once('vendor/autoload.php');

    //criando um objeto do slim chamando app, para configurar os EndPoint
    $app = new \Slim\App();

    //EndPoint: Requisição para listar todos os contatos
    $app->get('/contatos', function($request, $response, $args){


        require_once('../modulo/config.php');
        require_once('../controller/controllerContatos.php');
        

        //solicita dados para a controller
        if($dados = listarContato()){

            //realiza a conversao do array de dados em formato JSON
            if($dadosJSON = createJSON($dados)){

                //caso exista dados a serem retornados, informamos o statusCode 200 e
                //enviamos um JSON com todos os dados encontrados
                $response-> withStatus(200)
                         -> withHeader('Content-Type', 'application/json')   
                         -> write($dadosJSON);

            }

        } else {

                //retorna um statusCode que significa que a requisição foi aceita, porém
                //sem conteudo de retorno
                return $response-> withStatus(204)
                                -> withHeader('Content-Type', 'application/json')   
                                -> write('{"message": "item não encontrado"}');   

        }
            
        
    });

    //EndPoint: Requisição para listar contatos pelo id
    $app->get('/contatos/{id}', function($request, $response, $args){

        //import da controller de contatos, que fará busca de dados
        $id = $args['id'];
        
        require_once('../modulo/config.php');
        require_once('../controller/controllerContatos.php');
        

        

        //solicita dados para a controller
        if($dados = buscarContato($id)){

            //realiza a conversao do array de dados em formato JSON
            if(!isset($dados['idErro'])){

                if($dadosJSON = createJSON($dados)){
            //caso exista dados a serem retornados, informamos o statusCode 200 e
            //enviamos um JSON com todos os dados encontrados
                    $response-> withStatus(200)
                            -> withHeader('Content-Type', 'application/json')   
                            -> write($dadosJSON);
                }
            }else{
                //CONVERTE PARA JSON O ERRO,pois a controller retorna em array
                $dadosJSON = createJSON($dados);
                //retorna um statusCode que significa que a requisição foi aceita, porém
                //sem conteudo de retorno
                return $response-> withStatus(404)
                                -> withHeader('Content-Type', 'application/json')   
                                -> write('{"message": "dados invalidos",
                                            "erro":'.$dadosJSON.'
                                            }'); 
    
            }
         
        } else {

            return $response-> withStatus(204)
            -> withHeader('Content-Type', 'application/json')   
            -> write('{"message": "dados invalidos",
                        "erro":'.$dadosJSON.'
                        }'); 

        }

    });


    //endpoint: requisição para deletar um contato pelo id
    $app->delete('/contatos/{id}', function($request, $response, $args){

        if(!isset($args['id']) || !is_numeric($args['id'])){

            //recebe o id enviadono endpoint atraves da variavel id
            $id = $args['id'];
            
            //import da controller contatos, que fará a busca de dados
            require_once('../modulo/config.php');
            require_once('../controller/controllerContatos.php');

            if($dados = buscarContato($id)){

                $foto = $dados['foto'];

                $arrayDados = array (
                    "id"   => $id,
                    "foto" => $foto
                );

                //chama a função de excluir o contato, encaminhando o array com o ID e a foto
                if(excluirContato($arrayDados)){

                    if(is_bool($resposta) && $resposta == true){

                        return $response-> withStatus(200)
                        -> withHeader('Content-Type', 'application/json')   
                        -> write('{"message": "registro excluido com sucesso!"}');

                    } elseif(is_array($resposta)){

                        $dadosJSON = createJSON($resposta)

                        return $response-> withStatus(200)
                        -> withHeader('Content-Type', 'application/json')   
                        -> write('{"message": "houve um problema no processo de exclusão"
                                              "erro":'.$dadosJSON.'}');

                    }
                    

                }
            } else {

                return $response-> withStatus(404)
                                    -> withHeader('Content-Type', 'application/json')   
                                    -> write('{"message": "o id informado não existe na base de dados"}'); 
            }

        } else {

                
                 return $response-> withStatus(204)
                                 -> withHeader('Content-Type', 'application/json')   
                                 -> write('{"message": "é obrigatorio informar um id com formato valido"}'); 

        }
        

        
    });


    //EndPoint: Requisição para inserir um novo contatos
    $app->post('/contatos', function($request, $response, $args){

    });

    //Executa todos os EndPoints
    $app->run();
    
?>