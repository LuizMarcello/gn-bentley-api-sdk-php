<?php

require '../vendor/autoload.php';

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
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="/codigos-documentacao/">
            <img src="https://gerencianet.com.br/wp-content/themes/Gerencianet/images/marca-gerencianet.svg" onerror="this.onerror=null; this.src='img/marca-gerencianet.png'"
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


    <?php
    //Instância da API PIX
    $obApiPix = new Api(
      'https://api-pix-h.gerencianet.com.br',
      'Client_Id_adf60ba7ea206de2b1fd2054a7e00a93c66daf96',
      'Client_Secret_0cf0babdc5a54e32050a422d2067dc5c93e574bc',
      __DIR__ . '/certificates/certificadobentleygerencianet.pem'

    );

    //Corpo da requisição
    //Requisição (request) que será enviada ao PSP gerencianet:
    $request = [
      'calendario' => [
        'expiracao' => 3600
      ],
      'devedor' => [
        'cpf' => '07178216921',
        'nome' => 'Valeria Miranda de Oliveira'
      ],
      'valor' => [
        'original' => '1900.00'
      ],
      'chave' => 'financeiro@bentleybrasil.com.br',
      'solicitacaoPagador' => 'Adesao de equipamentos - projeto Juruena'
    ];

    //Gerando um txid randômico
    function getToken($length){
      $token = "";
      $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
      $codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
      $codeAlphabet.= "0123456789";
      $max = strlen($codeAlphabet);
  
      for ($i=0; $i < $length; $i++) {
          $token .= $codeAlphabet[random_int(0, $max-1)];
      }
  
      return $token;
  }

    //Variável para guardar a reposta do PSP gerencianet:
    //txid: No QrCode dinámico, no mínimo 26 caracteres e
    //no máximo 35 caracteres, letras e números.
   /*  $response = $obApiPix->createCob('renjifkq334tigrtwimacellol', $request); */
    $response = $obApiPix->createCob(getToken(35), $request);

    if (!isset($response['location'])) {
      echo 'Problemas ao gerar pix dinâmico';
      echo "<pre>";
      print_r($response);
      echo "</pre>";
      exit;
    }

    //Instancia principal do PAYLOAD PIX
    $obPayload = (new Payload)
      ->setMerchantName($response['devedor']['nome'])
     /*  ->setMerchantCity('Londrina') */
      ->setAmount($response['valor']['original'])
      ->setTxid($response['txid'])
      ->setUrl($response['location'])
      ->setUniquePayment(true);

    //Código de pagamento PIX
    $payloadQrCode = $obPayload->getPayload();

    //Instância do QR CODE
    $obQrCode = new QrCode($payloadQrCode);

    //Imagem do QRCODE
    ?> <p style="margin-left: 3%;"><?php $image = (new Output\Png)->output($obQrCode, 220); ?></p>

    <div style="margin-left: 3%;">
      <h5>QR CODE DINÂMICO DO PIX</h5>
      <p>
      <h5><strong>Escaneie este código para pagar</strong></h5>
      </p>
      <p>
      <h6>1. Acesse seu Internet Banking ou app de pagamentos.</h6>
      </p>
      <p>
      <h6>2. Escolha pagar via Pix</h6>
      </p>
      <p>
      <h6>3. Escaneie o seguinte código:</h6>
      </p>
    </div>

    <!-- Convertendo para "base64" e imprimir dentro do html -->
    <img src="data:image/png;base64, <?= base64_encode($image) ?>">

    <br>

    <!-- Código pix: <br> -->
    <div style="margin-left: 3%;">
      <div>Pague e será creditado na hora, ou copie este código QR para fazer o pagamento</div>
      <br>
      <div>Escolha pagar via Pix pelo seu Internet Banking ou app de pagamentos.</div>
      <div> Depois, cole o seguinte código:</div>
      <strong><?= $payloadQrCode ?></strong>
      <!--  <button type="button" class="btn btn-primary">Copiar código</button> -->
    </div>



    <br><br>
    <!-- FOOTER -->
    <footer class="main-footer" style="text-align: center;">
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