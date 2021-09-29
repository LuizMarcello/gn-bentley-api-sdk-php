<?php
global $pdo;
require_once 'classes/usuarios.php';
$u = new Usuario;
if (!isset($_SESSION)) session_start();
ob_start();
/* $u = new Usuario; */
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Bentley-Recuperar senha</title>
  <!-- Icones fontawesome: -->
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
  <!-- Fontes da google: font-family: 'Open Sans', sans-serif; -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700">
  <link rel="stylesheet" href="css/styleee.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <!--  <link rel="stylesheet" href="css/style.css"> -->
  <link rel="stylesheet" href="css/estilo.css">
  <link rel="stylesheet" href="css/styleee.css">

</head>

<body>
  <header>
    <img src="https://sistema.bentleybrasil.com.br/img/logo-empresa-br.png" alt="Bentley Brasil">
    <nav>
  </header>

  <h3>Recuperar senha</h3>

  <?php
  $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

  if (!empty($dados['SendRecupSenha'])) {
    /*  var_dump($dados); */
    $query_usuario = "SELECT id_usuario, nome, email
                    FROM  usuarios
                    WHERE email =:email
                    LIMIT 1";
    $u->conectar("gerencianet_usuarios", "localhost", "root", "P@ssw0rd");
    $result_usuario =  $pdo->prepare($query_usuario);
    $result_usuario->bindParam(
      ':email',
      $dados['usuario'],
      PDO::PARAM_STR
    );
    $result_usuario->execute();

    if (($result_usuario) and ($result_usuario->rowCount() != 0)) {
      /*  echo "Enviar e-mail"; */
      $row_usuario = $result_usuario->fetch(PDO::FETCH_ASSOC);
      $chave_recuperar_senha = password_hash($row_usuario['id_usuario'], PASSWORD_DEFAULT);
      echo "Chave $chave_recuperar_senha <br>";
    } else {
      $_SESSION['msg'] = "<p style='color: black'>Êrro: E-mail não cadastrado!</p>";
    }
  }

  if (isset($_SESSION['msg'])) {
    echo $_SESSION['msg'];
    unset($_SESSION['msg']);
  }
  ?>

  <main>
    <div class="flex-box container-box">
      <div class="content-box">
        <form method="POST" action="">
          <label>
            <h3>E-mail</h3>
          </label>
          <input type="text" name="usuario" placeholder="Digite o email" value="">
          <input type="submit" value="Recuperar" name="SendRecupSenha">
        </form>
      </div>
    </div>
  </main>

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