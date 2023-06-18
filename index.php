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
    <title>Interface principal</title>
    
    <link rel="stylesheet" href="style/style.css">
  </head>
  <body>
    <?php include_once "menu.php";?><br><br>

    <nav class="nav-menu">
    <ul>
    <li><a href="#">Meu Perfil</a></li>
    <li><a href="doc.php">Documentos</a></li>
    <li><a href="doc2.php">Cadastro de Documentos</a></li>
    <li><a href="pservico.php">Prestadores de Servico</a></li>
    <li><a href="pservico2.php">Cadastro de Prestadores de Serviço</a></li>
    <li><a href="index.php?logout">Sair</a></li>
    </ul>
    </nav>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
  </body>
</html>