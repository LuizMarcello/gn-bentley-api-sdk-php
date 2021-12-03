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
    <link rel="stylesheet" href="css/styleindex.css">
</head>

<body>
    <header>
        <img src="https://sistema.bentleybrasil.com.br/img/logo-empresa-br.png" alt="Bentley Brasil">
        <nav>
            <div class="navmenu">
                <li>
                    <?php if (isset($_SESSION['id'])) { ?>
                    <a class="nav-link" href="sair.php"><a style="white-space: nowrap;" href="usuarioLogado.php">Meu
                            Perfil</a></a>
                    <?php } ?>
                </li>
                <li>
                    <?php if (isset($_SESSION['id'])) { ?>
                    <a class="nav-link" href="sair.php">Sair</a> 
                    <?php } ?>
                    <?php if (!isset($_SESSION['id'])) { ?>
                    <a class="nav-link" href="logar.php">Logar</a>
                    <?php } ?>
                </li>
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
                <li>
                    <a style="white-space: nowrap;" class="nav-link"><?php echo $dado['nome']; ?> </a>
                </li>
                <?php } ?>
                <?php } ?>
            </div>
        </nav>
    </header>

    <section class="cabecalho">
        <img src="img/cabecalhositebentley.jpg" alt="Bentley Brasil">
    </section>

    <section class="imagensjuruena">
        <h1>Equipamentos Bentley</h1>
        <div class=imagensjuruena-container>
            <div class="produtos-item img01">
                <h2>Powerbean M5</h2>
                <img src="img/juruena05.jpg" alt="Imagem 1">
            </div>
            <div class="produtos-item img02">
                <h2>Powerbeam AC</h2>
                <img src="img/juruena03.jpg" alt="Imagem 2">
            </div>
            <div class="produtos-item img03">
                <h2>TP-Link Tl-wr840n</h2>
                <img src="img/juruena04.jpg" alt="Imagem 3">
            </div>
            <div class="produtos-item img04">
                <h2>Liteabeam AC</h2>
                <img src="img/juruena01.jpg" alt="Imagem 4">
            </div>
        </div>
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