<?php

include 'Conexao.php';

session_start();

/* SEGURANÇA */

if (!isset($_SESSION['usuario_id'])) {

    die("Você precisa estar logado.");

}

/* IMAGEM */

$nomeImagem = "";

if (
    isset($_FILES['capa']) &&
    $_FILES['capa']['error'] == 0
){

    $diretorio = "uploads/";

    if(!file_exists($diretorio)){

        mkdir($diretorio, 0777, true);

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
}

/* DADOS */

$idUsuario =
    $_SESSION['usuario_id'];

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

/* LATITUDE E LONGITUDE */

$latitude = 0;
$longitude = 0;

/* INSERT EVENTO */

$sql = "
INSERT INTO eventos_cadastrados (

    id_usuarios,
    id_categoria,

    titulo,
    descricao,

    rua,
    bairro,
    numero,
    cidade,
    CEP,
    ponto_referencia,

    latitude,
    longitude,

    Imagem

)

VALUES (

    '$idUsuario',
    '$categoriaId',

    '$tituloEvento',
    '$descricao',

    '$rua',
    '$bairro',
    '$numero',
    '$cidade',
    '$cep',
    '$pontoReferencia',

    '$latitude',
    '$longitude',

    '$nomeImagem'
)
";

if($conexao->query($sql)){

    $idEvento =
        $conexao->insert_id;

    /* DATAS */

    $datas =
        $_POST['datas'];

    $horasInicio =
        $_POST['horas_inicio'];

    $horasFim =
        $_POST['horas_fim'];

    for(
        $i = 0;
        $i < count($datas);
        $i++
    ){

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

        $sqlDatas = "
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

        $conexao->query($sqlDatas);
    }

    echo "
    <script>

        alert('Evento cadastrado com sucesso!');

        window.location.href='index.php';

    </script>
    ";

}else{

    echo "Erro: " . $conexao->error;

}

$conexao->close();

?>