<?php
global $pdo;
require_once 'classes/usuarios.php';
$u = new Usuario;
if (!isset($_SESSION)) session_start();
ob_start(); //Limpa o buffer de saída no redirecionamento
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Bentley-Autalizar senha</title>
  <!-- Icones fontawesome: -->
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
  <!-- Fontes da google: font-family: 'Open Sans', sans-serif; -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700">
  <link rel="stylesheet" href="css/styleee.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <!--  <link rel="stylesheet" href="css/style.css"> -->
  <link rel="stylesheet" href="css/estilo.css">
  <link rel="stylesheet" href="css/styleee.css">
</head>

<body>
  <h3>Atualizar senha</h3>

  <?php
  $chave = filter_input(INPUT_GET, 'chave', FILTER_DEFAULT);
  /* var_dump($chave); */

  if (!empty($chave)) {
    //var_dump($chave);

    $query_usuario = "SELECT id 
                             FROM usuarios 
                            WHERE recuperar_senha =:recuperar_senha
                            LIMIT 1";
    /* $u->conectar("gerencianet_usuarios", "localhost", "root", "root1234"); */
    $u->conectar("gerencianet_usuarios", "localhost", "root", "P@ssw0rd");
    $result_usuario =  $pdo->prepare($query_usuario);
    $result_usuario->bindParam(':recuperar_senha', $chave, PDO::PARAM_STR);
    $result_usuario->execute();

    if (($result_usuario) and ($result_usuario->rowCount() != 0)) {
      $row_usuario = $result_usuario->fetch(PDO::FETCH_ASSOC);
      $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
      /* var_dump($dados); */

      if (!empty($dados['SendNovaSenha'])) {
        //xxx
        $senha_usuario = password_hash($dados['senha_usuario'], PASSWORD_DEFAULT);
        $recuperar_senha = 'NULL';

        $query_up_usuario = "UPDATE usuarios 
                        SET senha_usuario =:senha_usuario
                        recuperar_senha =:recuperar_senha
                        WHERE id =:id 
                        LIMIT 1";
        $result_up_usuario = $pdo->prepare($query_up_usuario);
        $result_up_usuario->bindParam(':senha_usuario', $senha_usuario, PDO::PARAM_STR);
        $result_up_usuario->bindParam(':recuperar_senha', $recuperar_senha);
        $result_up_usuario->bindParam(':id', $row_usuario['id'], PDO::PARAM_INT);

        if ($result_up_usuario->execute()) {
         /*  $link = "http://localhost/gn-bentley-api-sdk-php/codigo-fonte/atualizar_senha.php?chave=$chave_recuperar_senha"; */
          $_SESSION['msg'] = "<p style='color: green'>Senha atualizada com sucesso!</p>";
          header("Location: logar.php");
        } else {
          echo "<p style='color: #ff0000'>Erro: Tentedd novamente!</p>";
        }
      }
    } else {
      $_SESSION['msg'] = "<p style='color: #ff0000'>Erro: Link inválido, solicite novo link para atualizar a senha!</p>";
      header("Location: recuperar_senha.php");
    }
  } else {
    $_SESSION['msg'] = "<p style='color: #ff0000'>Erro: Link inválido, solicite novo link para atualizar a senha!</p>";
    header("Location: recuperar_senha.php");
  }

  ?>

  <form method="POST">
    <?php
    $usuario = "";
    if (isset($dados['senha_usuario'])) {
      $usuario = $dados['senha_usuario'];
    } ?>
    <label>Senha</label>
    <input type="password" name="senha_usuario" placeholder="Digite a novahh senha" value="<?php echo $usuario; ?>"><br><br>
    <input type="submit" value="Atualizar" name="SendNovaSenha">
  </form>

  <br>
  Lembrou a senha? Então <a href="logar.php">clique aqui</a> para logar.


</body>

</html>