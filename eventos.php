<?php
session_start();
include 'Conexao.php';

/* =========================================
   ID DO EVENTO
========================================= */

$id = isset($_GET['id'])
    ? mysqli_real_escape_string($conexao, $_GET['id'])
    : 0;

/* =========================================
   BUSCA EVENTO
========================================= */

$sql = "
SELECT 
    e.*,
    c.categoria_evento

FROM eventos_cadastrados e

INNER JOIN categoria c
ON e.id_categoria = c.id_categoria

WHERE e.id_evento = '$id'
";

$result = mysqli_query($conexao, $sql);

$evento = mysqli_fetch_assoc($result);

/* =========================================
   EVENTO NÃO ENCONTRADO
========================================= */

if(!$evento){

    die("Evento não encontrado!");

}

/* =========================================
   DATAS DO EVENTO
========================================= */

$sqlDatas = "
SELECT *
FROM datas_evento
WHERE id_evento = '$id'
ORDER BY data_inicio ASC
";

$resultDatas = mysqli_query($conexao, $sqlDatas);

/* =========================================
   STATUS USUÁRIO
========================================= */

$jaParticipou = false;
$jaFavoritou = false;

if(isset($_SESSION['usuario_id'])){

    $id_usuario = $_SESSION['usuario_id'];

    /* PARTICIPAÇÃO */

    $verificaParticipacao = mysqli_query($conexao, "

        SELECT 1
        FROM atividade
        WHERE id_usuarios = '$id_usuario'
        AND id_evento = '$id'

    ");

    $jaParticipou =
        mysqli_num_rows($verificaParticipacao) > 0;

    /* FAVORITO */

    $verificaFavorito = mysqli_query($conexao, "

        SELECT 1
        FROM favoritos
        WHERE id_usuario = '$id_usuario'
        AND id_evento = '$id'

    ");

    $jaFavoritou =
        mysqli_num_rows($verificaFavorito) > 0;
}
?>

<!DOCTYPE html>

<html lang="pt-br">

<head>

    <!-- META -->
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <!-- TÍTULO -->
    <title>

        <?= htmlspecialchars($evento['titulo']); ?>

        | CityFlow

    </title>

    <!-- FONT AWESOME -->
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
    >

    <!-- CSS -->
    <link rel="stylesheet" href="header.css">
    <link rel="stylesheet" href="style_evento.css">

</head>

<body>

<!-- =========================================
     HEADER
========================================= -->

<header>

    <!-- LOGO -->
    <div class="logo">

        <a href="index.php">

            <img
                src="imgs/cityFlow.webp"
                alt="Logo CityFlow"
            >

        </a>

    </div>

    <!-- MAPA -->
    <a href="mapa.php" target="_blank">

        <button class="botaoMapa">
            MAPA
        </button>

    </a>

    <!-- MENU -->
    <nav>

        <ul class="menu">

            <li>

                <a href="index.php">
                    INÍCIO
                </a>

            </li>

            <li>

                <a href="informacoes.php">
                    INFORMAÇÕES
                </a>

            </li>

            <li>

                <a href="cadastroEvento.php">

                    <i class="fa-solid fa-circle-plus"></i>

                    DIVULGAR EVENTOS

                </a>

            </li>

            <!-- PERFIL -->
            <?php if(isset($_SESSION['usuario_id'])): ?>

                <li class="perfil">

                    <a href="#">

                        <i class="fa-solid fa-circle-user"></i>

                        <?= $_SESSION['nome_usuario']; ?>

                    </a>

                    <!-- SUBMENU -->
                    <ul class="submenu">

                        <li>

                            <a href="minhaConta.php">
                                Minha Conta
                            </a>

                        </li>

                        <li>

                            <a href="minhaConta.php#favoritos">
                                Favoritos
                            </a>

                        </li>

                        <li>

                            <a href="ajuda.php">
                                Ajuda
                            </a>

                        </li>

                        <li>

                            <a href="logout.php">
                                Sair
                            </a>

                        </li>

                    </ul>

                </li>

            <?php endif; ?>

        </ul>

    </nav>

</header>

<!-- =========================================
     CONTEÚDO
========================================= -->

<div class="main-container">

    <!-- BOTÃO VOLTAR -->
    <a href="index.php" class="btn-voltar">

        <i class="fa-solid fa-arrow-left"></i>

        Voltar

    </a>

    <!-- GRID -->
    <div class="grid-evento">

        <!-- =====================================
             TOPO EVENTO
        ====================================== -->

        <section class="header-evento">

            <!-- =================================
                 ESQUERDA
            ================================== -->

            <div class="info-evento">

                <!-- CATEGORIA -->
                <span class="badge-categoria">

                    <?= htmlspecialchars($evento['categoria_evento']); ?>

                </span>

                <!-- TÍTULO -->
                <h1>

                    <?= htmlspecialchars($evento['titulo']); ?>

                </h1>

                <!-- =================================
                     INFORMAÇÕES EXTRAS
                ================================== -->

                <div class="top-infos-evento">

                    <!-- CLASSIFICAÇÃO -->
                    <div class="classificacao">

                        <i class="fa-solid fa-user-shield"></i>

                        <span>
                            Classificação:
                        </span>

                        <strong>

                            <?= htmlspecialchars($evento['classificacao_indicativa']); ?>

                        </strong>

                    </div>

                    <!-- CEP -->
                    <div class="info-extra">

                        <i class="fa-solid fa-location-dot"></i>

                        CEP:

                        <?= htmlspecialchars($evento['CEP']); ?>

                    </div>

                </div>

                <!-- =================================
                     DATAS
                ================================== -->

                <div class="datas-evento">

                    <?php while($data = mysqli_fetch_assoc($resultDatas)): ?>

                        <div class="data-box">

                            <!-- TOPO -->
                            <div class="data-topo">

                                <i class="fa-regular fa-calendar"></i>

                                <span>
                                    EVENTO
                                </span>

                            </div>

                            <!-- DATA -->
                            <strong>

                                <?= date(
                                    "d/m/Y",
                                    strtotime($data['data_inicio'])
                                ); ?>

                            </strong>

                            <!-- HORÁRIO -->
                            <div class="horario-evento">

                                <i class="fa-regular fa-clock"></i>

                                <?= date(
                                    "H:i",
                                    strtotime($data['horario_inicio'])
                                ); ?>

                                -

                                <?= date(
                                    "H:i",
                                    strtotime($data['horario_fim'])
                                ); ?>

                            </div>

                        </div>

                    <?php endwhile; ?>

                </div>

                <!-- =================================
                     LOCALIZAÇÃO
                ================================== -->

                <div class="localizacao-topo">

                    <h2>

                        <i class="fa-solid fa-location-dot"></i>

                        Localização

                    </h2>

                    <!-- ENDEREÇO -->
                    <div class="endereco-completo">

                        <?= htmlspecialchars($evento['rua']); ?>,

                        <?= htmlspecialchars($evento['numero']); ?>

                        -

                        <?= htmlspecialchars($evento['bairro']); ?>

                        -

                        <?= htmlspecialchars($evento['cidade']); ?>

                    </div>

                    <!-- REFERÊNCIA -->
                    <?php if(!empty($evento['ponto_referencia'])): ?>

                    <div class="referencia-local">

                        <i class="fa-solid fa-route"></i>

                        <?= htmlspecialchars($evento['ponto_referencia']); ?>

                    </div>

                    <?php endif; ?>

                    <!-- CEP -->
                    <div class="cep-local">

                        CEP:
                        <?= htmlspecialchars($evento['CEP']); ?>

                    </div>

                    <!-- MAPA -->
                    <a
                        href="mapa.php?id=<?= $evento['id_evento']; ?>"
                        class="btn-mapa-local"
                        target="_blank"
                    >

                        <i class="fa-solid fa-map-location-dot"></i>

                        Ver no mapa

                    </a>

                </div>

            </div>

            <!-- =================================
                 DIREITA
            ================================== -->

            <div class="lado-direito">

                <!-- IMAGEM -->
                <div class="container-imagem">

                    <img
                        src="uploads/<?= htmlspecialchars($evento['Imagem']); ?>"
                        alt="<?= htmlspecialchars($evento['titulo']); ?>"
                    >

                </div>

                <!-- DESCRIÇÃO IMAGEM -->
                <?php if(!empty($evento['descIMG'])): ?>

                <div class="descricao-imagem">

                    <i class="fa-solid fa-image"></i>

                    <?= htmlspecialchars($evento['descIMG']); ?>

                </div>

                <?php endif; ?>

                <!-- =================================
                     AÇÕES
                ================================== -->

                <div class="card">

                    <h3>
                        Ações
                    </h3>

                    <div class="acoes-evento">

                        <!-- PARTICIPAR -->
                        <button
                            class="btn-acao"
                            id="btnParticipar"
                            data-id="<?= $evento['id_evento']; ?>"
                            <?= $jaParticipou ? 'disabled' : ''; ?>
                        >

                            <?php if($jaParticipou): ?>

                                <i class="fa-solid fa-star"></i>

                                Participando

                            <?php else: ?>

                                <i class="fa-regular fa-star"></i>

                                Participar

                            <?php endif; ?>

                        </button>

                        <!-- FAVORITAR -->
                        <button
                            class="btn-secundario"
                            id="btnFavoritar"
                            data-id="<?= $evento['id_evento']; ?>"
                        >

                            <?php if($jaFavoritou): ?>

                                <i class="fa-solid fa-heart"></i>

                                Favoritado

                            <?php else: ?>

                                <i class="fa-regular fa-heart"></i>

                                Favoritar

                            <?php endif; ?>

                        </button>

                    </div>

                </div>

            </div>

        </section>

        <!-- =====================================
             DESCRIÇÃO
        ====================================== -->

        <div class="card">

            <h3>
                Sobre o Evento
            </h3>

            <p>

                <?= nl2br(
                    htmlspecialchars($evento['descricao'])
                ); ?>

            </p>

        </div>

    </div>

</div>

<!-- =========================================
     FAVORITAR
========================================= -->

<script>

document.addEventListener("DOMContentLoaded", function(){

    const btnFav =
        document.getElementById("btnFavoritar");

    if(!btnFav) return;

    btnFav.addEventListener("click", function(){

        let id = this.dataset.id;

        fetch("favoritar.php", {

            method:"POST",

            headers:{
                "Content-Type":
                "application/x-www-form-urlencoded"
            },

            body:"id_evento=" + id

        })

        .then(res => res.text())

        .then(res => {

            if(res === "login"){

                alert("Faça login primeiro!");

                return;
            }

            if(res === "ok"){

                this.innerHTML =
                '<i class="fa-solid fa-heart"></i> Favoritado';

            }

            if(res === "removido"){

                this.innerHTML =
                '<i class="fa-regular fa-heart"></i> Favoritar';

            }

        });

    });

});

</script>

</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
                    <a href="https://www.instagram.com/seu_perfil" target="_blank" rel="noopener noreferrer" aria-label="Instagram">IG</a>
                    <a href="https://twitter.com/seu_perfil" target="_blank" rel="noopener noreferrer" aria-label="Twitter">TW</a>
                    <a href="https://www.facebook.com/seu_perfil" target="_blank" rel="noopener noreferrer" aria-label="Facebook">FB</a>
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