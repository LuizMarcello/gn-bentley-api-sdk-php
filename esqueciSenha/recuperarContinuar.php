<!DOCTYPE html>
<html lang="en">

<?php
include_once '../classes/usuarios.php';
include_once 'functions.php';
?>

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <title>Document</title>
</head>


<body>
  <form method="POST">
    <h4>Recuperar senha</h4>
    <label>Insira o email cadastrado</label>
    <input type="text" name="email" class="form-control"><br>
    <code>Insira o email cadastrado para receber um link para trocar a senha por email.</code><br><br><br>

    <input type="submit" value="Enviar dados para o email" class="btn btn-outline-success btn-lg btn-block">
    <input type="hidden" name="env" value="form">
  </form>

  <?php
        echo verifica_dados($pdo);
  ?>
</body>

</html>