<?php

session_start();
include 'Conexao.php';


/* =========================================================
   SEGURANÇA
========================================================= */

if (!isset($_SESSION['usuario_id'])) {

    die("Você precisa estar logado.");

}

$idUsuario = $_SESSION['usuario_id'];


/* =========================================================
   VERIFICAR DATAS DO EVENTO
========================================================= */

$datas = $_POST['datas'] ?? [];
$horasInicio = $_POST['horas_inicio'] ?? [];
$horasFim = $_POST['horas_fim'] ?? [];

$hoje = date('Y-m-d');


/*
   Verifica se existe pelo menos uma data
*/

if (empty($datas)) {

    die("É necessário informar pelo menos uma data para o evento.");

}


/*
   Verifica todas as datas cadastradas
*/

foreach ($datas as $data) {

    if (empty($data)) {

        die("Uma das datas do evento não foi preenchida.");

    }


    /*
       NÃO PERMITE DATA ANTERIOR A HOJE
    */

    if ($data < $hoje) {

        echo "
        <script>

            alert('Não é permitido cadastrar eventos com datas anteriores ao dia atual.');

            window.history.back();

        </script>
        ";

        exit();

    }

}


/* =========================================================
   IMAGEM
========================================================= */

$nomeImagem = "";

if (
    isset($_FILES['capa']) &&
    $_FILES['capa']['error'] == 0
) {

    $diretorio = "uploads/";


    if (!file_exists($diretorio)) {

        mkdir($diretorio, 0777, true);

    }


    $extensao = pathinfo(
        $_FILES['capa']['name'],
        PATHINFO_EXTENSION
    );


    $nomeImagem = uniqid() . "." . $extensao;


    move_uploaded_file(
        $_FILES['capa']['tmp_name'],
        $diretorio . $nomeImagem
    );

}


/* =========================================================
   DADOS DO EVENTO
========================================================= */

$tituloEvento = mysqli_real_escape_string(
    $conexao,
    $_POST['nome'] ?? ''
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
    $_POST['cep'] ?? ''
);


$pontoReferencia = mysqli_real_escape_string(
    $conexao,
    $_POST['ponto_referencia'] ?? ''
);


$categoriaId = (int)($_POST['categorias'] ?? 0);


/* =========================================================
   CLASSIFICAÇÃO INDICATIVA
========================================================= */

$classificacaoIndicativa = mysqli_real_escape_string(
    $conexao,
    $_POST['classificacao'] ?? ''
);


/* =========================================================
   LATITUDE E LONGITUDE
========================================================= */

// Monta o endereço completo do evento
$enderecoCompleto = $rua . ', ' .
                    $numero . ', ' .
                    $bairro . ', ' .
                    $cidade . ', ' .
                    $cep . ', Brasil';

// Converte o endereço em coordenadas
$urlGeocodificacao = 'https://nominatim.openstreetmap.org/search?' . http_build_query([
    'q' => $enderecoCompleto,
    'format' => 'json',
    'limit' => 1,
    'countrycodes' => 'br'
]);

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $urlGeocodificacao);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'User-Agent: CityFlow/1.0'
]);

$resposta = curl_exec($ch);

curl_close($ch);

$dadosLocalizacao = json_decode($resposta, true);

// Verifica se encontrou a localização
if (!empty($dadosLocalizacao) && isset($dadosLocalizacao[0])) {

    $latitude = $dadosLocalizacao[0]['lat'];
    $longitude = $dadosLocalizacao[0]['lon'];

} else {

    $latitude = null;
    $longitude = null;

}


/* =========================================================
   CADASTRAR EVENTO
========================================================= */

$sql = "
INSERT INTO eventos_cadastrados (

    id_usuarios,
    id_categoria,

    titulo,
    subtitulo,
    descricao,

    classificacao_indicativa,

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
    '$subtitulo',
    '$descricao',

    '$classificacaoIndicativa',

    '$rua',
    '$bairro',
    '$numero',
    '$cidade',
    '$cep',
    '$pontoReferencia',

    " . ($latitude !== null ? "'$latitude'" : "NULL") . ",
    " . ($longitude !== null ? "'$longitude'" : "NULL") . ",

    '$nomeImagem'

)
";


/* =========================================================
   EXECUTAR CADASTRO
========================================================= */

if ($conexao->query($sql)) {


    $idEvento = $conexao->insert_id;


    /* =====================================================
       CADASTRAR DATAS
    ===================================================== */

    for (
        $i = 0;
        $i < count($datas);
        $i++
    ) {


        $data = mysqli_real_escape_string(
            $conexao,
            $datas[$i]
        );


        $horaInicio = mysqli_real_escape_string(
            $conexao,
            $horasInicio[$i] ?? ''
        );


        $horaFim = mysqli_real_escape_string(
            $conexao,
            $horasFim[$i] ?? ''
        );


        /*
           Como o seu formulário atual trabalha com
           uma data por ocorrência, a data inicial
           e final recebem a mesma data.
        */

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


        if (!$conexao->query($sqlDatas)) {

            /*
               Se der erro ao cadastrar a data,
               remove o evento que acabou de ser criado.
            */

            $conexao->query("
                DELETE FROM eventos_cadastrados
                WHERE id_evento = $idEvento
            ");


            die(
                "Erro ao cadastrar a data do evento: "
                . $conexao->error
            );

        }

    }


    /* =====================================================
       SUCESSO
    ===================================================== */

    echo "
    <script>

        alert('Evento cadastrado com sucesso!');

        window.location.href = 'index.php';

    </script>
    ";


} else {


    /* =====================================================
       ERRO
    ===================================================== */

    echo "
    <script>

        alert('Erro ao cadastrar o evento.');

        window.history.back();

    </script>
    ";

}


$conexao->close();x

?>