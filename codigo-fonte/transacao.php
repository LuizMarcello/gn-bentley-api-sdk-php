<?php

//Recebendo as constantes com as chaves: "secret_id" e "user_id".
require_once('config.php');
//Vendor. Integração com o gerenciaNet
require_once('../vendor/autoload.php');

use Gerencianet\Exception\GerencianetException;
use Gerencianet\Gerencianet;

// insira seu Client_Id, conforme o ambiente (Des ou Prod)
$clientId = CONF_ID; //Constante de config.php
// insira seu Client_Secret, conforme o ambiente (Des ou Prod)
$clientSecret = CONF_SECRETO; //Constante de config.php

$boleto = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRIPPED);

//Se o botão "Gerar Boleto" for acionado:
if (isset($boleto['gerarBoleto'])) {

  unset($boleto['gerarBoleto']);

  echo $boleto['nome'] . "<hr>";
  echo $boleto['email'] . "<hr>";
  echo $boleto['fone'] . "<hr>";
  echo $boleto['cpf'] . "<hr>";
  echo $boleto['produto'] . "<hr>";
  echo $boleto['valor'] . "<hr>";
  echo $boleto['vencimento'] . "<hr>";

  $options = [
    'client_id' => $clientId,
    'client_secret' => $clientSecret,
    'sandbox' => true // altere conforme o ambiente (true = Homologação e false = producao)
  ];

  $item_1 = [
    'name' => $boleto['produto'], // nome do item, produto ou serviço
    'amount' => 1, // quantidade
    'value' => intval($boleto['valor']) // valor (1000 = R$ 10,00)
                                        // (Obs: É possível a criação de itens com valores negativos. Porém, 
                                        // o valor total da fatura deve ser superior ao valor mínimo para 
                                        // geração de transações.)
  ];

  $items =  [
    $item_1
  ];

  $body  =  [
    'items' => $items
  ];

  try {
    $api = new Gerencianet($options);
    $charge = $api->createCharge([], $body);

    print_r($charge);
  } catch (GerencianetException $e) {
    print_r($e->code);
    print_r($e->error);
    print_r($e->errorDescription);
  } catch (Exception $e) {
    print_r($e->getMessage());
  }
}
