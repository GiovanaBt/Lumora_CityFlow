<?php
session_start();
include 'Conexao.php';

$id = isset($_GET['id'])
    ? mysqli_real_escape_string($conexao, $_GET['id'])
    : 0;

/* =========================================
   BUSCA EVENTO
========================================= */

$sql = "
SELECT 
    e.*,
    c.categoria_evento

FROM eventos_cadastrados e

INNER JOIN categoria c
ON e.id_categoria = c.id_categoria

WHERE e.id_evento = '$id'
";

$result = $conexao->query($sql);

$evento = $result->fetch_assoc();

if(!$evento){
    die("Evento não encontrado!");
}

/* =========================================
   BUSCA DATAS DO EVENTO
========================================= */

$sqlDatas = "
SELECT *
FROM datas_evento
WHERE id_evento = '$id'
ORDER BY data_inicio ASC
";

$resultDatas = mysqli_query($conexao, $sqlDatas);

/* =========================================
   STATUS USUÁRIO
========================================= */

$jaParticipou = false;
$jaFavoritou = false;

if(isset($_SESSION['usuario_id'])){

    $id_usuario = $_SESSION['usuario_id'];

    /* PARTICIPAÇÃO */
    $verifica = mysqli_query($conexao, "
        SELECT 1
        FROM atividade
        WHERE id_usuarios = '$id_usuario'
        AND id_evento = '$id'
    ");

    $jaParticipou = mysqli_num_rows($verifica) > 0;

    /* FAVORITO */
    $verificaFav = mysqli_query($conexao, "
        SELECT 1
        FROM favoritos
        WHERE id_usuario = '$id_usuario'
        AND id_evento = '$id'
    ");

    $jaFavoritou = mysqli_num_rows($verificaFav) > 0;
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

<meta charset="UTF-8">

<meta
    name="viewport"
    content="width=device-width, initial-scale=1.0"
>

<title>
    <?= htmlspecialchars($evento['titulo']); ?> | CityFlow
</title>

<link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
>

<link rel="stylesheet" href="header.css">
<link rel="stylesheet" href="style_evento.css">

</head>

<body>

<!-- =========================================
     HEADER
========================================= -->

<header>

    <div class="logo">

        <a href="index.php">

            <img src="imgs/cityFlow.webp">

        </a>

    </div>

    <a href="mapa.php" target="_blank">

        <button class="botaoMapa">
            MAPA
        </button>

    </a>

    <nav>

        <ul class="menu">

            <li>
                <a href="index.php">
                    INÍCIO
                </a>
            </li>

            <li>
                <a href="informacoes.php">
                    INFORMAÇÕES
                </a>
            </li>

            <li>
                <a href="cadastroEvento.php">

                    <i class="fa-solid fa-circle-plus"></i>

                    DIVULGAR EVENTOS

                </a>
            </li>

            <?php if(isset($_SESSION['usuario_id'])): ?>

                <li class="perfil">

                    <a href="#">

                        <i class="fa-solid fa-circle-user"></i>

                        <?= $_SESSION['nome_usuario']; ?>

                    </a>

                    <ul class="submenu">

                        <li>
                            <a href="minhaConta.php">
                                Minha Conta
                            </a>
                        </li>

                        <li>
                            <a href="minhaConta.php#favoritos">
                                Favoritos
                            </a>
                        </li>

                        <li>
                            <a href="ajuda.php">
                                Ajuda
                            </a>
                        </li>

                        <li>
                            <a href="logout.php">
                                Sair
                            </a>
                        </li>

                    </ul>

                </li>

            <?php else: ?>

                <li>

                    <div class="menu-container" id="abrirModal">

                        <i class="fa-solid fa-arrow-right-to-bracket"></i>

                        <span>
                            ENTRAR
                        </span>

                    </div>

                </li>

            <?php endif; ?>

        </ul>

    </nav>

</header>

<!-- =========================================
     CONTEÚDO
========================================= -->

<div class="main-container">

    <a href="index.php" class="btn-voltar">

        <i class="fa-solid fa-arrow-left"></i>

        Voltar

    </a>

    <div class="grid-evento">

        <!-- TOPO -->
        <section class="header-evento">

            <!-- ESQUERDA -->
            <div class="info-evento">

                <!-- CATEGORIA -->
                <span class="badge-categoria">

                    <?= htmlspecialchars($evento['categoria_evento']); ?>

                </span>

                <!-- TITULO -->
                <h1>

                    <?= htmlspecialchars($evento['titulo']); ?>

                </h1>
                <!--CLASSIFICAÇÃO INDICATIVA -->
                <div class="classificacao">

                <i class="fa-solid fa-user-shield"></i>

                Classificação:
                
                <?= htmlspecialchars($evento['classificacao_indicativa']); ?>

            </div>

                <!-- DATAS -->
                <div class="datas-evento">

                    <?php while($data = mysqli_fetch_assoc($resultDatas)): ?>

                        <div class="data-box">

                            <span>
                                EVENTO
                            </span>

                            <strong>

                                <?= date("d/m", strtotime($data['data_inicio'])); ?>

                            </strong>

                            <span>

                                <?= date("H:i", strtotime($data['horario_inicio'])); ?>

                                -

                                <?= date("H:i", strtotime($data['horario_fim'])); ?>

                            </span>

                        </div>

                    <?php endwhile; ?>

                </div>

                <!-- LOCAL -->
                <div class="localizacao-topo">

                    <h2>
                        Localização
                    </h2>

                    <div class="linha">

                        <span>
                            Cidade
                        </span>

                        <p>

                            <?= htmlspecialchars($evento['cidade']); ?>

                        </p>

                    </div>

                    <div class="linha">

                        <span>
                            Bairro
                        </span>

                        <p>

                            <?= htmlspecialchars($evento['bairro']); ?>

                        </p>

                    </div>

                    <div class="linha">

                        <span>
                            Rua
                        </span>

                        <p>

                            <?= htmlspecialchars($evento['rua']); ?>,
                            <?= htmlspecialchars($evento['numero']); ?>

                        </p>

                    </div>

                    <?php if(!empty($evento['ponto_referencia'])): ?>

                    <div class="linha">

                        <span>
                            Referência
                        </span>

                        <p>

                            <?= htmlspecialchars($evento['ponto_referencia']); ?>

                        </p>

                    </div>

                    <?php endif; ?>

                    <a
                        href="mapa.php?id=<?= $evento['id_evento']; ?>"
                        class="btn-mapa-local"
                        target="_blank"
                    >

                        <i class="fa-solid fa-location-dot"></i>

                        Ver no mapa

                    </a>

                </div>

            </div>

            <!-- DIREITA -->
            <div class="lado-direito">

                <!-- IMAGEM -->
                <div class="container-imagem">

                    <img
                        src="uploads/<?= htmlspecialchars($evento['Imagem']); ?>"
                        alt="<?= htmlspecialchars($evento['titulo']); ?>"
                    >

                </div>

                <!-- AÇÕES -->
                <div class="card">

                    <h3>
                        Ações
                    </h3>

                    <div class="acoes-evento">

                        <!-- PARTICIPAR -->
                        <button
                            class="btn-acao"
                            id="btnParticipar"
                            data-id="<?= $evento['id_evento']; ?>"
                            <?= $jaParticipou ? 'disabled' : ''; ?>
                        >

                            <?php if($jaParticipou): ?>

                                <i class="fa-solid fa-star"></i>

                                Participando

                            <?php else: ?>

                                <i class="fa-regular fa-star"></i>

                                Participar

                            <?php endif; ?>

                        </button>

                        <!-- FAVORITAR -->
                        <button
                            class="btn-secundario"
                            id="btnFavoritar"
                            data-id="<?= $evento['id_evento']; ?>"
                        >

                            <?php if($jaFavoritou): ?>

                                <i class="fa-solid fa-heart"></i>

                                Favoritado

                            <?php else: ?>

                                <i class="fa-regular fa-heart"></i>

                                Favoritar

                            <?php endif; ?>

                        </button>

                    </div>

                </div>

            </div>

        </section>

        <!-- DESCRIÇÃO -->
        <div class="card">

            <h3>
                Sobre o Evento
            </h3>

            <p>

                <?= nl2br(htmlspecialchars($evento['descricao'])); ?>

            </p>

        </div>

    </div>

</div>

<!-- =========================================
     JS FAVORITO
========================================= -->

<script>

document.addEventListener("DOMContentLoaded", function(){

    const btnFav =
        document.getElementById("btnFavoritar");

    if(!btnFav) return;

    btnFav.addEventListener("click", function(){

        let id = this.dataset.id;

        fetch("favoritar.php", {

            method:"POST",

            headers:{
                "Content-Type":"application/x-www-form-urlencoded"
            },

            body:"id_evento=" + id

        })

        .then(res => res.text())

        .then(res => {

            if(res === "login"){

                alert("Faça login primeiro!");

                return;
            }

            if(res === "ok"){

                this.innerHTML =
                    '<i class="fa-solid fa-heart"></i> Favoritado';
            }

            if(res === "removido"){

                this.innerHTML =
                    '<i class="fa-regular fa-heart"></i> Favoritar';
            }

        });

    });

});

</script>

</body>
</html>