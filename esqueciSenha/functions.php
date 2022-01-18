<?php
global $pdo;
include_once("/classes/usuarios.php");
function verifica_dados($pdo)
{
  if (isset($_POST['env']) && $_POST['env'] == "form") {
    //Verificar se o email e senha já estão cadastrados
    $sql = $pdo->prepare("SELECT email FROM usuarios WHERE email = ?");
    $sql->bind_param("s", $_POST['email']);
    $sql->execute();
    $get = $sql->get_result();
    $total = $get->num_rows;

    if ($total > 0) {
      echo "tem";
    } else {
      echo "não tem";
    }
  }
}
global $pdo;
function enviar_email($pdo)
{
}
