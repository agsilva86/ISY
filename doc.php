<?php
session_start();
if(!isset($_SESSION['login'])){
    header('location:login.php');   
}
?>
<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Prestador de serviço</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link href="style.css" rel="stylesheet" type= "text/css">
</head>
<body>
     <!-- container para organizar a visualizacao na tela-->  
    <div class="container margemtop100"></div>
<?php 
    include "menu.php";
    include "conn.php";
     //AVISO PARA EXCLUIR DOCUMENTO
     if(isset($_GET['aviso'])){
        $id=$_GET['id'];
        echo "<br/>";
        echo "<br/>";
        echo "<br/>";
        echo "Deseja realmente excluir?</br>";
        echo "<a href='doc.php?excluir&id=".$id."'>Sim</a> ||";
        echo "<a href='doc.php'>Não</a>";
     }
     //EXCLUIR DOCUMENTO
     if(isset($_GET['excluir'])){
        $id=$_GET['id'];
        $excluir= $conn-> prepare('DELETE FROM `documentos` WHERE id_doc=:pid');
        $excluir -> bindValue(':pid',$id);
        $excluir ->execute();
        
        echo "
        <div class='alert alert-success' role='alert'>
             Excluido com sucesso! 
        </div>" ;
     }
?>

<!-- MOSTRAR DOCUMENTO
    Basicamente um sistema de lista
-->
<?php
$id=$_SESSION['login'];
    $exibir=$conn->prepare('SELECT * FROM `documentos` WHERE cadastro_id_cad=:pid');
    $exibir->bindValue(':pid',$id);
    $exibir->execute();
    if($exibir -> rowCount()==0){
        echo "Nao ha registros";
     }else{
        while($row=$exibir->fetch()){ ?>
        <div class="container margemtop25 esconder">
            <div class="card">
              <div class="card-body">  
                  <h5 class="card-title" > <?php echo $row['desc_docs'] ?></h5>
                  <p>Tipo: <?php echo $row['tipo_docs']?></p>
                  <p>Data: <?php echo $row['datap_docs'] ?> </p>
                  <p>Vizualizar documento:<a href="<?php echo $row['url_docs'] ?>"><?php echo $row['desc_docs'] ?></a><br/></p>
                  <a href="<?php echo $row['url_docs'] ?>" download="<?php echo $row['url_docs'] ?>">Baixar</a>
                  <!-- botoes só funcionam caso o id do usuario seja igual a sessao -->
                  <?php
                    if($row['cadastro_id_cad'] === $_SESSION['login']){
                        echo "<a href=?aviso&id=".$row['id_doc']." >Excluir </a>";
                    };
                  ?>
              </div>
            </div> 
        </div> 
        <?php }
     }
    ?>
 <!-- container para organizar a visualizacao na tela-->    
<div class="container margemtop100"></div> 
<!-- botao adicionar -->

<div class="footer bg-light esconder">
<a href="index.php?">voltar</a><a class="btn btn-primary" href="doc2.php" role="button">Adicionar</a>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
</body>
</html>