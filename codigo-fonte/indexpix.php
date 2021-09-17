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
  <link rel="stylesheet" href="bootstrapBoleto/css/bootstrap.css">
  <link rel="stylesheet" href="bootstrapBoleto/css/style.css">
  <script type="text/javascript" src="bootstrapBoleto/js/jquery-2.2.4.min.js"></script>
  <script type="text/javascript" src="bootstrapBoleto/js/bootstrap.js"></script>
  <script type="text/javascript" src="bootstrapBoleto/js/jquery.mask.js"></script>
  <script type="text/javascript" src="bootstrapBoleto/js/scripts.js"></script>
  <title>Gerencianet</title>
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
    <nav class="navbar navbar-default">
      <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
           data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="/codigos-documentacao/">
            <img src="https://gerencianet.com.br/wp-content/themes/Gerencianet/images/marca-gerencianet.svg" onerror="this.onerror=null; this.src='img/marca-gerencianet.png'" alt="Gerencianet - Conceito 
             em Pagamentos" width="218" height="31">
          </a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
          <ul class="nav navbar-nav">
            <li class=""><a href="index.php">Retornar a Home</a></li>
          </ul>
          <ul class="nav navbar-nav">
            <li class=""><a href="indexcomprar.php">Retornar as opções de pagamento</a></li>
          </ul>
          <ul class="nav navbar-nav pull-right">
            <div class="collapse navbar-collapse" id="navbarCollapse">
              <div style="margin: 36px 0 0 50px;">
                <?php
                if (isset($_SESSION['id_usuario'])) {
                  $u->conectar("gerencianet_usuarios", "localhost", "root", "P@ssw0rd");
                  /*   $u->conectar("gerencianet_usuarios", "localhost", "root", "root1234"); */
                  $user = $_SESSION['id_usuario'];
                  $sql = "SELECT * FROM usuarios WHERE id_usuario = $user";
                  global $pdo;
                  $sql = $pdo->prepare($sql);
                  $sql->bindValue("id_usuario", $_SESSION['id_usuario']);
                  $sql->execute();

                  if ($sql->rowCount() > 0) {
                    $dado = $sql->fetch();
                ?>
                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1;">
                      <p><?php echo $dado['nome']; ?> </p>
                    </div>
                  <?php } ?>
                <?php } ?>
              </div>
            </div>

          </ul>
        </div><!-- /.navbar-collapse -->
      </div><!-- /.container-fluid -->
    </nav>
  </header>

  <main>
    <form action="gerar-qrcode-dinamico.php" method="POST">
      <div id="acima" class="form-group">
        <label for="cpfoucnpj" class="control-label"></label>
        <input class="form-control" type="text" disabled>
        <div class="col-sm-3">
          <select name="cpfoucnpj" class="form-control" id="cpfoucnpj">
            <option value="">CPF ou CNPJ</option>
            <option value="cpf">CPF</option>
            <option value="cnpj">CNPJ</option>
          </select>
        </div>
      </div>

      <div id="pai">
        <div id="pai1" class="form-group cpf col-sm-3">
          <label for="cpf" class="control-label">Cpf</label>
          <input class="documento form-control" name="cpf" type="text" id="cpf" 
          placeholder="Informe o cpf" value="cpf" required>
        </div>

        <div id="pai1" class="form-group cnpj col-sm-3">
          <label for="cnpj" class="control-label">Cnpj</label>
          <input class="documento form-control" name="cnpj" type="text" id="cnpj"
           placeholder="Informe o cnpj" value="" required>
        </div>

        <br><br>

        <div id="pai2" class="form-group cpf col-sm-3">
          <label for="nome" class="control-label">Nome pessoa física</label>
          <input class="documento form-control" rows="3" name="nome" type="text"
           id="nome" placeholder="Nome" value="<?php echo $dado['nome']; ?>" required>
        </div>
        <div id="pai2" class="form-group cnpj col-sm-3">
          <label for="razaosocial" class="control-label">Razão Social</label>
          <input class="documento form-control" rows="3" name="nome" type="text"
           id="razaosocial" placeholder="Razão Social" value="<?php echo $dado['nome']; ?>"
            required>
        </div>
        <div id="resetar" class="form-group cnpj cpf">
          <input class="btn btn-warning" type="reset" value="Limpar dados">
        </div>
        <div id="enviar" class="form-group cnpj cpf">
          <input class="btn btn-primary" type="submit" value="Gerar QrCode">
        </div>
      </div>
    </form>

    <!-- FOOTER -->
    <footer class="main-footer" style="text-align: center; margin-top: 25%;">
      <div>
        <div class="float-rightd-none d-sm-block">
          <b>Satellite Broadband Networks</b> 1.0-rc
        </div>
        <strong>Copyright &copy; <a href="https://adminlte.io"> Bentley Brasil
            - Projeto
            Juruena</a>.</strong> Todos os direitos reservados
      </div>
    </footer>
  </main>

</body>

</html>