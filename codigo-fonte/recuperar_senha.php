<?php
global $pdo;
require_once 'classes/usuarios.php';

if (!isset($_SESSION)) session_start();
ob_start();
$u = new Usuario;


?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Bentley-Recuperar senha</title>
  <!-- Icones fontawesome: -->
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
    integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
  <!-- Fontes da google: font-family: 'Open Sans', sans-serif; -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700">
  <link rel="stylesheet" href="css/styleee.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <!--  <link rel="stylesheet" href="css/style.css"> -->
  <link rel="stylesheet" href="css/estilo.css">
  <link rel="stylesheet" href="css/styleee.css">

</head>

<body>
  <header>
    <img src="https://sistema.bentleybrasil.com.br/img/logo-empresa-br.png" alt="Bentley Brasil">
    <nav>
  </header>

  <h3>Recuperar senha</h3>

  <?php
  $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

  if (!empty($dados['SendRecupSenha'])) {
      //var_dump($dados);
      $query_usuario = "SELECT id, nome, email 
                  FROM usuarios 
                  WHERE email =:usuario  
                  LIMIT 1";
      $u->conectar("gerencianet_usuarios", "localhost", "root", "root1234");
             
      $result_usuario =  $pdo->prepare($query_usuario);
      $result_usuario->bindParam(':usuario',$dados['usuario'], PDO::PARAM_STR);
      $result_usuario->execute();
  
      if (($result_usuario) and ($result_usuario->rowCount() != 0)) {
          $row_usuario = $result_usuario->fetch(PDO::FETCH_ASSOC);
          $chave_recuperar_senha = password_hash($row_usuario['id'], PASSWORD_DEFAULT);
          //echo "Chave $chave_recuperar_senha <br>";

          $query_up_usuario = "UPDATE usuarios 
                      SET recuperar_senha =:recuperar_senha 
                      WHERE id =:id 
                      LIMIT 1";
          $result_up_usuario = $pdo->prepare($query_up_usuario);
          $result_up_usuario->bindParam(':recuperar_senha', $chave_recuperar_senha, PDO::PARAM_STR);
          $result_up_usuario->bindParam(':id', $row_usuario['id'], PDO::PARAM_INT);
    
          if ($result_up_usuario->execute()) {
            $link = "http://localhost/gn-bentley-api-sdk-php/codigo-fonte/atualizar_senha.php?chave=$chave_recuperar_senha";
         var_dump($link);
        } else {
          echo  "<p style='color: #ff0000'>Erro: Tente novamente!</p>";
      }
  } else {
      echo "<p style='color: #ff0000'>Erro: Usuário não encontrado!</p>";
    }
  }

  if (isset($_SESSION['msg'])) {
    echo $_SESSION['msg'];
    unset($_SESSION['msg']);
  }
  ?>

  <main>
    <div class="flex-box container-box">
      <div class="content-box">
        <form method="POST" action="">
          <?php
          $usuario = "";
          if(isset($dados['email'])) {
            $usuario = $dados['email'];
          } ?>

          <label>
            <h4>Digite o e-mail cadastrado</h4>
          </label>
          <input type="text" name="usuario" placeholder="Digite o email" value="<?php echo $usuario; ?>">
          <br><br>
          <input type="submit" value="Recuperar" name="SendRecupSenha">
        </form>
        <br>
        Lembrou da senha? Então <a href="index.php">clique aqui</a> para logar.
      </div>
    </div>
  </main>

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