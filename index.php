<?php 

require_once("vendor/autoload.php");

use \Slim\Slim;
use \Hcode\Page;
use \Hcode\PageAdmin;

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

$app->run();

 ?>