<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Alterar Senha</title>
</head>

<body>
  <?php
  $chave = "";
  if ($_GET["chave"]) {
    $chave = preg_replace('/[^[:alnum:]]/', '', $_GET["chave"]);
  ?>

    <form id="alterarSenha" action="set-nova-senha.php" method="POST">
      <input type="hidden" name="chave" value="<?php echo $chave; ?>" />

      <h2>Alteração da senha</h2>

      <label>Email</label><br>
      <input type="text" name="email" /><br><br>

      <label>Nova Senha</label><br>
      <input type="password" name="senha" /><br>

      <button>Enviar</button>
    </form>

  <?php
  } else {
    echo '<h1>Página não encontrada</h1>';
  }
  ?>
</body>

</html>