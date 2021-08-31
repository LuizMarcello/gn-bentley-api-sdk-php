<?php

require '../vendor/autoload.php';

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

<h1>QR CODE PIX</h1>

<br>

<!-- Convertendo para "base64" e imprimir dentro do html -->
<img src="data:image/png;base64, <?= base64_encode($image) ?>">

<br><br>

Código pix: <br>

<strong><?= $payloadQrCode ?></strong>