<?php
global $pdo;
include_once '../classes/usuarios.php';
require_once '../vendor/autoload.php';
$u = new Usuario;
$u->conectar("gerencianet_usuarios", "localhost", "root", "P@ssw0rd");
/* $u->conectar("gerencianet_usuarios", "localhost", "root", "root1234"); */
if (!isset($_SESSION)) session_start();

function verifica_dados($pdo)
{
  if (isset($_POST['env']) && $_POST['env'] == "form") {
    $email = $_POST['email'];
    $sql = $pdo->prepare("SELECT * FROM usuarios WHERE email = '$email'");
    $sql->bindValue("s", $email);
    $sql->execute();

    if ($sql->rowCount() > 0) {

      $dados = $sql->fetch(PDO::FETCH_ASSOC);
      add_dados_recover($pdo, $email);
      enviar_email($pdo, $dados['email']);
    } else {
    }
  }
}

function add_dados_recover($pdo, $email)
{
  $rash = md5(rand());
  /* $rash = base64_encode(rand()); */
  $sql = $pdo->prepare("INSERT INTO recover_solicitation (email, rash) VALUES (?, ?)");
  $sql->bindValue("ss", $email, $rash);
  $sql->execute();
  /*  echo $rash; */
}

function enviar_email($pdo, $email)
{
  /* echo $email; */
}
