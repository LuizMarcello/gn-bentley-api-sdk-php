<?php
global $pdo;
require_once 'classes/usuarios.php';
$u = new Usuario;
if (!isset($_SESSION)) session_start();
ob_start(); //Limpa o buffer de saída no redirecionamento
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Bentley-Autalizar senha</title>
  <!-- Icones fontawesome: -->
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
   integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
  <!-- Fontes da google: font-family: 'Open Sans', sans-serif; -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700">
  <link rel="stylesheet" href="css/styleee.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" 
  integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <!--  <link rel="stylesheet" href="css/style.css"> -->
  <link rel="stylesheet" href="css/estilo.css">
  <link rel="stylesheet" href="css/styleee.css">
</head>

<body>
  <h3>Atualizar senha</h3>

  <?php
  $chave = filter_input(INPUT_GET, 'chave', FILTER_DEFAULT);
  var_dump($chave);

  $query_usuario = "SELECT id 
   FROM usuarios 
   WHERE recuperar_senha =:recuperar_senha
 LIMIT 1";
  /* $u->conectar("gerencianet_usuarios", "localhost", "root", "root1234"); */
  $u->conectar("gerencianet_usuarios", "localhost", "root", "P@ssw0rd");
  $result_usuario =  $pdo->prepare($query_usuario);
  $result_usuario->bindParam(':recuperar_senha', $chave, PDO::PARAM_STR);
  $result_usuario->execute();

  if (($result_usuario) and ($result_usuario->rowCount() != 0)) {
  } else {
    $_SESSION['msg'] = "<p style='color: #ff0000'>Erro: Link inválido, solicite novo link para atualizar a senha!</p>";
    header("Location: recuperar_senha.php");
  }

  ?>

</body>

</html>