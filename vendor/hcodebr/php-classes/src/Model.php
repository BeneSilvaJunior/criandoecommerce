<?php

namespace Hcode;

class Model {

 //Valores dos campos contidos no objeto (ex. USUARIO: id, nome, usuario, senha etc)
 private $values = [];

 //Método mágico "__call" para quando o objeto da classe for instanciado - verifica se é método get ou set
 public function __call($name, $args)
 {
   //Tipo do método - define os 3 primeiros caracteres do nome do método (ex.: getNome = 'get', setIdade = 'set')
   $method = substr($name, 0, 3);
   
   //Nome do campo que foi chamado - define do 3º carcatere até o último (ex.: getNome = 'Nome', setIdade = 'Idade')
   $fieldName = substr($name, 3, strlen($name));
   
   //var_dump($method, $fieldName);
   //exit;
   
   //Verifica o método (get ou set)
   switch ($method)
   {
   case "get": //se get, retorna o nome do campo
   		return $this->values[$fieldName];
	break;
	case "set": //se set, atribui o valor de args[0] para o nome do campo
		$this->values[$fieldName] = $args[0];
	break;
   }
 }
 
 /* a função "setData" consulta o banco, armazena os nomes dos campos em um array e crie os métodos "get" e "set" dinamicamente.
 	Ex.: array [nome, idade, sexo ...] --> setNome, setIdade, setSexo... 
 */
 public function setData($data = array())
 {
	 foreach ($data as $key => $value) {
		  
		 //Forma os nomes dos métodos get/set - neste caso "set" + nome do campo. Ex.: setNome... e passa o valor "$value" ao método
		 $this->{"set".$key}($value);
	 }
 }
 
 
 public function getValues()
 {
	 return $this->values;
 }


}

?>