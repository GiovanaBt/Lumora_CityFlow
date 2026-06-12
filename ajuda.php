<?php session_start(); // ADICIONADO: Necessário para as sessões funcionarem ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>City Flow - O pulso da sua cidade</title>
    <link rel="stylesheet" href="header.css">
    <link rel="stylesheet" href="ajuda.css">
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
<div class="central-container">
    
    <h1 class="titulo-central">Central de Ajuda</h1>

    <h2 class="subtitulo-faq">Perguntas frequentes sobre:</h2>

    <div class="faq-container">
        
        <div class="faq-topic">
            <button class="topic-header">Como Funciona <span>∨</span></button>
            <div class="topic-content">
                <div class="faq-item">
                    <button class="faq-question">O que é o CityFlow? <span>+</span></button>
                    <div class="faq-answer">
                        <p>Somos uma plataforma dedicada exclusivamente à divulgação de eventos. Nosso objetivo é conectar o público aos melhores eventos da região em um só lugar.</p>
                    </div>
                </div>
                <div class="faq-item">
                    <button class="faq-question">O site vende ingressos? <span>+</span></button>
                    <div class="faq-answer">
                        <p>Não. Nós apenas divulgamos as informações. Para comprar ingressos, você deve clicar no link oficial indicado na página de cada evento, que te levará para a ticketira responsável.</p>
                    </div>
                </div>
                <div class="faq-item">
                    <button class="faq-question">As informações dos eventos são confiáveis? <span>+</span></button>
                    <div class="faq-answer">
                        <p>Trabalhamos para manter tudo atualizado, mas recomendamos sempre conferir as redes sociais oficiais do organizador antes de se deslocar para o evento.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="faq-topic">
            <button class="topic-header">Anunciar Evento <span>∨</span></button>
            <div class="topic-content">
                <div class="faq-item">
                    <button class="faq-question">Como posso cadastrar meu evento? <span>+</span></button>
                    <div class="faq-answer">
                        <p>Basta clicar no botão "Anunciar" no menu principal, preencher o formulário com fotos, descrição, data e link de vendas e aguardar a moderação.</p>
                    </div>
                </div>
                <div class="faq-item">
                    <button class="faq-question">Existe algum custo para divulgar? <span>+</span></button>
                    <div class="faq-answer">
                        <p>Oferecemos planos gratuitos para divulgação básica e opções de "Destaque" para quem deseja maior visibilidade na página inicial.</p>
                    </div>
                </div>
                <div class="faq-item">
                    <button class="faq-question">Quanto tempo demora para meu evento ser aprovado? <span>+</span></button>
                    <div class="faq-answer">
                        <p>Nossa equipe analisa os anúncios em até 24 horas úteis para garantir a qualidade das informações.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="faq-topic">
            <button class="topic-header">Dúvidas de Ingressos <span>∨</span></button>
            <div class="topic-content">
                <div class="faq-item">
                    <button class="faq-question">Não recebi meu ingresso por e-mail, o que eu faço? <span>+</span></button>
                    <div class="faq-answer">
                        <p>Como não realizamos a venda, você deve entrar em contato diretamente com a plataforma onde adquiriu o ingresso (ex: Sympla, Eventim, Blueticket).</p>
                    </div>
                </div>
                <div class="faq-item">
                    <button class="faq-question">O evento foi cancelado, como peço reembolso? <span>+</span></button>
                    <div class="faq-answer">
                        <p>O reembolso deve ser solicitado diretamente ao organizador ou à plataforma de vendas oficial do evento. O CityFlow não gerencia pagamentos.</p>
                    </div>
                </div>
                <div class="faq-item">
                    <button class="faq-question">Posso comprar ingressos diretamente com vocês? <span>+</span></button>
                    <div class="faq-answer">
                        <p>Não. Para sua segurança, nunca realize pagamentos para contas em nome do nosso site; use sempre os links oficiais de compra.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="faq-topic">
            <button class="topic-header">Categorias de Eventos <span>∨</span></button>
            <div class="topic-content">
                <div class="faq-item">
                    <button class="faq-question">Quais tipos de eventos encontro aqui? <span>+</span></button>
                    <div class="faq-answer">
                        <p>Divulgamos desde shows e festas até workshops corporativos, eventos esportivos e feiras culturais.</p>
                    </div>
                </div>
                <div class="faq-item">
                    <button class="faq-question">Como filtro eventos na minha cidade? <span>+</span></button>
                    <div class="faq-answer">
                        <p>Na página inicial, você pode usar nossa barra de busca ou selecionar sua região no menu de filtros para ver apenas o que está perto de você.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="faq-topic">
            <button class="topic-header">Minhas Divulgações <span>∨</span></button>
            <div class="topic-content">
                <div class="faq-item">
                    <button class="faq-question">Como altero informações de um evento? <span>+</span></button>
                    <div class="faq-answer">
                        <p>Acesse sua conta, vá em "Painel do Organizador" e clique em editar no evento desejado. As alterações passarão por uma nova revisão.</p>
                    </div>
                </div>
                <div class="faq-item">
                    <button class="faq-question">Posso excluir um evento encerrado? <span>+</span></button>
                    <div class="faq-answer">
                        <p>Eventos encerrados saem automaticamente da busca principal, mas você pode arquivá-los ou excluí-los através do seu painel de controle.</p>
                    </div>
                </div>
                <div class="faq-item">
                    <button class="faq-question">Como vejo as visualizações do meu anúncio? <span>+</span></button>
                    <div class="faq-answer">
                        <p>No seu painel, disponibilizamos métricas de visualizações e cliques para que você acompanhe o desempenho da sua divulgação.</p>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="atendimento-section">
        <h2 class="titulo-atendimento">Atendimento</h2>
        <div class="atendimento-info">
            <p>✉ lumora.cf@gmail.com</p>
        </div>
    </div>

</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    // Abrir Categorias (Tópicos)
    const topics = document.querySelectorAll(".topic-header");
    topics.forEach(topic => {
        topic.addEventListener("click", function() {
            const content = this.nextElementSibling;
            content.classList.toggle("active-content");
            const span = this.querySelector('span');
            span.innerText = content.classList.contains('active-content') ? '∧' : '∨';
        });
    });

    // Abrir Perguntas
    const questions = document.querySelectorAll(".faq-question");
    questions.forEach(question => {
        question.addEventListener("click", function() {
            const answer = this.nextElementSibling;
            answer.classList.toggle("active-content");
        });
    });
});
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
                    <a href="#" aria-label="Instagram">IG</a>
                    <a href="#" aria-label="Twitter">TW</a>
                    <a href="#" aria-label="Facebook">FB</a>
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