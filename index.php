<?php 

// Importo a classe
include_once 'grifo.class.php';


// Senha digitada pelo usuario
$senha_digitada = '1q2w3e4r';



// Instancio a classe Grifo
$grifo = new Grifo();
// Gero a senha para ser salva no banco de dados
$senha_gerada = $grifo::make_password($senha_digitada);
// Agora basta pegar o resultado armazenado na variavel $senha_gerada e salvar no banco de dados




//####################################################################// 

// para comparar a senha digitada com a senha salva no bando de dados
// primeiro devo buscar a senha a ser comparada no banco
// e atribuir ela a uma variavel 

// Senha salva no banco de dados com 60 caracters
$senha_DB = '$2a$08$9c938da6c419eb032f001Oa.Z5Sg8m6OxLWp7DIEW0I5zLIr0CCsa';


// Agora basta rodar o metodo de checagem dos dados
if ($grifo::check_pass($senha_digitada, $senha_DB)) {
	echo 'Senha OK!';
} else {
	echo 'Senha incorreta!';
}

