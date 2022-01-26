<?php
require_once 'classes/usuarios.php';
if (!isset($_SESSION)) session_start();
$u = new Usuario;
/* $u->conectar("gerencianet_usuarios", "localhost", "root", "P@ssw0rd"); */
   $u->conectar("gerencianet_usuarios", "localhost", "root", "root1234");
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <title>Bentley Brasil</title>
  <!-- Icones fontawesome: -->
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
    integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
  <!-- Fontes da google: font-family: 'Open Sans', sans-serif; -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700">

  <link rel="stylesheet" href="css/styleusuariologado.css">

</head>

<body>
  <header>
    <img src="img/logo-empresa-br.png" alt="Bentley Brasil">
    <nav>
      <div class="navmenu">
        <li><a style="white-space: nowrap;" href="index.php">Voltar a Home</a></li>

        <!-- <li><a href="">Contato</a></li> -->
        <?php
        if (isset($_SESSION['id'])) {
          $user = $_SESSION['id'];
          $sql = "SELECT * FROM usuarios WHERE id = $user";
          global $pdo;
          $sql = $pdo->prepare($sql);
          $sql->bindValue("id", $_SESSION['id']);
          $sql->execute();

          if ($sql->rowCount() > 0) {
            $dado = $sql->fetch();
        ?>
        <li>
          <a style="white-space: nowrap;" class="nav-link"><?php echo $dado['nome']; ?> </a>
        </li>
        <?php } ?>
        <?php } ?>

      </div>
    </nav>
  </header>


  <main>
    <div class="flex-box container-box">
      <div class="content-box" style="width: 90%; margin-left: auto; margin-right: auto;">
        <h1>Meus dados cadastrais</h1>
        <table border="1" width="85%">
          <thead>
            <tr>
              <th>Nome</th>
              <th>Telefone</th>
              <th>Email</th>
              <th></th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td><?php if (isset($sql)) { echo $dado['nome']; } ?></td>
              <td><?php if (isset($sql)) { echo $dado['telefone']; } ?></td>
              <td><?php if (isset($sql)) { echo $dado['email']; } ?></td>
              <td><a href="meuPerfilEditar.php"><b>Editar</b></a></td>
              <td><a href=""><b>Excluir</b></a></td>
              
            </tr>
          </tbody>
        </table>

        <!-- <form method="POST">
          <div class="organiz">
            <label for="nome">
              <h5>Nome</h5>
            </label>
            <input type="text" name="nome" value="<?php if (isset($sql)) { echo $dado['nome']; } ?>" maxlength="45"
              required>
            <label for="telefone">
              <h5>Telefone</h5>
            </label>
            <input type="text" name="telefone" id="telefone"
              value="<?php if (isset($sql)) { echo $dado['telefone']; } ?>" size="20" maxlength="15" required>
            <label for="email">
              <h5>Email</h5>
            </label>
            <input type="email" name="email" value="<?php if (isset($sql)) { echo $dado['email']; } ?>" maxlength="45"
              required>
            <input type="submit" value="Salvar alteração" maxlength="45">

            <a href="index.php"><strong>Voltar a home</strong></a>
          </div>
        </form> -->

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

  <script type="text/javascript" src="jQuery/jquery-3.6.0.min.js">
  </script>
  <script type="text/javascript" src="jQuery/jquery.mask.js"></script>

  <script type="text/javascript">
    $(document).ready(function () {
      /* Criando a máscara jQuery na digitação do telefone */
      var SPMaskBehavior = function (val) {
          return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
        },
        spOptions = {
          onKeyPress: function (val, e, field, options) {
            field.mask(SPMaskBehavior.apply({}, arguments), options);
          }
        };

      $('#telefone').mask(SPMaskBehavior, spOptions);

      /* Salvando o telefone no banco de dados MySql sem a máscara */
      $("#telefone").mask("(00) 00000-0000' : '(00) 0000-00009");
      $("#telefone").addClass("form-control");

      $("#form").submit(function () {
        var telefoneValue = $("#telefone").val();

        // Remove os caracteres que não são dígitos:
        telefoneValue = telefoneValue.replace(/\D/g, '');

        // Atualiza o valor no campo do formulário:
        $("#telefone").val(telefoneValue);
      });
    });
  </script>
</body>

</html>