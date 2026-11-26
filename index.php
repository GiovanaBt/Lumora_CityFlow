<?php
/* =========================================================
1. INICIAR SESSÃO
========================================================= */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/* =========================================================
2. ARQUIVAR EVENTOS PASSADOS
========================================================= */

include 'arquivarEventosPassados.php';

/* =========================================================
3. CONEXÃO COM O BANCO DE DADOS
========================================================= */

$host = "localhost";
$usuario = "root";
$senha = "Home@spSENAI2025!";
$banco = "cityflow";

$conn = new mysqli($host, $usuario, $senha, $banco);

if ($conn->connect_error) {
    die("Erro de conexão com o banco de dados: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");

/* =========================================================
4. FUNÇÃO PARA PROTEGER TEXTOS
========================================================= */

function escapar($texto) {
    return htmlspecialchars(
        (string) $texto,
        ENT_QUOTES,
        'UTF-8'
    );
}

/* =========================================================
5. CAPTURAR ERRO DE LOGIN
========================================================= */

$erroLogin = $_SESSION['erro_login'] ?? '';

unset($_SESSION['erro_login']);

/* =========================================================
6. VERIFICAR LOGIN
========================================================= */

$logado = isset($_SESSION['usuario_id']);

/* =========================================================
7. CARROSSEL PRINCIPAL
========================================================= */

$sql = "
    SELECT
        id_evento,
        titulo,
        Imagem,
        bairro,
        cidade
    FROM eventos_cadastrados
    ORDER BY id_evento DESC
    LIMIT 5
";

$resultado = $conn->query($sql);

/* =========================================================
8. EVENTOS DE HOJE
========================================================= */

$sqlHoje = "
    SELECT
        e.id_evento,
        e.titulo,
        e.Imagem,
        e.bairro,
        e.cidade,
        MIN(d.data_inicio) AS data_inicio,
        MIN(d.horario_inicio) AS horario_inicio
    FROM eventos_cadastrados e
    INNER JOIN datas_evento d
        ON e.id_evento = d.id_evento
    WHERE CURDATE() BETWEEN d.data_inicio AND d.data_fim
    GROUP BY
        e.id_evento,
        e.titulo,
        e.Imagem,
        e.bairro,
        e.cidade
    ORDER BY
        data_inicio ASC,
        horario_inicio ASC
    LIMIT 10
";

$resultHoje = $conn->query($sqlHoje);

/* =========================================================
9. EVENTOS INFANTIS
========================================================= */

$sqlKids = "
    SELECT
        e.id_evento,
        e.titulo,
        e.Imagem,
        e.bairro,
        e.cidade,
        MIN(d.data_inicio) AS data_inicio,
        MIN(d.horario_inicio) AS horario_inicio
    FROM eventos_cadastrados e
    INNER JOIN datas_evento d
        ON e.id_evento = d.id_evento
    WHERE
        e.classificacao_indicativa IN ('L', '10')
        AND d.data_fim >= CURDATE()
    GROUP BY
        e.id_evento,
        e.titulo,
        e.Imagem,
        e.bairro,
        e.cidade
    ORDER BY
        data_inicio ASC,
        horario_inicio ASC
    LIMIT 10
";

$resultKids = $conn->query($sqlKids);

/* =========================================================
10. PRÓXIMOS EVENTOS
========================================================= */

$sqlUltima = "
    SELECT
        e.id_evento,
        e.titulo,
        e.Imagem,
        e.bairro,
        e.cidade,
        MIN(d.data_inicio) AS data_inicio,
        MIN(d.horario_inicio) AS horario_inicio
    FROM eventos_cadastrados e
    INNER JOIN datas_evento d
        ON e.id_evento = d.id_evento
    WHERE
        d.data_inicio BETWEEN CURDATE()
        AND DATE_ADD(CURDATE(), INTERVAL 2 DAY)
    GROUP BY
        e.id_evento,
        e.titulo,
        e.Imagem,
        e.bairro,
        e.cidade
    ORDER BY data_inicio ASC
    LIMIT 10
";

$resultUltima = $conn->query($sqlUltima);

/* =========================================================
11. COLEÇÕES
========================================================= */

$colecoes = [
    ['id'=>1, 'label'=>'MÚSICA', 'icone'=>'fa-solid fa-music'],
    ['id'=>2, 'label'=>'DANÇA', 'icone'=>'fa-solid fa-person-dress'],
    ['id'=>3, 'label'=>'LEITURA', 'icone'=>'fa-solid fa-book-open'],
    ['id'=>4, 'label'=>'GASTRONOMIA', 'icone'=>'fa-solid fa-utensils'],
    ['id'=>5, 'label'=>'ESPORTE', 'icone'=>'fa-solid fa-football'],
    ['id'=>6, 'label'=>'CINEMA', 'icone'=>'fa-solid fa-film'],
    ['id'=>7, 'label'=>'TEATRO', 'icone'=>'fa-solid fa-masks-theater'],
    ['id'=>8, 'label'=>'PERFORMANCE', 'icone'=>'fa-solid fa-star'],
    ['id'=>9, 'label'=>'PINTURA/ARTE', 'icone'=>'fa-solid fa-palette'],
    ['id'=>10, 'label'=>'EDUCAÇÃO', 'icone'=>'fa-solid fa-graduation-cap'],
    ['id'=>11, 'label'=>'STANDUPS', 'icone'=>'fa-solid fa-microphone'],
    ['id'=>12, 'label'=>'CONGRESSOS/PALESTRAS', 'icone'=>'fa-solid fa-users'],
    ['id'=>13, 'label'=>'CURSOS/WORKSHOPS', 'icone'=>'fa-solid fa-laptop'],
    ['id'=>14, 'label'=>'PRIDE', 'icone'=>'fa-solid fa-rainbow'],
    ['id'=>15, 'label'=>'RELIGIÃO/ESPIRITUALIDADE', 'icone'=>'fa-solid fa-dove'],
    ['id'=>16, 'label'=>'RECITAR', 'icone'=>'fa-solid fa-pen-nib'],
    ['id'=>17, 'label'=>'ESCRITA/POEMAS', 'icone'=>'fa-solid fa-feather']
];
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="index.css">
<link rel="stylesheet" href="header.css">
<link rel="stylesheet" href="footer.css">

<link rel="shortcut icon" href="imgs/logoCityFlow.webp">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">css">
</head>

<body>


<!-- =========================================================
10. HEADER RESPONSIVO
========================================================= -->

<header class="header-principal">

    <!-- LOGO -->
    <div class="logo">
        <a href="index.php">
            <img src="imgs/cityFlow.webp" alt="CityFlow">
        </a>
    </div>

    <!-- BOTÃO HAMBÚRGUER -->
    <button
        class="hamburguer"
        id="hamburguer"
        type="button"
        aria-label="Abrir menu"
        aria-expanded="false"
        aria-controls="menuPrincipal">
        <i class="fa-solid fa-bars"></i>
    </button>

    <!-- MENU PRINCIPAL -->
    <nav id="menuPrincipal">
        <ul class="menu">
            <li>
                <a href="index.php">INÍCIO</a>
            </li>

            <li>
                <a href="informacoes.php">INFORMAÇÕES</a>
            </li>

            <li>
                <a href="cadastroEvento.php">
                    <i class="fa-solid fa-circle-plus"></i>
                    DIVULGAR EVENTOS
                </a>
            </li>

            <!-- PERFIL E OPÇÕES DA CONTA -->
            <?php if ($logado): ?>

                <!-- DESKTOP (Dropdown) -->
                <li class="perfil">
                    <a
                        href="#"
                        class="perfil-link"
                        aria-haspopup="true"
                        aria-expanded="false">
                        <i class="fa-solid fa-circle-user"></i>
                        <?= escapar($_SESSION['nome_usuario'] ?? 'Minha Conta'); ?>
                        <i class="fa-solid fa-chevron-down seta-submenu"></i>
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
                            <a href="logout.php" class="btn-sair">
                                <i class="fa-solid fa-right-from-bracket"></i>
                                Sair
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- MOBILE / TABLET (Aparecem completos dentro do Hambúrguer) -->
                <li class="opcao-mobile">
                    <a href="minhaConta.php">
                        <i class="fa-solid fa-user-gear"></i>
                        MINHA CONTA
                    </a>
                </li>

                <li class="opcao-mobile">
                    <a href="minhaConta.php#favoritos">
                        <i class="fa-solid fa-heart"></i>
                        FAVORITOS
                    </a>
                </li>

                <li class="opcao-mobile">
                    <a href="ajuda.php">
                        <i class="fa-solid fa-circle-question"></i>
                        CENTRAL DE AJUDA
                    </a>
                </li>

                <li class="opcao-mobile">
                    <a href="logout.php" class="btn-sair">
                        <i class="fa-solid fa-right-from-bracket"></i>
                        SAIR
                    </a>
                </li>

            <?php else: ?>

                <!-- ENTRAR -->
                <li>
                    <button
                        type="button"
                        class="menu-container"
                        id="abrirModal">
                        <i class="fa-solid fa-arrow-right-to-bracket"></i>
                        <span>ENTRAR</span>
                    </button>
                </li>

            <?php endif; ?>

            <!-- MAPA -->
            <li>
                <a href="mapa.php" class="botaoMapa">
                    <i class="fa-solid fa-map-location-dot"></i>
                    MAPA
                </a>
            </li>
        </ul>
    </nav>

</header>


<!-- =========================================================
11. MODAL DE LOGIN
========================================================= -->

<div id="modal" class="modal">
    <div class="modal-conteudo">
        <span class="fechar">&times;</span>
        <h1>QUE BOM TER VOCÊ AQUI!</h1>
        <h3>FAÇA SEU LOGIN</h3>

        <?php if (!empty($erroLogin)): ?>
            <p class="erro-login"><?= escapar($erroLogin); ?></p>
        <?php endif; ?>

        <form action="fazerLogin.php" method="POST">
            <label for="emailLogin">E-MAIL:</label>
            <input type="email" id="emailLogin" name="emailLogin" required>

            <label for="senhaLogin">SENHA:</label>
            <input type="password" id="senhaLogin" name="senhaLogin" required>

            <button type="submit">ENTRAR</button>
        </form>

        <h4>Não possui uma conta?</h4>
        <a href="cadastroUsuario.php">Cadastre-se</a>
    </div>
</div>


<!-- =========================================================
12. JAVASCRIPT DO HEADER CITYFLOW
========================================================= -->

<script>
document.addEventListener('DOMContentLoaded', function () {

    const hamburguer = document.getElementById('hamburguer');
    const menu = document.getElementById('menuPrincipal');
    const perfil = document.querySelector('.perfil');
    const perfilLink = document.querySelector('.perfil-link');
    const modal = document.getElementById('modal');
    const abrirModal = document.getElementById('abrirModal');
    const fecharModal = document.querySelector('.fechar');
    const logado = <?= $logado ? 'true' : 'false'; ?>;

    function atualizarIconeMenu(aberto) {
        if (!hamburguer) return;
        hamburguer.innerHTML = aberto
            ? '<i class="fa-solid fa-xmark"></i>'
            : '<i class="fa-solid fa-bars"></i>';
        hamburguer.setAttribute('aria-expanded', String(aberto));
        hamburguer.setAttribute('aria-label', aberto ? 'Fechar menu' : 'Abrir menu');
    }

    function fecharSubmenu() {
        if (!perfil) return;
        perfil.classList.remove('submenu-aberto');
        if (perfilLink) {
            perfilLink.setAttribute('aria-expanded', 'false');
        }
    }

    function abrirMenu() {
        if (!menu || !hamburguer) return;
        menu.classList.add('ativo');
        atualizarIconeMenu(true);
    }

    function fecharMenu() {
        if (!menu || !hamburguer) return;
        menu.classList.remove('ativo');
        atualizarIconeMenu(false);
        fecharSubmenu();
    }

    if (hamburguer && menu) {
        hamburguer.addEventListener('click', function (evento) {
            evento.preventDefault();
            evento.stopPropagation();
            if (menu.classList.contains('ativo')) {
                fecharMenu();
            } else {
                abrirMenu();
            }
        });
    }

    if (perfil && perfilLink) {
        perfilLink.addEventListener('click', function (evento) {
            evento.preventDefault();
            evento.stopPropagation();
            const aberto = perfil.classList.toggle('submenu-aberto');
            perfilLink.setAttribute('aria-expanded', String(aberto));
        });
    }

    if (menu) {
        menu.querySelectorAll('a').forEach(function (link) {
            if (link.classList.contains('perfil-link')) return;
            link.addEventListener('click', function () {
                if (window.innerWidth <= 900) {
                    fecharMenu();
                }
            });
        });
    }

    document.addEventListener('click', function (evento) {
        if (!menu || !hamburguer) return;
        if (
            window.innerWidth <= 900 &&
            menu.classList.contains('ativo') &&
            !menu.contains(evento.target) &&
            !hamburguer.contains(evento.target)
        ) {
            fecharMenu();
        }
    });

    document.addEventListener('keydown', function (evento) {
        if (evento.key === 'Escape') {
            fecharMenu();
            if (modal) modal.style.display = 'none';
        }
    });

    window.addEventListener('resize', function () {
        if (window.innerWidth > 900) {
            fecharMenu();
        }
    });

    if (modal && logado) {
        modal.style.display = 'none';
    }

    if (abrirModal && modal) {
        abrirModal.addEventListener('click', function () {
            if (!logado) {
                fecharMenu();
                modal.style.display = 'flex';
            }
        });
    }

    if (fecharModal && modal) {
        fecharModal.addEventListener('click', function () {
            modal.style.display = 'none';
        });
    }

    if (modal) {
        modal.addEventListener('click', function (evento) {
            if (evento.target === modal) {
                modal.style.display = 'none';
            }
        });
    }

    fecharMenu();
});
</script>


<!-- =========================================================
13. CARROSSEL PRINCIPAL
========================================================= -->

<section class="carousel-section">
    <div class="carousel-container">
        <?php if ($resultado && $resultado->num_rows > 0): ?>
            <?php
            $i = 0;
            while ($evento = $resultado->fetch_assoc()):
                $activeClass = ($i === 0) ? 'active' : '';
            ?>
                <div
                    class="carousel-slide <?= $activeClass; ?>"
                    style="
                        background-image:
                        linear-gradient(
                            rgba(0,0,0,.25),
                            rgba(0,0,0,.65)
                        ),
                        url('uploads/<?= rawurlencode($evento['Imagem']); ?>');
                    ">
                    <div class="overlay">
                        <h1><?= escapar($evento['titulo']); ?></h1>
                        <p>
                            <i class="fa-solid fa-location-dot"></i>
                            <?= escapar($evento['bairro']); ?> - <?= escapar($evento['cidade']); ?>
                        </p>
                        <a
                            href="eventos.php?id=<?= (int)$evento['id_evento']; ?>"
                            class="btn-saiba">
                            Saiba mais
                        </a>
                    </div>
                </div>
            <?php
                $i++;
            endwhile;
            ?>
        <?php else: ?>
            <div class="carousel-slide active">
                <div class="overlay">
                    <h1>DESCUBRA O QUE ACONTECE NA SUA CIDADE!</h1>
                    <p>Explore os eventos disponíveis no CityFlow.</p>
                </div>
            </div>
        <?php endif; ?>

        <button class="carousel-arrow prev" type="button">
            <i class="fa-solid fa-chevron-left"></i>
        </button>

        <button class="carousel-arrow next" type="button">
            <i class="fa-solid fa-chevron-right"></i>
        </button>
    </div>
</section>


<!-- =========================================================
14. JAVASCRIPT DO CARROSSEL PRINCIPAL
========================================================= -->

<script>
const slides = document.querySelectorAll('.carousel-slide');
const prevBtn = document.querySelector('.carousel-arrow.prev');
const nextBtn = document.querySelector('.carousel-arrow.next');
let current = 0;
let autoSlide;

function updateCarousel() {
    if (slides.length === 0) return;
    slides.forEach(slide => {
        slide.classList.remove('active', 'prev', 'next');
    });
    slides[current].classList.add('active');
    if (slides.length > 1) {
        const prev = (current - 1 + slides.length) % slides.length;
        const next = (current + 1) % slides.length;
        slides[prev].classList.add('prev');
        slides[next].classList.add('next');
    }
}

function nextSlide() {
    if (slides.length <= 1) return;
    current = (current + 1) % slides.length;
    updateCarousel();
}

function prevSlide() {
    if (slides.length <= 1) return;
    current = (current - 1 + slides.length) % slides.length;
    updateCarousel();
}

function resetAutoSlide() {
    clearInterval(autoSlide);
    if (slides.length > 1) {
        autoSlide = setInterval(nextSlide, 5000);
    }
}

if (nextBtn) {
    nextBtn.addEventListener('click', function() {
        nextSlide();
        resetAutoSlide();
    });
}

if (prevBtn) {
    prevBtn.addEventListener('click', function() {
        prevSlide();
        resetAutoSlide();
    });
}

updateCarousel();
resetAutoSlide();
</script>


<!-- =========================================================
15. COLEÇÕES
========================================================= -->

<section class="container-carrossel">
    <h3>EXPLORE NOSSAS COLEÇÕES</h3>

    <div class="track" id="carrossel-track">
        <?php foreach ($colecoes as $colecao): ?>
            <a
                href="categoria.php?id=<?= $colecao['id']; ?>"
                class="card">
                <div class="icon-box">
                    <i class="<?= escapar($colecao['icone']); ?>"></i>
                </div>
                <span><?= escapar($colecao['label']); ?></span>
            </a>
        <?php endforeach; ?>
    </div>

    <div class="btn-next">
        <button
            class="arrow prev"
            type="button"
            onclick="rolarEsquerda()">
            &#10094;
        </button>

        <button
            class="arrow next"
            type="button"
            onclick="rolarDireita()">
            &#10095;
        </button>
    </div>
</section>


<!-- =========================================================
16. JAVASCRIPT DAS COLEÇÕES
========================================================= -->

<script>
const track = document.getElementById('carrossel-track');

function rolarDireita() {
    if (!track) return;
    track.scrollBy({
        left: 320,
        behavior: 'smooth'
    });
}

function rolarEsquerda() {
    if (!track) return;
    track.scrollBy({
        left: -320,
        behavior: 'smooth'
    });
}
</script>


<!-- =========================================================
17. EVENTOS DE HOJE
========================================================= -->

<section class="mini-carousel-container">
    <div class="titulo-carrossel">
        <span>EVENTOS HOJE</span>
        <div class="placa-data" id="dataHoje"></div>
    </div>

    <button
        class="mini-arrow left"
        type="button"
        onclick="scrollMini('hoje', -1)">
        <i class="fa-solid fa-chevron-left"></i>
    </button>

    <div class="mini-carousel-track" id="hoje">
        <?php if ($resultHoje && $resultHoje->num_rows > 0): ?>
            <?php while ($e = $resultHoje->fetch_assoc()): ?>
                <div class="mini-card">
                    <div class="mini-img">
                        <img
                            src="uploads/<?= rawurlencode($e['Imagem']); ?>"
                            alt="<?= escapar($e['titulo']); ?>">
                    </div>

                    <div class="mini-info">
                        <span class="mini-data">
                            <?= date('d/m', strtotime($e['data_inicio'])); ?>
                        </span>

                        <h3><?= escapar($e['titulo']); ?></h3>

                        <p class="mini-local">
                            <i class="fa-solid fa-location-dot"></i>
                            <?= escapar($e['bairro']); ?> - <?= escapar($e['cidade']); ?>
                        </p>

                        <p class="mini-hora">
                            <i class="fa-solid fa-clock"></i>
                            <?= substr($e['horario_inicio'], 0, 5); ?>
                        </p>

                        <a href="eventos.php?id=<?= (int)$e['id_evento']; ?>">
                            Saiba Mais
                        </a>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p class="sem-eventos">
                Não existem eventos acontecendo hoje.
            </p>
        <?php endif; ?>
    </div>

    <button
        class="mini-arrow right"
        type="button"
        onclick="scrollMini('hoje', 1)">
        <i class="fa-solid fa-chevron-right"></i>
    </button>
</section>


<!-- =========================================================
18. EVENTOS INFANTIS
========================================================= -->

<section class="mini-carousel-container">
    <h2 class="titulo-carrossel">
        EVENTOS INFANTIS
    </h2>

    <button
        class="mini-arrow left"
        type="button"
        onclick="scrollMini('kids', -1)">
        <i class="fa-solid fa-chevron-left"></i>
    </button>

    <div class="mini-carousel-track" id="kids">
        <?php if ($resultKids && $resultKids->num_rows > 0): ?>
            <?php while ($e = $resultKids->fetch_assoc()): ?>
                <div class="mini-card">
                    <div class="mini-img">
                        <img
                            src="uploads/<?= rawurlencode($e['Imagem']); ?>"
                            alt="<?= escapar($e['titulo']); ?>">
                    </div>

                    <div class="mini-info">
                        <span class="mini-data">
                            <?= date('d/m', strtotime($e['data_inicio'])); ?>
                        </span>

                        <h3><?= escapar($e['titulo']); ?></h3>

                        <p class="mini-local">
                            <i class="fa-solid fa-location-dot"></i>
                            <?= escapar($e['bairro']); ?> - <?= escapar($e['cidade']); ?>
                        </p>

                        <p class="mini-hora">
                            <i class="fa-solid fa-clock"></i>
                            <?= substr($e['horario_inicio'], 0, 5); ?>
                        </p>

                        <a href="eventos.php?id=<?= (int)$e['id_evento']; ?>">
                            Saiba Mais
                        </a>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p class="sem-eventos">
                Não existem eventos infantis disponíveis.
            </p>
        <?php endif; ?>
    </div>

    <button
        class="mini-arrow right"
        type="button"
        onclick="scrollMini('kids', 1)">
        <i class="fa-solid fa-chevron-right"></i>
    </button>
</section>


<!-- =========================================================
19. PRÓXIMOS EVENTOS
========================================================= -->

<section class="mini-carousel-container">
    <h2 class="titulo-carrossel">
        PRÓXIMOS EVENTOS
    </h2>

    <button
        class="mini-arrow left"
        type="button"
        onclick="scrollMini('ultima', -1)">
        <i class="fa-solid fa-chevron-left"></i>
    </button>

    <div class="mini-carousel-track" id="ultima">
        <?php if ($resultUltima && $resultUltima->num_rows > 0): ?>
            <?php while ($e = $resultUltima->fetch_assoc()): ?>
                <div class="mini-card">
                    <div class="mini-img">
                        <img
                            src="uploads/<?= rawurlencode($e['Imagem']); ?>"
                            alt="<?= escapar($e['titulo']); ?>">
                    </div>

                    <div class="mini-info">
                        <span class="mini-data">
                            <?= date('d/m', strtotime($e['data_inicio'])); ?>
                        </span>

                        <h3><?= escapar($e['titulo']); ?></h3>

                        <p class="mini-local">
                            <i class="fa-solid fa-location-dot"></i>
                            <?= escapar($e['bairro']); ?> - <?= escapar($e['cidade']); ?>
                        </p>

                        <?php if (!empty($e['horario_inicio'])): ?>
                            <p class="mini-hora">
                                <i class="fa-solid fa-clock"></i>
                                <?= substr($e['horario_inicio'], 0, 5); ?>
                            </p>
                        <?php endif; ?>

                        <a href="eventos.php?id=<?= (int)$e['id_evento']; ?>">
                            Saiba Mais
                        </a>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p class="sem-eventos">
                Não existem próximos eventos cadastrados.
            </p>
        <?php endif; ?>
    </div>

    <button
        class="mini-arrow right"
        type="button"
        onclick="scrollMini('ultima', 1)">
        <i class="fa-solid fa-chevron-right"></i>
    </button>
</section>


<!-- =========================================================
20. JAVASCRIPT DOS MINI-CARROSSÉIS E DATA DE HOJE
========================================================= -->

<script>
function scrollMini(id, direcao) {
    const container = document.getElementById(id);
    if (!container) return;
    container.scrollBy({
        left: direcao * 300,
        behavior: 'smooth'
    });
}

const dataHojeEl = document.getElementById('dataHoje');
if (dataHojeEl) {
    const hoje = new Date();
    const dia = String(hoje.getDate()).padStart(2, '0');
    const mes = String(hoje.getMonth() + 1).padStart(2, '0');
    dataHojeEl.textContent = `${dia}/${mes}`;
}
</script>


<!-- =========================================================
21. FOOTER
========================================================= -->

<?php include 'footer.php'; ?>

</body>
</html>