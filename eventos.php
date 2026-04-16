<?php
session_start();
include 'Conexao.php';

$id = isset($_GET['id']) ? mysqli_real_escape_string($conexao, $_GET['id']) : 0;

$sql = "SELECT e.*, c.categoria_evento 
        FROM eventos_cadastrados e 
        INNER JOIN categoria c ON e.id_categoria = c.id_categoria 
        WHERE e.id_evento = '$id'";

$result = $conexao->query($sql);
$evento = $result->fetch_assoc();

if (!$evento) {
    die("<link rel='stylesheet' href='style_evento.css'><div class='error-container'><h1>Evento não encontrado!</h1></div>");
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($evento['titulo']); ?> | CityFlow</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="style_evento.css">
</head>
<body>

<header class="header-principal">
    <div class="logo">
        <a href="index.php"><img src="imgs/cityFlow.webp" alt="Logo"></a>
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

<div class="main-container">
    <a href="index.php" class="btn-voltar"><i class="fa-solid fa-arrow-left"></i> Voltar para o Início</a>

    <header class="header-evento">
        <span class="badge-categoria"><?= htmlspecialchars($evento['categoria_evento']); ?></span>
        <h1><?= htmlspecialchars($evento['titulo']); ?></h1>
    </header>

    <div class="grid-evento">
        <div class="container-imagem">
            <img src="uploads/<?= $evento['Imagem']; ?>" alt="Capa do Evento">
        </div>

        <div class="container-detalhes">
            <section class="secao-info">
                <h3>📅 Data e Horário</h3>
                <div class="info-item">
                    <p><strong>Início:</strong> <?= date("d/m/Y", strtotime($evento['data_inicio_evento'])); ?> às <?= date("H:i", strtotime($evento['horario_inicio_evento'])); ?></p>
                    <?php if($evento['data_fim_evento'] != $evento['data_inicio_evento']): ?>
                        <p><strong>Término:</strong> <?= date("d/m/Y", strtotime($evento['data_fim_evento'])); ?> às <?= date("H:i", strtotime($evento['horario_fim_evento'])); ?></p>
                    <?php endif; ?>
                </div>
            </section>

            <section class="secao-info">
                <h3>📍 Localização</h3>
                <div class="info-item">
                    <p><strong>Cidade:</strong> <?= htmlspecialchars($evento['cidade']); ?></p>
                    <p><strong>Endereço:</strong> <?= htmlspecialchars($evento['rua']); ?>, <?= $evento['numero']; ?></p>
                    <p><strong>Bairro:</strong> <?= htmlspecialchars($evento['bairro']); ?></p>
                    
                    <?php if(!empty($evento['ponto_referencia'])): ?>
                        <p class="ponto-referencia">
                            <strong>Ponto de Referência:</strong> <?= htmlspecialchars($evento['ponto_referencia']); ?>
                        </p>
                    <?php endif; ?>
                </div>
            </section>

            <section class="secao-info">
                <h3>📝 Sobre o Evento</h3>
                <div class="info-item descricao-texto">
                    <?= nl2br(htmlspecialchars($evento['descricao'])); ?>
                </div>
            </section>
        </div>
    </div>
</div>

</body>
</html>