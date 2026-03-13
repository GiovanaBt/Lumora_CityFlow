<?php
session_start();

/* CONEXÃO COM BANCO */
$host = "localhost";
$usuario = "root";
$senha = "Home@spSENAI2025!";
$banco = "cityflow";

$conn = new mysqli($host, $usuario, $senha, $banco);

if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

/* RECEBER DADOS DO FORM */
$email = $_POST['emailLogin'];
$senhaLogin = $_POST['senhaLogin'];

/* QUERY SEGURA */
$sql = "SELECT * FROM usuarios WHERE email = ? AND senha = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $email, $senhaLogin);

$stmt->execute();

$resultado = $stmt->get_result();

if ($resultado->num_rows == 1) {

    $usuario = $resultado->fetch_assoc();

    $_SESSION['usuario_id'] = $usuario['id_usuarios'];
    $_SESSION['nome_usuario'] = $usuario['nome_usuario'];

    header("Location: index.php");
    exit();

} else {

    $_SESSION['erro_login'] = "Usuário ou senha incorretos";

    header("Location: index.php");
    exit();
}
?>