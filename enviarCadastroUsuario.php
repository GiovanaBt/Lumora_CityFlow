<?php
session_start();
include 'Conexao.php';

$nomeCompleto = $_POST['nomeCompleto'];
$dataNascimento = $_POST['dataNascimento'];
$email = $_POST['email'];
$senha = $_POST['senha'];
$nomeUsuario = $_POST['nomeUsuario'];
$cpf = $_POST['cpf'];
$telefone = $_POST['telefone'];

$sql = "INSERT INTO usuarios (
    nome_completo,
    data_nascimento,
    cpf,
    telefone,
    email,
    senha,
    nome_usuario
) VALUES (
    '$nomeCompleto',
    '$dataNascimento',
    '$cpf',
    '$telefone',
    '$email',
    '$senha',
    '$nomeUsuario'
)";

if ($conexao->query($sql) === TRUE) {
    $idUsuario = $conexao->insert_id;

    $_SESSION['usuario_id'] = $idUsuario;
    $_SESSION['nome_usuario'] = $nomeUsuario;
    $_SESSION['nome_completo'] = $nomeCompleto;

    echo "<script>
            window.location.href = 'index.php';
          </script>";

} else {
    echo "Erro: " . $conexao->error;
}

$conexao->close();
?>
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