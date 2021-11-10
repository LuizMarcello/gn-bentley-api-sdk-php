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

  <link rel="stylesheet" href="css/style.css">

  <link rel="stylesheet" href="css/estilo.css">

  <title>Cadastrar</title>
  <script type="text/javascript">
    function mascara(telefone) {
      if (telefone.value.length == 0)
        telefone.value = '(' + telefone
        .value; //quando começamos a digitar, o script irá inserir um parênteses no começo do campo.
      if (telefone.value.length == 3)
        telefone.value = telefone.value +
        ') '; //quando o campo já tiver 3 caracteres (um parênteses e 2 números) o script irá inserir mais um parênteses, fechando assim o código de área.

      if (telefone.value.length == 10)
        telefone.value = telefone.value +
        '-'; //quando o campo já tiver 8 caracteres, o script irá inserir um tracinho, para melhor visualização do telefone.
    }
  </script>
</head>

<body>
  <header>
    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
      <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse"
          aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
          <ul class="navbar-nav me-auto mb-2 mb-md-0">
            <span class="brand-text font-weight-light">
              <img height="80" src="https://sistema.bentleybrasil.com.br/img/logo-empresa-br.png">
            </span>
            <div style="margin: 36px 0 0 50px;">
              <a class="nav-link" href="index.php">Voltar a Bentley Brasil</a>
            </div>
          </ul>
        </div>
      </div>
    </nav>
  </header>

  <main>
    <div class="flex-box container-box">
      <div class="content-box">
        <h1>Cadastrar</h1>
        <form method="POST">
          <input type="text" name="nome" placeholder="Nome Completo" maxlength="45">
          <input type="text" name="telefone" size="20" maxlength="15" placeholder="Telefone" maxlength="45" onkeypress="mascara(this)">
          <input type="email" name="email" placeholder="Email" maxlength="45">
          <input type="password" name="senha_usuario" placeholder="Senha" maxlength="45">
          <input type="password" name="confsenha" placeholder="Confirmar Senha" maxlength="45">
          <input type="submit" value="Cadastrar" maxlength="45">
          <a style="margin-top: 50px;" href="logar.php">Já sou cadastrado<strong> Logar</strong></a>
        </form>
      </div>
    </div>
  </main>

  <!-- FOOTER -->


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
</body>

</html>