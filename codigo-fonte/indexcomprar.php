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
$obPayload = (new Payload)->setPixKey('48274402987')
  ->setDescription('Pagamento do pedido 123456')
  ->setMerchantName('Marcelo da Silva')
  ->setMerchantCity('Londrina')
  ->setAmount(100.00)
  ->setTxid('IMCL1234');

//Código de pagamento PIX
$payloadQrCode = $obPayload->getPayload();

//Instância do QR CODE
$obQrCode = new QrCode($payloadQrCode);

//Imagem do QRCODE
$image = (new Output\Png)->output($obQrCode, 400);

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="bootstrapBoleto/css/bootstrap.css">
  <link rel="stylesheet" href="bootstrapBoleto/css/style.css">
  <script type="text/javascript" src="bootstrapBoleto/js/jquery-2.2.4.min.js"></script>
  <script type="text/javascript" src="bootstrapBoleto/js/bootstrap.js"></script>
  <script type="text/javascript" src="bootstrapBoleto/js/jquery.mask.js"></script>
  <script type="text/javascript" src="bootstrapBoleto/js/scripts.js"></script>
  <title>Comprar</title>
</head>

<body>
  <header>
    <nav class="navbar navbar-default">
      <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
            data-target="#bs-example-navbar-collapse-1" aria-expanded="true">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="/codigos-documentacao/">
            <img src="https://gerencianet.com.br/wp-content/themes/Gerencianet/images/marca-gerencianet.svg"
              onerror="this.onerror=null; this.src='img/marca-gerencianet.png'"
              alt="Gerencianet - Conceito em Pagamentos" width="218" height="31">
          </a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
          <ul class="nav navbar-nav">
            <li class=""><a href="index.php">Retornar a Bentley Brasil</a></li>
          </ul>

          <ul class="nav navbar-nav pull-right">
            <div class="collapse navbar-collapse" id="navbarCollapse">
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
                                    $dado = $sql->fetch();
                  ?>
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1;">
                  <p><?php echo $dado['nome']; ?> </p>
                </div>
                <?php } ?>
                <?php } ?>
              </div>
            </div>
          </ul>
        </div>
      </div>
    </nav>
  </header>

  <main>

    <div class="div-chat-m">
      <p> Projeto Jeruena - Internet Ilimitada </p>
      <p> Internet via rádio com a velocidade de fibra ótica</p>
    </div>

    <div class="div-chat-i">
      <p>Adesão de equipamentos - Valor R$ 1.900,00</p>
    </div>


    <div class="div-chat-z">
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
        style="bottom: 0; position:absolute; margin-left:25%; margin-bottom: 1%">
        <b>Satellite Broadband Networks</b> 1.0-rc
        <strong>Copyright &copy; <a href="https://adminlte.io"> Bentley Brasil
            - Projeto
            Juruena</a>.</strong> Todos os direitos reservados
      </div>
    </footer>
  </main>

</body>

</html>