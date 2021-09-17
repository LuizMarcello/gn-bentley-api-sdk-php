<?php

require_once 'classes/usuarios.php';
require '../vendor/autoload.php';
$u = new Usuario;

if (!isset($_SESSION)) session_start();

if (!isset($_SESSION['id_usuario'])) {
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
    <!--  <link rel="stylesheet" href="bootstrapBoleto/css/bootstrap.css"> -->
    <!--  <link rel="stylesheet" href="bootstrapBoleto/css/style.css"> -->
    <!-- <link rel="stylesheet" href="css/estilo.css"> -->
    <link rel="stylesheet" href="bootstrapBoleto/css/bootstrap.css">
    <link rel="stylesheet" href="bootstrapBoleto/css/style.css">
    <link rel="stylesheet" href="css/estilos.css">
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
        $(document).ready(function() {
            //Select para mostrar e esconder divs
            $('#fisicaoujuridica').on('change', function() {
                var SelectValue = '.' + $(this).val();
                $('#pai div').hide();
                $(SelectValue).toggle();
            });
        });
    </script>
</head>

<body>
    <header>
        <nav class="navbar navbar-default">

            <div class="container-fluid">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <img height="80" src="https://sistema.bentleybrasil.com.br/img/logo-empresa-br.png">
                </div>
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <li class=""><a href="index.php">Retornar a Home</a></li>
                    </ul>
                    <ul class="nav navbar-nav">
                        <li class=""><a href="indexcomprar.php">Retornar as opções de pagamento</a></li>
                    </ul>
                    <ul class="nav navbar-nav pull-right">
                        <div class="collapse navbar-collapse" id="navbarCollapse">
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
                                        $dado = $sql->fetch();
                                ?>
                                        <a class="nav-link"><?php echo $dado['nome']; ?> </a>
                            </div>

                    </ul>
                <?php } ?>
            <?php } ?>
                </div>
            </div>
        </nav>
    </header>

    <main>



        <h3>Bentley Brasil - Gerador de Boletos</h3>

        <form action="emitir_boleto.php" method="POST">
            <div id="acima" class="form-group">
                <label for="fisicaoujuridica" class="control-label"></label>
                <input class="form-control" type="text" disabled>
                <div class="col-sm-3">
                    <select name="fisicaoujuridica" class="form-control" id="fisicaoujuridica">
                        <option value="">Pessoa física ou jurídica</option>
                        <option value="fisica">Física</option>
                        <option value="juridica">Jurídica</option>
                    </select>
                </div>
            </div>

            <div id="pai">
                <div id="pai1-1" class="form-group fisica col-sm-3">
                    <label for="nome" class="control-label">Nome</label>
                    <input type="text" name="nome" id="nome" value="<?php echo $dado['nome']; ?>"><br>
                    <label for="email" class="control-label">Email</label>
                    <input type="mail" name="email" id="email" value="<?php echo $dado['email']; ?>"><br>
                    <label for="telefone" class="control-label">telefone</label>
                    <input type="number" name="telefone" id="telefone" value="<?php echo $dado['telefone']; ?>"><br>
                    <label for="cpf" class="control-label">CPF válido</label>
                    <input type="number" name="cpf" id="cpf"><br>
                    <label for="produto" class="control-label">Produto</label>
                    <input type="text" name="produto" id="produto" value="Adesão de equipamentos - Projeto Juruena"><br>
                    <label for="valor" class="control-label">Valor</label>
                    <input type="number" name="valor" id="valor" value="190000"><br>
                    <label for="vcto" class="control-label">Vencimento</label>
                    <input type="date" name="vencimento" id="vcto">
                    <!-- <div class="botao"> -->
                        <button type="submit" class="btn" name=gerarBoleto>Gerar Boleto</button>
                   <!--  </div> -->
                </div>

                <div id="pai1-2" class="form-group juridica col-sm-3">
                    <input type="text" name="razaosocial" placeholder="Razão social" value="<?php echo $dado['nome']; ?>">
                    <input type="mail" name="email" placeholder="E-mail" value="<?php echo $dado['email']; ?>">
                    <input type="number" name="fone" placeholder="Telefone" value="<?php echo $dado['telefone']; ?>">
                    <input type="number" name="cpf" placeholder="Cnpj válido">
                    <input type="text" name="produto" placeholder="Titulo do produto" value="Adesão de equipamentos - Projeto Juruena">
                    <input type="number" name="valor" placeholder="Valor" value="190000">
                    <input type="date" name="vencimento">
                   <!--  <div class="botao"> -->
                        <button type="submit" class="btn" name=gerarBoleto>Gerar Boleto</button>
                    <!-- </div> -->
                </div>
            </div>
        </form>

        <!-- FOOTER -->
        <footer class="main-footer">
            <div class="float-center d-none d-sm-block" style="bottom: 0; position:absolute; margin-left:30%;
             margin-bottom: 1%">
                <b>Satellite Broadband Networks</b> 1.0-rc
                <strong>Copyright &copy; <a href="https://adminlte.io"> Bentley Brasil
                        - Projeto
                        Juruena</a>.</strong> Todos os direitos reservados
            </div>
        </footer>
    </main>
</body>

</html>