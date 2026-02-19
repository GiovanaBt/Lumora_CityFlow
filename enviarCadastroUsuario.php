<?php
session_start();
include 'Conexao.php';

$nomeCompleto = $_POST['nomeCompleto'];
$dataNascimento = $_POST['dataNascimento'];
$email = $_POST['email'];
$senha = $_POST['senha'];
$nomeUsuario = $_POST['nomeUsuario'];

$sql = "INSERT INTO Usuarios (nome_completo, data_nascimento, email, senha, nome_usuario) VALUES 
        ('$nomeCompleto', '$dataNascimento', '$email', '$senha', '$nomeUsuario')";

if ($conexao->query($sql) === TRUE) {
    $idUsuario = $conexao->insert_id;

    $_SESSION['usuario_id'] = $idUsuario;
    $_SESSION['nome_usuario'] = $nomeUsuario;
    $_SESSION['nome_completo'] = $nomeCompleto;

    echo "<script>
            window.location.href = 'index.php';
          </script>";

} else {
    echo "Erro: " . $conexao->error;
}

$conexao->close();
?>
