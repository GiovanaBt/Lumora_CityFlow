<?php
session_start();

/* 1. CONEXÃO COM BANCO */
$host = "localhost";
$usuario = "root";
$senha = "Home@spSENAI2025!";
$banco = "CityFlow";

$conn = new mysqli($host, $usuario, $senha, $banco);

if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

/* 2. CAPTURA ERRO DE LOGIN (Lógica de limpeza) */
$erroLogin = "";
if(!empty($_SESSION['erro_login'])){
    $erroLogin = $_SESSION['erro_login'];
    unset($_SESSION['erro_login']); // Apaga para não aparecer ao dar F5
}

/* 3. BUSCAR EVENTOS */
// Note que agora selecionamos explicitamente o 'titulo' e o 'id_evento'
$sql = "SELECT id_evento, titulo, Imagem, bairro, cidade 
        FROM eventos_cadastrados 
        ORDER BY id_evento DESC 
        LIMIT 5";
$resultado = $conn->query($sql);

$hoje = date('Y-m-d');

/* =========================================================
   CARROSSEL: HOJE
========================================================= */

$sqlHoje = "
SELECT DISTINCT
    e.id_evento,
    e.titulo,
    e.Imagem,
    e.bairro,
    e.cidade,
    d.data_inicio,
    d.horario_inicio

FROM eventos_cadastrados e

INNER JOIN datas_evento d
ON e.id_evento = d.id_evento

WHERE CURDATE() BETWEEN d.data_inicio AND d.data_fim

ORDER BY d.data_inicio ASC

LIMIT 10
";

$resultHoje = $conn->query($sqlHoje);

/* =========================================================
   CARROSSEL: INFANTIL
========================================================= */

$sqlKids = "
SELECT DISTINCT
    e.id_evento,
    e.titulo,
    e.Imagem,
    e.bairro,
    e.cidade,
    d.data_inicio,
    d.horario_inicio

FROM eventos_cadastrados e

INNER JOIN datas_evento d
ON e.id_evento = d.id_evento

WHERE e.classificacao_indicativa IN ('L', '10')

ORDER BY d.data_inicio ASC

LIMIT 10
";

$resultKids = $conn->query($sqlKids);
/* =========================================================
   CARROSSEL: PRÓXIMOS EVENTOS
========================================================= */
$sqlUltima = "
SELECT e.id_evento, e.titulo, e.Imagem, e.bairro, e.cidade
FROM eventos_cadastrados e
JOIN datas_evento d ON e.id_evento = d.id_evento
WHERE d.data_inicio BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 2 DAY)
ORDER BY e.id_evento DESC
LIMIT 10
";
$resultUltima = $conn->query($sqlUltima);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>City Flow - O pulso da sua cidade</title>
    <link rel="stylesheet" href="header.css">
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="footer.css">
    <link rel="shortcut icon" href="imgs/logoCityFlow.webp">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body>

<!-- =========================================================
   HEADER
========================================================= -->
<header>
    <div class="logo">
        <a href="index.php"><img src="imgs/cityFlow.webp"></a>
    </div>

    <div class="hamburguer" id="hamburguer">
        <i class="fa-solid fa-bars"></i>
    </div>

    <a href="mapa.php" target="_blank">
        <button class="botaoMapa">MAPA</button>
    </a>

    <nav>
        <ul class="menu">
            <li><a href="index.php">INÍCIO</a></li>
            <li><a href="informacoes.php">INFORMAÇÕES</a></li>
            <li><a href="cadastroEvento.php"><i class="fa-solid fa-circle-plus"></i> DIVULGAR EVENTOS</a></li>

            <?php if (isset($_SESSION['usuario_id'])): ?>
                <li class="perfil">
                    <a href="#"><i class="fa-solid fa-circle-user"></i> <?php echo $_SESSION['nome_usuario']; ?></a>
                    <ul class="submenu">
                        <li><a href="minhaConta.php"><i class="fa-solid fa-user-gear"></i> Minha Conta</a></li>
                        <li><a href="minhaConta.php#favoritos"><i class="fa-solid fa-heart"></i> Favoritos</a></li>
                        <li><a href="ajuda.php"><i class="fa-solid fa-circle-question"></i> Central de ajuda</a></li>
                        <li><a href="logout.php" class="btn-sair"><i class="fa-solid fa-right-from-bracket"></i> Sair</a></li>
                    </ul>
                </li>
            <?php else: ?>
                <li>
                    <div class="menu-container" id="abrirModal">
                        <i class="fa-solid fa-arrow-right-to-bracket"></i>
                        <span class="texto-entrar">ENTRAR</span>
                    </div>
                </li>
            <?php endif; ?>
        </ul>
    </nav>
