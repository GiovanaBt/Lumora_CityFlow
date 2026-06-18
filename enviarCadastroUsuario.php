ENVIAR CADASTRO EVENTO 
<?php
session_start();
include 'Conexao.php';

$nomeCompleto = $_POST['nomeCompleto'];
$dataNascimento = $_POST['dataNascimento'];
$email = $_POST['email'];
$senha = $_POST['senha'];
$confirmarSenha = $_POST['confirmarSenha'];
$nomeUsuario = $_POST['nomeUsuario'];
$cpf = $_POST['cpf'];
$telefone = $_POST['telefone'];

if ($senha !== $confirmarSenha) {
    echo "<script>
            alert('As senhas não coincidem!');
            window.history.back();
          </script>";
    exit;
}

$sql = "INSERT INTO usuarios (
    nome_completo,
    data_nascimento,
    cpf,
    telefone,
    email,
    senha,
    nome_usuario
) VALUES (
    '$nomeCompleto',
    '$dataNascimento',
    '$cpf',
    '$telefone',
    '$email',
    '$senha',
    '$nomeUsuario'
)";

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