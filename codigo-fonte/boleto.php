<?php
 
session_start();

require '../vendor/autoload.php'; // caminho relacionado a SDK
 
use Gerencianet\Exception\GerencianetException;
use Gerencianet\Gerencianet;
 
$clientId = 'Client_Id_f59589b32e4af8c830014d5f7a4caec26741770d';
$clientSecret = 'Client_Secret_ba04464d354e740abc603c2e7005b4b097b9234c'; 
 
$options = [
  'client_id' => $clientId,
  'client_secret' => $clientSecret,
  'sandbox' => true // altere conforme o ambiente (true = Homologação e false = producao)
];
 
// $charge_id refere-se ao ID da transação gerada anteriormente
$params = [
  'id' => $_SESSION['ID_COMPRA']
];
 
$customer = [
  'name' => 'Alex Vidal', 
  'cpf' => '94271564656' , 
  'phone_number' => '64992367973' 
];
 
$bankingBillet = [
  'expire_at' => '2021-09-16', // data de vencimento do boleto (formato: YYYY-MM-DD)
  'customer' => $customer
];
 
$payment = [
  'banking_billet' => $bankingBillet // forma de pagamento (banking_billet = boleto)
];
 
$body = [
  'payment' => $payment
];
 
try {
    $api = new Gerencianet($options);
    $charge = $api->payCharge($params, $body);
 
    print_r($charge);
} catch (GerencianetException $e) {
    print_r($e->code);
    print_r($e->error);
    print_r($e->errorDescription);
} catch (Exception $e) {
    print_r($e->getMessage());
}