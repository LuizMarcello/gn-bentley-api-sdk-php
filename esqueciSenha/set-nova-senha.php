<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Alterar Senha</title>
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
  $novasenha = $_POST["senha"];
  $chave = $_POST["chave"];

  $email = preg_replace('/[^[:alnum:]_.-@]/', '', $email);
  $chave = preg_replace('/[^[:alnum:]]/', '', $chave);
  $novasenha = addslashes($novasenha);

  /* Função que irá validar a chave de segurança do usuário  */
  $result = $u->checkChave($email, $chave);

  /* $result contém o id do usuário que solicitou alteração de senha */
  if ($result) {
    $alterasenha = $u->setNovaSenha($novasenha, $result);
    echo '<h1>Senha alterada com sucesso</h1>';
  } else {
    echo '<h1>Êrro: Usuário não encontrado</h1>';
  }



  ?>

</body>

</html>