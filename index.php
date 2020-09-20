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
 
 //Rota para consulta de usuários
 $app->get("/admin/users", function() {
	 
	 //Verifica se o usuário está logado e se tem acesso ao administrativo
	 User::verifyLogin();
	 
	 $users = User::listAll(); //lista usuários
 
 	$page = new PageAdmin();	
	$page->setTpl("users", array(
		"users"=>$users
	 ));
 });

 //-----   Rotas de telas

 //Rota para criação de usuários
 $app->get("/admin/users/create", function() {
	 
	 User::verifyLogin();
 
 	$page = new PageAdmin();	
	$page->setTpl("users-create");
 });
 
 /* Obs.: manter a rota  ...iduser/delete antes de ..iduser para que a rota /delete seja lida*/ 
 
   //Exclui usuários
 $app->get("/admin/users/:iduser/delete", function($iduser) {
	 User::verifyLogin();
 }); 
 
 //Rota para atualização de usuários
 $app->get("/admin/users/:iduser", function($iduser) {
	 
	 User::verifyLogin();
 
 	$page = new PageAdmin();	
	$page->setTpl("users-update");
 });
 
  //Rota para atualização de usuários
 $app->get("/admin/users/:iduser", function($iduser) {
	 
	 User::verifyLogin();
 
 	$page = new PageAdmin();	
	$page->setTpl("users-update");
 });

 //Faz o insert no banco
 $app->post("/admin/users/create", function() {
	 User::verifyLogin();
	 
	 $user = new User();
	 
	 //Verifica se inadmin foi definido, o valor é 1, senão é 0
	 $_POST["inadmin"] = (isset($_POST["inadmin"]))?1:0;
	 
	 $user->setData($_POST);
	 $user->save();
	 
	 header("Location: /admin/users");
	 exit;
 });
 
 
 /*
 $app->post("/admin/users/create", function () {

 	User::verifyLogin();

	$user = new User();

 	$_POST["inadmin"] = (isset($_POST["inadmin"])) ? 1 : 0;

 	$_POST['despassword'] = password_hash($_POST["despassword"], PASSWORD_DEFAULT, ["cost"=>12
 	]);

 	$user->setData($_POST);
	$user->save();

	header("Location: /admin/users");
 	exit;

});
*/
  //Salva as edições
 $app->post("/admin/users/:iduser", function($iduser) {
	 User::verifyLogin();
 });


$app->run();

 ?>