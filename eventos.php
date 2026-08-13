<?php
session_start();
include 'Conexao.php';

/* =========================================
   ID DO EVENTO
========================================= */

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

$result = mysqli_query($conexao, $sql);

$evento = mysqli_fetch_assoc($result);

/* =========================================
   EVENTO NÃO ENCONTRADO
========================================= */

if (!$evento) {

    die("Evento não encontrado!");

}

/* =========================================
   DATAS DO EVENTO
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

if (isset($_SESSION['usuario_id'])) {

    $id_usuario = $_SESSION['usuario_id'];

    /* PARTICIPAÇÃO */

    $verificaParticipacao = mysqli_query($conexao, "

        SELECT 1
        FROM atividade
        WHERE id_usuarios = '$id_usuario'
        AND id_evento = '$id'

    ");

    $jaParticipou =
        mysqli_num_rows($verificaParticipacao) > 0;

    /* FAVORITO */

    $verificaFavorito = mysqli_query($conexao, "

        SELECT 1
        FROM favoritos
        WHERE id_usuario = '$id_usuario'
        AND id_evento = '$id'

    ");

    $jaFavoritou =
        mysqli_num_rows($verificaFavorito) > 0;
}
?>

<!DOCTYPE html>

<html lang="pt-br">

<head>

    <!-- META -->
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <!-- TÍTULO -->
    <title>

        <?= htmlspecialchars($evento['titulo']); ?>

        | CityFlow

    </title>

    <!-- FONT AWESOME -->
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
    >

    <!-- CSS -->
    <link rel="stylesheet" href="header.css">
    <link rel="stylesheet" href="style_evento.css">
    <link rel="stylesheet" href="footer.css">
    <link rel="shortcut icon" href="imgs/logoCityFlow.webp">

</head>

<body>

<!-- =========================================
     HEADER
========================================= -->

<header>

    <!-- LOGO -->
    <div class="logo">

        <a href="index.php">

            <img
                src="imgs/cityFlow.webp"
                alt="Logo CityFlow"
            >

        </a>

    </div>

    <!-- MAPA -->
    <a href="mapa.php" target="_blank">

        <button class="botaoMapa">
            MAPA
        </button>

    </a>

    <!-- MENU -->
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

            <!-- PERFIL -->
            <?php if (isset($_SESSION['usuario_id'])): ?>

                <li class="perfil">

                    <a href="#">

                        <i class="fa-solid fa-circle-user"></i>

                        <?= $_SESSION['nome_usuario']; ?>

                    </a>

                    <!-- SUBMENU -->
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

            <?php endif; ?>

        </ul>

    </nav>

</header>

<!-- =========================================
     CONTEÚDO
========================================= -->

<div class="main-container">

    <!-- BOTÃO VOLTAR -->
    <a href="index.php" class="btn-voltar">

        <i class="fa-solid fa-arrow-left"></i>

        Voltar

    </a>

    <!-- GRID -->
    <div class="grid-evento">

        <!-- =====================================
             TOPO EVENTO
        ====================================== -->

        <section class="header-evento">

            <!-- =================================
                 ESQUERDA
            ================================== -->

            <div class="info-evento">

                <!-- CATEGORIA -->
                <span class="badge-categoria">

                    <?= htmlspecialchars($evento['categoria_evento']); ?>

                </span>

                <!-- TÍTULO -->
                <h1>

                    <?= htmlspecialchars($evento['titulo']); ?>

                </h1>

                <!-- =================================
                     INFORMAÇÕES EXTRAS
                ================================== -->

                <div class="top-infos-evento">

                    <!-- CLASSIFICAÇÃO -->
                    <div class="classificacao">

                        <i class="fa-solid fa-user-shield"></i>

                        <span>
                            Classificação:
                        </span>

                        <strong>

                            <?= htmlspecialchars($evento['classificacao_indicativa']); ?>

                        </strong>

                    </div>

                    <!-- CEP -->
                    <div class="info-extra">

                        <i class="fa-solid fa-location-dot"></i>

                        CEP:

                        <?= htmlspecialchars($evento['CEP']); ?>

                    </div>

                </div>

                <!-- =================================
                     DATAS
                ================================== -->

                <div class="datas-evento">

                    <?php while ($data = mysqli_fetch_assoc($resultDatas)): ?>

                        <div class="data-box">

                            <!-- TOPO -->
                            <div class="data-topo">

                                <i class="fa-regular fa-calendar"></i>

                                <span>
                                    EVENTO
                                </span>

                            </div>

                            <!-- DATA -->
                            <strong>

                                <?= date(
                                    "d/m/Y",
                                    strtotime($data['data_inicio'])
                                ); ?>

                            </strong>

                            <!-- HORÁRIO -->
                            <div class="horario-evento">

                                <i class="fa-regular fa-clock"></i>

                                <?= date(
                                    "H:i",
                                    strtotime($data['horario_inicio'])
                                ); ?>

                                -

                                <?= date(
                                    "H:i",
                                    strtotime($data['horario_fim'])
                                ); ?>

                            </div>

                        </div>

                    <?php endwhile; ?>

                </div>

                <!-- =================================
                     LOCALIZAÇÃO
                ================================== -->

                <div class="localizacao-topo">

                    <h2>

                        <i class="fa-solid fa-location-dot"></i>

                        Localização

                    </h2>

                    <!-- ENDEREÇO -->
                    <div class="endereco-completo">

                        <?= htmlspecialchars($evento['rua']); ?>,

                        <?= htmlspecialchars($evento['numero']); ?>

                        -

                        <?= htmlspecialchars($evento['bairro']); ?>

                        -

                        <?= htmlspecialchars($evento['cidade']); ?>

                    </div>

                    <!-- REFERÊNCIA -->
                    <?php if (!empty($evento['ponto_referencia'])): ?>

                        <div class="referencia-local">

                            <i class="fa-solid fa-route"></i>

                            <?= htmlspecialchars($evento['ponto_referencia']); ?>

                        </div>

                    <?php endif; ?>

                    <!-- CEP -->
                    <div class="cep-local">

                        CEP:
                        <?= htmlspecialchars($evento['CEP']); ?>

                    </div>

                    <!-- MAPA -->
                    <a
                        href="mapa.php?id=<?= $evento['id_evento']; ?>"
                        class="btn-mapa-local"
                        target="_blank"
                    >

                        <i class="fa-solid fa-map-location-dot"></i>

                        Ver no mapa

                    </a>

                </div>

            </div>

            <!-- =================================
                 DIREITA
            ================================== -->

            <div class="lado-direito">

                <!-- IMAGEM -->
                <div class="container-imagem">

                    <img
                        src="uploads/<?= htmlspecialchars($evento['Imagem']); ?>"
                        alt="<?= htmlspecialchars($evento['titulo']); ?>"
                    >

                </div>

                <!-- DESCRIÇÃO IMAGEM -->
                <?php if (!empty($evento['descIMG'])): ?>

                    <div class="descricao-imagem">

                        <i class="fa-solid fa-image"></i>

                        <?= htmlspecialchars($evento['descIMG']); ?>

                    </div>

                <?php endif; ?>

                <!-- =================================
                     AÇÕES
                ================================== -->

                <div class="card">

                    <h3>
                        Ações
                    </h3>

                    <div class="acoes-evento">

                        <!-- PARTICIPAR -->
                        <button
                            type="button"
                            class="btn-acao"
                            id="btnParticipar"
                            data-id="<?= htmlspecialchars($evento['id_evento']); ?>"
                        >

                            <?php if ($jaParticipou): ?>

                                <i class="fa-solid fa-star"></i>

                                Participando

                            <?php else: ?>

                                <i class="fa-regular fa-star"></i>

                                Participar

                            <?php endif; ?>

                        </button>


                        <!-- FAVORITAR -->
                        <button
                            type="button"
                            class="btn-secundario"
                            id="btnFavoritar"
                            data-id="<?= htmlspecialchars($evento['id_evento']); ?>"
                        >

                            <?php if ($jaFavoritou): ?>

                                <i class="fa-solid fa-heart"></i>

                                Favoritado

                            <?php else: ?>

                                <i class="fa-regular fa-heart"></i>

                                Favoritar

                            <?php endif; ?>

                        </button>

                    </div>

                </div>

                <!-- =====================================
                     DESCRIÇÃO
                ====================================== -->

                <div class="card">

                    <h3>
                        Sobre o Evento
                    </h3>

                    <p>

                        <?= nl2br(
                            htmlspecialchars($evento['descricao'])
                        ); ?>

                    </p>

                </div>

            </div>

        </section>

    </div>

</div>

<script>

document.addEventListener("DOMContentLoaded", function () {

    /* =====================================================
       PARTICIPAR / DESPARTICIPAR
    ===================================================== */

    const btnParticipar =
        document.getElementById("btnParticipar");

    if (btnParticipar) {

        btnParticipar.addEventListener("click", function () {

            const botao = this;

            const idEvento = botao.dataset.id;

            // Evita clique duplo
            if (botao.dataset.processando === "true") {
                return;
            }

            botao.dataset.processando = "true";

            fetch("participar.php", {

                method: "POST",

                headers: {
                    "Content-Type":
                        "application/x-www-form-urlencoded"
                },

                body:
                    "id_evento=" +
                    encodeURIComponent(idEvento)

            })

            .then(response => response.text())

            .then(resposta => {

                resposta = resposta.trim();

                console.log(
                    "Resposta do participar.php:",
                    resposta
                );

                // Usuário não está logado
                if (resposta === "login") {

                    alert("Faça login primeiro!");

                    return;
                }

                // PARTICIPOU
                if (resposta === "ok") {

                    botao.innerHTML =
                        '<i class="fa-solid fa-star"></i> Participando';

                    botao.classList.add("participando");

                    return;
                }

                // DESPARTICIPOU
                if (resposta === "desparticipou") {

                    botao.innerHTML =
                        '<i class="fa-regular fa-star"></i> Participar';

                    botao.classList.remove("participando");

                    return;
                }

                // Evento não encontrado
                if (resposta === "evento_inexistente") {

                    alert("Evento não encontrado!");

                    return;
                }

                // Qualquer outro erro
                console.error(
                    "Resposta inesperada:",
                    resposta
                );

                alert(
                    "Não foi possível alterar sua participação."
                );

            })

            .catch(error => {

                console.error(
                    "Erro no participar.php:",
                    error
                );

                alert(
                    "Erro de conexão com o servidor."
                );

            })

            .finally(() => {

                botao.dataset.processando = "false";

            });

        });

    }


    /* =====================================================
       FAVORITAR / DESFAVORITAR
    ===================================================== */

    const btnFavoritar =
        document.getElementById("btnFavoritar");

    if (btnFavoritar) {

        btnFavoritar.addEventListener("click", function () {

            const botao = this;

            const idEvento = botao.dataset.id;

            // Evita clique duplo
            if (botao.dataset.processando === "true") {
                return;
            }

            botao.dataset.processando = "true";

            fetch("favoritar.php", {

                method: "POST",

                headers: {
                    "Content-Type":
                        "application/x-www-form-urlencoded"
                },

                body:
                    "id_evento=" +
                    encodeURIComponent(idEvento)

            })

            .then(response => response.text())

            .then(resposta => {

                resposta = resposta.trim();

                console.log(
                    "Resposta do favoritar.php:",
                    resposta
                );

                // Usuário não está logado
                if (resposta === "login") {

                    alert("Faça login primeiro!");

                    return;
                }

                // FAVORITOU
                if (resposta === "ok") {

                    botao.innerHTML =
                        '<i class="fa-solid fa-heart"></i> Favoritado';

                    botao.classList.add("favoritado");

                    return;
                }

                // DESFAVORITOU
                if (resposta === "removido") {

                    botao.innerHTML =
                        '<i class="fa-regular fa-heart"></i> Favoritar';

                    botao.classList.remove("favoritado");

                    return;
                }

                console.error(
                    "Resposta inesperada:",
                    resposta
                );

                alert(
                    "Não foi possível alterar o favorito."
                );

            })

            .catch(error => {

                console.error(
                    "Erro no favoritar.php:",
                    error
                );

                alert(
                    "Erro de conexão com o servidor."
                );

            })

            .finally(() => {

                botao.dataset.processando = "false";

            });

        });

    }

});

</script>

<!-- =========================================================
   FOOTER
========================================================= -->

<?php include 'footer.php'; ?>

</body>

</html>