</header>

<!-- =========================================================
   MODAL LOGIN
========================================================= -->
<div id="modal" class="modal">
    <div class="modal-conteudo">
        <span class="fechar">&times;</span>

        <h1>QUE BOM TER VOCÊ AQUI!</h1>
        <h3>FAÇA SEU LOGIN</h3>

        <?php if($erroLogin != ""): ?>
            <p class="erro-login"><?php echo $erroLogin; ?></p>
        <?php endif; ?>

        <form action="fazerLogin.php" method="POST">
            <label>E-MAIL:</label>
            <input type="email" name="emailLogin" required>

            <label>SENHA:</label>
            <input type="password" name="senhaLogin" required>

            <button type="submit">ENTRAR</button>
        </form>

        <h4>Não possui uma conta?</h4>
        <a href="cadastroUsuario.php">Cadastre-se</a>
    </div>
</div>

<!-- =========================================================
   SCRIPT MODAL
========================================================= -->
<script>
document.addEventListener("DOMContentLoaded", function() {

    const logado = <?php echo isset($_SESSION['usuario_id']) ? 'true' : 'false'; ?>;
    const modal = document.getElementById("modal");

    if (logado && modal) {
        modal.style.display = "none";
    }

    const abrir = document.getElementById("abrirModal");
    if (abrir) {
        abrir.addEventListener("click", () => {
            if (!logado) modal.style.display = "flex";
        });
    }

    const fechar = document.querySelector(".fechar");
    if (fechar) {
        fechar.addEventListener("click", () => {
            modal.style.display = "none";
        });
    }

});
</script>

<!-- =========================================================
   CARROSSEL PRINCIPAL
========================================================= -->
<section class="carousel-section">
    <div class="carousel-container">

        <?php if($resultado && $resultado->num_rows > 0): ?>
            <?php 
            $i = 0;
            while($evento = $resultado->fetch_assoc()): 
                $activeClass = ($i == 0) ? "active" : "";
            ?>

                <div class="carousel-slide <?php echo $activeClass; ?>"
                    style="
                        background-image:
                        linear-gradient(rgba(0,0,0,0.25), rgba(0,0,0,0.65)),
                        url('uploads/<?php echo htmlspecialchars($evento['Imagem']); ?>');
                    ">

                    <div class="overlay">
                        <h1><?php echo htmlspecialchars($evento['titulo']); ?></h1>

                        <p>
                            <i class="fa-solid fa-location-dot"></i>
                            <?php echo htmlspecialchars($evento['bairro']); ?> -
                            <?php echo htmlspecialchars($evento['cidade']); ?>
                        </p>

                        <a href="eventos.php?id=<?php echo $evento['id_evento']; ?>" class="btn-saiba">
                            Saiba mais
                        </a>
                    </div>

                </div>

            <?php 
                $i++;
            endwhile; 
            ?>
        <?php endif; ?>

        <button class="carousel-arrow prev"><i class="fa-solid fa-chevron-left"></i></button>
        <button class="carousel-arrow next"><i class="fa-solid fa-chevron-right"></i></button>

    </div>
</section>

<!-- =========================================================
   SCRIPT CARROSSEL PRINCIPAL
