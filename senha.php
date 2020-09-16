 <?php
 /* Define as chaves (constantes) 'SECRET_IV' e 'SECRET', e armazena o valor da função 
 'pack()' dentro dela. A função converte uma string em 16 bits. Caso a senha tenha 
 menos ou mais de 16 caracteres (16 bits), usa-se a função para a conversão (para 16 caracteres) */ 
 define('SECRET_IV', pack('a16', 'senha'));
 define('SECRET', pack('a16', 'senha'));
 
 //Array 'data' com chave e valor armazenados
 $data = [
   "site" => "CriandoBits"
 ];
 
 $openss1 = openssl_encrypt (
 
 /* String a ser encriptada. Como a informação estava em um array, 
  foi necessário transformar o array em uma string 'json_encode()'*/
  json_encode($data),
  'AES-128-CBC', //Algoritmo usado
  SECRET, //1ª chave
  0, //Não retorna nada além da criptografia
 SECRET_IV //2ª chave
 );
 
 echo $openss1; //Mostra informação criptografada
 
 //Processo inverso (decriptografia)
 $string = openssl_decrypt($openss1, 'AES-128-CBC', SECRET, 0, SECRET_IV);
 
 //Mostra $string como array (true)
 var_dump(json_decode($string, true)); 
 
 ?>