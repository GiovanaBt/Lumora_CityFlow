<?php
session_start();
include 'Conexao.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: index.php");
    exit();
}

$idUsuario = $_SESSION['usuario_id'];

$sql = "SELECT 
            e.id_evento,
            e.titulo,
            e.subtitulo,
            e.descricao,
            e.Imagem,
            e.rua,
            e.bairro,
            e.numero,
            e.cidade,
            e.CEP,
            e.ponto_referencia,
            e.classificacao_indicativa,
            c.categoria_evento
        FROM eventos_cadastrados e
        LEFT JOIN categoria c 
            ON e.id_categoria = c.id_categoria
        WHERE e.id_usuarios = ?
        ORDER BY e.id_evento DESC";

$stmt = mysqli_prepare($conexao, $sql);
mysqli_stmt_bind_param($stmt, "i", $idUsuario);
mysqli_stmt_execute($stmt);

$resultado = mysqli_stmt_get_result($stmt);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>City Flow - O pulso da sua cidade</title>
     <link rel="stylesheet" href="header.css">
     <link rel="stylesheet" href="footer.css">
     <link rel="stylesheet" href="submenu.css">
    <link rel="shortcut icon" href="imgs/logoCityFlow.webp">
    <link rel="shortcut icon" href="imgs/logoCityFlow.webp">
    <link rel="stylesheet" href="editarMeusEventos.css">
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>

<body>
    <header>
    <div class="logo">
        <a href="index.php">
            <img src="imgs/cityFlow.webp" alt="Logo CityFlow">
        </a>
    </div>

    <a href="mapa.php" target="_blank">
        <button class="botaoMapa">MAPA</button>
    </a>

    <nav>
        <ul class="menu">
            <li><a href="index.php">INÍCIO</a></li>
            <li><a href="informacoes.php">INFORMAÇÕES</a></li>
            <li>
                <a href="cadastroEvento.php">
                    <i class="fa-solid fa-circle-plus"></i> DIVULGAR EVENTOS
                </a>
            </li>

            <?php if (isset($_SESSION['usuario_id'])): ?>
                <li class="perfil">
                    <a href="#">
                        <i class="fa-solid fa-circle-user"></i>
                        <?php echo $_SESSION['nome_usuario']; ?>
                    </a>
                    <ul class="submenu">
                        <li><a href="minhaConta.php"><i class="fa-solid fa-user-gear"></i> Minha Conta</a></li>
                        <li><a href="minhaConta.php#favoritos"><i class="fa-solid fa-heart"></i> Favoritos</a></li>
                        <li><a href="ajuda.php"><i class="fa-solid fa-circle-question"></i> Central de ajuda</a></li>
                        <li><a href="logout.php" class="btn-sair"><i class="fa-solid fa-right-from-bracket"></i> Sair</a></li>
                    </ul>
                </li>
            <?php endif; ?>
        </ul>
    </nav>
</header>

    
<main class="meus-eventos">

    <div class="titulo-pagina">
    <!-- Ícone solto em uma div -->
    <div class="icone-titulo">
        <i class="fa-solid fa-ticket"></i>
    </div>

    <!-- Título + Subtítulo juntos -->
    <div class="texto-titulo">
        <h1>MEUS EVENTOS</h1>
        <p>Aqui estão os eventos que você cadastrou no CityFlow.</p>
    </div>
</div>

    <?php if (mysqli_num_rows($resultado) > 0): ?>

        <div class="eventos-container">

            <?php while ($evento = mysqli_fetch_assoc($resultado)): ?>

                <div class="evento-card">

                    <div class="evento-imagem">

                        <?php if (!empty($evento['Imagem'])): ?>

                           <img src="uploads/<?= htmlspecialchars($evento['Imagem']); ?>"
     alt="<?= htmlspecialchars($evento['titulo']); ?>">

                        <?php else: ?>

                            <div class="sem-imagem">
                                <i class="fa-solid fa-image"></i>
                            </div>

                        <?php endif; ?>

                    </div>

                    <div class="evento-info">

                        <span class="categoria">
                            <?= htmlspecialchars($evento['categoria_evento'] ?? 'Sem categoria'); ?>
                        </span>

                        <h2>
                            <?= htmlspecialchars($evento['titulo']); ?>
                        </h2>

                        <p>
                            <?= htmlspecialchars($evento['subtitulo'] ?? ''); ?>
                        </p>

                        <p class="local">
                            <i class="fa-solid fa-location-dot"></i>

                            <?= htmlspecialchars($evento['cidade']); ?> -
                            <?= htmlspecialchars($evento['bairro']); ?>
                        </p>

                        <a
                            href="editarEvento.php?id=<?= $evento['id_evento']; ?>"
                            class="btn-editar"
                        >
                            <i class="fa-solid fa-pen-to-square"></i>
                            Editar evento
                        </a>

                    </div>

                </div>

            <?php endwhile; ?>

        </div>

    <?php else: ?>

        <div class="nenhum-evento">

            <i class="fa-solid fa-calendar-xmark"></i>

            <h2>Você ainda não criou nenhum evento.</h2>

            <p>
                Cadastre um evento para ele aparecer aqui.
            </p>

            <a href="cadastroEvento.php" class="btn-cadastrar">
                <i class="fa-solid fa-plus"></i>
                Cadastrar evento
            </a>

        </div>

    <?php endif; ?>

</main>

<?php include 'footer.php'; ?>

</body>
</html>