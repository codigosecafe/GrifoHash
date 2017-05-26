<?php

/**
 * Grifo classe hash para senha
 * 
 * @author Claudio Alexssandro Lino <claudio@codigosecafe.com.br>
 * @link   https://github.com/codigosecafe/grifo-hash-php
 */
class Grifo
{

	protected static $Prefix_salt;
	protected static $Cost_default;
	protected static $Length_salt;
	protected static $_token;

    /**
     * inicia a classe Grifo e defino os seus valores padrao
     */
    public function __construct($Prefix_salt = '2a', $Cost_default = 8, $Length_salt = 22)
    {

    	self::$Prefix_salt = $Prefix_salt;
        self::$Cost_default = $Cost_default;
        self::$Length_salt = $Length_salt;


        $tokenBase = self::hashBase64($_SERVER ['SERVER_NAME']);
    	self::$_token = crypt( $tokenBase , self::$Prefix_salt );

    }
    /**
    * Método para gerar a senha a ser salva no banco de dados
    *
    * @param  $password
    * @return string
    *
    **/
    public static function make_password($password='')
    {	
    	// Gero a string que sera usada pelo metodo crypt
   		$strig_pass = self::makeStringPass($password);
   		// Defino uma seqüência de hash para ser usada pelo crypt no padrao Blowfish
   		$_hashbase = sprintf('$%s$%02d$%s$', self::$Prefix_salt, self::$Cost_default, $strig_pass);
   		// Encripta 
   		return crypt($strig_pass, $_hashbase);

    }

    /**
    * Método para comparar a senha digitada com a senha do banco de dados
    *
    * @param  $password, $passwordDB
    * @return boolean
    *
    **/
    public static function check_pass($password, $passwordDB)
    {	// Gero a string que sera usada pelo metodo crypt
    	$password = self::makeStringPass($password);
    	// Checo se a senha da variavel password é a mesma da variavel passwordDB
    	return (crypt($password, $passwordDB) === $passwordDB);
    }

    /**
    * Método para criar uma string codificada com o padrao base64
    *
    * @param  $base
    * @return string
    *
    **/

    private static function hashBase64($base)
    {
    	// Codifico a string atraves do metodo base64_encode
    	$base = base64_encode($base);
    	// Substituo o sinal de + para que fique no padrão aceitavel pelo Blowfish
        $base = str_replace('+', '.', $base);
        // retorno a string gerada
        return $base;
    }

    /**
    * Método para criar a string que sera usada como base da senha criptografada
    *
    * @param  $var
    * @return string
    *
    **/

     private static function makeStringPass($password='')
    {
    	// Retorno a senha codificada pelo metodo hashBase64
   		$Base64 = self::hashBase64($password);
   		// Converto a senha para uma hash md5 
   		$_md5 = md5($Base64);
   		// Adciono mais uma camada agora utilizando o metodo hash com o padrao sha256
   		$_hash256 = hash('sha256',$_md5);
   		// Adciono mais uma camada agora utilizando o metodo hash com o padrao sha512
   		$_hash512 = hash('sha512',$_hash256);
   		// Inverto o hash criado e contateno com o token utilizado pela classe
   		return strrev($_hash512).self::$_token;	
    }

    

}