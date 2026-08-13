<?php

include 'Conexao.php';

session_start();


/* =========================================================
   SEGURANÇA
========================================================= */

if (!isset($_SESSION['usuario_id'])) {

    die("Você precisa estar logado.");
}

$idUsuario = $_SESSION['usuario_id'];


/* =========================================================
   VERIFICAÇÃO DO EVENTO
========================================================= */

if (
    !isset($_POST['id_evento']) ||
    !is_numeric($_POST['id_evento'])
) {

    die("Evento inválido.");
}

$idEvento = (int)$_POST['id_evento'];


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

$resultadoVerifica =
    mysqli_stmt_get_result($stmtVerifica);

$eventoAtual =
    mysqli_fetch_assoc($resultadoVerifica);


if (!$eventoAtual) {

    die("Você não tem permissão para editar este evento.");
}


/* =========================================================
   DADOS DO EVENTO
========================================================= */

$tituloEvento =
    mysqli_real_escape_string(
        $conexao,
        $_POST['nome']
    );

$descricao =
    mysqli_real_escape_string(
        $conexao,
        $_POST['descricao']
    );

$rua =
    mysqli_real_escape_string(
        $conexao,
        $_POST['rua']
    );

$bairro =
    mysqli_real_escape_string(
        $conexao,
        $_POST['bairro']
    );

$numero =
    mysqli_real_escape_string(
        $conexao,
        $_POST['numero']
    );

$cidade =
    mysqli_real_escape_string(
        $conexao,
        $_POST['cidade']
    );

$cep =
    mysqli_real_escape_string(
        $conexao,
        $_POST['cep']
    );

$pontoReferencia =
    mysqli_real_escape_string(
        $conexao,
        $_POST['ponto_referencia']
    );

$categoriaId =
    (int)$_POST['categorias'];


/* =========================================================
   CLASSIFICAÇÃO INDICATIVA
========================================================= */

$classificacaoIndicativa =
    mysqli_real_escape_string(
        $conexao,
        $_POST['classificacao']
    );


/* =========================================================
   LATITUDE E LONGITUDE
========================================================= */

$latitude = isset($_POST['latitude'])
    ? mysqli_real_escape_string(
        $conexao,
        $_POST['latitude']
    )
    : null;

$longitude = isset($_POST['longitude'])
    ? mysqli_real_escape_string(
        $conexao,
        $_POST['longitude']
    )
    : null;


/* =========================================================
   IMAGEM
========================================================= */

$nomeImagem = $eventoAtual['Imagem'];


/*
   Se o usuário escolher uma nova imagem,
   substitui a imagem anterior.
*/

if (
    isset($_FILES['capa']) &&
    $_FILES['capa']['error'] == 0
) {

    $diretorio = "uploads/";

    if (!file_exists($diretorio)) {

        mkdir(
            $diretorio,
            0777,
            true
        );
    }


    $extensao = pathinfo(
        $_FILES['capa']['name'],
        PATHINFO_EXTENSION
    );


    $nomeImagem =
        uniqid() . "." . $extensao;


    move_uploaded_file(
        $_FILES['capa']['tmp_name'],
        $diretorio . $nomeImagem
    );


    /*
       Apaga a imagem antiga,
       se existir.
    */

    if (
        !empty($eventoAtual['Imagem']) &&
        file_exists($eventoAtual['Imagem'])
    ) {

        unlink($eventoAtual['Imagem']);
    }
}


/* =========================================================
   ATUALIZA EVENTO
========================================================= */

$sql = "
UPDATE eventos_cadastrados
SET

    id_categoria = '$categoriaId',

    titulo = '$tituloEvento',

    descricao = '$descricao',

    classificacao_indicativa =
        '$classificacaoIndicativa',

    rua = '$rua',

    bairro = '$bairro',

    numero = '$numero',

    cidade = '$cidade',

    CEP = '$cep',

    ponto_referencia =
        '$pontoReferencia',

    latitude = " .
    ($latitude !== null
        ? "'$latitude'"
        : "NULL"
    ) . ",

    longitude = " .
    ($longitude !== null
        ? "'$longitude'"
        : "NULL"
    ) . ",

    Imagem = '$nomeImagem'

WHERE id_evento = '$idEvento'
AND id_usuarios = '$idUsuario'
";


/* =========================================================
   EXECUTA ATUALIZAÇÃO
========================================================= */

if ($conexao->query($sql)) {


    /* =====================================================
       ATUALIZA DATAS
    ===================================================== */

    if (
        isset($_POST['datas']) &&
        isset($_POST['horas_inicio']) &&
        isset($_POST['horas_fim'])
    ) {

        $datas =
            $_POST['datas'];

        $horasInicio =
            $_POST['horas_inicio'];

        $horasFim =
            $_POST['horas_fim'];


        /*
           Remove as datas antigas
        */

        $sqlExcluirDatas = "
        DELETE FROM datas_evento
        WHERE id_evento = '$idEvento'
        ";

        $conexao->query(
            $sqlExcluirDatas
        );


        /*
           Insere novamente as datas
        */

        for (
            $i = 0;
            $i < count($datas);
            $i++
        ) {

            $data =
                mysqli_real_escape_string(
                    $conexao,
                    $datas[$i]
                );

            $horaInicio =
                mysqli_real_escape_string(
                    $conexao,
                    $horasInicio[$i]
                );

            $horaFim =
                mysqli_real_escape_string(
                    $conexao,
                    $horasFim[$i]
                );


            $sqlData = "
            INSERT INTO datas_evento (

                id_evento,
                data_inicio,
                data_fim,
                horario_inicio,
                horario_fim

            )

            VALUES (

                '$idEvento',
                '$data',
                '$data',
                '$horaInicio',
                '$horaFim'

            )
            ";


            $conexao->query(
                $sqlData
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
        $conexao->error;
}


$conexao->close();

?>