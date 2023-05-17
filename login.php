<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link href="style.css" rel="stylesheet" type= "text/css">
</head>
<body>
    <!-- logo -->
  <div class="container-fluid esconder">
    <div class ="row">
      <div class="col">
        <img src="imagens/logo-sembg.png" class="rounded mx-auto d-block margemtop50" alt="logo da empresa" height="125">
      </div>
    </div>
  <div>
    <!-- caixa com o login-->
   <div class="container bg-primary margemtop25">
       <div class="row">
        <div class="col">
            <form action="login.php" method="POST">
             <label for="email" class="form-label">Insira seu e-mail:</label><br>
                <input class="form-control" type="email" id="email" name="email" placeholder="email@email.com" required><br/>
             <label for="senha" class="form-label">Insira sua senha:</label><br>
                <input class="form-control" type="password" id="senha" name="senha" required>
              <input type="submit" name="login" Value="Entrar">    
            </form>            
        </div>
        <div class="row">    
            <h5 class="text-center"><a>Termos e Condições</a></h5>
        </div>
       </div>
   </div>
   <div class="container margemtop50">
      <h3 class="text-center"><a href="formulario.php">Não tenho conta</a></h3>
   </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
</body>
</html>

<?php
  include "conn.php";
  if(isset($_POST['login'])){
     $email=$_POST['email'];
     $senha=$_POST['senha'];
     $senha= md5($senha);
     $login=$conn->prepare('SELECT*FROM cadastro WHERE email_cad = :pemail AND senha_cad = :psenha');
     $login->bindValue(':pemail',$email);
     $login->bindValue(':psenha',$senha);
     $login->execute();

     if($login->rowCount()==0){
      echo "Login ou senha inválida!";
      }else{
      session_start();
      $linha=$login->fetch();
      $_SESSION['login']=$linha['id_cad'];
      header('location:logincont.php');
      }
  }
?>