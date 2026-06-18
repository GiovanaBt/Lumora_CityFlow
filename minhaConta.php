<?php
session_start();
include 'Conexao.php';

/* PROTEÇÃO */
if (!isset($_SESSION['usuario_id'])) {
    header("Location: index.php");
    exit();
}

$idUsuario = $_SESSION['usuario_id'];

/* DADOS DO USUÁRIO */
$sqlUsuario = "SELECT * FROM usuarios WHERE id_usuarios = $idUsuario";
$resultUsuario = mysqli_query($conexao, $sqlUsuario);
$usuario = mysqli_fetch_assoc($resultUsuario);

/* FAVORITOS */
$sqlFavoritos = "
SELECT e.*
FROM favoritos f
JOIN eventos_cadastrados e ON e.id_evento = f.id_evento
WHERE f.id_usuario = $idUsuario
";
$resultFavoritos = mysqli_query($conexao, $sqlFavoritos);

/* MEUS EVENTOS */
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
<title>City Flow - Minha Conta</title>

<link rel="stylesheet" href="header.css">
<link rel="stylesheet" href="minhaConta.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

<link rel="shortcut icon" href="imgs/logoCityFlow.webp">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body>

<!-- HEADER (NÃO ALTERADO) -->
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
                        <li><a href="minhaConta.php">Minha Conta</a></li>
                        <li><a href="minhaConta.php#favoritos">Favoritos</a></li>
                        <li><a href="ajuda.php">Ajuda</a></li>
                        <hr>
                        <li><a href="logout.php" class="btn-sair">Sair</a></li>
                    </ul>
                </li>
            <?php endif; ?>
        </ul>
    </nav>
</header>

<!--LAYOUT NOVO -->
<div class="layout-conta">

    <!-- 🔹 ESQUERDA (DADOS) -->
    <div class="lado-esquerdo">

        <h1 class="titulo-principal">Minha Conta</h1>
<       <h2 class="subtitulo">Dados da Conta</h2>

        <form action="atualizarUsuario.php" method="POST" class="dados">

            <div class="campo">
                <label>Nome</label>
                <input type="text" name="nome" value="<?= $usuario['nome_usuario']; ?>" id="nome" disabled>
                <i class="fa fa-pen" onclick="habilitarEdicao('nome')"></i>
            </div>

            <div class="campo">
                <label>Email</label>
                <input type="email" name="email" value="<?= $usuario['email']; ?>" id="email" disabled>
                <i class="fa fa-pen" onclick="habilitarEdicao('email')"></i>
            </div>

            <div class="campo">
                <label>Telefone</label>
                <input type="text" name="telefone" value="<?= $usuario['telefone'] ?? ''; ?>" id="telefone" disabled>
                <i class="fa fa-pen" onclick="habilitarEdicao('telefone')"></i>
            </div>

            <div class="campo">
                <label>CPF</label>
                <input type="text" name="cpf" value="<?= $usuario['cpf'] ?? ''; ?>" id="cpf" disabled>
                <i class="fa fa-pen" onclick="habilitarEdicao('cpf')"></i>
            </div>

            <button type="submit" class="btn-salvar" id="btnSalvar">
                Salvar Alterações
            </button>

        </form>

    </div>

    <!--  DIREITA (EVENTOS + FAVORITOS) -->
    <div class="lado-direito">

        <!--  FAVORITOS -->
        <section id="favoritos">
           <h2 class="secao">
    <i class="fa-solid fa-star icone-favorito"></i>
    Meus Favoritos
</h2>

            <div class="container">
                <?php if(mysqli_num_rows($resultFavoritos) > 0): ?>
                    <?php while($fav = mysqli_fetch_assoc($resultFavoritos)): ?>

                        <a href="eventos.php?id=<?= $fav['id_evento']; ?>">
                            <div class="card">
                                <img src="uploads/<?= $fav['Imagem']; ?>">
                                <div class="descricao"><?= $fav['titulo']; ?></div>
                                <div class="local"><?= $fav['bairro']; ?></div>
                            </div>
                        </a>

                    <?php endwhile; ?>
                <?php else: ?>
                    <p>Você não tem favoritos</p>
                <?php endif; ?>
            </div>
        </section>

        <!-- 🎟 EVENTOS -->
        <section id="meusEventos">
            <h2 class="secao">Meus Eventos</h2>

            <div class="container">
                <?php if($resultEventos->num_rows > 0): ?>
                    <?php while($row = $resultEventos->fetch_assoc()): ?>

                        <a href="eventos.php?id=<?= $row['id_evento']; ?>">
                            <div class="card">
                                <img src="uploads/<?= $row['Imagem']; ?>">
                                <div class="descricao"><?= $row['titulo']; ?></div>
                                <div class="local"><?= $row['bairro']; ?></div>
                            </div>
                        </a>

                    <?php endwhile; ?>
                <?php else: ?>
                    <p>Você não criou eventos</p>
                <?php endif; ?>
            </div>
        </section>

    </div>

</div>

<!-- JS -->
<script>
function habilitarEdicao(id) {
    document.getElementById(id).removeAttribute("disabled");
    document.getElementById("btnSalvar").style.display = "block";
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
                    <a href="https://www.instagram.com/seu_perfil" target="_blank" rel="noopener noreferrer" aria-label="Instagram">IG</a>
                    <a href="https://twitter.com/seu_perfil" target="_blank" rel="noopener noreferrer" aria-label="Twitter">TW</a>
                    <a href="https://www.facebook.com/seu_perfil" target="_blank" rel="noopener noreferrer" aria-label="Facebook">FB</a>
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