<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Bentley Juruena</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse"
                    aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <ul class="navbar-nav me-auto mb-2 mb-md-0">
                        <span class="brand-text font-weight-light">
                            <img height="80" src="https://sistema.bentleybrasil.com.br/img/logo-empresa-br.png">
                        </span>
                        <div style="margin: 0 0 0 30px;">
                            <a class="nav-link" aria-current="page" href="index.php">Home</a>
                            <a class="nav-link" href="">Detalhes dos Produtos</a>
                        </div>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main>
        <div>
            <!--  <img src="img/cabecalhositebentley.jpg" height="90%" width="90%" style="padding: 110px 110px 70px 110px;"> -->
            <img src="img/cabecalhositebentley.jpg" height="100%" width="100%" style="margin: 30px 5px 5px 5px;">
        </div>

        <div style="margin-top: 30px;">
            <p>Comprar</p>
        </div>

        <div style="margin-top: 10px;">
            <span class="float-left">
            <i class="bi bi-upc">
                <button type="button" class="btn btn-primary"><a href="indexboleto.php">Boleto</a></button>
                </i>
            </span>
            
            <span class="float-right">
                <button type="button" class="btn btn-prymary"><a href="indexcartao.php">Cartão de crédito</a></button>
            </span>
           
            <span class="float-right">
                <button type="button" class="btn btn-primary"><a href="indexcartao.php">Pix</a></button>
            </span>
        </div>

        <!-- FOOTER -->
        <footer class="main-footer">
            <div>
                <div class="float-right d-none d-sm-block">
                    <b>Satellite Broadband Networks</b> 1.0-rc
                </div>
                <strong>Copyright &copy; <a href="https://adminlte.io"> Bentley Brasil
                        - Projeto
                        Juruena</a>.</strong> Todos os direitos reservados
            </div>
        </footer>
    </main>
    <!--  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script> -->
</body>

</html>