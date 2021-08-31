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
  <title>Login</title>
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
        <h1>Entrar</h1>
        <form method="POST">
          <input type="email" name="email" placeholder="Usuário">
          <input type="password" name="senha" placeholder="Senha">
          <input type="submit" value="Acessar">
          <a href="cadastrar.php">Ainda não é inscrito?<strong> Cadastre-se</strong></a>
        </form>
      </div>
    </div>
  </main>

  <br>

  <!-- FOOTER -->
  <footer class="main-footer">
    <div class="float-center d-none d-sm-block" style="bottom: 0; position:absolute; margin-left: 21%;" >
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

  <?php
  if (isset($_POST['email'])) {
    //Usando a variável global "POST"
    //addslashes():Para impedir que comandos maliciosos sejam inseridos no formulário.
    $email = addslashes($_POST['email']);
    $senha = addslashes($_POST['senha']);

    //Verificando se está preenchido, se tem algum campo em branco
    if (!empty($email) && !empty($senha)) {
      $u->conectar("gerencianet_usuarios", "localhost", "root", "root1234");
      if ($u->msgErro == "") //Se continuar vazia, está tudo OK.
      {
        if ($u->logar($email, $senha)) {
          header("location: indexboleto.php");
        } else {
  ?>

  <div class="msg-erro">
    Email e/ou senha incorretos!
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
    Preencha todos os campos!
  </div>
  <?php
    }
  }
  ?>
</body>

</html>