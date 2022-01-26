<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Enviar nova senha</title>
  <!-- Icones fontawesome: -->
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
    integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
  <!-- Fontes da google: font-family: 'Open Sans', sans-serif; -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700">
  <link rel="stylesheet" href="../esqueciSenha/css/styleindex.css">
</head>

<body>

  <header>
    <img src="../img/logo-empresa-br.png" alt="Bentley Brasil">
    <nav>
      <div class="navmenu">
        <li>
          <a class="nav-link" href="esqueci-a-senha.html">Voltar</a>
        </li>
    </nav>
  </header>

  <?php
  global $pdo;
  require_once '../classes/usuarios.php';
  if (!isset($_SESSION)) session_start();
  $u = new Usuario;
 /* $u->conectar("gerencianet_usuarios", "localhost", "root", "P@ssw0rd"); */
   $u->conectar("gerencianet_usuarios", "localhost", "root", "root1234");

if(isset($_POST["email"])){

$email = $_POST["email"];

  $email = preg_replace('/[^[:alnum:]_.-@]/', '', $email);

  $chave = $u->geraChaveAcesso($email);

  if ($chave) {
    /* echo '<a href="http://localhost/gn-bentley-api-sdk-php/esqueciSenha/alterar-senha.php?chave=' . $chave . '">
http://localhost/gn-bentley-api-sdk-php/esqueciSenha/alterar-senha.php?chave=' . $chave . '</a>'; */
echo '<a href="http://localhost/gn-bentley-api-sdk-php/esqueciSenha/alterar-senha.php?chave=' . $chave . '">
Clique aqui para alterar sua senha criptografada</a>';
        
  } else {
    echo '<h1>Êrro: Usuário não encontrado.</h1>';
  }
}else {
?>
  <h3>Você não informou nenhum e-mail</h3>
  <?php
}
  ?>

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