========================================================= -->
<script>
const slides = document.querySelectorAll('.carousel-slide');
const prevBtn = document.querySelector('.carousel-arrow.prev');
const nextBtn = document.querySelector('.carousel-arrow.next');

let current = 0;

function updateCarousel(){

    slides.forEach(slide => {
        slide.classList.remove('active','prev','next');
    });

    slides[current].classList.add('active');

    const prev = (current - 1 + slides.length) % slides.length;
    const next = (current + 1) % slides.length;

    slides[prev].classList.add('prev');
    slides[next].classList.add('next');
}

function nextSlide(){
    current++;
    if(current >= slides.length) current = 0;
    updateCarousel();
}

function prevSlide(){
    current--;
    if(current < 0) current = slides.length - 1;
    updateCarousel();
}

nextBtn.addEventListener('click', () => { nextSlide(); resetAutoSlide(); });
prevBtn.addEventListener('click', () => { prevSlide(); resetAutoSlide(); });

let autoSlide = setInterval(() => { nextSlide(); }, 5000);

function resetAutoSlide(){
    clearInterval(autoSlide);
    autoSlide = setInterval(() => { nextSlide(); }, 5000);
}

updateCarousel();
</script>

<!-- =========================================================
   COLEÇÕES
========================================================= -->
<?php
$colecoes = [
    ['id'=>1,'label'=>'MÚSICA','icone'=>'fa-solid fa-music'],
    ['id'=>2,'label'=>'DANÇA','icone'=>'fa-solid fa-person-dress'],
    ['id'=>3,'label'=>'LEITURA','icone'=>'fa-solid fa-book-open'],
    ['id'=>4,'label'=>'GASTRONOMIA','icone'=>'fa-solid fa-utensils'],
    ['id'=>5,'label'=>'ESPORTE','icone'=>'fa-solid fa-football'],
    ['id'=>6,'label'=>'CINEMA','icone'=>'fa-solid fa-film'],
    ['id'=>7,'label'=>'TEATRO','icone'=>'fa-solid fa-masks-theater'],
    ['id'=>8,'label'=>'PERFORMANCE','icone'=>'fa-solid fa-star'],
    ['id'=>9,'label'=>'PINTURA/ARTE','icone'=>'fa-solid fa-palette'],
    ['id'=>10,'label'=>'EDUCAÇÃO','icone'=>'fa-solid fa-graduation-cap'],
    ['id'=>11,'label'=>'STANDUPS','icone'=>'fa-solid fa-microphone'],
    ['id'=>12,'label'=>'CONGRESSOS/PALESTRAS','icone'=>'fa-solid fa-users'],
    ['id'=>13,'label'=>'CURSOS/WORKSHOPS','icone'=>'fa-solid fa-laptop'],
    ['id'=>14,'label'=>'PRIDE','icone'=>'fa-solid fa-rainbow'],
    ['id'=>15,'label'=>'RELIGIÃO/ESPIRITUALIDADE','icone'=>'fa-solid fa-dove'],
    ['id'=>16,'label'=>'RECITAR','icone'=>'fa-solid fa-pen-nib'],
    ['id'=>17,'label'=>'ESCRITA/POEMAS','icone'=>'fa-solid fa-feather']
];
?>

<section class="container-carrossel">
    <h3>EXPLORE NOSSAS COLEÇÕES</h3>

    <div class="track" id="carrossel-track">
        <?php foreach ($colecoes as $colecao): ?>
            <a href="categoria.php?id=<?php echo $colecao['id']; ?>" class="card">
                <div class="icon-box">
                    <i class="<?php echo $colecao['icone']; ?>"></i>
                </div>
                <span><?php echo $colecao['label']; ?></span>
            </a>
        <?php endforeach; ?>
    </div>

    <div class="btn-next">
        <button class="arrow prev" onclick="rolarEsquerda()">&#10094;</button>
        <button class="arrow next" onclick="rolarDireita()">&#10095;</button>
    </div>
</section>

