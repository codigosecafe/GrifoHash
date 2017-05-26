<?php 

// Importo a classe
include_once 'class/grifo.class.php';
// Instancio a classe Grifo
$grifo = new Grifo();

//####################################################################// 

// Senha digitada pelo usuario
$senha_digitada = '1q2w3e4r'; // a senha pode ser coletada via o método $_POST ou $_GET

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

