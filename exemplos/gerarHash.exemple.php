<?php 

// Importo a classe
include_once '../class/grifo.class.php';
// Instancio a classe Grifo
$grifo = new Grifo();

//####################################################################// 



// Senha digitada pelo usuario
$senha_digitada = '1q2w3e4r'; // a senha pode ser coletada via o método $_POST ou $_GET
// Gero o hashing da senha para ser salva no banco de dados
$senha_gerada = $grifo::make_password($senha_digitada);
// Agora basta armazenar o valor da variavel $senha_gerada no campo senha da tabela do seu banco de dados
echo "Senha gerada com hashing aleatorio e unico<br/>";
echo "<b>$senha_gerada</b>";
echo "<br/>Se a pagina for atualizada sera gerado outro hash<br/>";