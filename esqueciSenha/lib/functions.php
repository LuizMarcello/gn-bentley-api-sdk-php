<?php
global $pdo;
include_once '../../classes/usuarios.php';
include_once '../../vendor/autoload.php';
$u = new Usuario;
/* $u->conectar("gerencianet_usuarios", "localhost", "root", "P@ssw0rd"); */
   $u->conectar("gerencianet_usuarios", "localhost", "root", "root1234");
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
    /* enviar_email($pdo, $dados['email']); */
    } else {

    }
  }
}

	function add_dados_recover($pdo, $email){
	$rash = md5(rand());
  /* $rash = base64_encode(rand()); */
  $sql = $pdo->prepare("INSERT INTO recover_solicitation (email, rash) VALUES (?, ?)");
  $sql->bindValue("s", $email);
  $sql->bindValue("s", $rash); 
  array($sql);
  $sql->execute(array());

  /* echo $rash; */

		 if ($sql->rowCount() > 0) {
			enviar_email($pdo, $email, $rash);
		}
	}

	function enviar_email($pdo, $email, $rash){

   /*  echo $email;  */
		$destinatario = $email;

		$subject = "RECUPERAR SENHA";
		$headers = "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=UTF-8\r\n";
		$message = "<html><head>";
		$message .= "
			<h2>Você solicitou uma nova senha?</h2>
			<hr>
			<h3>Se sim, aqui está o link para você recuperar a sua senha:</h3>
			<p>Para recuperar sua senha, acesse este link: <a href='".sitedir."?pagina=alterar&rash={$rash}'>".sitedir."?pagina=alterar&rash={$rash}</a></p>
			<hr>
			<h5>Não foi você quem solicitou? Se não ignore este email, porém alguém tentou alterar seus dados.</h5>
			<hr>
			Atenciosamente, Tutoriais e Informática.
		";

		$message .="</head></html>";

		if(mail($destinatario, $subject, $message, $headers)){
			echo "<div class='alert alert-success'>Os dados foram enviados para o seu email. Acesse para recuperar.</div>";
		}else{
			echo "<div class='alert alert-danger'>Erro ao enviar</div>".$sql->error;
		}
	}

	function verifica_rash($pdo, $rash){
		$sql = $pdo->prepare("SELECT * FROM recover_solicitation WHERE rash = ? AND status = 0");
		$sql->bindValue("s", $rash);
    $sql->execute();
	/* 	$get = $sql->get_result();
		$total = $get->num_rows; */

if ($sql->rowCount() > 0) {
				if(isset($_POST['env']) && $_POST['env'] == "upd"){
			$nsenha = addslashes(md5($_POST['senha']));
			
			 $dados = $sql->fetch(PDO::FETCH_ASSOC);
			atualiza_senha($pdo, $dados['email'], $nsenha);
			deleta_rashs($pdo, $dados['email']);
			echo "<br><div class='alert alert-success'>Senha alterada com sucesso.</div>";
			redireciona("?pagina=inicio");
			}
}else{
			echo "<br><div class='alert alert-danger'>Rash inválida.</div>";
		}
		}
				
	function atualiza_senha($pdo, $email, $senha){
		$sql = $pdo->prepare("UPDATE usuarios SET senha = ? WHERE email = ?");
		$sql->bindValue("s", $email);
  $sql->bindValue("s", $senha); 
  array($sql);
  $sql->execute(array());

	if ($sql->rowCount() > 0) {
			return true;
		}else{
			return false;
		}
	}

	function deleta_rashs($pdo, $email){
		$sql = $pdo->prepare("DELETE FROM recover_solicitation WHERE email = ?");
		$sql->bindValue("s", $email);
    $sql->execute();

		if ($sql->rowCount() > 0) {
			return true;
		}else{
			echo $pdo->error;
		}
	}

	function redireciona($dir){
		echo "<meta http-equiv='refresh' content='3; url={$dir}'>";
	}

?>