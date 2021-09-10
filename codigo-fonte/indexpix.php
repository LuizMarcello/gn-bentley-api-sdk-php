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

//Imprimindo apenas a imagem do QRCODE:
/* header('Content-Type: image/png');
echo $image; */

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
  <title>Gerencianet</title>
</head>

<body>
  <header>
    <nav class="navbar navbar-default">
      <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
            data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
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
          <ul class="nav navbar-nav">
            <li class=""><a href="indexcomprar.php">Retornar as opções de pagamento</a></li>
          </ul>
          <ul class="nav navbar-nav pull-right">
            <div class="collapse navbar-collapse" id="navbarCollapse">
              <div style="margin: 36px 0 0 50px;">
                <?php
                if (isset($_SESSION['id_usuario'])) {
                 /*  $u->conectar("gerencianet_usuarios", "localhost", "root", "P@ssw0rd"); */
                  $u->conectar("gerencianet_usuarios", "localhost", "root", "root1234");
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
        </div><!-- /.navbar-collapse -->
      </div><!-- /.container-fluid -->
    </nav>
  </header>

  <main>

    <form action="gerar-qrcode-dinamico.php" method="POST" accept-charset="UTF-8">
      <div class="form-check" style="margin-left: 100px; margin-top:50px">
        <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1" checked>
        <label class="form-check-label" for="flexRadioDefault1">
          CPF
        </label>
      </div>
      <div class="form-check" style="margin-left: 100px; margin-top:25px">
        <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2">
        <label class="form-check-label" for="flexRadioDefault2">
          CNPJ
        </label>
      </div>

      <div class="form-group" style="margin-left: 100px; margin-top: 1%;">
        <label for="documento" class="control-label"></label>
        <!-- <input class="documento form-control" name="documento" type="text" id="documento" value=""> -->
        <input class="documento form-control" name="documento" type="text" id="documento" value="Informe o CPF" required>
      </div>

      <div style="margin-left: 700px;">
      <img src="img/internetRadio.jpg" width="300px" height="210px"> 
    </div>

      <br><br>

      <div class="form-group" style="margin-left: 100px; margin-top:15px" ;>
        <label for="nome_razaosocial" class="control-label">
         
        </label>
        <input class="form-control" rows="3" name="nome_razaosocial" type="text" id="nome_razaosocial" required
          value="Nome/Razão Social">
       
      </div>
    </form>

    

    <!-- FOOTER -->
    <footer class="main-footer" style="text-align: center; margin: 12%;">
      <div>
        <div class="float-rightd-none d-sm-block">
          <b>Satellite Broadband Networks</b> 1.0-rc
        </div>
        <strong>Copyright &copy; <a href="https://adminlte.io"> Bentley Brasil
            - Projeto
            Juruena</a>.</strong> Todos os direitos reservados
      </div>
    </footer>
  </main>

</body>

</html>