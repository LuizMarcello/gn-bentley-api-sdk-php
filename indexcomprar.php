<?php
require_once 'classes/usuarios.php';
require 'vendor/autoload.php';
$u = new Usuario;
$u->conectar("gerencianet_usuarios", "localhost", "root", "P@ssw0rd");
   /* $u->conectar("gerencianet_usuarios", "localhost", "root", "root1234"); */

if (!isset($_SESSION)) session_start();

if (!isset($_SESSION['id'])) {
  header("location: logar.php");
  exit;
}

use App\Pix\Payload;
use Mpdf\QrCode\QrCode;
use Mpdf\QrCode\Output;

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
  <link rel="stylesheet" href="css/styleindexcomprar.css">
</head>


<body>
  <header>
    <img src="img/logo-empresa-br.png" alt="Bentley Brasil">
    <nav>
      <div class="navmenu">
        <li><a href="index.php">Home</a></li>
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
        <!-- <div class="navuser"> -->
        <li>
          <a class="nav-link"><?php echo $dado['nome']; ?> </a>
        </li>
        <?php } ?>
        <?php } ?>
      </div>
    </nav>
  </header>


  <main>
    <section class="cabecalho">
      <img src="img/cabecalhositebentley.jpg" alt="Bentley Brasil">
    </section>

    <section class="juruena">
      <div class="juruena1">
        <img src="img/next.png" width="35x" height="25px">
        <p style="margin-left: 1%;"> Projeto Juruena <=> Link com Internet Ilimitada </p><br><br>
      </div>
      <div class="juruena2">
        <img src="img/next.png" width="35px" height="25px">
        <p style="margin-left: 1%;"> Internet via rádio com velocidade de fibra ótica</p>
      </div>
      <div class="juruena3">
        <img src="img/next.png" width="35px" height="25px" style="margin-top: 1.5%;">
        <p style="margin-left: 1%; margin-top: 1%; font-size: 17px;">Adesão de equipamentos - Valor R$ 1.900,00</p>
      </div>
    </section>



    <div class="div-chat-z">

      <div class="comoprefere">
        <!--  <div class="btn btn-outline-primary"> -->
        <p>
          <!-- Como você prefere pagar? -->
        </p><br>
      </div>

      <!-- INICIO BOTAO JUNO - NAO EDITAR -->
      <section class="opcoespgto">
        <a href="https://checkout.juno.com.br/#/paymentLink/6C54FC2FB117AA53/copy">
          <img alt="Pague com juno!" src="img/facaAdesaoDoProduto.png" />
        </a>
      </section>
      <!-- FINAL BOTAO JUNO -->

      <!-- <section class="opcoespgto">
        <div class="boleto">
          <a href="indexBoleto.php"><button type="button" class="btn btn-outline-primary btn-sm">
              <img src="img/boleto-logo.svg" width="130px" height="90px"></button></a>
          <p><strong>Mediante compensação</strong></p>
        </div>

        <div class="cartao">
          <a href="indexcartao.php"><button type="button" class="btn btn-outline-primary btn-sm">
              <img src="img/credit-cards.png" width="130px" height="90px"></button></a>
          <p><strong>Cartão de crédito</strong></p>
        </div>

        <div class="pix">
          <a href="indexpix.php"><button type="button" class="btn btn-outline-primary btn-sm">
              <img src="img/logo-pix.png" width="130px" height="90px"></button></a>
          <p><strong> Aprovação imediata</strong></p>
        </div>
      </section> -->

    </div>
  </main>

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

</body>

</html>