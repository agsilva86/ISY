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
    <title>Formulario prestador de serviço</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link href="style.css" rel="stylesheet" type= "text/css">
</head>
<body>
    <?php 
        include "menu.php";
    ?>
<div class="container margemtop100 esconder"> 
    <h3> Cadastro do PS</h3> 
    <form action="pservico2.php" method=POST id="pservico">
        <!-- id do usuario-->
        <input type="hidden" name="id_usu" value=<?php echo $rownome['id_cad']?>>
        <!--nome do prestador de servico-->
        <label for="nome" class="col-sm-2 col-form-label">Nome fornecedor:</label>
        <input type="text" name="nome" placeholder="nome" class="form-control" id="nome" required>
        <!-- telefone do prestador de servico-->
        <label for="tel" class="col-sm-2 col-form-label">Telefone:</label>
        <input type="tel" name="telefone" placeholder="telefone" class="form-control" id="tel" data-mask="(00) 00000-0000" data-mask-selectonfocus="true"  required onkeyup="handlePhone(event)"><br>
            <!--Separador do numero com JavaScript-->
            <script>
            const handlePhone = (event) => {
              let input = event.target
              input.value = phoneMask(input.value)
            }          
            const phoneMask = (value) => {
              if (!value) return ""
              value = value.replace(/\D/g,'')
              value = value.replace(/(\d{2})(\d)/,"($1) $2")
              value = value.replace(/(\d)(\d{4})$/,"$1-$2")
              return value
            }
          </script>
        <!-- servico do prestador de servico  OBS: FUTURAMENTE MUDAR PARA CAIXA DE SELECAO COM SERVICOS PRE DEFINIDOS-->
        <label for="tipops" class="col-sm-2 col-form-label">Serviço prestado:</label>
        <input type="text" name="tipops" placeholder="serviço" class="form-control" id="tipops" required><br/>
        <!-- avaliacao  OBS: A IDEIA É MUDAR PARA SISTEMA DE ESTRELAS FUTURAMENTE-->
        <label for="aval" class="col-sm-2 col-form-label">Avaliação:</label>
        <input type="number" name="aval" placeholder="1 até 5" class="form-control" id="aval" required><br/>
        <!-- comentario sobre o prestador de servico -->
        <textarea name="coment" form="pservico" placeholder="comentario" class="form-control" id="coment"></textarea><br/>
        <!-- botao enviar -->
        <input type="submit" name="gravar" value="Salvar">

        <a href="pservico.php">Cancelar</a>
    </form>
    </div>  
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
</body>
</html>

<?php

 if(isset($_POST['gravar'])){
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
    $telefone= $telefone[2];
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
    //var_dump($nome);
    $id_usu=$_POST['id_usu']; 
    $tipo=$_POST['tipops'];
    $coment=$_POST['coment'];
    //GRAVAR PRESTADOR
    $grava = $conn->prepare('INSERT INTO `pservico` (`id_ps`, `cadastro_id_cad`, `tipo_ps`, `nome_ps`, `aval_ps`, `coment_ps`) VALUES (NULL, :pid_usu, :ptipo, :pnome, :paval, :pcoment);');
    $grava->bindValue(':pid_usu',$id_usu);
    $grava->bindValue(':ptipo',$tipo);
    $grava->bindValue(':pnome',$nome);
    $grava->bindValue(':paval', $aval);
    $grava->bindValue(':pcoment',$coment);
    $grava->execute();
    //GRAVAR TELEFONE DO PRESTADOR
    $id_prestador=$conn->lastInsertID();
    $gravanum = $conn-> prepare ('INSERT INTO telefoneps(id_phoneps, pservico_id_ps,num_phoneps, ddd_phoneps) VALUES (NULL,:pidprestador, :ptelefone, :pdd)');
    $gravanum->bindValue(':pidprestador',$id_prestador);
    $gravanum->bindValue(':ptelefone',$telefone);
    $gravanum->bindValue(':pdd',$dd);
    $gravanum->execute();

    echo"<div class='alert alert-success' role='alert'>
            Adicionado com sucesso!!
        </div>";
 }
?>