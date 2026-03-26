<?php
include 'Conexao.php';

$id = isset($_GET['id']) ? mysqli_real_escape_string($conexao, $_GET['id']) : 0;

$sql = "SELECT e.*, c.categoria_evento 
        FROM eventos_cadastrados e 
        INNER JOIN categoria c ON e.id_categoria = c.id_categoria 
        WHERE e.id_evento = '$id'";

$result = $conexao->query($sql);
$evento = $result->fetch_assoc();

if (!$evento) {
    die("<style>body{background:#000;color:#fff;display:flex;justify-content:center;align-items:center;height:100vh;}</style><h1>Evento não encontrado!</h1>");
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($evento['titulo']); ?> | CityFlow</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', sans-serif; }
        body { background-color: #0b0e14; color: #ffffff; padding: 20px; }
        .main-container { max-width: 1100px; margin: 40px auto; }
        .header-evento { text-align: center; margin-bottom: 40px; }
        .badge-categoria { background: #00bcd4; color: #000; padding: 6px 16px; border-radius: 50px; font-weight: bold; font-size: 0.8rem; text-transform: uppercase; }
        /* Ajuste para o título não quebrar o visual se for longo */
        .header-evento h1 { font-size: 2.8rem; margin-top: 15px; text-transform: uppercase; color: #fff; line-height: 1.2; }
        .grid-evento { display: grid; grid-template-columns: 1.2fr 1fr; gap: 40px; }
        .container-imagem img { width: 100%; border-radius: 15px; border: 1px solid #30363d; box-shadow: 0 15px 40px rgba(0,0,0,0.6); }
        .secao-info { background: #161b22; padding: 25px; border-radius: 12px; border: 1px solid #30363d; margin-bottom: 20px; }
        .secao-info h3 { color: #00bcd4; margin-bottom: 12px; font-size: 1.1rem; text-transform: uppercase; }
        .info-item p { margin-bottom: 8px; color: #c9d1d9; font-size: 1.1rem; }
        .descricao-texto { color: #8b949e; line-height: 1.8; white-space: pre-wrap; font-size: 1.1rem; text-align: justify; }
        
        /* Botão de voltar para facilitar a navegação */
        .btn-voltar { display: inline-block; margin-bottom: 20px; color: #00bcd4; text-decoration: none; font-weight: bold; }
        .btn-voltar:hover { text-decoration: underline; }

        @media (max-width: 850px) { .grid-evento { grid-template-columns: 1fr; } }
    </style>
</head>
<body>

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
            <p style="color: #00bcd4; font-size: 0.9rem; margin-top: 10px;">
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