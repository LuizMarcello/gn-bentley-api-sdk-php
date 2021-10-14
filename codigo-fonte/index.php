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
    <title>Bentley Brasil</title>
    <!-- Icones fontawesome: -->
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
     integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <!-- Fontes da google: font-family: 'Open Sans', sans-serif; -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700">
    <link rel="stylesheet" href="css/styleee.css">
</head>

<body>
    <header>

        <img src="https://sistema.bentleybrasil.com.br/img/logo-empresa-br.png" alt="Bentley Brasil">
        <nav>
            <div class="navmenu">
                <li><a href="index.php">Home</a></li>
                <li><a href="">Sobre</a></li>
                <li><a href="">Contato</a></li>
                <li>
                    <?php if (isset($_SESSION['id'])) { ?>
                        <a class="nav-link" href="sair.php">Sair</a>
                    <?php } ?>
                    <?php if (!isset($_SESSION['id'])) { ?>
                        <a class="nav-link" href="logar.php">Entrar</a>
                    <?php } ?>
                </li>
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
            <div class="navmenu">
                <li><a href="dados.php">Meus dados</a></li>
            </div>
        </nav>
    </header>

    <section class="cabecalho">
        <img src="img/cabecalhositebentley.jpg" alt="Bentley Brasil">
    </section>

    <section class="imagensjuruena">
        <ul class="imgjuruena">
            <img src="../imgFlexBox/juruena01.jpg" alt="Bentley Brasil">
            <img src="../imgFlexBox/juruena03.jpg" alt="Bentley Brasil">
            <img src="../imgFlexBox/juruena02.jpg" alt="Bentley Brasil">
        </ul>
    </section>

    <section class="reserva">
        <a href="indexcomprar.php"><img src="img/fazerreserva.jpg"></a>
    </section>

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