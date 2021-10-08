<?php



global $pdo;

class Usuario
{
  /* Utilizando o PDO para conectar */
  private $pdo;
  public $msgErro = ""; //Esta variável vazia, está tudo OK.

  public function conectar($nome, $host, $usuario, $senha)
  {
    global $pdo;
    try {
      $pdo = new PDO("mysql:dbname=" . $nome . ";host=" . $host, $usuario, $senha);
    } catch (PDOException $e) {
      $msgErro = $e->getMessage();
    }
  }

  public function cadastrar($nome, $telefone, $email, $senha)
  {
    global $pdo;
    //Verificar se já existe o email cadastrado
    $sql = $pdo->prepare("SELECT id FROM usuarios WHERE email = :e");
    $sql->bindValue(":e", $email);
    $sql->execute();
    //Condicional: Se retornar um id, usuário digitado(email) já existe.
    if ($sql->rowCount() > 0) {
      return false; //Já está cadastrado.
    } else {
      //Caso não, então cadastrar no banco de dados
      $sql = $pdo->prepare("INSERT INTO usuarios (nome, telefone, email, senha_usuario)
      VALUES (:n, :t, :e, :s)");
      $sql->bindValue(":n", $nome);
      $sql->bindValue(":t", $telefone);
      $sql->bindValue(":e", $email);
      $sql->bindValue(":s", md5($senha));
      $sql->execute();
      return true; //Cadastrado com sucesso.
    }
  }

  public function logar($email, $senha)
  {
    global $pdo;
    //Verificar se o email e senha já estão cadastrados
    $sql = $pdo->prepare("SELECT id FROM usuarios WHERE email = :e AND senha_usuario = :s");
    $sql->bindValue(":e", $email);
    $sql->bindValue(":s", md5($senha));
    $sql->execute();
    if ($sql->rowCount() > 0) {
      //Se sim, entrar no sistema(criar uma sessão)
      //fetch(): Pega tudo que veio do banco de dados e transforma 
      //num array, com os nomes das colunas.
      $dado = $sql->fetch();
      //Criando uma sessão
      /* session_start(); */
      //Agora o id do usuário que acabou de logar, está armazenado numa sessão.
      $_SESSION['id'] = $dado['id'];
      return true; //Está cadastrado, então foi logado com sucesso.
    } else {
      return false; //Não foi possível logar.
    }
  }
}