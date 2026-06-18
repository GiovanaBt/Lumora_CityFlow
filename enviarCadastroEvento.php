<?php

include 'Conexao.php';

session_start();


/* =========================================================
   SEGURANÇA
========================================================= */

if (!isset($_SESSION['usuario_id'])) {

    die("Você precisa estar logado.");
}

/* =========================================================
   IMAGEM
========================================================= */

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

/* =========================================================
   DADOS
========================================================= */

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
    ? mysqli_real_escape_string($conexao, $_POST['latitude'])
    : null;

$longitude = isset($_POST['longitude'])
    ? mysqli_real_escape_string($conexao, $_POST['longitude'])
    : null;

/* =========================================================
   INSERT EVENTO
========================================================= */

$sql = "
INSERT INTO eventos_cadastrados (

    id_usuarios,
    id_categoria,

    titulo,
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
    '$descricao',

    '$classificacaoIndicativa',

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

    /* =====================================================
       DATAS
    ===================================================== */

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

    echo 'Erro: ' . $conexao->error;
}

$conexao->close();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Footer</title>
    <link rel="stylesheet" href="footer.css">
</head>
<body>
    <?php
// Configurações do Rodapé
$ano_atual = date('Y');
$footer_data = [
    'ajuda' => [
        'titulo' => 'Ajuda',
        'links'  => [
            ['txt' => 'Central de Ajuda', 'url' => '#'],
            ['txt' => 'FAQ', 'url' => '#'],
            ['txt' => 'Contato e Suporte', 'url' => '#'],
            ['txt' => 'Reportar Problema', 'url' => '#']
        ]
    ],
    'institucional' => [
        'titulo' => 'Institucional',
        'links'  => [
            ['txt' => 'Sobre o CityFlow', 'url' => '#'],
            ['txt' => 'Missão e Valores', 'url' => '#'],
            ['txt' => 'Privacidade', 'url' => '#'],
            ['txt' => 'Termos de Uso', 'url' => '#']
        ]
    ]
];
?>

<footer class="footer-main">
    <div class="footer-overlay">
        <div class="footer-container">
            
            <?php foreach ($footer_data as $coluna): ?>
            <div class="footer-col">
                <h4 class="footer-title"><?php echo $coluna['titulo']; ?></h4>
                <ul class="footer-links">
                    <?php foreach ($coluna['links'] as $link): ?>
                        <li><a href="<?php echo $link['url']; ?>"><?php echo $link['txt']; ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php endforeach; ?>

            <div class="footer-brand">
                <div class="logo-wrapper">
                    <span class="logo-city">CITY</span><span class="logo-flow">FLOW</span>
                </div>
                <p class="brand-text">
                    Conectando a essência das ruas e a cultura urbana. Descubra eventos, arte e movimento em um só lugar.
                </p>
                <div class="social-icons">
                    <a href="#" aria-label="Instagram">IG</a>
                    <a href="#" aria-label="Twitter">TW</a>
                    <a href="#" aria-label="Facebook">FB</a>
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <p>&copy; <?php echo $ano_atual; ?> CityFlow - Todos os direitos reservados.</p>
        </div>
    </div>
</footer>
</body>
</html>