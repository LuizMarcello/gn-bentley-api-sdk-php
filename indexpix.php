<?php

require_once 'classes/usuarios.php';
require 'vendor/autoload.php';

if (!isset($_SESSION)) session_start();

if (!isset($_SESSION['id'])) {
  header("location: logar.php");
  exit;
}
$u = new Usuario;
/* $u->conectar("gerencianet_usuarios", "localhost", "root", "P@ssw0rd"); */
$u->conectar("gerencianet_usuarios", "localhost", "root", "root1234");

use App\Pix\Payload;
use Mpdf\QrCode\QrCode;
use Mpdf\QrCode\Output;

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Bentley Brasil</title>
  <!-- Icones fontawesome: -->
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />

  <!-- Fontes da google: font-family: 'Open Sans', sans-serif; -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700">
  <link rel="stylesheet" href="css/styleindexpix.css">
  <script type="text/javascript" src="bootstrapBoleto/js/jquery-2.2.4.min.js"></script>
  <script type="text/javascript" src="bootstrapBoleto/js/bootstrap.js"></script>
  <script type="text/javascript" src="bootstrapBoleto/js/jquery.mask.js"></script>
  <script type="text/javascript" src="bootstrapBoleto/js/scripts.js"></script>
  <style>
    #pai div {
      display: none;
    }
  </style>


</head>

<body>
  <header>
    <img src="https://sistema.bentleybrasil.com.br/img/logo-empresa-br.png" alt="Bentley Brasil">
    <nav>
      <div class="navmenu">
        <li><a href="index.php">Home</a></li>
        <li><a href="indexcomprar.php">Página de compras</a></li>
        <!-- <li><a href="">Contato</a></li> -->

        <?php
        if (isset($_SESSION['id'])) {

          $user = $_SESSION['id'];
          $sql = "SELECT * FROM usuarios WHERE id = $user";
          global $pdo;
          $sql = $pdo->prepare($sql);
          $sql->bindValue("id", $_SESSION['id']);
          $sql->execute();

          if ($sql->rowCount() > 0) {
            $dado = $sql->fetch(); ?>
            <div class="navuser">
              <li>
                <a class="nav-link"><?php /*  echo $dado['nome']; */ ?> </a>
              </li>
            </div>
          <?php } ?>
        <?php } ?>
      </div>
    </nav>
  </header>



  <main>

    <div class="gerador">
      <h5>Bentley Brasil - Gerador de QrCode Pix</h5>
    </div>

    <form action="gerar-qrcode-dinamico.php" method="POST">

      <div id="area" class="form-group col-sm-3">

        <label for="cpf" class="control-label"></label>
        <input class="documento form-control" rows="3" name="cpf" value="cpf" type="text" id="cpf" placeholder="cpf válido" required>

        <label for="nome" style="margin-top: 5%;" class="control-label">Nome</label>
        <input class="documento form-control" rows="3" name="nome" style="margin-top: 1%;" value="<?php echo $dado['nome']; ?>" type="text" id="nome" placeholder="Nome" required>

       
          <div class="btn form-group">
            <input class="btn-warning" style="background:#c3c63b;" type="reset" value="Limpar dados">

            <input class="btn-primary" style="background:#c3c63b;" id="botao" type="submit" value="Gerar QrCode">
          </div>
        

      </div>

    </form>
  </main>

  <!--  gerador  area  botoes  btn  -->


  <script>
    //desabilita o botão "gerar qrcode" e só habilita com 14 caracteres no input do cpf.
    document.getElementById("botao").disabled = true;

    //cria um event listener que escuta mudanças no input
    document.getElementById("cpf").addEventListener("input", function(event) {

      //busca conteúdo do input
      var conteudo = document.getElementById("cpf").value;

      //Definindo a quantidade de caracteres no input do cpf
      var n = conteudo.length;

      //valida conteudo do input 
      if (conteudo !== null && conteudo !== '' && n == 14) {
        //habilita o botão
        document.getElementById("botao").disabled = false;
      } else {
        //desabilita o botão se o conteúdo do input ficar em branco
        document.getElementById("botao").disabled = true;
      }
    });
  </script>

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