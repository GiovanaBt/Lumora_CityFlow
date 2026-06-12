<?php
session_start();
include 'Conexao.php';

/* =========================================================
PEGAR ID DA CATEGORIA
========================================================= */

$idCategoria = isset($_GET['id'])
    ? intval($_GET['id'])
    : 0;

/* =========================================================
BUSCAR NOME DA CATEGORIA
========================================================= */

$sqlCategoria = "
SELECT categoria_evento
FROM categoria
WHERE id_categoria = $idCategoria
";

$resultCategoria = mysqli_query($conexao, $sqlCategoria);

$categoria = mysqli_fetch_assoc($resultCategoria);

/* =========================================================
BUSCAR EVENTOS DA CATEGORIA
========================================================= */

$sqlEventos = "
SELECT *
FROM eventos_cadastrados
WHERE id_categoria = $idCategoria
ORDER BY id_evento DESC
";

$resultEventos = mysqli_query($conexao, $sqlEventos);

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
    content="width=device-width, initial-scale=1.0">

    <title>

        Categoria -
        <?php echo $categoria['categoria_evento']; ?>

    </title>

    <!-- CSS -->

    <link rel="stylesheet" href="header.css">

    <link rel="stylesheet" href="categoria.css">

    <!-- ICON -->

    <link rel="shortcut icon"
    href="imgs/logoCityFlow.webp">

    <!-- FONT AWESOME -->

    <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

</head>

<body>

<!-- =========================================================
HEADER
========================================================= -->

<header>

    <div class="logo">

        <a href="index.php">

            <img src="imgs/cityFlow.webp">

        </a>

    </div>

    <!-- BOTÃO MAPA -->

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

            <?php if (isset($_SESSION['usuario_id'])): ?>

                <li class="perfil">

                    <a href="#">

                        <i class="fa-solid fa-circle-user"></i>

                        <?php echo $_SESSION['nome_usuario']; ?>

                    </a>

                    <ul class="submenu">

                        <li>

                            <a href="minhaConta.php">

                                <i class="fa-solid fa-user-gear"></i>

                                Minha Conta

                            </a>

                        </li>

                        <li>

                            <a href="minhaConta.php#favoritos">

                                <i class="fa-solid fa-heart"></i>

                                Favoritos

                            </a>

                        </li>

                        <li>

                            <a href="ajuda.php">

                                <i class="fa-solid fa-circle-question"></i>

                                Central de ajuda

                            </a>

                        </li>

                        <li>

                            <a href="logout.php"
                            class="btn-sair">

                                <i class="fa-solid fa-right-from-bracket"></i>

                                Sair

                            </a>

                        </li>

                    </ul>

                </li>

            <?php else: ?>

                <li>

                    <div class="menu-container"
                    id="abrirModal">

                        <i class="fa-solid fa-arrow-right-to-bracket"></i>

                        <span class="texto-entrar">

                            ENTRAR

                        </span>

                    </div>

                </li>

            <?php endif; ?>

        </ul>

    </nav>

</header>

<!-- =========================================================
TOPO DA CATEGORIA
========================================================= -->

<section class="categoria-topo">

    <div class="forma-topo-1"></div>

    <div class="forma-topo-2"></div>

    <div class="badge-categoria">

        <i class="fa-solid fa-sparkles"></i>

        <span>
            CITY FLOW • CATEGORIA
        </span>

    </div>

    <h1>

        <?php echo $categoria['categoria_evento']; ?>

    </h1>

    <p>

        Explore os melhores eventos dessa categoria
        e descubra experiências incríveis acontecendo
        na sua cidade.

    </p>

</section>

<!-- =========================================================
CARROSSEL DE EVENTOS
========================================================= -->

<section class="eventos-wrapper">

    <!-- BOTÃO ESQUERDA -->

    <button
        class="btn-carrossel btn-prev"
        onclick="scrollEventos(-1)"
    >

        <i class="fa-solid fa-chevron-left"></i>

    </button>

    <!-- TRACK -->

    <div
        class="eventos-grid"
        id="eventosGrid"
    >

    <?php if(mysqli_num_rows($resultEventos) > 0): ?>

        <?php while($evento = mysqli_fetch_assoc($resultEventos)): ?>

            <a
                href="eventos.php?id=<?php echo $evento['id_evento']; ?>"
                class="card-evento"
            >

                <!-- IMAGEM -->

                <div class="img-evento">

                    <img
                        src="uploads/<?php echo $evento['Imagem']; ?>"
                        alt=""
                    >

                </div>

                <!-- INFO -->

                <div class="info-evento">

                    <h3>

                        <?php echo $evento['titulo']; ?>

                    </h3>

                    <p class="local-evento">

                        <i class="fa-solid fa-location-dot"></i>

                        <?php echo $evento['bairro']; ?>

                        -

                        <?php echo $evento['cidade']; ?>

                    </p>

                    <span class="btn-ver">

                        VER EVENTO

                    </span>

                </div>

            </a>

        <?php endwhile; ?>

    <?php else: ?>

        <p class="nenhum-evento">

            Nenhum evento encontrado nessa categoria.

        </p>

    <?php endif; ?>

    </div>

    <!-- BOTÃO DIREITA -->

    <button
        class="btn-carrossel btn-next"
        onclick="scrollEventos(1)"
    >

        <i class="fa-solid fa-chevron-right"></i>

    </button>

</section>

<!-- =========================================================
SCRIPT CARROSSEL
========================================================= -->

<script>

const eventosGrid =
document.getElementById("eventosGrid");

function scrollEventos(direction){

    const distancia = 420;

    eventosGrid.scrollBy({

        left: direction * distancia,

        behavior: "smooth"

    });
}

</script>

</body>
</html>
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