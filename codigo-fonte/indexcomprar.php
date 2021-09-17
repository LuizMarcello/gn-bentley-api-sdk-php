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
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Bentley Juruena</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet" media="all">
  <link rel="stylesheet" href="bootstrapBoleto/css/style.css">
  <link rel="stylesheet" href="css/style.css">
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
              <img height="70" src="https://sistema.bentleybrasil.com.br/img/logo-empresa-br.png">
            </span>
            <div style="margin: 36px 0 0 50px;">
              <a class="nav-link" aria-current="page" href="index.php">Home</a>
            </div>
            <div style="margin: 36px 0 0 50px;">
              <?php
                            if (isset($_SESSION['id_usuario'])) {
                                $u->conectar("gerencianet_usuarios", "localhost", "root", "P@ssw0rd");
                                /* $u->conectar("gerencianet_usuarios", "localhost", "root", "root1234"); */
                                $user = $_SESSION['id_usuario'];
                                $sql = "SELECT * FROM usuarios WHERE id_usuario = $user";
                                global $pdo;
                                $sql = $pdo->prepare($sql);
                                $sql->bindValue("id_usuario", $_SESSION['id_usuario']);
                                $sql->execute();

                                if ($sql->rowCount() > 0) {
                                    $dado = $sql->fetch(); ?>
              <a class="nav-link"><?php echo $dado['nome']; ?> </a>
            </div>
            <!-- <div style="margin: 36px 0 0 50px;">
                            <a class="nav-link"><?php echo $dado['email']; ?> </a>
                        </div> -->
          </ul>
          <?php } ?>
          <?php } ?>
        </div>
      </div>
    </nav>

  </header>


  <main>
    <div class="cabecalhobentley">
      <!-- <img src="img/imagesbentley.jpg" width="470px" height="250px"> -->
      <img height="100%" width="90%" src="img/cabecalhositebentley.jpg">
    </div>

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

    <div class="div-chat-z">
      <!--  <div class="btn btn-outline-primary"> -->
      <p
        style="font-family:Arial, Helvetica, sans-serif; font-size: large; font-weight: bold; margin-left: 1%; margin-top: 3%;">
        Como você prefere pagar?</p><br>
      <a href="indexboleto.php"><button type="button" class="btn btn-outline-primary btn-sm"><img
            src="img/boleto-logo.svg" width="130px" height="90px"></button></a>
      <p><strong>Mediante compensação</strong></p>
      <br>
      <a href="indexcartao.php"><button type="button" class="btn btn-outline-primary btn-sm"><img
            src="img/credit-cards.png" width="130px" height="90px"></button></a>
      <p><strong>Cartão de crédito</strong></p>
      <br>
      <a href="indexpix.php"><button type="button" class="btn btn-outline-primary btn-sm"><img src="img/logo-pix.png"
            width="130px" height="90px"></button></a>
      <p><strong> Aprovação imediata</strong></p>
    </div>




    <!-- FOOTER -->
    <footer class="main-footer">
      <div class="float-center d-none d-sm-block"
        style="bottom: 0; position:absolute; margin-left:5%; margin-bottom: 1%">
        <b>Satellite Broadband Networks</b> 1.0-rc
        <strong>Copyright &copy; <a href="https://adminlte.io"> Bentley Brasil
            - Projeto
            Juruena</a>.</strong> Todos os direitos reservados
      </div>
    </footer>
  </main>

</body>

</html>