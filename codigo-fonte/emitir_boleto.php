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
    'sandbox' => true
];

if (isset($_POST)) {

    $item_1 = [
        'name' => $_POST["descricao"],
        'amount' => (int) $_POST["quantidade"],
        'value' => (int) $_POST["valor"]
    ];

    $items = [
        $item_1
    ];

    $body = ['items' => $items];

    try {
        $api = new Gerencianet($options);
        $charge = $api->createCharge([], $body);
        if ($charge["code"] == 200) {

            $params = ['id' => $charge["data"]["charge_id"]];
            $customer = [
                'name' => $_POST["nome_cliente"],
                'cpf' => $_POST["cpf"],
                'phone_number' => $_POST["telefone"]
            ];

            //Formatando a data, convertendo do estino brasileiro para americano.
            $data_brasil = DateTime::createFromFormat('d/m/Y', $_POST["vencimento"]);
            
            $bankingBillet = [
                'expire_at' => $data_brasil->format('Y-m-d'),
                'customer' => $customer
            ];
            $payment = ['banking_billet' => $bankingBillet];
            $body = ['payment' => $payment];

            $api = new Gerencianet($options);
            $pay_charge = $api->payCharge($params, $body);
            echo json_encode($pay_charge);
        } else {
            
        }
    } catch (GerencianetException $e) {
        print_r($e->code);
        print_r($e->error);
        print_r($e->errorDescription);
    } catch (Exception $e) {
        print_r($e->getMessage());
    }
} 