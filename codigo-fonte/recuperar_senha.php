<?php
global $pdo;
require_once 'classes/usuarios.php';
if (!isset($_SESSION)) session_start();
ob_start(); //Limpa o buffer de saída no redirecionamento
$u = new Usuario;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';
$mail = new PHPMailer(true);

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Bentley-Recuperar senha</title>
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
  <header>
    <img src="https://sistema.bentleybrasil.com.br/img/logo-empresa-br.png" alt="Bentley Brasil">
    <!-- <nav> -->
  </header>

  <h3>Recuperar senha</h3>

  <?php
  $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

  if (!empty($dados['SendRecupSenha'])) {
    //var_dump($dados);
    $query_usuario = "SELECT id, nome, email
                 FROM usuarios 
                 WHERE email =:email  
                 LIMIT 1";
    /* $u->conectar("gerencianet_usuarios", "localhost", "root", "root1234"); */
    $u->conectar("gerencianet_usuarios", "localhost", "root", "P@ssw0rd");

    $result_usuario =  $pdo->prepare($query_usuario);
    $result_usuario->bindParam(':email', $dados['email'], PDO::PARAM_STR);
    $result_usuario->execute();

    if (($result_usuario) and ($result_usuario->rowCount() != 0)) {
      $row_usuario = $result_usuario->fetch(PDO::FETCH_ASSOC);
      $chave_recuperar_senha = password_hash($row_usuario['id'], PASSWORD_DEFAULT);
      //echo "Chave $chave_recuperar_senha <br>";

      $query_up_usuario = "UPDATE usuarios 
                     SET recuperar_senha =:recuperar_senha 
                     WHERE id =:id 
                     LIMIT 1";

      /* $u->conectar("gerencianet_usuarios", "localhost", "root", "root1234"); */
      $u->conectar("gerencianet_usuarios", "localhost", "root", "P@ssw0rd");

      $result_up_usuario =  $pdo->prepare($query_up_usuario);
      $result_up_usuario->bindParam(':recuperar_senha', $chave_recuperar_senha, PDO::PARAM_STR);
      $result_up_usuario->bindParam(':id', $row_usuario['id'], PDO::PARAM_INT);

      if ($result_up_usuario->execute()) {
       $link = "http://localhost/gn-bentley-api-sdk-php/codigo-fonte/atualizar_senha.php?chave=$chave_recuperar_senha";
        //echo "http://localhost/gn-bentley-api-sdk-php/codigo-fonte/atualizar_senha.php?chave=$chave_recuperar_senha";
       

        try {
          /* $mail->SMTPDebug = SMTP::DEBUG_SERVER; */
          $mail->CharSet = 'UTF-8';
          $mail->isSMTP();
          $mail->Host       = 'smtp.mailtrap.io';
          $mail->SMTPAuth   = true;
          $mail->Username   = 'e1217c28bd525c';
          $mail->Password   = '3ff022005ffff9';
          $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
          $mail->Port       = 2525;

          $mail->setFrom('luizmarcello.vmo@hotmail.com', 'Atendimento');
          $mail->addAddress($row_usuario['email'], $row_usuario['nome']);

          $mail->isHTML(true);                                  //Set email format to HTML
          $mail->Subject = 'Recuperar senha';
          $mail->Body    = 'Prezado(a) ' . $row_usuario['nome'] . ".<br><br>Você solicitou alteração de senha.<br><br>Para continuar o processo de recuperação de sua senha, clique no link abaixo ou cole o endereço no seu navegador: <br><br><a href='" . $link . "'>" . $link . "</a><br><br>Se você não solicitou essa alteração, nenhuma ação é necessária. Sua senha permanecerá a mesma até que você ative este código.<br><br>";
          $mail->AltBody = 'Prezado(a) ' . $row_usuario['nome'] . "\n\nVocê solicitou alteração de senha.\n\nPara continuar o processo de recuperação de sua senha, clique no link abaixo ou cole o endereço no seu navegador: \n\n" . $link . "\n\nSe você não solicitou essa alteração, nenhuma ação é necessária. Sua senha permanecerá a mesma até que você ative este código.\n\n";

          $mail->send();

          $_SESSION['msg'] = "<p style='color: green'>Enviado e-mail com instruções para recuperar a senha. Acesse a sua caixa de e-mail para recuperar a senha!</p>";
          header("Location: logar.php");
        } catch (Exception $e) {
          echo "Erro: E-mail não enviado sucesso. Mailer Error: {$mail->ErrorInfo}";
        }
      } else {
        echo  "<p style='color: #ff0000'>Erro: Tente novamente!</p>";
      }
    } else {
      echo "<p style='color: #ff0000'>Erro: Usuário não encontrado!</p>";
    }
  }

  if (isset($_SESSION['msg_rec'])) {
    echo $_SESSION['msg_rec'];
    unset($_SESSION['msg_rec']);
  }

  ?>

  <main>
    <div class="flex-box container-box">
      <div class="content-box">

        <form method="POST" action="">
          <?php
          $usuario = "";
          if (isset($dados['email'])) {
            $usuario = $dados['email'];
          } ?>
          <label>
            <h4>Digite o e-mail cadastrado</h4>
          </label>

          <input type="text" name="email" placeholder="Digite o email" value="<?php echo $usuario; ?>">
          <br><br>
          <input type="submit" value="Recuperar" name="SendRecupSenha">
        </form>

        <br>
        Lembrou a senha? Então <a href="logar.php">clique aqui</a> para logar.


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