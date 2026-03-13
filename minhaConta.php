<?php
session_start();
include 'Conexao.php';

$idUsuario = $_SESSION['usuario_id'];

$sql = "SELECT * FROM Eventos_Cadastrados 
where id_usuarios = $idUsuario
ORDER BY id_evento DESC";
$result = $conexao->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>City Flow - Concte-se à cultura de sua cidade</title>
    <link rel="stylesheet" href="index.css">
    <link rel="shortcut icon" href="imgs/logoCityFlow.webp" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
body {
    font-family: Arial, sans-serif;
    background: #000000ff;
}
.container {
    display: grid;
    grid-template-columns: repeat(auto-fit,minmax(250px,1fr));
    gap: 20px;
    padding: 30px;
}
.card {
    background: linear-gradient(45deg, #a8329e, #2dbac9);
    border-radius: 20px;
    padding-bottom: 15px;
    text-align: center;
}
.card img {
    width: 100%;
    height: 220px;
    object-fit: contain;
    border-radius: 20px 20px 0 0;
}
.nome {
    font-size: 22px;
    margin: 10px 0;
}
.local {
    color: #000000ff;
}
.data {
    color: #3f3f3fff;
}
.btn {
    display: block;
    margin: 10px auto;
    width: 70%;
    padding: 10px;
    background: #25d366;
    color: white;
    text-decoration: none;
    border-radius: 20px;
}
.meusEventos {
    color: white;
    text-align: center;
}
</style>

</head>

<body>
    <header>
    <div class='logo'>
        <a href="index.php">
            <img src="imgs/cityFlow.webp" alt="logo">
        </a>
    </div>

    <div class="hamburguer" id="hamburguer">
        <i class="fa-solid fa-bars"></i>
    </div>

    <a href="mapa.php" target="_blank">
        <button class="botaoMapa">MAPA</button> 
    </a>

    <nav> 
        <ul class="menu" id="menu"> 
            <li><a href="index.php">INÍCIO</a></li>
            <li><a href="#informacoes">INFORMAÇÕES</a></li>
            <li><a href="cadastroEvento.php"><i class="fa-solid fa-circle-plus"></i>DIVULGAR EVENTOS</a></li>

            <?php 
            /* Início do bloco PHP: Verifica se o usuário está logado.
               Se existir um 'usuario_id' na sessão, ele mostra o menu de Perfil.
            */
            if (isset($_SESSION['usuario_id'])): 
            ?> 
                <li class="perfil">
                    <a href="#">
                        <i class="fa-solid fa-circle-user"></i> <?php echo $_SESSION['nome_usuario']; ?> <i class="fa-solid fa-chevron-down" style="font-size: 10px; margin-left: 5px;"></i> </a>

                    <ul class="submenu">
                        <li class="submenu-header">PERFIL</li> 
                        
                        <li><a href="minhaConta.php"><i class="fa-solid fa-user-gear"></i> Minha Conta</a></li>
                        <li><a href="minhaConta.php#favoritos"><i class="fa-solid fa-heart"></i> Favoritos</a></li>
                        <li><a href="minhaConta.php#meusEventos"><i class="fa-solid fa-calendar-days"></i> Meus eventos</a></li>
                        
                        <hr style="border: 0.5px solid #333; margin: 5px 15px; opacity: 0.2;">
                        
                        <li><a href="logout.php" class="btn-sair"><i class="fa-solid fa-right-from-bracket"></i> Sair</a></li>
                    </ul>
                </li>
            <?php 
            /* Caso o usuário NÃO esteja logado (else), mostra o botão de login.
            */
            else: 
            ?>
                <li>
                    <div class="menu-container" id="abrirModal">
                        <i class="fa-solid fa-arrow-right-to-bracket"></i> <span class="texto-entrar">ENTRAR</span>
                    </div>
                </li>
            <?php endif; // Fim da condição PHP ?> 
        </ul>
    </nav>
</header>

<section id='meusEventos'>
<h1 class='meusEventos'>Meus Eventos</h1>

<div class="container">
    <?php while($row = $result->fetch_assoc()): ?>
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