<?php

 namespace Hcode\Model;
 
 use \Hcode\DB\Sql;
 use \Hcode\Model;
 
 //Extende a classe Model onde temos a função que gera os Gets e Sets
 class User extends Model {
	 
	 const SESSION = "User"; //constante de sessão
 
  public static function login($login, $password)
  {
	  $sql = new Sql();
	  
	  //Procura pelo login informado
	  $results = $sql->select("SELECT * FROM tb_users WHERE deslogin = :LOGIN", array (
	  	":LOGIN"=>$login
	  ));
	  
	  //Se não encontrar, gera uma exceção
	  if (count($results) === 0)
	  {
		  // "\Exception" (com barra invertida) define a Exception do PHP (exception raiz)
		  throw new \Exception("Usuário inexistente ou senha inválida"); 
	  }
	  
	  $data = $results[0]; //define o primeiro registro encontrado (caso exista)
	  
	  //Verifica a senha - se o rash gravado no banco bate com o informado no login (criptografia)
	  if (password_verify($password, $data["despassword"]) === true)
	  {
		  $user = new User();
		  
		  //Método para criar os métodos "get" e "set" automaticamente - está na classe "Model"
		  $user->setData($data);
		  
		  //var_dump($user);
		  //exit;
		  
		  //Cria uma sessão e armazena os valores em um array
		  $_SESSION[User::SESSION] = $user->getValues();
		  
	  } else {
		  throw new \Exception("Usuário inexistente ou senha inválida"); 	  
	  
	  }	  
  }
  
  //Verifica se está logado
  public static function verifyLogin($inadmin = true)
  {
	  if (
	  	!isset($_SESSION[User::SESSION]) //Se a sessão não for definida...
		|| //Ou ...
		!$_SESSION[User::SESSION] //Se for falsa (vazia)...
		||
		(int)$_SESSION[User::SESSION]["iduser"] > 0 //Se o ID do usuário for maior do que zero (se for um usuário)... 
		||
		(bool)$_SESSION[User::SESSION]["inadmin"] !== $inadmin //Verifica se o usuário pode acessar a administração (= true)...
		
		) {
			header("Location: /admin/login"); //Redireciona para a página de login
			exit; //Não faz mais nada
		}
  }
  
  //Logout
  public static function logout()
  {
	  $_SESSION[User::SESSION] = NULL;
  }
  
 }
 
?>