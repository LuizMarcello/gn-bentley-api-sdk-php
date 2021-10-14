<?php
require_once '../classes/usuarios.php';
$u = new Usuario;
$u->conectar("gerencianet_usuarios", "localhost", "root", "P@ssw0rd");
/* $u->conectar("gerencianet_usuarios", "localhost", "root", "root1234"); */
?>

<html>

<head>

</head>

<body>

  <?php
  if (isset($_GET['token'])) {
    $token = $_GET['token'];
    if ($token != $_SESSION['token']) {
      die('O token não corresponde');
    } else {
  ?>
      <div class="bg_login">
        <div class="box_esqueci_a_senha">
          <?php
          $sql = $pdo->prepare("SELECT * FROM usuarios WHERE email = ?");
          $sql->execute([$_SESSION['email']]);
          $info = $sql->fetch();

          if ($sql->rowCount() == 1) {
            if (isset($_POST['redefinirsenha'])) {
              $senha = $_POST['senha_usuario'];
              $criptografada = password_hash($senha, PASSWORD_DEFAULT);
              /*  $sql = $pdo->prepare("UPDATE usuarios SET senha_usuario = ? WHERE email = ?"); */
              $sql = $pdo->prepare("UPDATE usuarios WHERE email = ? SET senha_usuario = ? ");
              $sql->execute([$criptografada, $_SESSION['email']]);
              echo 'A sua senha foi redefinida com sucesso.';
            }
          } else {
            echo 'Não encontramos esse email';
          }
          ?>
          <div class="head_login">
            <h2><i class="fas fa-lock"></i> Redefinir a minha senha</h2>
          </div>
          <form method="POST">
            <div class="input_group">
              <label for="senha_usuario">Digite a sua nova senha</label>
              <input type="password" id="senha_usuario" name="senha_usuario">
            </div>

            <div class="input_group">
              <input type="submit" name="redefinirsenha" value="Redefinir">
            </div>
          </form>
          <div class="direitos">
            <p>Todos os direitos reservados</p>
          </div>
        </div>
      </div>
    <?php
    }
    ?>
  <?php
  } else {
    echo 'Precisa de um token';
  }
  ?>

</body>

</html>