<?php
$ano_atual = date('Y');

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
                    <a href="#">IG</a>
                    <a href="#">FB</a>
                    <a href="#">X</a>
                </div>

            </div>

            <?php foreach($footer_data as $coluna): ?>

            <div class="footer-col">

                <h4 class="footer-title">
                    <?= $coluna['titulo']; ?>
                </h4>

                <ul class="footer-links">

                    <?php foreach($coluna['links'] as $link): ?>

                    <li>
                        <a href="<?= $link['url']; ?>">
                            <?= $link['txt']; ?>
                        </a>
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