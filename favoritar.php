<?php
session_start();
include "Conexao.php";

if (!isset($_SESSION['usuario_id'])) {
    echo "login";
    exit;
}

$id_usuario = $_SESSION['usuario_id'];
$id_evento = $_POST['id_evento'];

// VERIFICA SE JÁ EXISTE
$check = mysqli_query($conexao, "
    SELECT * FROM favoritos 
    WHERE id_usuario = '$id_usuario' 
    AND id_evento = '$id_evento'
");

if (mysqli_num_rows($check) > 0) {

    // ❌ REMOVE DOS FAVORITOS
    mysqli_query($conexao, "
        DELETE FROM favoritos 
        WHERE id_usuario = '$id_usuario' 
        AND id_evento = '$id_evento'
    ");

    echo "removido";

} else {

    // ⭐ ADICIONA FAVORITO
    mysqli_query($conexao, "
        INSERT INTO favoritos (id_usuario, id_evento)
        VALUES ('$id_usuario', '$id_evento')
    ");

    echo "ok";
}
?>