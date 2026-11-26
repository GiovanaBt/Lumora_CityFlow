
<?php
$ano_atual = date('Y');

$paginaAtual = basename($_SERVER['PHP_SELF']);
$desativarLinks = ($paginaAtual === 'cadastroUsuario.php');

$footer_data = [
    'ajuda' => [
        'titulo' => 'Ajuda',
        'links' => [
            ['txt'=>'Central de Ajuda','url'=>'ajuda.php'],
            ['txt'=>'FAQ','url'=>'informacoes.php'],
            ['txt'=>'Contato e Suporte','url'=>'ajuda.php'],
            ['txt'=>'Reportar Problema','url'=>'ajuda.php']
        ]
    ],

    'eventos' => [
        'titulo' => 'Eventos',
        'links' => [
            ['txt'=>'Explorar','url'=>'eventos.php'],
            ['txt'=>'Mapa','url'=>'mapa.php'],
            ['txt'=>'Cadastrar Evento','url'=>'cadastroEvento.php'],
            ['txt'=>'Favoritos','url'=>'minhaConta.php']
        ]
    ],

    'institucional' => [
        'titulo' => 'Institucional',
        'links' => [
            ['txt'=>'Sobre o CityFlow','url'=>'informacoes.php'],
            ['txt'=>'Missão e Valores','url'=>'informacoes.php'],
            ['txt'=>'Privacidade','url'=>'informacoes.php'],
            ['txt'=>'Termos de Uso','url'=>'informacoes.php']
        ]
    ]
];
?>

<footer class="footer-main">
    <div class="footer-overlay">
        <div class="footer-container">

            <div class="footer-brand">

                <div class="logo-wrapper">
                    <span class="logo-city">CITY</span>
                    <span class="logo-flow">FLOW</span>
                </div>

                <p class="brand-text">
                    Conectando a essência das ruas e a cultura urbana.
                    Descubra eventos, arte e movimento em um só lugar.
                </p>

                <div class="social-icons">
                    <?php foreach (['IG', 'FB', 'X'] as $rede): ?>
                        <?php if ($desativarLinks): ?>
                            <span><?= $rede ?></span>
                        <?php else: ?>
                            <a href="#"><?= $rede ?></a>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>

            </div>

            <?php foreach ($footer_data as $coluna): ?>

                <div class="footer-col">

                    <h4 class="footer-title">
                        <?= htmlspecialchars($coluna['titulo']); ?>
                    </h4>

                    <ul class="footer-links">

                        <?php foreach ($coluna['links'] as $link): ?>

                            <li>
                                <?php if ($desativarLinks): ?>
                                    <span class="footer-link-desativado">
                                        <?= htmlspecialchars($link['txt']); ?>
                                    </span>
                                <?php else: ?>
                                    <a href="<?= htmlspecialchars($link['url']); ?>">
                                        <?= htmlspecialchars($link['txt']); ?>
                                    </a>
                                <?php endif; ?>
                            </li>

                        <?php endforeach; ?>

                    </ul>

                </div>

            <?php endforeach; ?>

        </div>

        <div class="footer-bottom">
            © <?= $ano_atual ?> CityFlow - Todos os direitos reservados.
        </div>

    </div>
</footer>
