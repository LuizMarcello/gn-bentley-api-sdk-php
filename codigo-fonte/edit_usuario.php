<?php
require_once 'classes/usuarios.php';
if (!isset($_SESSION)) session_start();
$u = new Usuario;
$u->conectar("gerencianet_usuarios", "localhost", "root", "P@ssw0rd");
/* $u->conectar("gerencianet_usuarios", "localhost", "root", "root1234"); */
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" href="css/estilo.css">
  <link rel="stylesheet" href="css/styleee.css">
  <link rel="stylesheet" href="css/estilos.css">
  <title>Alterar dados</title>
</head>

<body>
  <header>
    <img src="https://sistema.bentleybrasil.com.br/img/logo-empresa-br.png" alt="Bentley Brasil">
    <nav>
      <div class="navmenu">
        <li><a href="index.php">Voltar a Home</a></li>
      </div>
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
            <a class="nav-link"><?php echo $dado['nome']; ?> </a>
          </div>
        <?php } ?>
      <?php } ?>
    </nav>
  </header>

  <main>
    <div class="flex-box container-box">
      <div class="content-box">
        <h1>Alterar dados</h1>
        <form method="POST">
          <label for="nome">Nome</label>
          <input type="text" name="nome" placeholder="Nome Completo" value="<?php echo $dado['nome']; ?> " maxlength="45">
          <label for="telefone">Telefone</label>
          <input type="text" name="telefone" placeholder="Telefone" value="<?php echo $dado['telefone']; ?> " maxlength="45">
          <label for="email">Email cadastrado</label>
          <input type="email" name="email" placeholder="Usuário" value="<?php echo $dado['email']; ?> " maxlength="45">
          <label for="senha">Senha</label>
          <input type="password" name="senha" placeholder="Senha" value="<?php echo $dado['senha_usuario']; ?> " maxlength="45">
          <label for="confsenha">Repita a senha</label>
          <input type="password" name="confsenha" placeholder="Confirmar Senha" value="<?php echo $dado['senha_usuario']; ?> " maxlength="45">
          <input type="submit" value="Salvar" maxlength="45" style="margin-top: 10%;">

        </form>
      </div>
    </div>
  </main>

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

  <!-- //Pegando todas as informações que o usuário digitou e clicou "Cadastrar" -->

  <?php
  //Verificando se está preenchido, se tem algum campo em branco
  if (isset($_POST['nome'])) {
    //Usando a variável global "POST"
    //addslashes():Para impedir que comandos maliciosos sejam inseridos no formulário.
    $nome = addslashes($_POST['nome']);
    $telefone = addslashes($_POST['telefone']);
    $email = addslashes($_POST['email']);
    $senha = addslashes($_POST['senha']);
    $confsenha = addslashes($_POST['confsenha']);
    //Verificando se está preenchido, se tem algum campo em branco
    if (!empty($nome) && !empty($telefone) && !empty($email) && !empty($senha) && !empty($confsenha)) {
     
      if ($u->msgErro == "") //Vazia está tudo OK.
      {
        if ($senha == $confsenha) {
          if ($u->alterar($nome, $telefone, $email, $senha)) {
  ?>
  <div id="msg-sucesso">
    Alterado com sucesso!
  </div>
  <?php
         } else {
                   ?>
  <div class="msg-erro">
    Atenção: As senhas não conferem"
  </div>
  <?php
        }
      } else {
        ?>
  <div class="msg-erro">
    <?php echo "Erro: " . $u->msgErro; ?>
  </div>
  <?php
      }
    } else {
      ?>
  <div class="msg-erro">
    Por favor, preencha todos os campos!
  </div>
  <?php

    }
  }


  ?>
</body>

</html>