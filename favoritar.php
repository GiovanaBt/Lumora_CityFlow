<?php

session_start();
include "Conexao.php";

if (!isset($_SESSION['usuario_id'])) {
    echo "login";
    exit;
}

$id_usuario = $_SESSION['usuario_id'];
$id_evento = $_POST['id_evento'] ?? 0;

if (!$id_evento) {
    echo "erro";
    exit;
}

/* =========================================
   VERIFICA SE JÁ É FAVORITO
========================================= */

$check = mysqli_query($conexao, "
    SELECT id_favorito
    FROM favoritos
    WHERE id_usuario = '$id_usuario'
    AND id_evento = '$id_evento'
");

if (!$check) {
    echo "erro";
    exit;
}

/* =========================================
   JÁ É FAVORITO → DESFAVORITA
========================================= */

if (mysqli_num_rows($check) > 0) {

    $delete = mysqli_query($conexao, "
        DELETE FROM favoritos
        WHERE id_usuario = '$id_usuario'
        AND id_evento = '$id_evento'
    ");

    if ($delete) {
        echo "removido";
    } else {
        echo "erro";
    }

    exit;
}

/* =========================================
   NÃO É FAVORITO → FAVORITA
========================================= */

$insert = mysqli_query($conexao, "
    INSERT INTO favoritos
    (
        id_usuario,
        id_evento
    )
    VALUES
    (
        '$id_usuario',
        '$id_evento'
    )
");

if ($insert) {
    echo "ok";
} else {
    echo "erro";
}

exit;