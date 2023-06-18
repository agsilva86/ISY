<!doctype html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>cadastro</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
        <link href="style.css" rel="stylesheet" type= "text/css">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    </head>
    <body>
        <a href="logincont.php">Volta formulario temporario</a>
    </body>
<?php
/*Conectado ao Banco*/
include "conn.php";

/* validacao para nao salvar um condominio sem cep*/
if(!$_POST['cep']== NULL){ 
    if(!$_POST['nomecond']== NULL){
        if(!$_POST['numcond']== NULL){
                /*DADOS DO ENDEREÇO*/
                if(isset($_POST['enviar'])){
                    //dados condominio para salvar no banco
                    $cond=$_POST['nomecond'];
                    $rua=$_POST['rua'];
                    $numcond=$_POST['numcond'];
                    $bairro=$_POST['bairro'];
                    $cidade=$_POST['cidade'];
                    $cep=$_POST['cep'];
                    $estado=$_POST['estado'];
                    $enviar_end=$conn->prepare('INSERT INTO `condominio` (`id_cond`, `nome_cond`, `rua_cond`, `num_cond`,   `bairro_cond`,            `cidade_cond`, `cep_cond`, `uf_cond`) 
                    VALUES (NULL, :pnomecond, :prua, :pnumcond, :pbairro, :pcidade, :pcep, :pestado);');
                    $enviar_end->bindValue(':pnomecond',$cond);
                    $enviar_end->bindValue(':prua',$rua);
                    $enviar_end->bindValue(':pnumcond',$numcond);
                    $enviar_end->bindValue(':pbairro',$bairro);
                    $enviar_end->bindValue(':pcidade',$cidade);
                    $enviar_end->bindValue(':pcep',$cep);
                    $enviar_end->bindValue(':pestado',$estado);
                    $enviar_end->execute();
                    
                    $id_condominio=$conn->lastInsertID();
                    
                    $nome=$_POST['nomecond'];
                    $_UP['pasta']="arquivos/";
                    $_UP['tamanho']=1024*1024*5; //5mb
                    $_UP['extensao']=array('pdf');
                
                    //validação de extenção
                    $explode=explode('.',$_FILES['arquivo']['name']);
                    $aponta=end($explode);
                    $extensao=strtolower($aponta);
                    if(array_search($extensao,$_UP['extensao'])
                    ===false){
                        echo "Extensão não aceita";
                        exit();
                    }
                
                    //validação de tamanho de arquivo
                    if($_UP['tamanho']<=$_FILES['arquivo']['size']){
                        echo "Arquivo muito grande";
                        exit();
                    }
                    
                    $nome_final=$_FILES['arquivo']['name'];
                    //Envio do Arquivo
                    if(move_uploaded_file($_FILES['arquivo']['tmp_name'],$_UP['pasta'].$nome_final)){
                        include "conn.php";
                        
                        $tipo='ATA'; 
                        $desc='ATA do condominio: '.$_POST['nomecond'];
                        $dia=date('Y/m/d');
                        $url=$_UP['pasta'].$nome_final;
                
                        $envia_ata=$conn->prepare('INSERT INTO `documentos` (`id_doc`, `condominio_id_cond`, `cadastro_id_cad`, `desc_docs`, `num_docs`, `tipo_docs`, `datap_docs`, `url_docs`) 
                        VALUES (NULL, :pid_cond, :pid_cad, :pdesc, :pnumero_doc, :ptipo, :pdia, :purl); ');
                        $envia_ata->bindValue(':pid_cond', $id_condominio);
                        $envia_ata->bindValue(':pid_cad', $id_cad);
                        $envia_ata->bindValue(':pnumero_doc', $id_condominio);//numero do cond -> colocado até saber oque realmente deve-se colocar
                        $envia_ata->bindValue(':ptipo', $tipo);
                        $envia_ata->bindValue(':pdesc', $desc);
                        $envia_ata->bindValue(':pdia', $dia);
                        $envia_ata->bindValue(':purl', $url);
                        $envia_ata->execute();
                        echo "/Arq Gravado com sucesso!";
                    }else{
                        echo "/Algo deu errado com seu Arq!";
                    }
                }
        }        
    } 
}

//SALVAR DADOS NA TABELA CADASTRO   
if(isset($_POST['enviar'])){
    //dados usuario para salvar no banco
    //validar nome
    $nome_usu=$_POST['nome'];
    if(!preg_match("/^(?![ ])(?!.*[ ]{2})((?:e|da|do|das|dos|de|d'|D'|la|las|el|los)\s*?|(?:[A-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð'][^\s]*\s*?)(?!.*[ ]$))+$/",$nome_usu)){
        echo "nome errado";
        exit();
    }
    //validar dados do cpf
    $cpf=$_POST['cpf'];
    if(!preg_match('/^[0-9]{3}.?[0-9]{3}.?[0-9]{3}-?[0-9]{2}/', $cpf)){
        echo "cpf invalido";
        exit();
    }
    //validar email
    $email=$_POST['email'];
    if (!preg_match('/^(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){255,})(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){65,}@)(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22))(?:\.(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-[a-z0-9]+)*\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-[a-z0-9]+)*)|(?:\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\]))$/iD',$email)){
        echo "email invalido";
        exit();
      }
    //validar senha
    $senha=$_POST['senha'];
      if(!preg_match('/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9]).{6,}$/',$senha)){
            echo "senha não válida";
            echo $senha;
            exit();
      }
    //validar bloco
    $bloco=$_POST['bloco'];
    if(!preg_match('/^[a-zA-Z]{1,2}/',$bloco)){
            echo "bloco invalido";
            exit();
    }
    //caso o condominio nao esteja cadastrado ele passa por essa validacao para receber o novo condominio
    $id_cond=$_POST['id_cond'];
    if($id_cond == 0){
       $id_cond= $id_condominio;
            if($id_cond == 0){
                echo "ERRO";
                exit();
            }
    }
    //validando dados do telefone
    $telefone=$_POST['telefone'];
    if (!preg_match('/^\([0-9]{2}\)?\s?[0-9]{4,5}-[0-9]{4}$/', $telefone)){
        echo "erro telefone";
        exit();
    }
    //tratando os dados do telefone
        $telefone= str_replace("(","-",$telefone);
        $telefone= str_replace(")"," ",$telefone);
        $telefone= str_replace("-","",$telefone);
        $telefone= explode(" ",$telefone);
        $ddd= $telefone[0];
        $num_telefone= $telefone[2];
    //validar unidade
    $unidade=$_POST['unidade'];
    if(!preg_match('/^[0-9]+/',$unidade)){
        echo "unidade erro";
        exit();
    }
    $tipo_usu=$_POST['periodo'];

    $cadastrar_usu= $conn->prepare('INSERT INTO cadastro (condominio_id_cond, tiposdeusuario_id_tpusu, nome_cad,cpf_cad,unid_cad,bloco_cad, email_cad, senha_cad) VALUES (:pid_cond,:ptipo,:pnome,:pcpf,:punid,:pbloco,:pemail,md5(:psenha))');
    $cadastrar_usu->bindValue(':pid_cond',$id_cond);
    $cadastrar_usu->bindValue(':ptipo',$tipo_usu);
    $cadastrar_usu->bindValue(':pnome',$nome_usu);
    $cadastrar_usu->bindValue(':pcpf',$cpf);
    $cadastrar_usu->bindValue(':punid',$unidade);
    $cadastrar_usu->bindValue(':pbloco',$bloco);
    $cadastrar_usu->bindValue(':pemail',$email);
    $cadastrar_usu->bindValue(':psenha',$senha);
    $cadastrar_usu->execute();

    $id_cad=$conn->lastInsertID();
    $gravatel=$conn->prepare('INSERT INTO telefonecad(cadastro_id_cad, ddd_phonecad, num_phonecad) VALUES (:pcad_id,:pddd,:pnum_phone)');
    $gravatel->bindValue(':pcad_id',$id_cad);
    $gravatel->bindValue(':pddd',$ddd);
    $gravatel->bindValue(':pnum_phone',$num_telefone);
    $gravatel->execute();

    echo "gravado com sucesso";
}   
?>