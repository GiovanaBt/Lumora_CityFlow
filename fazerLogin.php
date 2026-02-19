<?php
session_start();
include 'Conexao.php';

$emailLogin = $_POST['emailLogin'];
$senhaLogin = $_POST['senhaLogin'];

$sql = "SELECT * FROM Usuarios 
        WHERE email = '$emailLogin' 
        AND senha = '$senhaLogin'";

$resultado = $conexao->query($sql);

if ($resultado->num_rows > 0) {
    $usuario = $resultado->fetch_assoc();

    $_SESSION['usuario_id'] = $usuario['id_usuarios'];
    $_SESSION['nome_usuario'] = $usuario['nome_usuario'];


    header("Location: index.php");
    exit();
} else {
    // Login inválido
    header("Location: index.php?erro=1");
    exit();
}

?>