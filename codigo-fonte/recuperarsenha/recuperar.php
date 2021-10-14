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

  <link rel="stylesheet" href="../css/estilo.css">
  <link rel="stylesheet" href="../css/estilos.css">
  <link rel="stylesheet" href="../css/styleee.css">
  <!-- <link rel="stylesheet" href="../css/style.css"> -->
  <!--  <link rel="stylesheet" href="../bootstrapBoleto/css/bootstrap.css"> -->
  <!--  <link rel="stylesheet" href="../bootstrapBoleto/css/style.css"> -->

  <script type="text/javascript" src="../bootstrapBoleto/js/jquery-2.2.4.min.js"></script>
  <script type="text/javascript" src="../bootstrapBoleto/js/bootstrap.js"></script>
  <script type="text/javascript" src="../bootstrapBoleto/js/jquery.mask.js"></script>
  <script type="text/javascript" src="../bootstrapBoleto/js/scripts.js"></script>
  <title>Gerencianet</title>
</head>

<body>
  <header>
    <img src="https://sistema.bentleybrasil.com.br/img/logo-empresa-br.png" alt="Bentley Brasil">
    <nav>
      <div class="navmenu">
        <li><a href="../index.php">Voltar a Home</a></li>
        <li><a href="../indexcomprar.php">Voltar a página de compras</a></li>
        <li><a href="../logar.php">Entrar</a></li>
        <!--  <li><a href="">Contato</a></li> -->
      </div>
      <?php
      if (isset($_SESSION['id_usuario'])) {
        $user = $_SESSION['id_usuario'];
        $sql = "SELECT * FROM usuarios WHERE id_usuario = $user";
        global $pdo;
        $sql = $pdo->prepare($sql);
        $sql->bindValue("id_usuario", $_SESSION['id_usuario']);
        $sql->execute();

        if ($sql->rowCount() > 0) {
          $dado = $sql->fetch(); ?>
          <div class="navuser">
            <a class="nav-link"><?php echo $dado['nome']; ?> </a>
          </div>
        <?php } ?>
      <?php } ?>
    </nav>
  </header>

  <h2>Esqueci a senha</h2>

  <?php
  require_once '../classes/usuarios.php';
  $u = new Usuario;
  $u->conectar("gerencianet_usuarios", "localhost", "root", "P@ssw0rd");
  /* $u->conectar("gerencianet_usuarios", "localhost", "root", "root1234"); */

  include('Email.php');

  if (isset($_POST['esqueciasenha'])) {
    $token = uniqid();
    $_SESSION['email'] = $_POST['email'];
    $_SESSION['token'] = $token;
    global $pdo;
    $sql = $pdo->prepare("SELECT * FROM usuarios WHERE email = ?");
    $sql->execute([$_SESSION['email']]);

    if ($sql->rowCount() == 1) {
      $info = $sql->fetch();

      /* $mail = new Email('hostdasuahospedagem', 'seuemailaqui@email.com', 'suasenhaqui', 'Nome do seu site'); */
      $mail = new Email('smtp.mailtrap.io', 'e1217c28bd525c', '3ff022005ffff9', 'Bentley Brasil');
      $mail->enviarPara($_POST['email'], $info['nome']);
      /*  $mail->enviarPara('luizmarcello.vmo@hotmail.com', $info['nome']); */

      $url = 'http://localhost/gn-bentley-api-sdk-php/codigo-fonte/recuperarsenha/redefinir.php';

      $corpo = 'Olá ' . $info['nome'] . ', <br>
            Foi solicitada uma redefinição da sua senha na "Nome do site". Acesse o link abaixo para redefinir sua senha.<br>
            <h3><a href="' . $url . '?token=' . $_SESSION['token'] . '">Redefinir a sua senha</a></h3> 
            <br>            
            Caso você não tenha solicitado essa redefinição, ignore esta mensagem.<br>
            Qualquer problema ou dúvida entre em contato pelo email contato@contato.com';

      $informacoes = ['Assunto' => 'Redefinição de senha', 'Corpo' => $corpo];

      $mail->formatarEmail($informacoes);

      if ($mail->enviarEmail()) {
        $data['sucesso'] = true;
      } else {
        $data['erro'] = true;
      }
      die('As orientações para criar uma nova senha no site tal foram enviadas ao seu e-mail.');
    } else {
      die('Não encontramos esse <b>email</b> em nossa base de dados.');
    }
  }

  ?>

  <main>
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
  </main>

</body>

</html>