<?php
require_once 'classes/usuarios.php';

if (!isset($_SESSION)) session_start();
$u = new Usuario;


?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Bentley Juruena</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet" media="all">
    <link rel="stylesheet" href="bootstrapBoleto/css/style.css">
    <link rel="stylesheet" href="css/style.css">


</head>

<body>
    <header>
        <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <ul class="navbar-nav me-auto mb-2 mb-md-0">
                        <span class="brand-text font-weight-light">
                            <img height="80" src="https://sistema.bentleybrasil.com.br/img/logo-empresa-br.png">
                        </span>
                        <div style="margin: 36px 0 0 50px;">
                            <a class="nav-link" aria-current="page" href="index.php">Home</a>
                        </div>
                        <div style="margin: 36px 0 0 50px;">
                            <a class="nav-link" href="">Detalhes dos Produtos</a>
                        </div>
                        <div style="margin: 36px 0 0 50px;">
                            <?php if (isset($_SESSION['id_usuario'])) { ?>
                                <a class="nav-link" href="sair.php">Sair</a>
                            <?php } ?>
                            <?php if (!isset($_SESSION['id_usuario'])) { ?>
                                <a class="nav-link" href="logar.php">Entrar</a>
                            <?php } ?>
                        </div>
                        <div style="margin: 36px 0 0 50px;">
                            <?php
                            if (isset($_SESSION['id_usuario'])) {
                                $u->conectar("gerencianet_usuarios", "localhost", "root", "P@ssw0rd");
                                /* $u->conectar("gerencianet_usuarios", "localhost", "root", "root1234"); */
                                $user = $_SESSION['id_usuario'];
                                $sql = "SELECT * FROM usuarios WHERE id_usuario = $user";
                                global $pdo;
                                $sql = $pdo->prepare($sql);
                                $sql->bindValue("id_usuario", $_SESSION['id_usuario']);
                                $sql->execute();

                                if ($sql->rowCount() > 0) {
                                    $dado = $sql->fetch(); ?>
                                    <a class="nav-link"><?php echo $dado['nome']; ?> </a>
                        </div>
                        <div style="margin: 36px 0 0 50px;">
                            <a class="nav-link"><?php echo $dado['email']; ?> </a>
                        </div>
                    </ul>
                <?php } ?>
            <?php } ?>
                </div>
            </div>
        </nav>

    </header>

    <main>
        <div>
            <!--  <img src="img/cabecalhositebentley.jpg" height="90%" width="90%" style="padding: 110px 110px 70px 110px;"> -->
            <img height="80%" width="100%" src="img/cabecalhositebentley.jpg" style="margin: 0px 0px 0px 0px">
        </div>
        <br>

        <div>
            <a href="indexcomprar.php"><img src="img/palavracomprar.jpg" width="140px" height="120px"></a>
        </div>

        <!-- FOOTER -->
        <footer class="main-footer">
            <div class="float-center d-none d-sm-block" style="bottom: 0; position:absolute; margin-left:5%; margin-bottom: 1%">
                <b>Satellite Broadband Networks</b> 1.0-rc
                <strong>Copyright &copy; <a href="https://adminlte.io"> Bentley Brasil
                        - Projeto
                        Juruena</a>.</strong> Todos os direitos reservados
            </div>
        </footer>
    </main>

</body>

</html>