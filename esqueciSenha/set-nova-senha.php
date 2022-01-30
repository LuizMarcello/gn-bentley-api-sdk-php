<!DOCTYPE html>
<html lang="en">

<?php
global $pdo;
require_once '../classes/usuarios.php';
if (!isset($_SESSION)) session_start();
$u = new Usuario;
$u->conectar("gerencianet_usuarios", "localhost", "root", "P@ssw0rd");
/*  $u->conectar("gerencianet_usuarios", "localhost", "root", "root1234"); */
?>

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Alterar Senha</title>
  <!-- Icones fontawesome: -->
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
  <!-- Fontes da google: font-family: 'Open Sans', sans-serif; -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700">
  <link rel="stylesheet" href="../esqueciSenha/css/styleindexSetNovaSenha.css">
</head>

<body>

  <header>
    <img src="../img/logo-empresa-br.png" alt="Bentley Brasil">
    <nav>
      <div class="navmenu">
        <li>
         <!--  <a class="nav-link" href="alterar-senha.php">Voltar</a><br> -->
          <a class="nav-link" href="../logar.php">Página de login</a>
        </li>
    </nav>
  </header>

  <main>
    <div class="content-box">
      <?php
      $email = $_POST["email"];
      $novasenha = $_POST["senha"];
      $repetesenha = $_POST["repetesenha"];

      if ($novasenha == $repetesenha) {
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
      } else {
      ?>
        <h3>senhas não conferem!!!</h3>
      <?php } ?>
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