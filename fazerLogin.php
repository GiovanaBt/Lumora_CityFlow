<?php
session_start();

/* PROTEÇÃO */
if (!isset($_POST['emailLogin']) || !isset($_POST['senhaLogin'])) {
    header("Location: index.php");
    exit();
}

/* CONEXÃO */
$conn = new mysqli("localhost", "root", "Home@spSENAI2025!", "cityflow");

/* DADOS */
$email = $_POST['emailLogin'];
$senhaLogin = $_POST['senhaLogin'];

/* QUERY */
$sql = "SELECT * FROM usuarios WHERE email = ? AND senha = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $email, $senhaLogin);
$stmt->execute();

$resultado = $stmt->get_result();

if ($resultado->num_rows == 1) {

    $usuario = $resultado->fetch_assoc();

    $_SESSION['usuario_id'] = $usuario['id_usuarios'];
    $_SESSION['nome_usuario'] = $usuario['nome_usuario'];

    unset($_SESSION['erro_login']); // 🔥 IMPORTANTE

    header("Location: index.php");
    exit();

} else {

    $_SESSION['erro_login'] = "Usuário ou senha incorretos";

    header("Location: index.php");
    exit();
}
?>