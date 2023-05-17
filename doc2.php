<?php
include "conn.php";
session_start();
if(!isset($_SESSION['login'])){
    header('location:login.php');
}
?>
<?php
$id=$_SESSION['login'];
$nome=$conn->prepare('SELECT * FROM cadastro WHERE id_cad=:pid');
$nome->bindValue(':pid',$id);
$nome->execute();
$rownome=$nome->fetch();
?>
<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Envio de Documentos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link href="style.css" rel="stylesheet" type= "text/css">
</head>
<body>
    <?php 
        include "menu.php";
    ?>
<div class="container margemtop100 esconder"> 
    <h3>Envio de Documentos</h3> 
    <form action="doc2.php" method=POST enctype="multipart/form-data">
        <!-- id do usuario-->
        <input type="hidden" name="nome" value=<?php $rownome['nome_cad']?>>
        <!--Anexo do Documento/Arquivo-->
        <label for="ata" class="form-label">Anexo:</label>
        <input class="form-control" type="file" name="arquivo" id="ata">
        <!-- Dados/Número do Documento -->
        <label for="aval" class="col-sm-2 col-form-label">informações:</label>
        <input type="number" name="numero_doc" placeholder="numero do doc..." class="form-control" required><br/>
        <!-- Tipo do Documento -->
        <label for="desc" class="form-label">Tipo do Documento:</label>
        <input type="text" name="tipo" placeholder="tipo do doc..." class="form-control" required><br/>
        <!-- Descrição do Arquivo/Documento -->
        <label for="desc" class="form-label">Descrição do Documento:</label>
        <input type="text" name="comentario" placeholder="descrição do doc..." class="form-control" required><br/>
        <!-- botao upload -->
        <input type="submit" name="upload" value="Salvar"/>
        
        <a href="doc.php?">Cancelar</a>
    </form>
    </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
</body>
</html>

<?php
if(isset($_POST['upload'])){
    $nome=$_POST['nome'];
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

        $id=$_SESSION['login'];
        $usu=$conn->prepare('SELECT * FROM cadastro WHERE id_cad=:pid');
        $usu->bindValue(':pid',$id);
        $usu->execute();
        $rowdata=$usu->fetch();

        $numero_doc=$_POST['numero_doc']; 
        $tipo=$_POST['tipo']; 
        $desc=$_POST['comentario'];
        $dia=date('Y/m/d');
        $url=$_UP['pasta'].$nome_final;

        $grava=$conn->prepare('INSERT INTO `documentos` (`id_doc`, `condominio_id_cond`, `cadastro_id_cad`, `desc_docs`, `num_docs`, `tipo_docs`, `datap_docs`, `url_docs`) 
        VALUES (NULL, :pid_cond, :pid_cad, :pdesc, :pnumero_doc, :ptipo, :pdia, :purl); ');
        $grava->bindValue(':pid_cond', $rowdata['condominio_id_cond']);
        $grava->bindValue(':pid_cad', $rowdata['id_cad']);
        $grava->bindValue(':pnumero_doc', $numero_doc);
        $grava->bindValue(':ptipo', $tipo);
        $grava->bindValue(':pdesc', $desc);
        $grava->bindValue(':pdia', $dia);
        $grava->bindValue(':purl', $url);
        $grava->execute();
        echo "Gravado com sucesso!";
    }else{
        echo "Algo deu errado!";
    }

}
?>