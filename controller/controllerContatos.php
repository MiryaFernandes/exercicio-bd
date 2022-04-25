<?php

/************************************************************************
 * objetivo: arquivo responsavel pela manipulação de dados de contato
 * obs: (este arquivo fará a ponte entre a view e a model)
 * 
 * autora: miryã
 * data: 04/03/2022
 * versão: 1.0
 * 
*/

//função para receber dados da view w encainhar para a model(inserir)
function inserirContato ($dadosContato)
{
    //validação para verificar se o objeto está vazio
    if(!empty($dadosContato))
    {

        if(!empty($dadosContato['txtNome']) && !empty($dadosContato['txtCelular']) && !empty($dadosContato['txtEmail'])){
               //criaçao do array de dados que sera encaminhado a model,
               //para inserir no bd, é importante criar este array conforme
               //as necessidades de manipulação do BD.
               //obs: criar as chaves do array conforme os nomes dos00 atributos 
               $arrayDados = array (
                   "nome" => $dadosContato['txtNome'],
                   "telefone" => $dadosContato['txtTelefone'],
                   "celular" => $dadosContato['txtCelular'],
                   "email" => $dadosContato['txtEmail'],
                   "obs" => $dadosContato['txtObs'],
               );

               //import do arquivo d emodelagem para manipular o bd
               require_once('model/bd/contato.php');
               //chama a funçao que fara o insert no bd
                if (insertContato($arrayDados))
                    return true;
                else
                    return array('idErro' => 1, 'message' => 'não foi posivel inserir os dados no banco de dados');    
        
        }else 
            return array('idErro' => 2, 'message' => 'existem campos obrigatorios que nao foram preenchidos'); 
    }

}

//função para receber dados da view w encainhar para a model(atualizar)
function atualizarContato ()
{



}

//função para realizar a exclusão de um contato
function excluirContato ($id)
{


    //validação para verificar se id contem um numer valido
    if($id != 0 && !empty($id) && is_numeric($id)){

        //import do arquivo do contato
        require_once('model/bd/contato.php');

        //chama a função do model e valida se o retorno foi verdadeiro ou falso
        if (deleteContato($id))
            return true;
        else
            return array ('idErro' => 3,
                            'message' => 'o banco de dados não pode excluir o registro.'        
                         );
    } else

        return array ('idErro' => 4,
        'message' => 'não é possivel excluir o registro sem informar um id válido.'        
     );

}

//função para solicitar os dados da model e encaminhar a lista
//de contatos para a view
function listarContato ()
{

    //import do arquivo que vai buscar os dados no bd
    require_once('model/bd/contato.php');

    //import do arquivo que vai buscar os dados no bd
    $dados = selectAllContato();  

    if(!empty($dados))
        return $dados;
    else
        return false;    

}

//funçao para buscar um contato atraves do id do registro 
function buscarContato($id)
{
    if($id !=0 && !empty($id) && is_numeric($id))
    {
        //import do arquivo de contato
        require_once('model/bd/contato.php');

        $dados = selectByIdContato($id);

        //valida se existe dados para serem desenvolvidos
        if(!empty($dados))
            return $dados;
        else
            return false;    
    } else 
    
    return array('idErro' => 3, 
                    'message' => 'não é possivel excluir o registro sem informar um id valido'); 

}


?>