<?php
require_once 'classes/usuarios.php';
if (!isset($_SESSION)) session_start();
$u = new Usuario;
$u->conectar("gerencianet_usuarios", "localhost", "root", "P@ssw0rd");
/* $u->conectar("gerencianet_usuarios", "localhost", "root", "root1234"); */
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
 integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

  <link rel="stylesheet" href="css/stylecadastrar.css">

  <title>Cadastrar</title>
  <!-- Icones fontawesome: -->
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
 integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />

  <script type="text/javascript">
    function mascara(telefone) {
      if (telefone.value.length == 0)
        telefone.value = '(' + telefone
        .value; //quando começamos a digitar, o script irá inserir um parênteses no começo do campo.
      if (telefone.value.length == 3)
        telefone.value = telefone.value +
        ') '; //quando o campo já tiver 3 caracteres (um parênteses e 2 números) o script irá inserir
      //mais um parênteses, fechando assim o código de área.

      if (telefone.value.length == 10)
        telefone.value = telefone.value +
        '-'; //quando o campo já tiver 8 caracteres, o script irá inserir um tracinho, para melhor
      //visualização do telefone.
    }
  </script>
</head>

<body>

  <header>
    <img src="https://sistema.bentleybrasil.com.br/img/logo-empresa-br.png" alt="Bentley Brasil">
    <nav>
      <div class="navmenu">
        <ul>
          <li><a href="index.php">Voltar a Home</a></li>
        </ul>
      </div>
    </nav>
  </header>

  <main>
    <div class="flex-box container-box">
      <h1>Cadastrar</h1>
      <form method="POST">
        <div class="content-box">
          <input type="text" name="nome" placeholder="Nome Completo" maxlength="45">
          <input type="text" name="telefone" size="20" maxlength="15" placeholder="Telefone" maxlength="45" onkeypress="mascara(this)">
          <input type="email" name="email" placeholder="Email" maxlength="45">
          <button onclick="mostrarASenha()" type="button" id="mostrarrSenha" class="btn btn-primary botao btn-sm">Mostrar Senha</button>
          <input type="password" name="senha_usuario" id="senha_usuario" placeholder="Senha" maxlength="45">
          <button onclick="mostrarASenhaRepete()" type="button" id="mostrarrSenhaRepete" class="btn btn-primary botao btn-sm">Mostrar Senha</button>
          <input type="password" name="confsenha" id="confsenha" placeholder="Confirmar Senha" maxlength="45">
          <input type="submit" value="Cadastrar" maxlength="45">
          <a href="logar.php">Já sou cadastrado<strong> Logar</strong></a>
        </div>
      </form>

    </div>
  </main>


  <!-- //Pegando todas as informações que o usuário digitou e clicou "Cadastrar" -->
  <?php
  /* Verificando se clicou no botão */
  if (isset($_POST['nome'])) {
    //Usando a variável global "POST"
    //addslashes():Para impedir que comandos maliciosos sejam inseridos no formulário.
    $nome = addslashes($_POST['nome']);
    $telefone = addslashes($_POST['telefone']);
    $email = addslashes($_POST['email']);
    $senha = addslashes($_POST['senha_usuario']);
    $confsenha = addslashes($_POST['confsenha']);
    //Verificando se está preenchido, se tem algum campo em branco
    if (!empty($nome) && !empty($telefone) && !empty($email) && !empty($senha) && !empty($confsenha)) {

      if ($u->msgErro == "") //Vazia está tudo OK.
      {
        if ($senha == $confsenha) {
          if ($u->cadastrar($nome, $telefone, $email, $senha)) {
  ?>
            <div id="msg-sucesso" style="margin-top: 13px;">
              Cadastrado com sucesso! Acesse para entrar!
            </div>
          <?php
          } else {
          ?>
            <div class="msg-erro">
              Email já cadastrado!
            </div>
          <?php
          }
        } else {
          ?>
          <div class="msg-erro">
            Atenção: As senhas não conferem"
          </div>
        <?php
        }
      } else {
        ?>
        <div class="msg-erro">
          <?php echo "Erro: " . $u->msgErro; ?>
        </div>
      <?php
      }
    } else {
      ?>
      <div class="msg-erro">
        Por favor, preencha todos os campos!
      </div>
  <?php
    }
  }
  ?>
  <script>
    function mostrarASenha() {
      var text = document.getElementById("mostrarrSenha").firstChild;
      var tipo = document.getElementById("senha_usuario");
      if (tipo.type == "password") {
        tipo.type = "text";
      } else {
        tipo.type = "password";
      }
      text.data = text.data == "Esconder senha" ? "Mostrar senha" : "Esconder senha";
    }

    function mostrarASenhaRepete() {
      var text = document.getElementById("mostrarrSenhaRepete").firstChild;
      var tipo = document.getElementById("confsenha");
      if (tipo.type == "password") {
        tipo.type = "text";
      } else {
        tipo.type = "password";
      }
      text.data = text.data == "Esconder senha" ? "Mostrar senha" : "Esconder senha";
    }
  </script>

  <footer>
    <ul>
      <li><a href=""><i class="fab fa-facebook"></i></a></li>
      <li><a href=""><i class="fab fa-twitter"></i></a></li>
      <li><a href=""><i class="fab fa-snapchat"></i></a></li>
      <li><a href=""><i class="fab fa-pinterest"></i></a></li>
    </ul>
    <p>Satellite Broadband Networks - Bentley Brasil - Projeto Juruena</p>
  </footer>

</body>

</html>