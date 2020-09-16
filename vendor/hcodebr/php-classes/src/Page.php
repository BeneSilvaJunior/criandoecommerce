<?php

namespace Hcode; //namespace defina a localização da classe Page, neste caso em Hcode

use Rain\Tpl; //usa outro namespace, o Rain\Tpl (ao chamar new Tpl() virá do namespace Rain\Tpl)

//Classe Page para gerenciar as telas, o HTML
class Page {
	
	private $tpl;
	private $options = [];
	
	//Por padrão, header e footer são true. Passamos as variáveis para o template (é um array vazio por padrão)
	private $defaults = [
		"header"=>true,
		"footer"=>true,
		"data"=>[]
	
	];

 //Método mágico - primeiro a ser carregado
 
 /* Passamos as opções "$opts = array" (por padrão é um array) e "$tpl_dir" (diretório das views) - por padrão é "/views/")
 Mas podemos ter algumas opções padrão (default) "$defaults" (é um array) */
 public function __construct($opts = array(), $tpl_dir = "/views/") {	 
	 
	 $this->options = array_merge($this->defaults, $opts);
 
    // configuração do template
	$config = array(
		"tpl_dir"       => $_SERVER["DOCUMENT_ROOT"].$tpl_dir, //pasta para pegar os templates
		"cache_dir"     => $_SERVER["DOCUMENT_ROOT"]."/views-cache/", //pasta com o cache HTML
		"debug"         => false // set to false to improve the speed
		
		//$_SERVER["DOCUMENT_ROOT"] define a pasta root do servidor
	);

    //Passa as configurações para o Tpl (use configurado "Rain\Tpl")
	Tpl::configure( $config );
	
	/* Para termos acesso ao tpl em outros métodos, é necessário que ele seja um atributo desta classe. 
	Para isso usamos a palavra-chave $this >>  private $tpl */
	$this->tpl = new Tpl;	
	
	/* Passamos as variáveis, que vem de acordo com a rota, que depende da rota que vc estiver chamando do slim. 
	Assim passamos os dados para a classe Page. Para isso recebemos algumas opções da classe */
	$this->setData($this->options["data"]);
	
	
	//Se header for true (todo site exceto página de login)
	if($this->options["header"] === true) $this->tpl->draw("header");
 
 }
 
 //Vamos juntar as opções que forem passadas com os default (fazer um merge)
 
 
 private function setData($data = array())
 {
	foreach ($data as $key =>$value) {
		$this->tpl->assign($key, $value);
	} 
 } 
 
 public function setTpl($name, $data = array(), $returnHTML = false)
 {
	 $this->setData($data);
	 
	 return $this->tpl->draw($name, $returnHTML);
 }
 
 //Metodo destrutor - último a ser carregado
 public function __destruct() {

 //Se footer for true (todo site exceto página de login)	 
 if($this->options["footer"] === true) $this->tpl->draw("footer");
 
 }

}
?>