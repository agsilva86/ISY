<?php
 include_once "conn.php";
 $exibir=$conn-> prepare('SELECT * FROM cadastro');
 $exibir->execute();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link href="style.css" rel="stylesheet" type= "text/css">
    <title>Menu</title>
</head>
<body>
  <nav class="navbar fixed-top bg-light esconder">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button><a href="area.php?">voltar</a>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul>
        <li>Meu perfil</li>
        <li>Notificações</li>
        <li>Solicitações</li>
        <li>Sugestão</li>
        <li>Reclamação</li>
        <li>Telefones Úteis</li>
        <li>Colaboradores</li>
        <li><a href="index.php?logout">Sair</a></li>
        <a href="index.php">index</a><br/>
        <a href="formulario.php">formulario</a><br/>
        <a href="doc.php">Documentos exib</a><br/>
        <a href="doc2.php">Documentos cad</a><br/>
        <a href="pservico.php">prestador de servico</a><br/>
        <a href="pservico2.php">formulario do prestador</a><br/>
        <a href="login.php">login</a><br/>
        <a href="logincont.php">tela apos login</a><br/>
        <a href="area.php">area de acesso</a><br/>
      </ul>
  </nav>
</body>
</html>
<?php 

if(isset($_GET['logout'])){
  session_destroy();
  header('location:login.php');
}

?>