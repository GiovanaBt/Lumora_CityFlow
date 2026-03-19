<?php
session_start();

/* 1. CONEXÃO COM BANCO */
$host = "localhost";
$usuario = "root";
$senha = "Home@spSENAI2025!";
$banco = "cityflow";

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
$sql = "SELECT * FROM eventos_cadastrados 
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
            <li><a href="#informacoes">INFORMAÇÕES</a></li>
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
                     style="background-image:url('uploads/<?php echo $evento['Imagem']; ?>')">
                    <div class="overlay">
                        <h1><?php echo $evento['descricao']; ?></h1>
                        <p><i class="fa-regular fa-calendar"></i> <?php echo date("d/m/Y", strtotime($evento['data_inicio_evento'])); ?></p>
                        <p><i class="fa-solid fa-location-dot"></i> <?php echo $evento['bairro']; ?> - <?php echo $evento['cidade']; ?></p>
                        <button class="btn-saiba">Saiba mais</button>
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
    // Abre o modal automaticamente se houver erro vindo do PHP
    document.addEventListener("DOMContentLoaded", function(){
        const modalLogin = document.getElementById("modal");
        if(modalLogin) {
            modalLogin.style.display = "block";
        }
    });
</script>
<?php endif; ?>

</body>
</html>