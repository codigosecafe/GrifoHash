<?php

/**
 * Grifo é uma classe PHP para gerar hashing de senha e validação da mesma.
 * A classe Grifo tem esse nome como sinonimo da palavra enigma inspirado no filme **O Jogo da Imitação**. 
 * Com uma ideia bem simples, de juntar alguns metodos de codificação e geração de hash para tornar a senha 
 * um pouco mais segura do que utilizar apenas um método como MD5, SHA-1 SHA-256 ou SHA-512. 
 * Esses métodos cumprem o que promete mas são notavelmente inseguros. 
 * A classe Grifo além de usuflir de alguns desses métodos finaliza o hashing com o padrão  bcrypt/blowfish.  
 * Recomendo a leitura do artigo em inglês: [https://en.wikipedia.org/wiki/Bcrypt](https://en.wikipedia.org/wiki/Bcrypt)
 * 
 * @author Claudio Alexssandro Lino <claudio@codigosecafe.com.br>
 * @link   https://github.com/codigosecafe/grifo-hash-php
 * @date 26/05/2017
 */
class Grifo
{

	protected static $Prefix_salt = '2a'; // isso habilita o blowfish para que seja usado
	protected static $Cost_default = '12';
	
	protected static $_token;

    /**
     * inicia a classe Grifo e defino o token a ser usado como padrao
     */
    public function __construct()
    {

        $tokenBase = self::hashBase64($_SERVER ['SERVER_NAME']);
    	self::$_token = crypt( $tokenBase , self::$Prefix_salt );

    }
    /**
    * Método responsável por gerar o hashing da senha que será armazenada no banco de dados. 
    * Indenpedente da senha sempre será gerado um hashing unico. Bom lembrar que o hash sempre será composto de 60 caracteres, 
    * então você pode definir a sua coluna que armazena a senha com CHAR(60) ou VARCHAR(60), claro se você estiver usando o MySQL. ;)
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
   		$_hashbase = sprintf('$%s$%02d$%s$', self::$Prefix_salt, self::$Cost_default, self::hashBase64('', true));
   		// Encripta 
   		return crypt($strig_pass, $_hashbase);

    }

    /**
    * Método responsável por comparar e validar o hashing da senha. 
    * Já que você estamos trabalhando com um hashing gerado aleatoriamente, seria impossível 
    * gerar um novo hash indentico ao hash que está no banco. mas o método bcrypt/blowfish permite que eu consiga validar a senha.
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

    private static function hashBase64($base, $randon = false)
    {
    	if ($randon):
    		$base = uniqid(mt_rand(), true);
    	endif;
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