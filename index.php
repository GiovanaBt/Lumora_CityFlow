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
$sql = "SELECT id_evento, titulo, Imagem, data_inicio_evento, bairro, cidade 
        FROM eventos_cadastrados 
        WHERE data_inicio_evento >= CURDATE() 
        ORDER BY data_inicio_evento 
        LIMIT 5";
$resultado = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>City Flow - O pulso da sua cidade</title>
    <link rel="stylesheet" href="index.css">
    <link rel="shortcut icon" href="imgs/logoCityFlow.webp">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

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
                        <hr style="border:0.5px solid #333; margin:5px 15px; opacity:0.2;">
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

<section class="carousel-section">
    <div class="carousel-container">
        <button class="arrow prev">&#10094;</button>
        <button class="arrow next">&#10095;</button>

        <?php if($resultado && $resultado->num_rows > 0): ?>
            <?php 
            $i = 0;
            while($evento = $resultado->fetch_assoc()): 
                $activeClass = ($i == 0) ? "active" : "";
            ?>
                <div class="carousel-slide <?php echo $activeClass; ?>" 
                     style="background-image:linear-gradient(rgba(0,0,0,0.3), rgba(0,0,0,0.6)), url('uploads/<?php echo $evento['Imagem']; ?>')">
                    <div class="overlay">
                        <h1><?php echo htmlspecialchars($evento['titulo']); ?></h1>
                        <p><i class="fa-regular fa-calendar"></i> <?php echo date("d/m/Y", strtotime($evento['data_inicio_evento'])); ?></p>
                        <p><i class="fa-solid fa-location-dot"></i> <?php echo htmlspecialchars($evento['bairro']); ?> - <?php echo htmlspecialchars($evento['cidade']); ?></p>
                        
                        <a href="eventos.php?id=<?php echo $evento['id_evento']; ?>">
                            <button class="btn-saiba">Saiba mais</button>
                        </a>
                    </div>
                </div>
            <?php 
                $i++;
            endwhile; 
            ?>
        <?php endif; ?>
    </div>
</section>

<script src="script.js"></script>

<?php if($erroLogin != ""): ?>
<script>
    document.addEventListener("DOMContentLoaded", function(){
        const modalLogin = document.getElementById("modal");
        if(modalLogin) {
            modalLogin.style.display = "block";
        }
    });
</script>
<?php endif; ?>
<?php
// 1. Definição dos Dados
$colecoes = [
    ['label' => 'MÚSICA',     'slug' => 'musica',      'icone' => 'img/icon-music.png'],
    ['label' => 'DANÇA',      'slug' => 'danca',       'icone' => 'img/icon-dance.png'],
    ['label' => 'LEITURA',    'slug' => 'leitura',     'icone' => 'img/icon-book.png'],
    ['label' => 'GASTRONOMIA', 'slug' => 'gastronomia', 'icone' => 'img/icon-food.png'],
    ['label' => 'ESPORTE',    'slug' => 'esporte',     'icone' => 'img/icon-sport.png'],
    ['label' => 'CINEMA',    'slug' => 'cinema',     'icone' => 'img/icon-cinema.png'],
    ['label' => 'TEATRO',    'slug' => 'teatro',     'icone' => 'img/icon-teatro.png'],
    ['label' => 'PERFORMANCE',    'slug' => 'performance',     'icone' => 'img/icon-performance.png'],
    ['label' => 'PINTURA/ARTE',    'slug' => 'pintura/arte',     'icone' => 'img/icon-pintura/arte.png'],
    ['label' => 'EDUCAÇÃO',    'slug' => 'educação',     'icone' => 'img/icon-educação.png'],
    ['label' => 'STANDUP',    'slug' => 'stand up',     'icone' => 'img/icon-standup.png'],
    ['label' => 'CONGRESSOS E PALESTRAS',    'slug' => 'Congressos e palestras',     'icone' => 'img/icon-Congressos e palestras.png'],
    ['label' => 'CURSOS E WORKSHOPS',    'slug' => 'Cursos e workshops',     'icone' => 'img/icon-Cursos e workshops.png'],
    ['label' => 'PRIDE',    'slug' => 'Pride',     'icone' => 'img/icon-Pride.png'],
    ['label' => 'REIGIÃO E ESPIRITUALIDADE',    'slug' => 'Religião e espiritualidade',     'icone' => 'img/icon-Religião e espiritualidade.png'],
    ['label' => 'RECITAR',    'slug' => 'Recitar',     'icone' => 'img/icon-Recitar.png'],
    ['label' => 'ESCRITA/POEMAS',    'slug' => 'Escrita/poemas',     'icone' => 'img/icon-Escrita/poemas.png'],
];
?>

<section class="container-carrossel">
    <h3>EXPLORE NOSSAS COLEÇÕES</h3>

    <div class="track" id="carrossel-track">
        <?php foreach ($colecoes as $colecao): ?>
            <a href="categoria.php?tipo=<?php echo $colecao['slug']; ?>" class="card">
                <div class="icon-box">
                    <img src="<?php echo $colecao['icone']; ?>" alt="Ícone <?php echo $colecao['label']; ?>" style="width: 45px; transition: transform 0.3s;">
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

<style>
.container-carrossel {
    background: linear-gradient(135deg, #3d1a42 0%, #1a3a4a 100%);
    padding: 40px 20px;
    border-radius: 25px;
    position: relative;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    color: #fff;
    overflow: hidden;
}

.track {
    display: flex;
    gap: 20px;
    overflow-x: auto;
    padding: 20px 10px;
    /* Suaviza o scroll manual e via JS */
    scroll-behavior: smooth; 
    scrollbar-width: none;
    -ms-overflow-style: none;
}

.track::-webkit-scrollbar {
    display: none;
}

.card {
    background: rgba(233, 236, 239, 1);
    min-width: 140px;
    height: 140px;
    border-radius: 22px;
    text-decoration: none;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    color: #333;
    font-weight: 700;
    font-size: 11px;
    flex-shrink: 0;
    text-align: center;
    box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    
    /* Animação suave ao passar o mouse */
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}

/* Efeito de "Levantar" o card ao passar o mouse */
.card:hover {
    transform: translateY(-10px) scale(1.05);
    background: #ffffff;
    box-shadow: 0 10px 25px rgba(0,0,0,0.3);
}

.card:hover img {
    transform: rotate(10deg) scale(1.1);
}

.btn-next {
    display: flex;
    justify-content: center;
    gap: 30px;
    margin-top: 20px;
}

.arrow {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(5px); /* Efeito de vidro */
    border: 1px solid rgba(255, 255, 255, 0.3);
    color: white;
    width: 50px;
    height: 50px;
    cursor: pointer;
    border-radius: 50%;
    font-size: 18px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
}

.arrow:hover {
    background: #fff;
    color: #3d1a42;
    transform: scale(1.1);
}

.arrow:active {
    transform: scale(0.9);
}
</style>

<script>
const track = document.getElementById('carrossel-track');

function rolarDireita() {
    // Rola uma quantidade baseada na largura do card + gap
    track.scrollBy({ left: 320, behavior: 'smooth' });
}

function rolarEsquerda() {
    track.scrollBy({ left: -320, behavior: 'smooth' });
}
</script>
</body>
</html>