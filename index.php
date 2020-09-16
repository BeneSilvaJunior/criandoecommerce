<?php 

//Verifica se a sessão está rodando no server
session_start();

require_once("vendor/autoload.php");

use \Slim\Slim;
use \Hcode\Page;
use \Hcode\PageAdmin;
use \Hcode\Model\User;
	
$app = new Slim();

$app->config('debug', true);

//rota site
$app->get('/', function() {
    
	$page = new Page(); //a classe Page chama os templates corretos	
	$page->setTpl("index");	

});

//rota admin
$app->get('/admin', function() {
    
	$page = new PageAdmin();	
	$page->setTpl("index");	

});

//Rota pro login
$app->get('/admin/login', function() {

 $page = new PageAdmin([
 	"header"=>false,
	"footer"=>false
 ]);
 $page->setTpl("login");
 
 /* Não existe o header e footer para a página de login, pois já existe na própria página de login. 
 Por isso será desabilitado, portanto "false" para header e footer.
 
 */
});

 //Rota para enviar os dados do formulário de login (usando método POST)
 $app->post('/admin/login', function() {
 
 //Valida o login. Cria-se a classe User (DAO)
 User::login($_POST["login"], $_POST["password"]);
 
 //Se nenhuma exceção for gerada, redireciona para a página do administrador
 header("Location: /admin");
 
 exit; //Para execução
 
 });
 
 //rota para logout
 $app->get('/admin/logout', function() {
	 
	 User::logout();
	 
	 header("Location: /admin/login");
	 exit;
 });

$app->run();

 ?>