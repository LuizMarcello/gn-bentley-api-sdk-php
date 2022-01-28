<?php

require_once 'classes/usuarios.php';
require_once 'vendor/autoload.php';
require_once 'app/Pix/Api.php';
require_once 'app/Pix/Payload.php';

$u = new Usuario;
$u->conectar("gerencianet_usuarios", "localhost", "root", "P@ssw0rd");
/*  $u->conectar("gerencianet_usuarios", "localhost", "root", "root1234"); */
if (!isset($_SESSION)) session_start();

/* if (!isset($_SESSION['id_usuario'])) {
  header("location: logar.php");
  exit;
} */

use \App\Pix\Api;
use \App\Pix\Payload;
use Mpdf\QrCode\QrCode;
use Mpdf\QrCode\Output;

if (isset($_SESSION['id_usuario'])) {

  $user = $_SESSION['id_usuario'];
  $sql = "SELECT * FROM usuarios WHERE id_usuario = $user";
  global $pdo;
  $sql = $pdo->prepare($sql);
  $sql->bindValue("id_usuario", $_SESSION['id_usuario']);
  $sql->execute();

  if ($sql->rowCount() > 0) {
    $dado = $sql->fetch();
  }
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Bentley Brasil</title>
  <!-- Icones fontawesome: -->
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" 
  integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p"
  crossorigin="anonymous" />
  <!-- Fontes da google: font-family: 'Open Sans', sans-serif; -->

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700">

  <link rel="stylesheet" href="bootstrapBoleto/css/bootstrap.css">
  <link rel="stylesheet" href="bootstrapBoleto/css/style.css">
  <link rel="stylesheet" href="css/stylegerarqrcodedinamico.css">
  <script type="text/javascript" src="bootstrapBoleto/js/jquery-2.2.4.min.js"></script>
  <script type="text/javascript" src="bootstrapBoleto/js/bootstrap.js"></script>
  <script type="text/javascript" src="bootstrapBoleto/js/jquery.mask.js"></script>
  <script type="text/javascript" src="bootstrapBoleto/js/scripts.js"></script>
  <title>Gerencianet</title>
</head>

<body>
  <header>
    <img src="img/logo-empresa-br.png" alt="Bentley Brasil">
    <nav>
      <div class="navmenu">
        <li><a href="index.php">Home</a></li>
        <li><a href="indexcomprar.php">Página de compras</a></li>
        <!--  <li><a href="">Contato</a></li> -->
        <?php
        if (isset($_SESSION['id_usuario'])) {
          $user = $_SESSION['id_usuario'];
          $sql = "SELECT * FROM usuarios WHERE id_usuario = $user";
          global $pdo;
          $sql = $pdo->prepare($sql);
          $sql->bindValue("id_usuario", $_SESSION['id_usuario']);
          $sql->execute();

          if ($sql->rowCount() > 0) {
            $dado = $sql->fetch(); ?>
            <!--   <div class="navuser"> -->
            <li>
              <a class="nav-link"><?php echo $dado['nome']; ?> </a>
            </li>
            <!--  </div> -->
          <?php } ?>
        <?php } ?>
      </div>
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

    //Filtro recebendo o POST do formulário em indexpix.php, e evitando ataques.
    $dados = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRIPPED);

    $cpfcomprador = $dados['cpf'];

    $cpflimpo = limpaCPF_CNPJ($cpfcomprador);

    //Função para limpar "." "," "-" "/" de cnpj e cpf.
    function limpaCPF_CNPJ($valor)
    {
      $valor = trim($valor);
      $valor = str_replace(".", "", $valor);
      $valor = str_replace(",", "", $valor);
      $valor = str_replace("-", "", $valor);
      $valor = str_replace("/", "", $valor);
      return $valor;
    }

    $nomecomprador = $dados['nome'];

    //Corpo da requisição
    //Requisição (request) que será enviada ao PSP gerencianet:
    $request = [
      'calendario' => [
        'expiracao' => 3600
      ],
      'devedor' => [
        'cpf' =>  $cpflimpo,
        'nome' => $nomecomprador
      ],
      'valor' => [
        'original' => '1900.00'
      ],
      'chave' => 'financeiro@bentleybrasil.com.br',
      'solicitacaoPagador' => 'Adesao de equipamentos - projeto Juruena'
    ];

    //Gerando um txid randômico
    function getToken($length)
    {
      $token = "";
      $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
      $codeAlphabet .= "abcdefghijklmnopqrstuvwxyz";
      $codeAlphabet .= "0123456789";
      $max = strlen($codeAlphabet);

      for ($i = 0; $i < $length; $i++) {
        $token .= $codeAlphabet[random_int(0, $max - 1)];
      }

      return $token;
    }

    //Variável para guardar a reposta do PSP gerencianet:
    //txid: No QrCode dinámico, no mínimo 26 caracteres e
    //no máximo 35 caracteres, letras e números.
    /*  $response = $obApiPix->createCob('renjifkq334tigrtwimacellol', $request); */
    $response = $obApiPix->createCob(getToken(35), $request);

    //Para saber o TxId gerado aleatóriamente e outras informações do QrCode gerado
    /* echo "<pre>";
      print_r($response);
      echo "</pre>"; */

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
      ->setUniquePayment(true)
      ->setDescription($response['solicitacaoPagador']);

    //Código de pagamento PIX
    $payloadQrCode = $obPayload->getPayload();

    //Instância do QR CODE
    $obQrCode = new QrCode($payloadQrCode);
    ?>

    <!-- Imagem do QRCODE -->
    <p style="margin-left: 3%;"><?php $image = (new Output\Png)->output($obQrCode, 220); ?></p>

    <section class="textos">
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
        <div>
          <h6>Pague e será creditado na hora, ou copie este código QR para fazer o pagamento</h6>
        </div>
        <br>
        <div>
          <h6>Escolha pagar via Pix pelo seu Internet Banking ou app de pagamentos.</h6>
        </div>
        <div>
          <h6>Depois, cole o seguinte código:</h6>
        </div>
        <strong>
          <h6><?= $payloadQrCode ?></h6>
        </strong><br> <br>
        <button type="button" class="btn btn-primary" onclick="copiarTexto()" ,>
          Copiar linha do QrCode
        </button>
    </section>

    <script>
      let copiarTexto = () => {
        //O texto que será copiado
        const texto = "<?= $payloadQrCode ?>";
        //Cria um elemento input (pode ser um textarea)
        let inputTest = document.createElement("input");
        inputTest.value = texto;
        //Anexa o elemento ao body
        document.body.appendChild(inputTest);
        //seleciona todo o texto do elemento
        inputTest.select();
        //executa o comando copy
        //aqui é feito o ato de copiar para a area de trabalho com base na seleção
        document.execCommand('copy');
        //remove o elemento
        document.body.removeChild(inputTest);
        //write("Código copiado");
      };
    </script>
    </div>
  </main>
  
  <br><br>
  <!-- FOOTER -->
  <footer>
    <ul>
      <li><a href=""><i class="fab fa-facebook"></i></a></li>
      <li><a href=""><i class="fab fa-twitter"></i></a></li>
      <li><a href=""><i class="fab fa-snapchat"></i></a></li>
      <li><a href=""><i class="fab fa-pinterest"></i></a></li>
    </ul>
    <p>Satellite Broadband Networks - Bentley Brasil - Projeto Juruena</p>
  </footer>


</body>

</html>