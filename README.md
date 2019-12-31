# GrifoHash
Espero que possa ajudar como o hashing das senhas do seu sistema. Essa classe foi criada e testada no laravel.

Instalação
```
composer require codigosecafe/grifo-hash
```

## Sobre a classe GrifoHash
GrifoHash é uma classe PHP para gerar hashing de senha e validação.
A classe GrifoHash tem esse nome como sinonimo da palavra enigma inspirado no filme **O Jogo da Imitação**. 
Com uma ideia bem simples, de juntar alguns metodos de codificação e geração de hash para tornar a senha um pouco mais segura do que utilizar apenas um método como MD5, SHA-1 SHA-256 ou SHA-512. Esses métodos cumprem o que promete mas são notavelmente inseguros. A classe GrifoHash além de usufruir de alguns desses métodos finaliza o hashing com o padrão  bcrypt/blowfish. 

###### Recomendo a leitura do artigo em inglês: [https://en.wikipedia.org/wiki/Bcrypt](https://en.wikipedia.org/wiki/Bcrypt)
---
## Adcionando a classe GrifoHash no meu projeto
Para adicionar a classe basta importala para o seu projeto através do método **"use"**. Ex.:
```php
<?php 
use codigosecafe\GrifoHash;
```
---
## Principais métodos da classe GrifoHash
#### ::make_password()
Método responsável por gerar o hashing da senha que será armazenada no banco de dados. Indenpedente da senha sempre será gerado um hashing unico. Bom lembrar que o hash sempre será composto de 60 caracteres, então você pode definir a sua coluna que armazena a senha com CHAR(60) ou VARCHAR(60), claro se você estiver usando o MySQL/MariaDB. ;)
##### Criptografando senhas
Para criptografar a senha basta atribuir o valor digitado pelo usuario a uma variavel e execultar o método make_password(). Ex. Testado no Laravel:
```php
<?php
namespace App\Http\Controllers;

use codigosecafe\GrifoHash;

class meuController extends Controller {

    public static function index() {

      // Instancio a classe GrifoHash
      $GrifoHash = new GrifoHash();

      //####################################################################// 

      // Senha digitada pelo usuario
      $senha_digitada = '1q2w3e4r'; // a senha pode ser coletada via o método $_POST ou $_GET
      // Gero o hashing da senha para ser salva no banco de dados
      $senha_gerada = $GrifoHash::make_password($senha_digitada);
      // Agora basta armazenar o valor da variavel $senha_gerada no campo senha da tabela do seu banco de dados
      echo "Senha gerada com hashing aleatorio e unico<br/>";
      echo "<b>$senha_gerada</b>";
      echo "<br/>Se a pagina for atualizada sera gerado outro hash<br/>";

    }

}

```
#### ::check_pass()
Método responsável por comparar e validar o hashing da senha. Já que estamos trabalhando com um hashing gerado aleatoriamente, seria impossível gerar um novo hash indentico ao hash que está no banco. mas o método bcrypt/blowfish permite que eu consiga validar a senha. Ex. Testado no Laravel:
```php
<?php
namespace App\Http\Controllers;

use codigosecafe\GrifoHash;

class meuController extends Controller {

    public static function index() {

    	// Instancio a classe GrifoHash
      $GrifoHash = new GrifoHash();

      //####################################################################// 

      // Senha digitada pelo usuario
      $senha_digitada = '1q2w3e4r'; // a senha pode ser coletada via o método $_POST ou $_GET

      // Para comparar a senha digitada com a senha salva no bando de dados
      // primeiro devo buscar a senha a ser comparada no banco
      // e atribuir ela a uma variavel 
      $senha_DB = '$2a$08$MTU4NDc5MDAxNDU5Mjc5Z.Nx0ZOYEiUDaOpyEMHZNNUYuJDHRgzI2'; // Senha salva no banco de dados com 60 caracters

      // Agora basta rodar o metodo de checagem dos hashing
      if ($GrifoHash::check_pass($senha_digitada, $senha_DB)) {
          echo 'Senha OK!';
      } else {
          echo 'Senha incorreta!';
      }

    }

}


```
###### Obs.: Caso tenha coriosidade como funciona todos os métodos da classe você pode ler o códigos font no arquivo src/GrifoHash/GrifoHash.php.
---

# Author: Claudio Alexssandro Lino

>Sou Full Stack Developer gosto de atuar em todas as fazes dos projetos, desde a criação do wireframe, configuração do servidor, planejamento das historias através dos métodos ágeis, codificação do backend e frontend. 
>
>Tenho experiência no frameworks Laravel (4 anos). Exerci varias funções dentro da minha profissão que qualificou a ser um Full Stack Developer , executei vários trabalhos como Web Design, Ilustrador WEB, Gerente de Media Social, Consultor SEO voltado para estrutura HTML, Desenvolvimento back-end para aplicações Web e Desktop, configuração e manutenção de servidores web baseado em linux. 
>

>Especializações: PHP, AngularJS, MySQL, PostgreSQL, MariaDB, Framework PHP Laravel, Intel® XDK, Ionic, Smarty Template - Blade Template - Bootstrap - Framework PHP CodeIgniter, Wordpress, Linux, Java Script, Jquery junto com Ajax, GIT e Vagrant.

---
> codigosecafe+git@gmail.com | Skype: claudio.alexssandro | https://www.linkedin.com/in/claudioalexssandrolino/
---

