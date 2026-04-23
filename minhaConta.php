<?php
session_start();
include 'Conexao.php';

$idUsuario = $_SESSION['usuario_id'];

// 🔥 FAVORITOS
$sqlFavoritos = "
SELECT e.*
FROM favoritos f
JOIN eventos_cadastrados e ON e.id_evento = f.id_evento
WHERE f.id_usuario = $idUsuario
";
$resultFavoritos = mysqli_query($conexao, $sqlFavoritos);

// 🔥 MEUS EVENTOS
$sqlEventos = "
SELECT * FROM eventos_cadastrados 
WHERE id_usuarios = $idUsuario
ORDER BY id_evento DESC
";
$resultEventos = $conexao->query($sqlEventos);
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>City Flow - Conecte-se à cultura de sua cidade</title>
     <link rel="stylesheet" href="header.css">
    <link rel="stylesheet" href="minhaConta.css">
    <link rel="shortcut icon" href="imgs/logoCityFlow.webp" type="image/x-icon">
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
<section id='favoritos'>
<h1 class='meusEventos'>Meus Favoritos</h1>

<div class="container">
    <?php while($fav = mysqli_fetch_assoc($resultFavoritos)): ?>
    
    <a href="eventos.php?id=<?= $fav['id_evento']; ?>" target="_blank" style="text-decoration:none; color:inherit;">

        <div class="card">
            <img src="uploads/<?= $fav['Imagem']; ?>" alt="">
            <div class="descricao"><?= $fav['titulo']; ?></div>
            <div class="local"><?= $fav['rua'] . ", " . $fav['numero'] . " - " . $fav['bairro']; ?></div>
            <div class="data">Data: <?= date("d/m/Y", strtotime($fav['data_inicio_evento'])); ?></div>
        </div>

    </a>

    <?php endwhile; ?>
</div>
</section>

<section id='meusEventos'>
<h1 class='meusEventos'>Meus Eventos</h1>

<div class="container">
    <?php while($row = $resultEventos->fetch_assoc()): ?>
    <a href="eventos.php?id=<?= $row['id_evento']; ?>" target="_blank" style="text-decoration:none; color:inherit;">

    <div class="card">
        <img src="uploads/<?= $row['Imagem']; ?>" alt="<?= $row['descricao']; ?>">
        <div class="descricao"><?= $row['descricao']; ?></div>
        <div class="local"><?= $row['rua'] . ", " . $row['numero'] . " - " . $row['bairro']; ?></div>
        <div class="data">Data: <?= date("d/m/Y", strtotime($row['data_inicio_evento'])); ?></div>
    </div>

    <?php endwhile; ?>
</div>
</section>

</body>