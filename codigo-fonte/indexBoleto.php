<?php
require '../vendor/autoload.php';
?>

<?php
session_start();
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
    <link rel="stylesheet" href="css/estilos.css">
   
    <script type="text/javascript" src="bootstrapBoleto/js/jquery-2.2.4.min.js"></script>
    <script type="text/javascript" src="bootstrapBoleto/js/bootstrap.js"></script>
    <script type="text/javascript" src="bootstrapBoleto/js/jquery.mask.js"></script>
    <script type="text/javascript" src="bootstrapBoleto/js/scripts.js"></script>
    <title>Boletos Gerencianet</title>
</head>

<body>
    <!-- <nav class="navbar navbar-default">
        <div class="container-fluid"> -->
            <!-- Brand and toggle get grouped for better mobile display -->
           <!--  <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/codigos-documentacao/">
                    <img src="https://gerencianet.com.br/wp-content/themes/Gerencianet/images/marca-gerencianet.svg"
                        onerror="this.onerror=null; this.src='img/marca-gerencianet.png'"
                        alt="Gerencianet - Conceito em Pagamentos" width="218" height="31">
                </a>
            </div> -->

            <!-- Collect the nav links, forms, and other content for toggling -->
           <!--  <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav"> -->
                    <!--   <li class=""><a href="https://dev.gerencianet.com.br/docs">Documentação</a></li> -->
                    <!--  <li class=""><a href="https://dev.gerencianet.com.br/docs/fale-conosco">Contatos</a></li> -->
                   <!--  <li class=""><a href="index.php">Retornar a Bentley Brasil</a></li> -->
                    <!-- <li class=""><a href="sair.php">Logoff Bentley</a></li> -->
               <!--  </ul>
                <ul class="nav navbar-nav">
                    <li class=""><a href="indexcomprar.php">Retornar as opções de pagamento</a></li>
                </ul>

                <ul class="nav navbar-nav pull-right"> -->
                    <!--  <li><a target="blank" href="https://gerencianet.com.br/#login">Entrar na gerencianet</a> -->
                    </li>
                    <!--  <li><a target="blank" href="https://gerencianet.com.br/#abrirconta">Abra sua conta</a> -->
                    </li>
                </ul>

            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>

    <div>
        <h3>Bentley Brasil - Gerador de Boletos</h3>
        <form action="emitir_boleto.php" method="POST">
            <input type="text" name="nome" placeholder="Nome completo">
            <input type="mail" name="email" placeholder="E-mail">
            <input type="number" name="fone" placeholder="Telefone">
            <input type="number" name="cpf" placeholder="CPF válido">
            <input type="text" name="produto" placeholder="Titulo do produto">
            <input type="number" name="valor" placeholder="Valor">
            <p>Data do vencimento</p>
            <input type="date" name="vencimento">
            <button type="submit" class="btn" name=gerarBoleto>Gerar Boleto</button>
        </form>
    </div>
    

   <!--  <div id="rodape" class="footer well">
        <div class="container-fluid text-center"> -->
            <!--  <img src="https://gerencianet.com.br/wp-content/themes/Gerencianet/images/marca-gerencianet.svg" onerror="this.onerror=null;
             this.src='img/marca-gerencianet.png'" alt="Gerencianet - Conceito em Pagamentos" width="218" height="27">
            <div class="content-footer">
                © 2007-2016 Gerencianet. Todos os direitos reservados.<br />
                Gerencianet Pagamentos do Brasil Ltda. • CNPJ: 09.089.356/0001-18<br />
                Avenida Juscelino Kubitschek, 909 - Ouro Preto, Minas Gerais<br />
            </div> -->

           <!--  <div>
                <div class="float-right d-none d-sm-block">
                    <b>Satellite Broadband Networks</b> 1.0-rc
                </div>
                <strong>Copyright &copy; <a href="https://adminlte.io"> Bentley Brasil
                        - Projeto
                        Juruena</a>.</strong> Todos os direitos reservados
            </div>/.navbar-collapse
        </div>/.container-fluid -->
    </div>
</body>

</html>