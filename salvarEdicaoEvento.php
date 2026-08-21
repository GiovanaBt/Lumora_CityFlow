<?php

session_start();
include 'Conexao.php';


/* =========================================================
   SEGURANÇA
========================================================= */

if (!isset($_SESSION['usuario_id'])) {

    die("Você precisa estar logado.");
}

$idUsuario = (int) $_SESSION['usuario_id'];


/* =========================================================
   VERIFICAÇÃO DO EVENTO
========================================================= */

if (
    !isset($_POST['id_evento']) ||
    !is_numeric($_POST['id_evento'])
) {

    die("Evento inválido.");
}

$idEvento = (int) $_POST['id_evento'];


/* =========================================================
   CONFIRMA QUE O EVENTO PERTENCE AO USUÁRIO
========================================================= */

$sqlVerifica = "
SELECT id_evento, Imagem
FROM eventos_cadastrados
WHERE id_evento = ?
AND id_usuarios = ?
";

$stmtVerifica = mysqli_prepare(
    $conexao,
    $sqlVerifica
);

mysqli_stmt_bind_param(
    $stmtVerifica,
    "ii",
    $idEvento,
    $idUsuario
);

mysqli_stmt_execute($stmtVerifica);

$resultadoVerifica = mysqli_stmt_get_result(
    $stmtVerifica
);

$eventoAtual = mysqli_fetch_assoc(
    $resultadoVerifica
);

if (!$eventoAtual) {

    die("Você não tem permissão para editar este evento.");
}


/* =========================================================
   RECEBE OS DADOS DO FORMULÁRIO
========================================================= */

$tituloEvento = mysqli_real_escape_string(
    $conexao,
    $_POST['titulo'] ?? ''
);

$subtitulo = mysqli_real_escape_string(
    $conexao,
    $_POST['subtitulo'] ?? ''
);

$descricao = mysqli_real_escape_string(
    $conexao,
    $_POST['descricao'] ?? ''
);

$rua = mysqli_real_escape_string(
    $conexao,
    $_POST['rua'] ?? ''
);

$bairro = mysqli_real_escape_string(
    $conexao,
    $_POST['bairro'] ?? ''
);

$numero = mysqli_real_escape_string(
    $conexao,
    $_POST['numero'] ?? ''
);

$cidade = mysqli_real_escape_string(
    $conexao,
    $_POST['cidade'] ?? ''
);

$cep = mysqli_real_escape_string(
    $conexao,
    $_POST['CEP'] ?? ''
);

$pontoReferencia = mysqli_real_escape_string(
    $conexao,
    $_POST['ponto_referencia'] ?? ''
);


/* =========================================================
   CATEGORIA
========================================================= */

if (
    !isset($_POST['id_categoria']) ||
    !is_numeric($_POST['id_categoria'])
) {

    die("Categoria inválida.");
}

$categoriaId = (int) $_POST['id_categoria'];


/*
   Confirma que a categoria realmente existe
*/

$sqlCategoria = "
SELECT id_categoria
FROM categoria
WHERE id_categoria = ?
";

$stmtCategoria = mysqli_prepare(
    $conexao,
    $sqlCategoria
);

mysqli_stmt_bind_param(
    $stmtCategoria,
    "i",
    $categoriaId
);

mysqli_stmt_execute($stmtCategoria);

$resultCategoria = mysqli_stmt_get_result(
    $stmtCategoria
);

if (mysqli_num_rows($resultCategoria) === 0) {

    die("A categoria selecionada não existe.");
}


/* =========================================================
   CLASSIFICAÇÃO INDICATIVA
========================================================= */

$classificacaoIndicativa = mysqli_real_escape_string(
    $conexao,
    $_POST['classificacao_indicativa'] ?? 'Livre'
);


/* =========================================================
   LATITUDE E LONGITUDE
========================================================= */

$latitude = null;
$longitude = null;

if (
    isset($_POST['latitude']) &&
    $_POST['latitude'] !== ''
) {

    $latitude = mysqli_real_escape_string(
        $conexao,
        $_POST['latitude']
    );
}

if (
    isset($_POST['longitude']) &&
    $_POST['longitude'] !== ''
) {

    $longitude = mysqli_real_escape_string(
        $conexao,
        $_POST['longitude']
    );
}


/* =========================================================
   IMAGEM
========================================================= */

$nomeImagem = $eventoAtual['Imagem'];


/*
   Se uma nova imagem foi enviada,
   substitui a imagem anterior.
*/

