<?php
require_once 'classes/usuarios.php';
require '../vendor/autoload.php';
$u = new Usuario;

if (!isset($_SESSION)) session_start();

if (!isset($_SESSION['id_usuario'])) {
  header("location: logar.php");
  exit;
}

use App\Pix\Payload;
use Mpdf\QrCode\QrCode;
use Mpdf\QrCode\Output;

//Instancia principal do PAYLOAD PIX
/* $obPayload = (new Payload)->setPixKey('48274402987')
  ->setDescription('Pagamento do pedido 123456')
  ->setMerchantName('Marcelo da Silva')
  ->setMerchantCity('Londrina')
  ->setAmount(100.00)
  ->setTxid('IMCL1234'); */

//Código de pagamento PIX
/* $payloadQrCode = $obPayload->getPayload(); */

//Instância do QR CODE
/* $obQrCode = new QrCode($payloadQrCode); */

//Imagem do QRCODE
/* $image = (new Output\Png)->output($obQrCode, 400);
 */
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Hotel Paraíso</title>
  <!-- Icones fontawesome: -->
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" 
  integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" 
  crossorigin="anonymous" />
  <!-- Fontes da google: font-family: 'Open Sans', sans-serif; -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700">
  <link rel="stylesheet" href="css/styleee.css">
</head>

<body>
  <header>
    <img src="https://sistema.bentleybrasil.com.br/img/logo-empresa-br.png" alt="Bentley Brasil">
    <nav>
      <div class="navmenu">
        <li><a href="index.php">Home</a></li>
        <li><a href="">Sobre</a></li>
        <li><a href="">Contato</a></li>
      </div>
      <?php
      if (isset($_SESSION['id_usuario'])) {
        $u->conectar("gerencianet_usuarios", "localhost", "root", "P@ssw0rd");
        /*   $u->conectar("gerencianet_usuarios", "localhost", "root", "root1234"); */
        $user = $_SESSION['id_usuario'];
        $sql = "SELECT * FROM usuarios WHERE id_usuario = $user";
        global $pdo;
        $sql = $pdo->prepare($sql);
        $sql->bindValue("id_usuario", $_SESSION['id_usuario']);
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
    <section class="cabecalho">
      <img src="img/cabecalhositebentley.jpg" alt="Bentley Brasil">
    </section>

    <section class="juruena">
      <div class="juruena1">
        <img src="img/next.png" width="35x" height="25px">
        <p style="margin-left: 1%;"> Projeto Jeruena - Internet Ilimitada </p><br><br>
      </div>
      <div class="juruena2">
        <img src="img/next.png" width="35px" height="25px">
        <p style="margin-left: 1%;"> Internet via rádio com a velocidade de fibra ótica</p>
      </div>
      <div class="juruena3">
        <img src="img/next.png" width="35px" height="25px" style="margin-top: 1.5%;">
        <p style="margin-left: 1%; margin-top: 1%; font-size: 22px;">Adesão de equipamentos - Valor R$ 1.900,00</p>
      </div>
    </section>


    <div class="div-chat-z">
      <div class="comoprefere">
        <!--  <div class="btn btn-outline-primary"> -->
        <p style="font-family:Arial, Helvetica, sans-serif; font-size: large; font-weight: bold; margin-left: 1%; margin-top: 3%;">
          Como você prefere pagar?</p><br>
      </div>

      <section class="opcoespgto">
        <div class="boleto">
          <a href="indexboleto.php"><button type="button" class="btn btn-outline-primary btn-sm"><img src="img/boleto-logo.svg" width="130px" height="90px"></button></a>
          <p><strong>Mediante compensação</strong></p>
        </div>

        <div class="cartao">
          <a href="indexcartao.php"><button type="button" class="btn btn-outline-primary btn-sm"><img src="img/credit-cards.png" width="130px" height="90px"></button></a>
          <p><strong>Cartão de crédito</strong></p>
        </div>

        <div class="pix">
          <a href="indexpix.php"><button type="button" class="btn btn-outline-primary btn-sm"><img src="img/logo-pix.png" width="130px" height="90px"></button></a>
          <p><strong> Aprovação imediata</strong></p>
        </div>
      </section>
    </div>





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
  </main>

</body>

</html>