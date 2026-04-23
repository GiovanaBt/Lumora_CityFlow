<?php
session_start();
include 'Conexao.php';

if (!isset($_SESSION['usuario_id'])) {
    echo "login";
    exit;
}

$id_usuario = $_SESSION['usuario_id'];
$id_evento = $_POST['id_evento'];

// Verifica se já existe
$check = mysqli_query($conexao, "
    SELECT * FROM atividade 
    WHERE id_usuarios = '$id_usuario' 
    AND id_evento = '$id_evento'
");

if (mysqli_num_rows($check) > 0) {
    echo "ja_participou";
    exit;
}

// Insere participação
mysqli_query($conexao, "
    INSERT INTO atividade (id_usuarios, id_evento, id_categoria)
    VALUES ('$id_usuario', '$id_evento', 1)
");

echo "ok";