<?php

require_once 'classes/usuarios.php';
require '../vendor/autoload.php';
$u = new Usuario;

if (!isset($_SESSION)) session_start();

if (!isset($_SESSION['id_usuario'])) {
  header("location: logar.php");
  exit;
}

use App\Pix\Payload;
use Mpdf\QrCode\QrCode;
use Mpdf\QrCode\Output;

//Instancia principal do PAYLOAD PIX
/* $obPayload = (new Payload)->setPixKey('48274402987')
  ->setDescription('Pagamento do pedido 123456')
  ->setMerchantName('Marcelo da Silva')
  ->setMerchantCity('Londrina')
  ->setAmount(100.00)
  ->setTxid('IMCL1234'); */

//Código de pagamento PIX
/* $payloadQrCode = $obPayload->getPayload(); */

//Instância do QR CODE
/* $obQrCode = new QrCode($payloadQrCode); */

//Imagem do QRCODE
/* $image = (new Output\Png)->output($obQrCode, 400); */

//Imprimindo apenas a imagem do QRCODE:
/* header('Content-Type: image/png');
echo $image; */

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Hotel Paraíso</title>
  <!-- Icones fontawesome: -->
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
  <!-- Fontes da google: font-family: 'Open Sans', sans-serif; -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700">
  <link rel="stylesheet" href="css/styleee.css">
  <script type="text/javascript" src="bootstrapBoleto/js/jquery-2.2.4.min.js"></script>
  <script type="text/javascript" src="bootstrapBoleto/js/bootstrap.js"></script>
  <script type="text/javascript" src="bootstrapBoleto/js/jquery.mask.js"></script>
  <script type="text/javascript" src="bootstrapBoleto/js/scripts.js"></script>
  <style>
    #pai div {
      display: none;
    }
  </style>

  <script>
    //Funções após a leitura do documento
    $(document).ready(function() {
      //Select para mostrar e esconder divs
      $('#cpfoucnpj').on('change', function() {
        var SelectValue = '.' + $(this).val();
        $('#pai div').hide();
        $(SelectValue).toggle();
      });
    });
  </script>
</head>

<body>
  <header>
    <img src="https://sistema.bentleybrasil.com.br/img/logo-empresa-br.png" alt="Bentley Brasil">
    <nav>
      <div class="navmenu">
        <li><a href="index.php">Voltar a Home</a></li>
        <li><a href="indexcomprar.php">Voltar a página de compras</a></li>
        <!-- <li><a href="">Contato</a></li> -->
      </div>
      <?php
      if (isset($_SESSION['id_usuario'])) {
        $u->conectar("gerencianet_usuarios", "localhost", "root", "P@ssw0rd");
         /*  $u->conectar("gerencianet_usuarios", "localhost", "root", "root1234"); */
        $user = $_SESSION['id_usuario'];
        $sql = "SELECT * FROM usuarios WHERE id_usuario = $user";
        global $pdo;
        $sql = $pdo->prepare($sql);
        $sql->bindValue("id_usuario", $_SESSION['id_usuario']);
        $sql->execute();

        if ($sql->rowCount() > 0) {
          $dado = $sql->fetch(); ?>
          <div class="navuser">
            <a class="nav-link"><?php echo $dado['nome']; ?> </a>
          </div>
        <?php } ?>
      <?php } ?>
    </nav>
  </header>

  <main>

    <h5>Bentley Brasil - Gerador de QrCode Pix</h5>

    <form action="gerar-qrcode-dinamico.php" method="POST">
      <section class="fisicaoujuridica">
        <div id="acima" class="form-group">
          <label for="cpfoucnpj" class="control-label"></label>
          <!--  <input class="form-control" type="text" disabled> -->
          <div class="col-sm-3">
            <select name="cpfoucnpj" class="form-control" id="cpfoucnpj">
              <option value="">
                <p> Pessoa física ou Jurídica</p>
              </option>
              <option value="cpf">Física</option>
              <option value="cnpj">Jurídica</option>
            </select>
          </div>
        </div>
      </section>

      <div id="pai">
        <section class="cpfoucnpj">
          <!--  <div id="pai"> -->
          <div class="form-group cpf col-sm-3">
            <label for="cpf" class="control-label"></label>
            <input class="documento form-control" rows="3" name="cpf" value="cpf" type="text" id="cpf"
             placeholder="Informe o CPF" required>
          </div>

          <div class="form-group cnpj col-sm-3">
            <label for="cnpj" class="control-label"></label>
            <input class="documento form-control" rows="3" name="cnpj" value="cnpj" type="text" id="cnpj" 
            placeholder="Informe o CNPJ" required>
          </div>
        </section>

        <section class="form">
          <div class="form-group cpf col-sm-3">
            <label for="nome" class="control-label">Pessoa física</label>
            <input class="documento form-control" rows="3" name="nome" value="<?php echo $dado['nome']; ?>"
             type="text" id="nome"
             placeholder="Nome" required>
          </div>
          <div class="form-group cnpj col-sm-3">
            <label for="razaosocial" class="control-label">Razão Social</label>
            <input class="documento form-control" rows="3" name="nome"  value="<?php echo $dado['nome']; ?>" 
            type="text" id="razaosocial"
             placeholder="Razão Social" required>
          </div>
        </section>

        <section class="botoes">
          <div class="form-group cnpj cpf">
            <input class="btn btn-warning" type="reset" value="Limpar dados">
          </div>
          <br>
          <div class="form-group cnpj cpf">
            <input class="btn btn-primary" type="submit" value="Gerar QrCode">
          </div>
        </section>
      </div>

    </form>


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
  </main>

</body>

</html>