<?php
include 'Conexao.php';

if (!isset($_SESSION)) { 
    session_start(); 
}

// Proteção: Se não estiver logado
if (!isset($_SESSION['usuario_id'])) {
    echo "<script>alert('Você precisa estar logado para acessar esta página.'); window.location.href='index.php';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CityFlow - Informações</title>
     <link rel="stylesheet" href="header.css">
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="informacoes.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
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

<main class="info-container">

    <h2 class="info-subtitle">INFORMAÇÕES GERAIS</h2>

    <div class="accordion-group">
        <details class="accordion-item">
            <summary>Sobre o site</summary>
            <div class="content">
                Somos um site criado para conectar pessoas a experiências urbanas únicas...
            </div>
        </details>

        <details class="accordion-item">
            <summary>Fale conosco</summary>
            <div class="content">
                <span style="color: #000000;">Email:</span>
                <p>lumora.cf@gmail.com</p>
            </div>
        </details>

        <details class="accordion-item">
            <summary>Termos de uso</summary>
            <div class="content">
                Ao utilizar o City Flow, você concorda em usar a plataforma de forma respeitosa...
            </div>
        </details>

        <details class="accordion-item">
            <summary>Política de Privacidade</summary>
            <div class="content">
                Sua privacidade é prioridade no City Flow...
            </div>
        </details>
    </div>

    <br><br>

    <section class="info-section">
        <h2 class="info-subtitle">FAQ</h2>

        <div class="accordion-group">
            <details class="accordion-item">
                <summary>Não lembro da senha cadastrada</summary>
                <div class="content">
                    Clique em “Esqueci minha senha” na tela de login...
                </div>
            </details>

            <details class="accordion-item">
                <summary>Segurança dos dados</summary>
                <div class="content">
                    No City Flow, seus dados são protegidos...
                </div>
            </details>

            <details class="accordion-item">
                <summary>Por que usar e-mail válido?</summary>
                <div class="content">
                    Seu e-mail é essencial para confirmação e recuperação de conta...
                </div>
            </details>
        </div>
    </section>

    <section class="info-section">
        <h2 class="info-subtitle">ACESSIBILIDADE</h2>

        <div class="accordion-group">
            <details class="accordion-item">
                <summary>Sensibilidade sensorial</summary>
                <div class="content">
                    Recomendamos verificar informações do evento...
                </div>
            </details>

            <details class="accordion-item">
                <summary>Medicamentos / insulina</summary>
                <div class="content">
                    Você pode portar medicamentos normalmente...
                </div>
            </details>
        </div>
    </section>

    <section class="info-section">
        <h2 class="info-subtitle">LGPD</h2>

        <div class="accordion-group">
            <details class="accordion-item">
                <summary>O que é LGPD?</summary>
                <div class="content">
                    A LGPD protege dados pessoais dos usuários...
                </div>
            </details>

            <details class="accordion-item">
                <summary>Objetivo da lei</summary>
                <div class="content">
                    Garantir privacidade e proteção de dados pessoais...
                </div>
            </details>
        </div>
    </section>

</main>

</body>
</html>