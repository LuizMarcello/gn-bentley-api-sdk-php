<?php

require_once 'classes/usuarios.php';
require '../vendor/autoload.php';
$u = new Usuario;
/* $u->conectar("gerencianet_usuarios", "localhost", "root", "P@ssw0rd"); */
 $u->conectar("gerencianet_usuarios", "localhost", "root", "root1234");

if (!isset($_SESSION)) session_start();

if (!isset($_SESSION['id'])) {
    header("location: logar.php");
    exit;
}

?>

<!DOCTYPE html>
<!-- <html lang="pt-br"> -->
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->


<head>
    <meta charset="UTF-8">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bentley Brasil</title>
    <!-- Icones fontawesome: -->
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
        integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <!-- Fontes da google: font-family: 'Open Sans', sans-serif; -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700">

    <link rel="stylesheet" href="bootstrapBoleto/css/bootstrap.css">
    <link rel="stylesheet" href="bootstrapBoleto/css/style.css">
    <link rel="stylesheet" href="css/estilos.css">
    <link rel="stylesheet" href="css/styleee.css">
    <script type="text/javascript" src="bootstrapBoleto/js/jquery-2.2.4.min.js"></script>
    <script type="text/javascript" src="bootstrapBoleto/js/bootstrap.js"></script>
    <script type="text/javascript" src="bootstrapBoleto/js/jquery.mask.js"></script>
    <script type="text/javascript" src="bootstrapBoleto/js/scripts.js"></script>
    <title>Boletos Gerencianet</title>
    <style>
        #pai div {
            display: none;
        }
    </style>

    <script>
        //Funções após a leitura do documento
        $(document).ready(function () {
            //Select para mostrar e esconder divs
            $('#fisicaoujuridica').on('change', function () {
                var SelectValue = '.' + $(this).val();
                $('#pai div').hide();
                $(SelectValue).toggle();
            });
        });
    </script>
</head>

<body>
    <header>
        <img src="https://sistema.bentleybrasil.com.br/img/logo-empresa-br.png" alt="Bentley Brasil">
        <nav>
            <div class="navmenu">
                <li><a href="index.php">Voltar a Home</a></li>
                <li><a href="indexcomprar.php">Voltar a página de compras</a></li>
                <!-- <li><a href="">Contato</a></li> -->
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

        <h5>Bentley Brasil - Gerador de Boletos</h5>

        <form action="emitir_boleto.php" method="POST">
            <section class="boleto">
                <div id="acima" class="form-group">
                    <label for="fisicaoujuridica" class="control-label"></label>
                    <input class="form-control" type="text" disabled>
                    <div class="col-sm-11">
                        <select name="fisicaoujuridica" class="form-control" id="fisicaoujuridica">
                            <option value="">Pessoa física ou jurídica</option>
                            <option value="fisica">Pessoa Física</option>
                            <option value="juridica">Pessoa Jurídica</option>
                        </select>
                    </div>
                </div>

                <div id="pai">
                    <div id="pai1-2" class="form-group col-sm-6 fisica">
                        <input type="number" name="cpf" placeholder="Cpf válido">
                    </div>
                    <div id="pai1-2" class="form-group  col-sm-6 juridica">
                        <input type="number" name="cnpj" placeholder="Cnpj válido">
                    </div>
                    <div id="pai1-2" class="form-group col-sm-8 fisica juridica">
                        <button type="submit" class="btn btn-success" name=gerarBoleto>Gerar Boleto</button>
                    </div>
                </div>

                <div id="pai1-2boleto" class="form-group col-sm-4">
                    <label for="nome" class="control-label">Nome</label>
                    <input type="text" name="nome" placeholder="Nome completo" value="<?php echo $dado['nome']; ?>">

                    <label for="email" class="control-label">Melhor email</label>
                    <input type="mail" name="email" placeholder="E-mail" value="<?php echo $dado['email']; ?>">

                    <label for="telefone" class="control-label">Telefone</label>
                    <input type="number" name="fone" placeholder="Telefone" value="<?php echo $dado['telefone']; ?>">

                    <label for="produto" class="control-label">Produto</label>
                    <input type="text" name="produto" placeholder="Produto"
                        value="Adesão de equipamentos - Projeto Juruena" readonly="readonly">

                    <label for="valor" class="control-label">Valor</label>
                    <input type="number" name="valor" placeholder="Valor do produto" value="190000" readonly="readonly">

                    <!--  <p>Data do vencimento</p> -->
                    <!-- Data de vencimento atual e acrescentando mais 3 dias -->
                    <input type="hidden" name="vencimento" value='<?php echo date("Y-m-d", strtotime("+3 days")); ?>'>
                    <!-- <input type="date" name="vencimento"> -->
                </div>
            </section>
        </form>

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