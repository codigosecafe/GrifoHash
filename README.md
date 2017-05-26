#grifo-hash-php
Espero que possa ajudar como o hashing das senhas do seu sistema

## Sobre o Grifo
Grifo é uma classe PHP para gerar hashing de senha e validação da mesma.
A classe Grifo tem esse nome como sinonimo da palavra enigma inspirado no filme **O Jogo da Imitação**. 
Com uma ideia bem simples, de juntar alguns metodos de codificação e geração de hash para tornar a senha um pouco mais segura do que utilizar apenas um método como MD5, SHA-1 SHA-256 ou SHA-512. Esse métodos cumprem o que promete mas são notavelmente inseguros. A classe Grifo além de usuflir de alguns desses métodos finaliza a criptografia com o padrão  bcrypt/blowfish. 
Recomendo a leitura do artigo em inglês: [https://en.wikipedia.org/wiki/Bcrypt](https://en.wikipedia.org/wiki/Bcrypt)
---
## Adcionando a classe Grifo no meu projeto
Para adicionar a classe basta incluir em seu arquivo através do método include_once(); Ex.:
```php
<?php 
// Importo a classe
include_once 'grifo.class.php';
// Instancio a classe Grifo
$grifo = new Grifo();
```
---
## Principais métodos da classe Grifo
#### make_password()
Método responsável por gerar o hashing da senha que será armazenada no banco de dados. Indenpedente da senha sempre será gerado um hashing unico. Bom lembrar que o hash sempre será composto de 60 caracteres, então você pode definir a sua coluna que armazena a senha com CHAR(60) ou VARCHAR(60), claro se você estiver usando o MySQL. ;)
##### Criptografando senhas
Para criptografar a senha basta atribuir o valor digitado pelo usuario a uma variavel e execultar o método make_password(). Ex.:
```php
<?php 
// Senha digitada pelo usuario
$senha_digitada = '1q2w3e4r'; // a senha pode ser coletada via o método $_POST ou $_GET
// Gero o hashing da senha para ser salva no banco de dados
$senha_gerada = $grifo::make_password($senha_digitada);
// Agora basta armazenar o valor da variavel $senha_gerada no campo senha da tabela do seu banco de dados
```
#### check_pass()
Método responsável por comparar e validar o hashing da senha. Já que você estamos trabalhando com um hashing gerado aleatoriamente, seria impossível gerar um novo hash indentico ao hash que está no banco. mas o método bcrypt/blowfish permite que eu consiga validar a senha. Ex:.
```php
<?php 
// Para comparar a senha digitada com a senha salva no bando de dados
// primeiro devo buscar a senha a ser comparada no banco
// e atribuir ela a uma variavel 
$senha_DB = '$2a$08$MTU4NDc5MDAxNDU5Mjc5Z.Nx0ZOYEiUDaOpyEMHZNNUYuJDHRgzI2'; // Senha salva no banco de dados com 60 caracters

// Agora basta rodar o metodo de checagem dos hashing
if ($grifo::check_pass($senha_digitada, $senha_DB)) {
	echo 'Senha OK!';
} else {
	echo 'Senha incorreta!';
}
```
###### Obs.: Caso tenha coriosidade como funciona todos os métodos da classe você pode ler o códigos font no arquivo grifo.class.php na pasta class.
---

Author: Claudio Alexssandro Lino <claudio@codigosecafe.com.br>

[https://www.facebook.com/codigosecafe.agencia.digital/](https://www.facebook.com/codigosecafe.agencia.digital/)

[http://codigosecafe.com.br/](http://codigosecafe.com.br/)
