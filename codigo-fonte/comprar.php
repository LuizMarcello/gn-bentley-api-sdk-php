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

<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Bentley Juruena</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
            <div class="container-fluid">

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse"
                    aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <ul class="navbar-nav me-auto mb-2 mb-md-0">
                        <span class="brand-text font-weight-light">
                            <img height="80" src="https://sistema.bentleybrasil.com.br/img/logo-empresa-br.png">
                        </span>
                        <a class="nav-link" aria-current="page" href="index.php">Home</a>

                        <a class="nav-link" aria-current="page" href="http://localhost/gn-bentley-api-sdk-php/codigo-fonte/boleto.php">Pagar com boleto</a>
                        <a class="nav-link" aria-current="page" href="http://localhost/gn-bentley-api-sdk-php/codigo-fonte/boleto.php">Pagar com cartão</a>
                                         
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    
</body>

</html>