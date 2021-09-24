<?php
require_once 'classes/usuarios.php';

if (!isset($_SESSION)) session_start();
$u = new Usuario;

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Paraíso</title>
    <!-- Icones fontawesome: -->
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <!-- Fontes da google: font-family: 'Open Sans', sans-serif; -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700">
    <link rel="stylesheet" href="css/styleee.css">
</head>

<body>
    <header>
        <!-- <img height="80" src="https://sistema.bentleybrasil.com.br/img/logo-empresa-br.png"> -->
        <img src="https://sistema.bentleybrasil.com.br/img/logo-empresa-br.png" alt="Bentley Brasil">
        <nav>
            <li><a href="">Home</a></li>
            <li><a href="">Sobre</a></li>
            <li><a href="">Contato</a></li>
            <?php
            if (isset($_SESSION['id_usuario'])) {
                $u->conectar("gerencianet_usuarios", "localhost", "root", "P@ssw0rd");
                /*   $u->conectar("gerencianet_usuarios", "localhost", "root", "root1234"); */
                $user = $_SESSION['id_usuario'];
                $sql = "SELECT * FROM usuarios WHERE id_usuario = $user";
                global $pdo;
                $sql = $pdo->prepare($sql);
                $sql->bindValue("id_usuario", $_SESSION['id_usuario']);
                $sql->execute();

                if ($sql->rowCount() > 0) {
                    $dado = $sql->fetch(); ?>
                    <div>
                        <a class="nav-link"><?php echo $dado['nome']; ?> </a>
                    </div>
                    <div style="margin: 36px 0 0 50px;">
                        <!--  <a class="nav-link"> --><?php /* echo $dado['email']; */ ?>
                        <!-- </a> -->
                    </div>
                <?php } ?>
            <?php } ?>
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