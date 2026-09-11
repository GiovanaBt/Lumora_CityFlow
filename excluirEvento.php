<?php

session_start();

include 'Conexao.php';

/* =========================
   VERIFICA LOGIN
========================= */

if (!isset($_SESSION['usuario_id'])) {
    header("Location: index.php");
    exit();
}

$idUsuario = $_SESSION['usuario_id'];

/* =========================
   VERIFICA ID DO EVENTO
========================= */

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: editarMeusEventos.php");
    exit();
}

$idEvento = (int) $_GET['id'];

/* =========================
   BUSCA O EVENTO
   SOMENTE DO USUÁRIO LOGADO
========================= */

$sqlEvento = "
    SELECT
        e.*,
        c.categoria_evento
    FROM eventos_cadastrados e

    LEFT JOIN categoria c
        ON e.id_categoria = c.id_categoria

    WHERE e.id_evento = ?
    AND e.id_usuarios = ?
";

$stmtEvento = mysqli_prepare($conexao, $sqlEvento);

mysqli_stmt_bind_param(
    $stmtEvento,
    "ii",
    $idEvento,
    $idUsuario
);

mysqli_stmt_execute($stmtEvento);

$resultadoEvento = mysqli_stmt_get_result($stmtEvento);

$evento = mysqli_fetch_assoc($resultadoEvento);


/* =========================
   EVENTO NÃO ENCONTRADO
========================= */

if (!$evento) {

    $_SESSION['erro_evento'] = "Evento não encontrado.";

    header("Location: editarMeusEventos.php");

    exit();
}


/* =========================
   BUSCA DATAS DO EVENTO
========================= */

$sqlDatas = "
    SELECT
        data_inicio,
        data_fim,
        horario_inicio,
        horario_fim
    FROM datas_evento
    WHERE id_evento = ?
    ORDER BY data_inicio ASC
";

$stmtDatas = mysqli_prepare($conexao, $sqlDatas);

mysqli_stmt_bind_param(
    $stmtDatas,
    "i",
    $idEvento
);

mysqli_stmt_execute($stmtDatas);

$resultadoDatas = mysqli_stmt_get_result($stmtDatas);

$datas = [];

while ($data = mysqli_fetch_assoc($resultadoDatas)) {
    $datas[] = $data;
}


/* =========================
   CONVERTE DATAS PARA JSON
========================= */

$datasJSON = json_encode(
    $datas,
    JSON_UNESCAPED_UNICODE
);


/* =========================
   INICIA TRANSAÇÃO
========================= */

mysqli_begin_transaction($conexao);

try {

    /* =========================
       SALVA NO HISTÓRICO
    ========================= */

    $sqlHistorico = "
        INSERT INTO historico_eventos (
            id_evento_original,
            id_usuarios,
            id_categoria,
            titulo,
            subtitulo,
            descricao,
            descIMG,
            Imagem,
            rua,
            bairro,
            numero,
            cidade,
            CEP,
            ponto_referencia,
            latitude,
            longitude,
            classificacao_indicativa,
            datas_evento
        )
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ";

    $stmtHistorico = mysqli_prepare(
        $conexao,
        $sqlHistorico
    );

    mysqli_stmt_bind_param(
        $stmtHistorico,
        "iiissssssissssddss",
        $evento['id_evento'],
        $evento['id_usuarios'],
        $evento['id_categoria'],
        $evento['titulo'],
        $evento['subtitulo'],
        $evento['descricao'],
        $evento['descIMG'],
        $evento['Imagem'],
        $evento['rua'],
        $evento['bairro'],
        $evento['numero'],
        $evento['cidade'],
        $evento['CEP'],
        $evento['ponto_referencia'],
        $evento['latitude'],
        $evento['longitude'],
        $evento['classificacao_indicativa'],
        $datasJSON
    );

    if (!mysqli_stmt_execute($stmtHistorico)) {
        throw new Exception("Erro ao salvar o evento no histórico.");
    }


    /* =========================
       EXCLUI O EVENTO
    ========================= */

    $sqlExcluir = "
        DELETE FROM eventos_cadastrados
        WHERE id_evento = ?
        AND id_usuarios = ?
    ";

    $stmtExcluir = mysqli_prepare(
        $conexao,
        $sqlExcluir
    );

    mysqli_stmt_bind_param(
        $stmtExcluir,
        "ii",
        $idEvento,
        $idUsuario
    );

    if (!mysqli_stmt_execute($stmtExcluir)) {
        throw new Exception("Erro ao excluir o evento.");
    }


    /* =========================
       CONFIRMA TUDO
    ========================= */

    mysqli_commit($conexao);

    $_SESSION['sucesso_evento'] =
        "Evento excluído e enviado para o histórico.";

} catch (Exception $e) {

    /* =========================
       DESFAZ CASO DÊ ERRO
    ========================= */

    mysqli_rollback($conexao);

    $_SESSION['erro_evento'] =
        "Não foi possível excluir o evento.";
}


/* =========================
   VOLTA PARA MEUS EVENTOS
========================= */

header("Location: editarMeusEventos.php");

exit();

?>