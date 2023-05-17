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
    <title>Interface principal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
    <?php include_once "menu.php";
    ?>
    <!-- container para organizar a visualizacao na tela-->  
    <div class="container margemtop100"></div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
  </body>
</html>
<?php
 //mostrar os dados do ps no formulario
 if(isset($_GET['alterar'])){
    $id=$_GET['id'];
    $altera= $conn -> prepare('SELECT * FROM pservico ps INNER JOIN telefoneps telps ON(ps.id_ps = telps.pservico_id_ps) WHERE id_ps = :pid');
    $altera->bindValue(':pid',$id);
    $altera ->execute();
    $row=$altera-> fetch();
    ?>
    <!doctype html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Alterar formulario prestador de serviço</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link href="style.css" rel="stylesheet" type= "text/css">
</head>
<body>
<div class="container margemtop100 esconder"> 
    <h3> Alterar dados do PS</h3> 
    <form action="pservico.php" method=POST id="pservico">
        <!-- id do usuario-->
        <input type="hidden" name="id_usu" value=<?php echo $row['cadastro_id_cad']?>>
        <input type="hidden" name="id_ps" value=<?php echo $row['id_ps']?>>
        <input type="hidden" name="id_tel" value=<?php echo $row['id_phoneps']?>>
        <!--nome do prestador de servico-->
        <label for="nome" class="col-sm-2 col-form-label">Nome fornecedor:</label>
        <input type="text" name="nome" placeholder="nome" class="form-control" id="nome" value=<?php echo $row['nome_ps']?> required>
        <!-- telefone do prestador de servico-->
        <label for="tel" class="col-sm-2 col-form-label">falta Telefone:</label>
        <input type="tel" name="telefone" placeholder="telefone" class="form-control" id="tel" data-mask="(00) 00000-0000" data-mask-selectonfocus="true"  value=<?php echo $row['ddd_phoneps'].$row['num_phoneps']?> required>
        <!-- servico do prestador de servico  OBS: FUTURAMENTE MUDAR PARA CAIXA DE SELECAO COM SERVICOS PRE DEFINIDOS-->
        <label for="tipops" class="col-sm-2 col-form-label">Serviço prestado:</label>
        <input type="text" name="tipops" placeholder="serviço" class="form-control" id="tipops" value=<?php echo $row['tipo_ps']?> required><br/>
        <!-- avaliacao  OBS: A IDEIA É MUDAR PARA SISTEMA DE ESTRELAS FUTURAMENTE-->
        <label for="aval" class="col-sm-2 col-form-label">Avaliação:</label>
        <input type="number" name="aval" placeholder="1 até 5" class="form-control" id="aval" value=<?php echo $row['aval_ps']?> required><br/>
        <!-- comentario sobre o prestador de servico -->
        <textarea name="coment" form="pservico" placeholder="comentario" class="form-control" id="coment" value=<?php echo $row['coment_ps']?> ></textarea><br/>
        <!-- botao enviar -->
        <input type="submit" name="altera" value="Alterar">   
    </form>
    </div>  
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
</body>
</html>
<?php
 }
?>