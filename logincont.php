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
    <title>Entrar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link href="style.css" rel="stylesheet" type= "text/css">
</head>
<body>
  <div class="container-fluid esconder">
    <!-- logo -->
    <div class ="row">
      <div class="col">
        <img src="imagens/logo-sembg.png" class="rounded mx-auto d-block margemtop50" alt="logo da empresa" height="125">
      </div>
    </div>
    <!--FRASE-->
    <div class="row">
        <div class="col">
            <h4 class="text-center margemtop50">GESTÃO DE <br/> CONDOMÍNIOS</h4>
        </div>
    </div>
    <!-- BOTAO ENTRAR  -->
    <div class ="row">
      <div class="col">
        <a class="btn btn-primary btn-lg margemtop75 mx-auto d-block " href="area.php" role="button">Entrar</a>
      </div>
    </div> 
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
</body>
</html>