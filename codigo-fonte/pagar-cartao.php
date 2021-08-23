<?php

require __DIR__ . '/../api/vendor/autoload.php';

use Gerencianet\Exception\GerencianetException;
use Gerencianet\Gerencianet;

$clientId = '';
$clientSecret = '';


if (isset($_POST)) {

    $options = [
        'client_id' => $clientId,
        'client_secret' => $clientSecret,
        'sandbox' => true
    ];

    $item_1 = [
        'name' => $_POST["descricao"],
        'amount' => (int) $_POST["quantidade"],
        'value' => (int) $_POST["valor"]
    ];

    $items = [
        $item_1
    ];

    $body = ['items' => $items];
     
    $api = new Gerencianet($options);
    $charge = $api->createCharge([], $body);
     //var_dump($charge);die();
    if ($charge["code"] == 200) {
      
        //Formatando a data, convertendo do estino brasileiro para americano.
        $data_brasil = DateTime::createFromFormat('d/m/Y', $_POST["nascimento"]);
        $params = ['id' => $charge["data"]["charge_id"]];
        $customer = [
            'name' => $_POST["nome_cliente"],
            'cpf' => $_POST["cpf"],
            'phone_number' => $_POST["telefone"],
            'email' => $_POST["email"],
            'birth' => $data_brasil->format('Y-m-d')
        ];

        $paymentToken = $_POST["payament_token"];

        $billingAddress = [
            'street' => $_POST["rua"],
            'number' => $_POST["numero"],
            'neighborhood' => $_POST["bairro"],
            'zipcode' => $_POST["cep"],
            'city' => $_POST["cidade"],
            'state' => $_POST["estado"],
        ];

        $creditCard = [
            'installments' => (int) $_POST["installments"],
            'billing_address' => $billingAddress,
            'payment_token' => $paymentToken,
            'customer' => $customer
        ];
        
        $payment = [
            'credit_card' => $creditCard
        ];
        
        $body = [
            'payment' => $payment
        ];

        

        try {
            $api = new Gerencianet($options);
            $charge = $api->payCharge($params, $body);

            echo json_encode($charge);
        } catch (GerencianetException $e) {
            print_r($e->code);
            print_r($e->error);
            print_r($e->errorDescription);
        } catch (Exception $e) {
            print_r($e->getMessage());
        }
    }
}    