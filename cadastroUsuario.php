<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>City Flow - Cadastro</title>
    <link rel="stylesheet" href="header.css">
    <link rel="stylesheet" href="cadastroUsuario.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

    <header>
    <div class="logo">
        <a href="index.php"><img src="imgs/cityFlow.webp" alt="Logo CityFlow"></a>
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

                <?php endif; ?>
</header>

    <form action="enviarCadastroUsuario.php" method="POST">
        <a href="javascript:history.back()" class="btn-voltar">&lt;</a>
        
        <h1>CRIE SUA CONTA</h1>
        <h2>PREENCHA OS CAMPOS ABAIXO</h2>
        
        <label>NOME COMPLETO:</label>
        <input type="text" name="nomeCompleto" placeholder="Digite aqui o seu nome completo" required>

        <label>DATA DE NASCIMENTO:</label>
        <input type="date" name="dataNascimento" required>

        <label>CPF:</label>
        <input type="number" name="cpf" placeholder="Digite aqui o seu CPF" required>

        <label>TELEFONE:</label>
        <input type="tel" name="telefone" placeholder="Digite aqui o seu telefone" required>

        <label>E-MAIL:</label>
        <input type="email" name="email" placeholder="Digite aqui o seu E-mail" required>

        <label>SENHA:</label>
        <input type="password" name="senha" placeholder="Digite aqui a sua senha" required>

        <label>NOME DE USUÁRIO:</label>
        <input type="text" name="nomeUsuario" placeholder="Digite aqui o seu nome de usuário" required>

        <button type="submit">ENVIAR</button>
    </form>

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