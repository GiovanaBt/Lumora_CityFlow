<?php

include 'Conexao.php';

/*
==================================================
  BUSCA EVENTOS QUE JÁ TERMINARAM
==================================================

Um evento só será considerado encerrado quando
A ÚLTIMA DATA do evento já tiver terminado.
*/

$sqlEventos = "
    SELECT
        e.*
    FROM eventos_cadastrados e

    WHERE EXISTS (
        SELECT 1
        FROM datas_evento d
        WHERE d.id_evento = e.id_evento
    )

    AND (
        SELECT MAX(
            TIMESTAMP(
                d.data_fim,
                d.horario_fim
            )
        )
        FROM datas_evento d
        WHERE d.id_evento = e.id_evento
    ) < NOW()
";

$resultado = mysqli_query($conexao, $sqlEventos);


/*
==================================================
  PROCESSA CADA EVENTO
==================================================
*/

while ($evento = mysqli_fetch_assoc($resultado)) {

    $idEvento = (int) $evento['id_evento'];

    /*
    ==============================================
      BUSCA AS DATAS E HORÁRIOS
    ==============================================
    */

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


    /*
    ==============================================
      TRANSFORMA DATAS EM JSON
    ==============================================
    */

    $datasJSON = json_encode(
        $datas,
        JSON_UNESCAPED_UNICODE
    );


    /*
    ==============================================
      INICIA TRANSAÇÃO
    ==============================================
    */

    mysqli_begin_transaction($conexao);

    try {

        /*
        ==========================================
          COPIA PARA O HISTÓRICO
        ==========================================
        */

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
                datas_evento,
                motivo
            )

            VALUES (
                ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,
                ?, ?, ?, ?, ?, ?, ?, ?
            )
        ";

        $stmtHistorico = mysqli_prepare(
            $conexao,
            $sqlHistorico
        );

        $motivo = "encerrado";

        mysqli_stmt_bind_param(
            $stmtHistorico,
            "iiissssssissssddsss",
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
            $datasJSON,
            $motivo
        );

        if (!mysqli_stmt_execute($stmtHistorico)) {

            throw new Exception(
                "Erro ao salvar no histórico."
            );

        }


        /*
        ==========================================
          REMOVE O EVENTO DO SITE
        ==========================================
        */

        $sqlExcluir = "
            DELETE FROM eventos_cadastrados
            WHERE id_evento = ?
        ";

        $stmtExcluir = mysqli_prepare(
            $conexao,
            $sqlExcluir
        );

        mysqli_stmt_bind_param(
            $stmtExcluir,
            "i",
            $idEvento
        );

        if (!mysqli_stmt_execute($stmtExcluir)) {

            throw new Exception(
                "Erro ao remover evento."
            );

        }


        /*
        ==========================================
          CONFIRMA
        ==========================================
        */

        mysqli_commit($conexao);

    } catch (Exception $erro) {

        /*
        ==========================================
          DESFAZ SE DER ERRO
        ==========================================
        */

        mysqli_rollback($conexao);

    }

}

?>