if (
    isset($_FILES['Imagem']) &&
    $_FILES['Imagem']['error'] === UPLOAD_ERR_OK
) {

    $diretorio = "uploads/";

    if (!file_exists($diretorio)) {

        mkdir(
            $diretorio,
            0777,
            true
        );
    }


    $extensao = strtolower(
        pathinfo(
            $_FILES['Imagem']['name'],
            PATHINFO_EXTENSION
        )
    );


    $extensoesPermitidas = [
        'jpg',
        'jpeg',
        'png',
        'webp'
    ];


    if (
        !in_array(
            $extensao,
            $extensoesPermitidas
        )
    ) {

        die("Formato de imagem inválido.");
    }


    $novoNomeImagem =
        uniqid() . "." . $extensao;


    $caminhoNovaImagem =
        $diretorio . $novoNomeImagem;


    if (
        move_uploaded_file(
            $_FILES['Imagem']['tmp_name'],
            $caminhoNovaImagem
        )
    ) {

        /*
           Apaga a imagem antiga somente
           depois que a nova foi salva.
        */

        if (!empty($eventoAtual['Imagem'])) {

            $imagemAntiga =
                $eventoAtual['Imagem'];

            /*
               Caso o banco tenha apenas
               o nome do arquivo.
            */

            if (
                file_exists(
                    $diretorio . $imagemAntiga
                )
            ) {

                unlink(
                    $diretorio . $imagemAntiga
                );
            }

            /*
               Caso o banco tenha o caminho completo.
            */

            elseif (
                file_exists($imagemAntiga)
            ) {

                unlink($imagemAntiga);
            }
        }


        $nomeImagem =
            $novoNomeImagem;
    }
}


/* =========================================================
   ATUALIZA O EVENTO
========================================================= */

$sql = "
UPDATE eventos_cadastrados
SET

    id_categoria = ?,

    titulo = ?,

    subtitulo = ?,

    descricao = ?,

    classificacao_indicativa = ?,

    rua = ?,

    bairro = ?,

    numero = ?,

    cidade = ?,

    CEP = ?,

    ponto_referencia = ?,

    latitude = ?,

    longitude = ?,

    Imagem = ?

WHERE id_evento = ?
AND id_usuarios = ?
";


$stmt = mysqli_prepare(
    $conexao,
    $sql
);


mysqli_stmt_bind_param(
    $stmt,
    "isssssssssssssii",
    $categoriaId,
    $tituloEvento,
    $subtitulo,
    $descricao,
    $classificacaoIndicativa,
    $rua,
    $bairro,
    $numero,
    $cidade,
    $cep,
    $pontoReferencia,
    $latitude,
    $longitude,
    $nomeImagem,
    $idEvento,
    $idUsuario
);


/* =========================================================
   EXECUTA ATUALIZAÇÃO
========================================================= */

if (mysqli_stmt_execute($stmt)) {


    /* =====================================================
       DATAS DO EVENTO
    ===================================================== */

    if (
        isset($_POST['data_inicio']) &&
        is_array($_POST['data_inicio'])
    ) {

        $datasInicio =
            $_POST['data_inicio'];

        $datasFim =
            $_POST['data_fim'] ?? [];

        $horariosInicio =
            $_POST['horario_inicio'] ?? [];

        $horariosFim =
            $_POST['horario_fim'] ?? [];


        /*
           Remove as datas antigas.
        */

        $sqlExcluirDatas = "
        DELETE FROM datas_evento
        WHERE id_evento = ?
        ";

        $stmtExcluirDatas = mysqli_prepare(
            $conexao,
            $sqlExcluirDatas
        );

        mysqli_stmt_bind_param(
            $stmtExcluirDatas,
            "i",
            $idEvento
        );

        mysqli_stmt_execute(
            $stmtExcluirDatas
        );


        /*
           Insere novamente as datas.
        */

        for (
            $i = 0;
            $i < count($datasInicio);
            $i++
        ) {

            if (
                empty($datasInicio[$i]) ||
                empty($horariosInicio[$i]) ||
                empty($horariosFim[$i])
            ) {

                continue;
            }


            $dataInicio = $datasInicio[$i];

            $dataFim =
                !empty($datasFim[$i])
                ? $datasFim[$i]
                : $dataInicio;

            $horarioInicio =
                $horariosInicio[$i];

            $horarioFim =
                $horariosFim[$i];


            $sqlData = "
            INSERT INTO datas_evento (
                id_evento,
                data_inicio,
                data_fim,
                horario_inicio,
                horario_fim
            )
            VALUES (?, ?, ?, ?, ?)
            ";


            $stmtData = mysqli_prepare(
                $conexao,
                $sqlData
            );


            mysqli_stmt_bind_param(
                $stmtData,
                "issss",
                $idEvento,
                $dataInicio,
                $dataFim,
                $horarioInicio,
                $horarioFim
            );


            mysqli_stmt_execute(
                $stmtData
            );
        }
    }


    /* =====================================================
       SUCESSO
    ===================================================== */

    echo "

    <script>

        alert('Evento atualizado com sucesso!');

        window.location.href =
            'editarMeusEventos.php';

    </script>

    ";


} else {

    echo "

    <script>

        alert('Erro ao atualizar o evento.');

        window.history.back();

    </script>

    ";

    echo "<br>Erro: " .
        mysqli_error($conexao);
}


mysqli_close($conexao);

?>