<?php
require_once 'classes/usuarios.php';
$u = new Usuario;
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
          <input type="text" name="telefone" placeholder="Telefone" maxlength="45">
          <input type="email" name="email" placeholder="Usuário" maxlength="45">
          <input type="password" name="senha" placeholder="Senha" maxlength="45">
          <input type="password" name="confsenha" placeholder="Confirmar Senha" maxlength="45">
          <input type="submit" value="Cadastrar" maxlength="45">
          <a href="logar.php">Já sou cadastrado<strong> Logar</strong></a>
        </form>
      </div>
    </div>
  </main>

  <!-- FOOTER -->
  <footer class="main-footer">
    <div class="float-center d-none d-sm-block" style="bottom: 0; position:absolute; margin-left: 21%;">
      <img src="https://gerencianet.com.br/wp-content/themes/Gerencianet/images/marca-gerencianet.svg"
        onerror="this.onerror=null; this.src='images/marca-gerencianet.png'" alt="Gerencianet - Conceito em Pagamentos"
        width="218" height="27">
      <div class="content-footer">
        © 2007-2016 Gerencianet. Todos os direitos reservados.<br />
        Gerencianet Pagamentos do Brasil Ltda.<br />
        <br />
      </div>
    </div>
  </footer>

  <!-- //Pegando todas as informações que o usuário digitou e clicou "Cadastrar" -->
  <?php
  /* Verificando se clicou no botão */
  if (isset($_POST['nome'])) {
    //Usando a variável global "POST"
    //addslashes():Para impedir que comandos maliciosos sejam inseridos no formulário.
    $nome = addslashes($_POST['nome']);
    $telefone = addslashes($_POST['telefone']);
    $email = addslashes($_POST['email']);
    $senha = addslashes($_POST['senha']);
    $confsenha = addslashes($_POST['confsenha']);
    //Verificando se está preenchido, se tem algum campo em branco
    if (!empty($nome) && !empty($telefone) && !empty($email) && !empty($senha) && !empty($confsenha)) {
      $u->conectar("gerencianet_usuarios", "localhost", "root", "P@ssw0rd");
      if ($u->msgErro == "") //Vazia está tudo OK.
      {
        if ($senha == $confsenha) {
          if ($u->cadastrar($nome, $telefone, $email, $senha)) {
  ?>
  <div id="msg-sucesso">
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