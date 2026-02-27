<!DOCTYPE html>
<html lang="en">
<?php
session_start();
include 'Conexao.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: index.php");
    exit();
}

$idUsuario = $_SESSION['usuario_id'];

$sql = "SELECT * FROM Eventos_Cadastrados 
        WHERE id_usuarios = ? 
        ORDER BY id_evento DESC";

$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $idUsuario);
$stmt->execute();

$result = $stmt->get_result();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>City Flow - Concte-se à cultura de sua cidade</title>
    <link rel="stylesheet" href="minhaConta.css">
    <link rel="shortcut icon" href="imgs/logoCityFlow_removebg.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

</head>

<body>
<header>
    <div class='logo'>
    <a href="index.php">
        <img src="imgs/logoCityFlow.webp" alt="logo">
    </a>
    </div>

    <div class="hamburguer" id="hamburguer">
        <i class="fa-solid fa-bars"></i>
    </div>

    <ul class="menu" id="menu">
    <li><a href="#informacoes">Informações</a></li>
    <li><a href="cadastroEvento.php">Divulgar Eventos</a></li>

    <?php if (isset($_SESSION['usuario_id'])): ?>
        <!-- Usuário LOGADO -->
        <li class="perfil">
            <a href="#">
                <i class="fa-solid fa-circle-user"></i>
                <?php echo $_SESSION['nome_usuario']; ?>
            </a>

            <ul class="submenu">
                <li><a href="minhaConta.php">Minha conta</a></li>
                <li><a href="favoritos.php">Favoritos</a></li>
                <li><a href="meusEventos.php">Meus eventos</a></li>
                <li><a href="ajuda.php">Central de ajuda</a></li>
                <li><a href="logout.php">Sair</a></li>
            </ul>
        </li>

    <?php else: ?>
        <li>
            <a id="abrirModal">
                <i class="fa-solid fa-circle-user"></i>
            </a>
        </li>
    <?php endif; ?>
</ul>

</header>
<body>
    <h1>Minha conta eba eba </h1>
<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
    <section id="favoritos">
        <h1>Favoritos</h1>
    </section>
    <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
    <section id="meusEventos">
<h1 style="text-align:center;">Meus Eventos</h1>

<div class="container">

    <div class="container">

    <?php while($row = $result->fetch_assoc()): ?>

        <div class="card">
            <img src="uploads/<?= $row['Imagem']; ?>" alt="<?= $row['descricao']; ?>">

            <div class="nome"><?= $row['descricao']; ?></div>
            <div class="local"><?= $row['rua']; ?> <?= $row['numero']; ?>, <?= $row['bairro']; ?></div>
            <div class="data">Data: <?= date("d/m/Y", strtotime($row['data_inicio_evento'])); ?></div>
        </div>

    <?php endwhile; ?>

    </div>

</div>
    </section>
</body>
</html>