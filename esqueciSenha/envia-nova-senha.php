<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Enviar nova senha</title>
</head>

<body>
  <?php
  global $pdo;
  require_once '../classes/usuarios.php';
  if (!isset($_SESSION)) session_start();
  $u = new Usuario;
  $u->conectar("gerencianet_usuarios", "localhost", "root", "P@ssw0rd");
  /* $u->conectar("gerencianet_usuarios", "localhost", "root", "root1234"); */

  $email = $_POST["email"];

  $email = preg_replace('/[^[:alnum:]_.-@]/', '', $email);

  $chave = $u->geraChaveAcesso($email);

  if ($chave) {
    echo '<a href="http://localhost/gn-bentley-api-sdk-php/esqueciSenha/alterar-senha.php?chave=' . $chave . '">
http://localhost/gn-bentley-api-sdk-php/esqueciSenha/alterar-senha.php?chave=' . $chave . '</a>';
  } else {
    echo '<h2>Êrro: Usuário não encontrado.</h2>';
  }
  ?>

</body>

</html>