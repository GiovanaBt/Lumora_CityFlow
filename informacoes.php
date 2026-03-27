<?php
include 'Conexao.php';
if (!isset($_SESSION)) { session_start(); }

// Proteção: Se não estiver logado, redireciona para a index ou exibe erro
if (!isset($_SESSION['usuario_id'])) {
    echo "<script>alert('Você precisa estar logado para acessar esta página.'); window.location.href='index.php';</script>";
    exit;
}
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>CityFlow - Informações</title>
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="informacoes.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
</html>

<body> 

<h1 class="info-title">INFORMAÇÕES</i></h1><br><br> 
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
            <li><a href="informacoes.php"><i class="fa-solid fa-circle-info"></i>INFORMAÇÕES</a></li>
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

<h1 class="info-title">INFORMAÇÕES</h1><br><br>
<main class="info-container">
    <h2 class="info-subtitle">INFORMAÇÕES GERAIS</h2>

        <div class="accordion-group">
            <details class="accordion-item"><summary>Sobre o site</summary><div class="content">Somos um site criado para conectar pessoas a experiências urbanas únicas. Reunimos eventos informais, encontros e vivências pela cidade, sempre com foco em praticidade, segurança e inclusão. <br><br> Nosso objetivo é facilitar o acesso a momentos autênticos, promovendo conexões reais em um ambiente leve e acessível para todos.</div></details>
            <details class="accordion-item"><summary>Fale conosco </summary><div class="content"><span style="color: #000000;">Email:</span> <p>lumora.cf@gmail.com</p></div></details>
            <details class="accordion-item"><summary>Termos de uso </summary><div class="content">Ao utilizar o City Flow, você concorda em usar a plataforma de forma respeitosa e responsável. <br><br> O site conecta usuários a eventos organizados por terceiros, e cada participante é responsável por sua conduta durante as experiências. Não é permitido utilizar a plataforma para atividades ilegais ou que prejudiquem outros usuários. <br><br> Os termos podem ser atualizados a qualquer momento para melhorar nossos serviços.</div></details>
            <details class="accordion-item"><summary>Política de Privacidade </summary><div class="content">Sua privacidade é prioridade no City Flow. <br><br> Coletamos apenas os dados necessários para oferecer uma experiência segura e personalizada. Suas informações são protegidas e não são compartilhadas sem necessidade ou autorização. <br><br> Você pode solicitar a atualização ou exclusão dos seus dados a qualquer momento, conforme previsto na legislação.</div></details>
        </div>
    </section>
    <br><br>

    <section class="info-section">
        <h2 class="info-subtitle">FAQ</h2>
        <div class="accordion-group">
            <details class="accordion-item"><summary>Não lembro da senha cadastrada </summary><div class="content">Clique em “Esqueci minha senha” na tela de login e siga as instruções enviadas para o seu e-mail. Em poucos passos você recupera o acesso.</div></details>
            <details class="accordion-item"><summary>Qual a segurança que tenho em fornecer meus dados no site? </summary><div class="content">No City Flow, seus dados são tratados com seriedade. Utilizamos medidas de segurança para proteger suas informações e seguimos a legislação vigente, garantindo privacidade e transparência no uso dos seus dados.</div></details>
            <details class="accordion-item"><summary>Por que tenho que informar e-mail válido? </summary><div class="content">Seu e-mail é essencial para confirmar inscrições, enviar atualizações sobre eventos e permitir a recuperação da sua conta, caso necessário.</div></details>
        </div>
    </section>
    
    <section class="info-section">
        <h2 class="info-subtitle">ACESSIBILIDADE</h2>
        <div class="accordion-group">
            <details class="accordion-item"><summary>Pessoas com sensibilidade sensorial (TEA, TPS, etc.) </summary><div class="content">Se você possui sensibilidade sensorial, recomendamos verificar as informações do evento ou entrar em contato com nossa equipe para orientações específicas. Sempre que possível, incentivamos organizadores a informar detalhes sobre som, iluminação e ambiente.</div></details>
            <details class="accordion-item"><summary>Preciso entrar com medicamentos / insulina, como faço? </summary><div class="content">Se você precisa portar medicamentos, como insulina, fique tranquilo(a). Recomendamos apenas levar a prescrição médica ou justificativa, caso solicitado pela organização do evento. Seu bem-estar vem em primeiro lugar.</div></details>
            </div>
    </section>

    <section class="info-section">
        <h2 class="info-subtitle">LEI GERAL DE PROTEÇÃO DE DADOS</h2>
        <div class="accordion-group">
            <details class="accordion-item"><summary>O que é a Lei Geral de Proteção de Dados (LGPD)?</summary><div class="content">A LGPD (Lei Geral de Proteção de Dados Pessoais – Lei 13.709 de 2018) tem o objetivo de proteger e garantir a privacidade dos dados pessoais dos cidadãos (pessoas físicas) no caso de qualquer tratamento destes dados, incluindo aqueles armazenados por empresas em acervos digitais, por meio regras de coleta, armazenamento e uso dos dados pessoais dos usuários. <br><br> A lei dá direito aos usuários de acesso aos seus dados pessoais armazenados e compartilhados em bancos de dados digitais das empresas, além de outros direitos garantidos aos usuários, bem como define obrigações de tais empresas, além de instituir procedimentos para garantir a segurança dos dados. <br><br> A Lei também prevê a possibilidade de o usuário solicitar informações sobre os dados armazenados e solicitar que seus dados sejam eliminados dos acervos digitais das empresas (desde que seja aplicável nos termos da LGPD). <br><br> Sites, produtos e serviços de terceiros (parceiros) possuem termos de uso e políticas de privacidade próprios, sendo necessário solicitar seus direitos diretamente a esses terceiros.</div></details>
            <details class="accordion-item"><summary>Qual é o objetivo da lei geral de proteção de dados (LGPD)? </summary><div class="content">De acordo com o texto da Lei, ela visa proteger os direitos fundamentais de liberdade e de privacidade e o livre desenvolvimento da personalidade da pessoa natural. O objetivo é também regulamentar qualquer atividade (uso, coleta, armazenamento, compartilhamento, etc que a lei chama de tratamento) de dados pessoais.</div></details>
            </div>
    </section>
</main>
</main>