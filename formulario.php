<?php session_start();?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link href="style.css" rel="stylesheet" type= "text/css">
    <title>Formulario</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <!-- Adicionando Javascript -->
    <script>
    function limpa_formulário_cep() {
            //Limpa valores do formulário de cep.
            document.getElementById('rua').value=("");
            document.getElementById('bairro').value=("");
            document.getElementById('cidade').value=("");
            document.getElementById('uf').value=("");
    }

    function meu_callback(conteudo) {
        if (!("erro" in conteudo)) {
            //Atualiza os campos com os valores.
            document.getElementById('rua').value=(conteudo.logradouro);
            document.getElementById('bairro').value=(conteudo.bairro);
            document.getElementById('cidade').value=(conteudo.localidade);
            document.getElementById('uf').value=(conteudo.uf);
        } //end if.
        else {
            //CEP não Encontrado.
            limpa_formulário_cep();
            alert("CEP não encontrado.");
        }
    }
        
    function pesquisacep(valor) {

        //Nova variável "cep" somente com dígitos.
        var cep = valor.replace(/\D/g, '');

        //Verifica se campo cep possui valor informado.
        if (cep != "") {

            //Expressão regular para validar o CEP.
            var validacep = /^[0-9]{8}$/;

            //Valida o formato do CEP.
            if(validacep.test(cep)) {

                //Preenche os campos com "..." enquanto consulta webservice.
                document.getElementById('rua').value="...";
                document.getElementById('bairro').value="...";
                document.getElementById('cidade').value="...";
                document.getElementById('uf').value="...";

                //Cria um elemento javascript.
                var script = document.createElement('script');

                //Sincroniza com o callback.
                script.src = 'https://viacep.com.br/ws/'+ cep + '/json/?callback=meu_callback';

                //Insere script no documento e carrega o conteúdo.
                document.body.appendChild(script);

            } //end if.
            else {
                //cep é inválido.
                limpa_formulário_cep();
                alert("Formato de CEP inválido.");
            }
        } //end if.
        else {
            //cep sem valor, limpa formulário.
            limpa_formulário_cep();
        }
    };

    //Função para ocultar dados se não for sindico
function HabCampos() {
  if (document.getElementById('periodo_sim').checked) {
    document.getElementById('campos').style.display = "block";
    document.getElementById('usu').style.display = "none";
document.getElementById('textfield').focus();
  }  else {
    document.getElementById('campos').style.display = "none";
    document.getElementById('usu').style.display = "block";
  }
  }
</script>
  </head>
  <body onload="HabCampos()"> 
    <div class="container">
      <form action="cad_cond.php" method="POST" enctype="multipart/form-data"> 
        <!-- dados pessoais -->
        <fieldset>
          <legend>Dados Pessoais</legend>
            <!--nome-->
            <label for="nome" class="form-label">Nome completo:</label><br>
                <input class="form-control" type="text" id="nome" name="nome"><br>
            <!--CPF-->
            <label for="cpf" class="form-label">CPF:</label><br>
                <input class="form-control" type="text" id="cpf" name="cpf" pattern="([0-9]{2}[\.]?[0-9]{3}[\.]?[0-9]{3}[\/]?[0-9]{4}[-]?[0-9]{2})|([0-9]{3}[\.]?[0-9]{3}[\.]?[0-9]{3}[-]?[0-9]{2})" placeholder="000.000.000.00"><br>
                            <!--telefone-->
                            <label for="telefone" class="form-label">Telefone:</label><br>
            <input type="tel" class="form-control" id="tel" name="telefone" maxlength="15"  onkeyup="handlePhone(event)"><br>
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
        </fieldset>
        <!--dados de Login-->
        <fieldset>
          <legend> Dados de Login </legend>
            <!--email-->
            <label for="email" class="form-label">Email:</label><br>
                <input class="form-control" type="email" id="email" name="email"  placeholder="email@email.com"><br/><!--pattern="^[A-Z0-9._%+-]+@(?:[A-Z0-9-]+\.)+[A-Z]{2,}$"-->
            <!--senha-->
            <label for="senha" class="form-label">Senha:</label><br>
                <input class="form-control" type="password" id="senha" name="senha"><!--pattern="/^((?=\S*?[A-Z])(?=\S*?[a-z])(?=\S*?[0-9]).{6,})\S$/"-->
                <div id="senha" class="form-text">A senha deve conter pelo menos 6 digitos, 1 letra maiscula, 1 letra minuscula e 1 numero sem espaço.</div>    
        </fieldset>
                    <!--Sindico-->
                    <div class="form-check">
              <label for="proprietario" class="form-label">Você é o Sindico?</label><br>
                <input name="periodo" id="periodo_nao" type="radio" value="2" onClick="HabCampos()" checked/>
                    <!--Não-->
                    <label class="form-check-label" for="sindico1">Não</label>
            </div>
            <div class="form-check">
                <input name="periodo" id="periodo_sim" type="radio" value="1" onClick="HabCampos()"/>
                    <!--Sim-->
                    <label class="form-check-label" for="sindico2">Sim</label>
            </div></br>
        </fieldset>
            <!--CONDOMINIO-->
            <legend>Dados do Condominio</legend>
            <!--bloco-->
            <label for="bloco" class="form-label">Bloco:</label><br>
                <input class="form-control" type="text" id="bloco" name="bloco"></br>
            <!--Unidade-->
            <label for="unidade" class="form-label">Unidade:</label><br>
                <input class="form-control" type="number" id="unidade" name="unidade"></br>
        <fieldset id="usu">
        <!--Nome Condominio-->
        <label for="unidade" class="form-label">Condominio:</label></br>
        <select name="id_cond" class="form-control">
        <option value="<?php echo $id_condominio= 0 ?>">Escolha o Condominio</option></br>
        <?php
        include "conn.php";
        $condominios=$conn->prepare('SELECT * FROM `condominio`');
        $condominios->execute();
        if($condominios->rowCount()==0){
        echo "Não há registros";
        }else{
        while($row=$condominios->fetch()){
        echo "<option value=\"".$row['id_cond']."\"";
        if($row['id_cond']==['nome_cond']){
            echo "selected";
        }
        echo">".$row['nome_cond']."</option>";
        }
        }
        ?>
        </select></br>
        <div>
        </fieldset>
        <!--Enviar-->
      <label for="senha" class="form-label">Terminou?</label><br>
      <input type="submit" name="enviar" class="form-control">
      </div>
      </form>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
  </body>
</html>