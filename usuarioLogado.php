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
     integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p"
      crossorigin="anonymous" />
    <!-- Fontes da google: font-family: 'Open Sans', sans-serif; -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700">


    <!--  <link rel="stylesheet" href="css/style.css"> -->
    <!--  <link rel="stylesheet" href="css/estilo.css"> -->
    <link rel="stylesheet" href="css/styleusuariologado.css">

    <script type="text/javascript">
        function mascara(telefone) {
            if (telefone.value.length == 0)
                telefone.value = '(' + telefone
                .value;
            if (telefone.value.length == 3)
                telefone.value = telefone.value +
                ') ';

            if (telefone.value.length == 10)
                telefone.value = telefone.value +
                '-';
        };
    </script>
</head>

<body>
    <header>
        <img src="https://sistema.bentleybrasil.com.br/img/logo-empresa-br.png" alt="Bentley Brasil">
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
            <div class="content-box">
                <h1>Alterar dados cadastrais</h1>
                <form method="POST">
                    <label for="nome">
                        <h5>Nome</h5>
                    </label>
                    <input type="text" name="nome" value="<?php if(isset($sql)) { echo $dado['nome'];}?>" maxlength="45"
                        required>
                    <label for="telefone">
                        <h5>Telefone</h5>
                    </label>
                    <input type="text" name="telefone" value="<?php if(isset($sql)) { echo $dado['telefone'];}?>"
                        size="20" maxlength="15" onkeypress="mascara(this)" required>
                    <label for="email">
                        <h5>Email</h5>
                    </label>
                    <input type="email" name="email" value="<?php if(isset($sql)) { echo $dado['email'];}?>"
                        maxlength="45" required>



                    <label for="senha_usuario">
                        <h5>Senha</h5>
                    </label>
                    <input type="password" name="senha_usuario" id="senha_usuario"
                        value="<?php if(isset($sql)) { echo $dado['senha_usuario'];}?>" maxlength="45" required>
                    <button onclick="mostrarASenha()" type="button" id="mostrarrSenha"
                        class="btn btn-primary botao btn-sm">Mostrar Senha</button>

                    <div>
                        <label for="confsenha" style="white-space: nowrap;">
                            <h5>Repita a senha</h5>
                        </label>
                        <input type="password" name="confsenha" id="confsenha"
                            value="<?php if(isset($sql)) { echo $dado['senha_usuario'];}?>" maxlength="45" required>
                        <button onclick="mostrarASenhaRepete()" type="button" id="mostrarrSenhaRepete"
                            class="btn btn-primary botao btn-sm">Mostrar Senha</button>
                    </div>


                    <input type="submit" value="Salvar" maxlength="45">
                    <a href="index.php"><strong>Voltar a home</strong></a>
                </form>
            </div>
        </div>
    </main>

    <script>
        function mostrarASenha() {
            var text = document.getElementById("mostrarrSenha").firstChild;
            var tipo = document.getElementById("senha_usuario");
            if (tipo.type == "password") {
                tipo.type = "text";
            } else {
                tipo.type = "password";
            }
            text.data = text.data == "Esconder senha" ? "Mostrar senha" : "Esconder senha";
        }

        function mostrarASenhaRepete() {
            var text = document.getElementById("mostrarrSenhaRepete").firstChild;
            var tipo = document.getElementById("confsenha");
            if (tipo.type == "password") {
                tipo.type = "text";
            } else {
                tipo.type = "password";
            }
            text.data = text.data == "Esconder senha" ? "Mostrar senha" : "Esconder senha";
        }
    </script>

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