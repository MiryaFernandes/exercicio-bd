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

require_once('modulo/config.php');

//função para receber dados da view w encainhar para a model(inserir)
function inserirContato ($dadosContato, $file)
{
    $nomeFoto = (string) null;
    
    //validação para verificar se o objeto está vazio
    if(!empty($dadosContato))
    {

        if(!empty($dadosContato['txtNome']) && !empty($dadosContato['txtCelular']) && !empty($dadosContato['txtEmail']))
        {
            //validaçao para identificar se chegou um arquivo para upload
            if($file != null)
            {

                //import da funçao de upload
                require_once('modulo/upload.php');

                //chama a funçao de upload
                $nomeFoto = uploadFile($file['fleFoto']);
                
                if(is_array($nomeFoto))
                {
                    //caso aconteça algum erro no processo de upload, funçao ir devolver a 
                    //seguinte mensagem de erro. esse array sera retornado para a router e
                    //ela irá exibir a mensagem para o usuario
                    return $nomeFoto;
                }
            }
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
                   "foto" => $nomeFoto,
                   "idestado" => $dadosContato['sltEstado']
               );

               //import do arquivo d emodelagem para manipular o bd
               require_once('model/bd/contato.php');
               //chama a funçao que fara o insert no bd
                if (insertContato($arrayDados))
                    return true;
                else
                    return array('idErro' => 1, 'message' => 'não foi posivel inserir os dados no banco de dados');    
        
        }else 
            return array('idErro' => 2, 'message' => 'existem campos obrigatorios que não foram preenchidos'); 
    }

}

//função para receber dados da view w encainhar para a model(atualizar)
function atualizarContato ($dadosContato, $id)
{

    $statusUpload = (boolean)

    //recebe o id enviado pelo arrayDados
    $id = $dadosContato['id'];

    //recebe a foto enviada pelo arrayDados (nome da foto que ja existe no bd)
    $foto = $dadosContato['foto'];

    //recebe o objeto de array referente a nova foto que podera ser enviada ao servidor
    $file = $dadosContato['file'];
    //validação para verificar se o objeto está vazio
    if(!empty($dadosContato))
    {

        //validaçao de caixa vazia dos elementos nome, celular e email
        //pois são obrigatorios no bd 
        if(!empty($dadosContato['txtNome']) && !empty($dadosContato['txtCelular']) && !empty($dadosContato['txtEmail']) && !empty($dadosContato['sltEstado'])){

            if(!empty($id) && $id != 0 && is_numeric($id)) {

                if($file['fleFoto']['name'] != null)
                {
                    //import da funçao de upload
                    require_once('modulo/upload.php');

                    //chama a funçao de upload para enviar a nova foto ao servidor
                    $novaFoto = uploadFile($file['fleFoto']);
                    
                    //permanece a mesma foto no bd
                    $novaFoto = $foto;

                }
               //criaçao do array de dados que sera encaminhado a model,
               //para inserir no bd, é importante criar este array conforme
               //as necessidades de manipulação do BD.
               //obs: criar as chaves do array conforme os nomes dos00 atributos 
               $arrayDados = array (
                   "nome"     => $dadosContato['txtNome'],
                   "telefone" => $dadosContato['txtTelefone'],
                   "celular"  => $dadosContato['txtCelular'],
                   "email"    => $dadosContato['txtEmail'],
                   "obs"      => $dadosContato['txtObs'],
                   "foto"     => $novaFoto,
                   "idestado" => $dadosContato['sltEstado']
               );

               //import do arquivo d emodelagem para manipular o bd
               require_once('model/bd/contato.php');
               //chama a funçao que fara o insert no bd
                if (insertContato($arrayDados)){

                    //validaçao para verificar se sera necessario apagar a foto antiga 
                    //essa variavel foi ativada em true na linha 105, quando realizamos
                    //o upload de uma nova foto para o servidor
                    if($statusUpload)
                    {

                        //apaga a foto antiga da pasta o servidor
                        unlink(DIRETORIO_FILE_UPLOAD.$foto);

                    }
                    

                    return true;

                }
                    
                else
                    return array('idErro' => 1, 'message' => 'não foi posivel inserir os dados no banco de dados');   
            } 
            
                else

                     return array ('idErro' => 4,
                     'message' => 'não é possivel editar o registro sem informar um id válido.'        
                  );
        
        } 

            else 
                return array('idErro' => 2, 'message' => 'existem campos obrigatorios que não foram preenchidos'); 
    }

 
}

//função para realizar a exclusão de um contato
function excluirContato($arrayDados)
{

    //recebo o id do regitro que será excluido
    $id = $arrayDados['id'];

    //recebe o nome da foto que será excluida da pasta do servidor
    $foto = $arrayDados['foto'];

    //validação para verificar se id contem um numer valido
    if($id != 0 && !empty($id) && is_numeric($id)){
        
        //import do arquivo do contato
        require_once('model/bd/contato.php');

        //import do arquivo de configuraçoes do projeto
        require_once('modulo/config.php');

        //chama a função do model e valida se o retorno foi verdadeiro ou falso
        if (deleteContato($id))
        {
            //unlink() - funçao para apagar um arquivo de um diretorio
            //permite apagar a foto fisicamente do diretorio do servidor
            if(unlink(DIRETORIO_FILE_UPLOAD.$foto))
                return true;
            else
            return array ('idErro' => 5,
            'message' => ' o registro do banco de dados foi excluido com sucesso!
                            porém a imagem não foi excluida do diretorio do servidor!.'        
         );    

        }
            
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