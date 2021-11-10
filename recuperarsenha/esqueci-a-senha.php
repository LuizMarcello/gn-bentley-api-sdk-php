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

   <!--  <link rel="stylesheet" href="../css/estilo.css"> -->
   <!--  <link rel="stylesheet" href="../css/estilos.css"> -->
    <link rel="stylesheet" href="../css/styleee.css">
   <!--  <link rel="stylesheet" href="../css/style.css"> -->
   <!--  <link rel="stylesheet" href="../bootstrapBoleto/css/bootstrap.css"> -->
    <link rel="stylesheet" href="../bootstrapBoleto/css/style.css">

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

    <form method="post" action="recuperar.php">
        <div class="input_form_login">
            <label for="email">Insira o seu e-mail e redefina a sua senha.</label>
            <input type="email" id="email" name="email" placeholder="Seu email">
        </div>
        <div class="input_form_login">
            <input type="submit" name="esqueciasenha" value="Redefinir">
        </div>
    </form>

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