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
   VERIFICA SE O EVENTO EXISTE
========================================= */

$evento = mysqli_query($conexao, "
    SELECT id_categoria
    FROM eventos_cadastrados
    WHERE id_evento = '$id_evento'
");

if (!$evento || mysqli_num_rows($evento) == 0) {
    echo "evento_inexistente";
    exit;
}

$dadosEvento = mysqli_fetch_assoc($evento);

$id_categoria = $dadosEvento['id_categoria'];

/* =========================================
   VERIFICA SE JÁ PARTICIPA
========================================= */

$check = mysqli_query($conexao, "
    SELECT id_atividade
    FROM atividade
    WHERE id_usuarios = '$id_usuario'
    AND id_evento = '$id_evento'
");

if (!$check) {
    echo "erro";
    exit;
}

/* =========================================
   JÁ PARTICIPA → DESPARTICIPA
========================================= */

if (mysqli_num_rows($check) > 0) {

    $delete = mysqli_query($conexao, "
        DELETE FROM atividade
        WHERE id_usuarios = '$id_usuario'
        AND id_evento = '$id_evento'
    ");

    if ($delete) {
        echo "desparticipou";
    } else {
        echo "erro";
    }

    exit;
}

/* =========================================
   NÃO PARTICIPA → PARTICIPA
========================================= */

$insert = mysqli_query($conexao, "
    INSERT INTO atividade
    (
        id_usuarios,
        id_evento,
        id_categoria
    )
    VALUES
    (
        '$id_usuario',
        '$id_evento',
        '$id_categoria'
    )
");

if ($insert) {
    echo "ok";
} else {
    echo "erro";
}

exit;