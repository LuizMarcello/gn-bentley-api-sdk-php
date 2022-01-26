<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Alterar Senha</title>
  <!-- Icones fontawesome: -->
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
    integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
  <!-- Fontes da google: font-family: 'Open Sans', sans-serif; -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700">
  <link rel="stylesheet" href="../esqueciSenha/css/styleindex.css">
</head>

<body>

  <header>
    <img src="../img/logo-empresa-br.png" alt="Bentley Brasil">
    <nav>
      <div class="navmenu">
        <li>
          <a class="nav-link" href="envia-nova-senha.php">Voltar</a>
        </li>
    </nav>
  </header>

  <?php
  $chave = "";



  if (isset($_GET["chave"])) {
    $chave = preg_replace('/[^[:alnum:]]/', '', $_GET["chave"]);
  ?>

  <form id="alterarSenha" action="set-nova-senha.php" method="POST">
    <input type="hidden" name="chave" value="<?php echo $chave; ?>" />

    <h1>Alteração da senha</h1>

    <label>Email</label><br>
    <input type="text" name="email" /><br><br>

    <label>Nova Senha</label><br>
    <input type="password" name="senha" id="senha" /><br>
    <button onclick="mostrarASenha()" type="button" id="mostrarrSenha" class="btn btn-primary botao btn-sm">
      Mostrar Senha</button><br><br>

    <label>Repita a nova senha</label><br>
    <input type="password" name="repetesenha" id="repetesenha" /><br>
    <button onclick="mostrarRepeteSenha()" type="button" id="repetirSenha" class="btn btn-primary botao btn-sm">
      Mostrar Senha</button><br><br>

    <!-- <input type="password" name="senha_usuario" id="senha_usuario" placeholder="Senha" maxlength="45"> -->
    <!-- <button onclick="mostrarASenha()" type="button" id="mostrarrSenha" class="btn btn-primary botao btn-sm">Mostrar Senha</button> -->

    <input type="submit" class="btn btn-primary botao btn-sm" value="Enviar" maxlength="45">
  </form>

  <?php
  } else {
    /* echo '<h1>Página não encontrada</h1>'; */
  }
  ?>

  <footer>
    <ul>
      <li><a href=""><i class="fab fa-facebook"></i></a></li>
      <li><a href=""><i class="fab fa-twitter"></i></a></li>
      <li><a href=""><i class="fab fa-snapchat"></i></a></li>
      <li><a href=""><i class="fab fa-pinterest"></i></a></li>
    </ul>
    <p>Satellite Broadband Networks - Bentley Brasil - Projeto Juruena</p>
  </footer>

  <script>
    function mostrarASenha() {
      var text = document.getElementById("mostrarrSenha").firstChild;
      var tipo = document.getElementById("senha");
      if (tipo.type == "password") {
        tipo.type = "text";
      } else {
        tipo.type = "password";
      }
      text.data = text.data == "Esconder senha" ? "Mostrar senha" : "Esconder senha";
    }

    function mostrarRepeteSenha() {
      var text = document.getElementById("repetirSenha").firstChild;
      var tipo = document.getElementById("repetesenha");
      if (tipo.type == "password") {
        tipo.type = "text";
      } else {
        tipo.type = "password";
      }
      text.data = text.data == "Esconder senha" ? "Mostrar senha" : "Esconder senha";
    }
  </script>

  <script type="text/javascript" src="jQuery/jquery-3.6.0.min.js"></script>
  <script type="text/javascript" src="jQuery/jquery.mask.js"></script>


</body>

</html>