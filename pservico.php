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
     //AVISO PARA EXCLUIR PRESTADOR DE SERVICO
     if(isset($_GET['aviso'])){
        $id=$_GET['id'];
        echo "<br/>";
        echo "<br/>";
        echo "<br/>";
        echo "Deseja realmente excluir?</br>";
        echo "<a href='pservico.php?excluir&id=".$id."'>Sim</a> ||";
        echo "<a href='pservico.php'>Não</a>";
     }
     //EXCLUIR PRESTADOR DE SERVICO
     if(isset($_GET['excluir'])){
        $id=$_GET['id'];
        $excluir= $conn-> prepare('DELETE FROM `pservico` WHERE `pservico`.`id_ps` = :pid');
        $excluir -> bindValue(':pid',$id);
        $excluir ->execute();
        
        $excluir= $conn-> prepare('DELETE FROM `telefoneps` WHERE `telefoneps`.`pservico_id_ps` = :pid');
        $excluir -> bindValue(':pid',$id);
        $excluir ->execute();
        echo "
        <div class='alert alert-success' role='alert'>
             Excluido com sucesso! 
        </div>" ;
     }

     // ALTERAR OS DADOS DO PRESTADOR DE SERVICO 
 if(isset($_POST['altera'])){
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
    $dd= $telefone[0];
    $telefone= $telefone[1];
    //validar nome
    $nome=$_POST['nome'];
    if(strlen($nome)<=2){ 
        echo "<div class='alert alert-danger' role='alert'>
            Preencha o nome com no mínimo 2 caracteres.
        </div>";
        exit();
    }   
    //validar avaliacao
    $aval=$_POST['aval'];
   if($aval>5 || $aval <1 ){
    echo "<div class='alert alert-danger' role='alert'>
                Insira o número entre 1 a 5;
            </div>";
     exit();
   }
    $aval=$_POST['aval'];
    $tipo=$_POST['tipops'];
    $coment=$_POST['coment'];
    $idps=$_POST['id_ps'];
    $nome=$_POST['nome'];
    $idtel=$_POST['id_tel'];

    $alterar= $conn -> prepare('UPDATE `pservico` SET `tipo_ps` = :ptipo, `nome_ps` = :pnome, `aval_ps` = :paval, `coment_ps` = :pcoment WHERE `pservico`.`id_ps` = :pid; ');
    $alterar->bindValue(':ptipo',$tipo);
    $alterar->bindValue(':pnome',$nome);
    $alterar->bindValue(':paval',$aval);
    $alterar->bindValue(':pcoment',$coment);
    $alterar->bindValue(':pid',$idps);
    $alterar->execute();


   $alterartel= $conn-> prepare('UPDATE `telefoneps` SET `ddd_phoneps` = :pddd, `num_phoneps` = :pnumero WHERE `telefoneps`.`id_phoneps` = :pid');
   $alterartel->bindValue(':pnumero',$telefone);
   $alterartel->bindValue(':pddd',$dd);
   $alterartel->bindValue(':pid',$idtel);
   $alterartel->execute();

   echo " <div class='alert alert-success' role='alert'>
   Alterado com sucesso!
         </div> ";
 ;
}
?>

<!-- MOSTRAR PRESTADOR DE SERVICO NA TELA
    Basicamente um sistema de lista
-->
   
  <?php
    $exibir=$conn->prepare('SELECT * FROM pservico ps INNER JOIN telefoneps telps ON(ps.id_ps = telps.pservico_id_ps)');
    $exibir->execute();
    if($exibir -> rowCount()==0){
        echo "Nao ha registros";
     }else{
        while($row=$exibir->fetch()){ ?>
        <div class="container margemtop25 esconder">
            <div class="card">
              <div class="card-body">  
                  <h5 class="card-title" > <?php echo $row['nome_ps'] ?></h5>
                  <p>telefone: <?php echo "(".$row['ddd_phoneps'].")".$row['num_phoneps']?></p>
                  <p>tipo: <?php echo $row['tipo_ps']?></p>
                  <p>avalição: <?php echo $row['aval_ps'] ?> </p>
                  <p>comentario: <?php echo $row['coment_ps'] ?></p>
                  <!-- botoes só funcionam caso o id do usuario seja igual a sessao -->
                  <?php
                    if($row['cadastro_id_cad'] === $_SESSION['login']){
                        echo "<a href=?aviso&id=".$row['id_ps']." >Excluir </a>";
                        echo "<a href=alterarps.php?alterar&id=".$row['id_ps']." >Alterar</a>";
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
<a href="index.php?">voltar</a><a class="btn btn-primary" href="pservico2.php" role="button">Adicionar</a>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
</body>
</html>