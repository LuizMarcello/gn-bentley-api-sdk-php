<?php
global $pdo;
if (!isset($_SESSION)) session_start();

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

  /* Método para esqueciSenha */
  public function geraChaveAcesso($email)
  {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = :email");
    $stmt->bindValue(":email", $email);
    $run = $stmt->execute();
    $rs = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($rs) {
      $chave = md5($rs["id"] . $rs["senha_usuario"]);
      return $chave;
    }
  }

  /* Método para esqueciSenha */
  /* Verifica se na tabela "usuarios" existe um usuário com o e-mail informado */
  public function checkChave($email, $chave)
  {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = :email");
    $stmt->bindValue(":email", $email);
    $run = $stmt->execute();
    $rs = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($rs) {
      $chaveCorreta = md5($rs["id"] . $rs["senha_usuario"]);
      if ($chave == $chaveCorreta) {
        return $rs["id"];
      }
    }
  }

  /* Método para esqueciSenha */
  public function setNovaSenha($novasenha, $id)
  {
    global $pdo;
    $stmt = $pdo->prepare("UPDATE usuarios SET senha_usuario = :novasenha WHERE id = :id");
    $stmt->bindValue(":novasenha", md5($novasenha));
    $stmt->bindValue(":id", $id);
    $run = $stmt->execute();
  }
}
