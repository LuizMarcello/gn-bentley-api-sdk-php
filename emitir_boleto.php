<?php

session_start();

require_once 'vendor/autoload.php';
require_once 'config.php';

/* echo CONF_SECRETO; */

use Gerencianet\Exception\GerencianetException;
use Gerencianet\Gerencianet;

$clientId = CONF_ID;
$clientSecret = CONF_SECRETO;

//Filtro recebendo o POST do formulário em indexBoleto.php, e evitando ataques.
$boleto = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRIPPED);

if(isset($boleto['gerarBoleto'])){

    unset($boleto['gerarBoleto']);

    echo $boleto['nome'] ."<hr>";
   
    echo $boleto['email'] ."<hr>";
    echo $boleto['fone'] ."<hr>";
    echo $boleto['cpf'] ."<hr>";
   
    echo $boleto['produto'] ."<hr>";
    echo $boleto['valor'] ."<hr>";
    echo $boleto['vencimento'] ."<hr>";
    /* echo "<pre>";
    print_r($boleto);
    echo "</pre>";
    exit; */

    $options = [
        'client_id' => $clientId,
        'client_secret' => $clientSecret,
        'sandbox' => true //altere conforme o ambiente (true = Homologação e 
                          //false = producao)
      ];
       
      $item_1 = [
          'name' => $boleto['produto'], // nome do item, produto ou serviço
          'amount' => 1, // quantidade
          'value' => intval($boleto['valor']) 
          //valor (1000 = R$ 10,00) (Obs: É possível a criação de itens com 
          //valores negativos. Porém, o valor total da fatura deve ser superior
          //ao valor mínimo para geração de transações.)
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
        header("Location: gerar-boleto.php?id=".$charge['data']['charge_id']."&nome=".$boleto['nome']."&cpf=".$boleto['cpf']."&fone=".$boleto['fone']."&vencimento=".$boleto['vencimento']);
    } catch (GerencianetException $e) {
        print_r($e->code);
        print_r($e->error);
        print_r($e->errorDescription);
    } catch (Exception $e) {
        print_r($e->getMessage());
    }
}
