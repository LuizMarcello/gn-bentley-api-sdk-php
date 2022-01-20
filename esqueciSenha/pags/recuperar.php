<!DOCTYPE html>
<html lang="en">

<?php
include_once '../../classes/usuarios.php';
include_once '../lib/functions.php';
?>

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
</head>
<body>
	
</body>
</html>

<form method="POST">
	<h4>Recuperar Senha</h4>
	<label>Insira o email cadastrado</label>
	<input type="email" name="email" class="form-control" required>
	<code>Insira o email cadastrado para receber um link para trocar a senha por email.</code><br><br><br>

	<input type="submit" value="Enviar dados para o email" class="btn btn-outline-success btn-lg btn-block">
	<input type="hidden" name="env" value="form">
</form>
<?php echo verifica_dados($pdo);?>