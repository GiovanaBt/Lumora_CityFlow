<?php
$host = 'localhost';
$usuario = 'root';
$senha = 'Home@spSENAI2025!';
$banco = 'CityFlow';

$conexao = new mysqli($host, $usuario, $senha, $banco);

if ($conexao->connect_error) {
    die("Erro na Conexão: ". $conexao->connect_error);
}
else {
    echo "Conectado com sucesso!<br>";
}
?>