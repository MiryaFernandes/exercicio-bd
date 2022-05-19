<?php

    //essa variavel foi crida para diferenciar no action do formulario
    //qual açao deveria ser levada para a router (inserir ou editar).
    //nas condiçoes abaixo, mudamos o action dessa variavel para
    //a açao de editar
    $form = "router.php?component=contatos&action=inserir";
    
    //variavel para carregar o nome da foto no banco de dados
    $foto = (string) null;

    //variavel para ser utilizada no carregar dos estados (opção de editar)
    $idestado = (string) null;

    //valida se a utilizaçao de variaveis de sessao esta ativa no servidor
    if(session_status())
    {
        //valida se a variavel de sessao dadosContato nao esta vazia
        if(!empty($_SESSION['dadosContato']))
        {
            $id         = $_SESSION['dadosContato']['id'];
            $nome       = $_SESSION['dadosContato']['nome'];
            $telefone   = $_SESSION['dadosContato']['telefone'];
            $celular    = $_SESSION['dadosContato']['celular'];
            $email      = $_SESSION['dadosContato']['email'];
            $obs        = $_SESSION['dadosContato']['obs'];
            $foto       = $_SESSION['dadosContato']['foto'];
            $idestado   = $_SESSION['dadosContato']['idestado'];


            //mudamos a açao do form para editar o registro no click do botao salvar
            $form = "router.php?component=contatos&action=editar&id=".$id."$foto=".$foto;

            unset($_SESSION['dadosContato']);

        }

    }

?>
<!DOCTYPE>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title> Cadastro </title>
        <link rel="stylesheet" type="text/css" href="css/style.css">


    </head>
    <body>
       
        <div id="cadastro"> 
            <div id="cadastroTitulo"> 
                <h1> Cadastro de Contatos </h1>
                
            </div>
            <div id="cadastroInformacoes">
                <!-- enctype="multipart/form-data"
                    essa opçao é obrigatoria para enviar
                    arquivos do formulario em html para 
                    o servidor -->
                <form  action="<?=$form?>" name="frmCadastro" method="post" enctype="multipart/form-data">
                    <div class="campos">
                        <div class="cadastroInformacoesPessoais">
                            <label> Nome: </label>
                        </div>
                        <div class="cadastroEntradaDeDados">
                            <input type="text" name="txtNome" value="<?=isset($nome)?$nome:null?>" placeholder="Digite seu Nome*" maxlength="100">
                        </div>
                    </div>

                    <div class="campos">
                        <div class="cadastroInformacoesPessoais">
                            <label> Estado: </label>
                        </div>
                        <div class="cadastroEntradaDeDados">
                            <select name="sltEstado">
                                <option value="">Selecione um item:</option>
                                <?php

                                    //import da controller de estados
                                    require_once('controller/controllerEstados.php');

                                    //chama a função para carregar todos os estados do bd
                                    $listEstados = listarEstados();
                                    foreach($listEstados as $item)
                                    {
                                        ?>

                                        <option <?=$idestado==$item['idestado']?'selected':null ?> value="<?=$item['idestado']?>"><?=$item['nome']?></option>

                                        <?php
                                    }

                                ?>
                            </select>
                        </div>
                    </div>
                                     
                    <div class="campos">
                        <div class="cadastroInformacoesPessoais">
                            <label> Telefone: </label>
                        </div>
                        <div class="cadastroEntradaDeDados">
                            <input type="tel" name="txtTelefone" value="<?=isset($telefone)?$telefone:null?>" placeholder="Digite seu telefone">
                        </div>
                    </div>
                    <div class="campos">
                        <div class="cadastroInformacoesPessoais">
                            <label> Celular: </label>
                        </div>
                        <div class="cadastroEntradaDeDados">
                            <input type="tel" name="txtCelular" value="<?=isset($celular)?$celular:null?>" placeholder="Digite seu celular*">
                        </div>
                    </div>
                   
                    
                    <div class="campos">
                        <div class="cadastroInformacoesPessoais">
                            <label> Email: </label>
                        </div>
                        <div class="cadastroEntradaDeDados">
                            <input type="email" name="txtEmail" value="<?=isset($email)?$email:null?>" placeholder="Digite seu email*">
                        </div>
                    </div>
                    <div class="campos">
                            <div class="cadastroInformacoesPessoais">
                                <labe>Escolha um arquivo: </label>
                            </div>
                            <div class="cadastroEntradaDados">
                                <input type="file" name="fleFoto" accept=".jpg, .png, .jpeg, .gif">
                            </div>
                    </div>
                    <div class="campos">
                        <div class="cadastroInformacoesPessoais">
                            <label> Observações: </label>
                        </div>
                        <div class="cadastroEntradaDeDados">
                            <textarea name="txtObs" cols="50" rows="7"><?=isset($obs)?$obs:null?></textarea>
                        </div>
                    </div>

                    <div class="campos">
                        <img src="<?=DIRETORIO_FILE_UPLOAD.$foto?>" class="foto">
                    </div>
                    <div class="enviar">
                        <div class="enviar">
                            <input type="submit" name="btnEnviar" value="Salvar">
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div id="consultaDeDados">
            <table id="tblConsulta" >
                <tr>
                    <td id="tblTitulo" colspan="6">
                        <h1> Consulta de Dados.</h1>
                    </td>
                </tr>
                <tr id="tblLinhas">
                    <td class="tblColunas destaque"> Nome </td>
                    <td class="tblColunas destaque"> Celular </td>
                    <td class="tblColunas destaque"> Email </td>
                    <td class="tblColunas destaque"> Fotos </td>
                    <td class="tblColunas destaque"> Opções </td>
                </tr>

                <?php
                
                //import do aruqivo da contoller para solicitar a listagem dos dados
                require_once('controller/controllerContatos.php');

                //chama a função qu vai retornar os dados de contato
                if($listContato = listarContato())
                {

                //a estrutura de repetição para retornar os dados do array 
                //e printar na tela
                foreach($listContato as $item)
                   {
                       $foto = $item['foto'];
                ?>
                    <tr id="tblLinhas">
                    <td class="tblColunas registros"><?=$item['nome']?></td>
                    <td class="tblColunas registros"><?=$item['celular']?></td>
                    <td class="tblColunas registros"><?=$item['email']?></td>
                    <td class="tblColunas registros">
                        <img src="<?=DIRETORIO_FILE_UPLOAD.$foto?>"class="foto">
                    </td>
                    

                   
                    <td class="tblColunas registros">
                            <a href="router.php?component=contatos&action=buscar&id=<?=$item['id']?>&foto=<?=$foto?>">
                                <img src="img/edit.png" alt="Editar" title="Editar" class="editar">
                            </a>

                            <a onClick="return confirm('deseja realmente excluir este item?');" href="router.php?component=contatos&action=deletar&id=<?=$item['id']?>&foto=<?=$foto?>">
                                <img src="img/trash.png" alt="Excluir" title="Excluir" class="excluir">
                            </a>
                            <img src="img/search.png" alt="Visualizar" title="Visualizar" class="pesquisar">
                    </td>
                    </tr>

                <?php
                    }

                }
                ?>
                
               
               
                </tr>
            </table>
        </div>
    </body>
</html>