<script>
const track = document.getElementById('carrossel-track');

function rolarDireita(){
    track.scrollBy({ left: 320, behavior: 'smooth' });
}

function rolarEsquerda(){
    track.scrollBy({ left: -320, behavior: 'smooth' });
}
</script>

<!-- =========================================================
   MINI CARROSSEIS
========================================================= -->
<section class="mini-carousel-container">

   <div class="titulo-carrossel">
    <span>EVENTOS HOJE</span>

    <div class="placa-data" id="dataHoje"></div>
</div>

    <button class="mini-arrow left"
            onclick="scrollMini('hoje', -1)">
        <i class="fa-solid fa-chevron-left"></i>
    </button>

    <div class="mini-carousel-track" id="hoje">

        <?php while($e = $resultHoje->fetch_assoc()): ?>

          <div class="mini-card">

    <div class="mini-img">
        <img src="uploads/<?php echo $e['Imagem']; ?>" alt="">
    </div>

    <div class="mini-info">

        <span class="mini-data">
            <?php echo date('d/m', strtotime($e['data_inicio'])); ?>
        </span>

        <h3><?php echo $e['titulo']; ?></h3>

        <p class="mini-local">
            <i class="fa-solid fa-location-dot"></i>
            <?php echo $e['bairro']; ?> - <?php echo $e['cidade']; ?>
        </p>

        <p class="mini-hora">
            <i class="fa-solid fa-clock"></i>
            <?php echo substr($e['horario_inicio'],0,5); ?>
        </p>

        <a href="eventos.php?id=<?php echo $e['id_evento']; ?>">
            Saiba Mais
        </a>

</div>

            </div>

        <?php endwhile; ?>

    </div>

    <button class="mini-arrow right"
            onclick="scrollMini('hoje', 1)">
        <i class="fa-solid fa-chevron-right"></i>
    </button>

</section>

<section class="mini-carousel-container">

    <h2 class="titulo-carrossel">EVENTOS INFANTIS</h2>

    <button class="mini-arrow left"
            onclick="scrollMini('kids', -1)">
        <i class="fa-solid fa-chevron-left"></i>
    </button>

    <div class="mini-carousel-track" id="kids">

        <?php if($resultKids && $resultKids->num_rows > 0): ?>
            <?php while($e = $resultKids->fetch_assoc()): ?>
<div class="mini-card">

    <div class="mini-img">
        <img src="uploads/<?php echo $e['Imagem']; ?>" alt="">
    </div>

    <div class="mini-info">

        <span class="mini-data">
            <?php echo date('d/m', strtotime($e['data_inicio'])); ?>
        </span>

        <h3><?php echo $e['titulo']; ?></h3>

        <p class="mini-local">
            <i class="fa-solid fa-location-dot"></i>
            <?php echo $e['bairro']; ?> - <?php echo $e['cidade']; ?>
        </p>

        <p class="mini-hora">
            <i class="fa-solid fa-clock"></i>
            <?php echo substr($e['horario_inicio'],0,5); ?>
        </p>

        <a href="eventos.php?id=<?php echo $e['id_evento']; ?>">
            Saiba Mais
        </a>

</div>
                </div>

            <?php endwhile; ?>
        <?php endif; ?>

    </div>

    <button class="mini-arrow right"
            onclick="scrollMini('kids', 1)">
        <i class="fa-solid fa-chevron-right"></i>
    </button>

</section>

<script>
function scrollMini(id, direction){

    const track = document.getElementById(id);

    track.scrollBy({
        left: direction * 600,
        behavior: "smooth"
    });
}
</script>

<script>
const hoje = new Date();

const dia = String(hoje.getDate()).padStart(2,'0');
const mes = String(hoje.getMonth() + 1).padStart(2,'0');

document.getElementById('dataHoje').textContent = `${dia}/${mes}`;
</script>

<!-- =========================================================
   FOOTER
========================================================= -->
<?php include 'footer.php'; ?>
</body>
</html>