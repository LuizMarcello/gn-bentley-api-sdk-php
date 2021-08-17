<?php

session_start();

/* Require todas as classes necessárias */
require '../vendor/autoload.php';

/* Abre a classe gerencianet */
use Gerencianet\Exception\GerencianetException;
use Gerencianet\Gerencianet;

/* Adiciona o json que contém o client_id e client_secret */
$file = file_get_contents('config.json');
$options = json_decode($file, true);
 
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