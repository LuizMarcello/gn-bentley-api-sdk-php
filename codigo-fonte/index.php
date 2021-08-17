<?php
 
session_start();

require '../vendor/autoload.php'; 
 
use Gerencianet\Exception\GerencianetException;
use Gerencianet\Gerencianet;
 
$clientId = 'Client_Id_f59589b32e4af8c830014d5f7a4caec26741770d'; 
$clientSecret = 'Client_Secret_ba04464d354e740abc603c2e7005b4b097b9234c'; 
 
$options = [
  'client_id' => $clientId,
  'client_secret' => $clientSecret,
  'sandbox' => true // (true = desenvolvimento e false = producao)
];
 
$item_1 = [
    'name' => 'Hospedagem Basica', 
    'amount' => 1, 
    'value' => 1000 
];
 
$item_2 = [
    'name' => 'Registro de Dominio', 
    'amount' => 2, 
    'value' => 3000 
];
 
$items =  [
    $item_1,
    $item_2
];

// Exemplo para receber notificações da alteração do status da transação:
// $metadata = ['notification_url'=>'sua_url_de_notificacao_.com.br']
// Outros detalhes em: https://dev.gerencianet.com.br/docs/notificacoes

// Como enviar seu $body com o $metadata
// $body  =  [
//    'items' => $items,
//    'metadata' => $metadata
// ];

$body  =  [
    'items' => $items
];

try {
    $api = new Gerencianet($options);
    $charge = $api->createCharge([], $body);
    $_SESSION['ID_COMPRA'] = $charge['data'] ['charge_id'];
} catch (GerencianetException $e) {
    print_r($e->code);
    print_r($e->error);
    print_r($e->errorDescription);
} catch (Exception $e) {
    print_r($e->getMessage());
}
?>

<a href="http://localhost/gn-bentley-api-sdk-php/codigo-fonte/boleto.php">Pagar com boleto</a>