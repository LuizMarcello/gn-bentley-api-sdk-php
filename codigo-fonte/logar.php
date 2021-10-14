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
  <title>Bentley Brasil</title>
  <!-- Icones fontawesome: -->
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
  <!-- Fontes da google: font-family: 'Open Sans', sans-serif; -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700">
  <link rel="stylesheet" href="css/styleee.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <!--  <link rel="stylesheet" href="css/style.css"> -->
  <link rel="stylesheet" href="css/estilo.css">

  <link rel="stylesheet" href="css/styleee.css">

  <title>Login</title>
</head>

<body>
  <header>
    <img src="https://sistema.bentleybrasil.com.br/img/logo-empresa-br.png" alt="Bentley Brasil">
    <nav>
      <div class="navmenu">
        <li><a href="index.php">Home</a></li>
        <li><a href="">Sobre</a></li>
        <li><a href="">Contato</a></li>
        <li>
          <?php if (isset($_SESSION['id'])) { ?>
            <a class="nav-link" href="sair.php">Sair</a>
          <?php } ?>
          <?php if (!isset($_SESSION['id'])) { ?>
            <a class="nav-link" href="logar.php">Entrar</a>
          <?php } ?>
        </li>
      </div>

      <?php
      if (isset($_SESSION['id'])) {

        $user = $_SESSION['id'];
        $sql = "SELECT * FROM usuarios WHERE id = $user";
        global $pdo;

        $sql = $pdo->prepare($sql);
        $sql->bindValue("id", $_SESSION['id']);
        $sql->execute();

        if ($sql->rowCount() > 0) {
          $dado = $sql->fetch(); ?>
          <div class="navuser">
            <a class="nav-link"><?php echo $dado['nome']; ?> </a>
          </div>
        <?php } ?>
      <?php } ?>
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
          <a href="cadastrar.php">Ainda não é inscrito?<strong> Cadastre-se</strong></a><br>
        </form>
        <p align="right"><a href="recuperarsenha/esqueci-a-senha.php">Esqueceu a senha? Recupere já!</a></p>
      </div>
    </div>
  </main>

  <br>

  <!-- FOOTER -->
  <footer>
    <ul>
      <li><a href=""><i class="fab fa-facebook"></i></a></li>
      <li><a href=""><i class="fab fa-twitter"></i></a></li>
      <li><a href=""><i class="fab fa-snapchat"></i></a></li>
      <li><a href=""><i class="fab fa-pinterest"></i></a></li>
    </ul>
    <p>Satellite Broadband Networks - Bentley Brasil - Projeto Juruena</p>
  </footer>

  <?php
  if (isset($_POST['email'])) {
    //Usando a variável global "POST"
    //addslashes():Para impedir que comandos maliciosos sejam inseridos no formulário.
    $email = addslashes($_POST['email']);
    $senha = addslashes($_POST['senha']);

    //Verificando se está preenchido, se tem algum campo em branco
    if (!empty($email) && !empty($senha)) {
     
      if ($u->msgErro == "") //Se continuar vazia, está tudo OK.
      {
        if ($u->logar($email, $senha)) {
          header("location: indexcomprar.php");
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