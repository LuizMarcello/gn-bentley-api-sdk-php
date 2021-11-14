<?php

require 'vendor/autoload.php';

session_start();
if (!isset($_SESSION['id_usuario'])) {
  header("location: logar.php");
  exit;
}

use \App\Pix\Api;
use \App\Pix\Payload;
use Mpdf\QrCode\QrCode;
use Mpdf\QrCode\Output;

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

            <!--   <li class=""><a href="https://dev.gerencianet.com.br/docs">Documentação</a></li> -->
            <!--  <li class=""><a href="https://dev.gerencianet.com.br/docs/fale-conosco">Contatos</a></li> -->
            <li class=""><a href="index.php">Voltar a Bentley Brasil</a></li>
            <!-- <li class=""><a href="sair.php">Logoff Bentley</a></li> -->
          </ul>

          <ul class="nav navbar-nav pull-right">
            <!--  <li><a target="blank" href="https://gerencianet.com.br/#login">Entrar na gerencianet</a> -->
            </li>
            <!-- <li><a target="blank" href="https://gerencianet.com.br/#abrirconta">Abra sua conta</a> -->
            </li>
          </ul>

        </div><!-- /.navbar-collapse -->
      </div><!-- /.container-fluid -->
    </nav>
  </header>

  <main>
    <h3>QR CODE DINÂMICO DO PIX</h3>

    <?php
    //Instância da API PIX
    $obApiPix = new Api(
      'https://api-pix-h.gerencianet.com.br',
      'Client_Id_adf60ba7ea206de2b1fd2054a7e00a93c66daf96',
      'Client_Secret_0cf0babdc5a54e32050a422d2067dc5c93e574bc',
      __DIR__ . '/certificates/certificadobentleygerencianet.pem');

    //Variável para guardar a reposta do PSP gerencianet:
    //txid: No QrCode dinámico, no mínimo 26 caracteres e
    //no máximo 35 caracteres, letras e números.
    $response = $obApiPix->consultCob('BEOQKPd0hSiUKQC9cWM1ZHX8vyf51sb1EZt');

    if (!isset($response['location'])) {
      echo 'Problemas ao consultar pix dinâmico';
      echo "<pre>";
      print_r($response);
      echo "</pre>";
      exit;
    }

    echo "<pre>";
    print_r($response);
    echo "</pre>";
    exit;
    
    ?>

    <!-- FOOTER -->
    <footer class="main-footer">
      <div>
        <div class="float-right d-none d-sm-block">
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