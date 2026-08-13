<?php
session_start();
include 'Conexao.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: index.php");
    exit();
}

$idUsuario = $_SESSION['usuario_id'];

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: editarMeusEventos.php");
    exit();
}

$idEvento = (int) $_GET['id'];

/* BUSCA O EVENTO E CONFIRMA QUE ELE PERTENCE AO USUÁRIO */

$sql = "SELECT *
        FROM eventos_cadastrados
        WHERE id_evento = ?
        AND id_usuarios = ?";

$stmt = mysqli_prepare($conexao, $sql);
mysqli_stmt_bind_param($stmt, "ii", $idEvento, $idUsuario);
mysqli_stmt_execute($stmt);

$resultado = mysqli_stmt_get_result($stmt);
$evento = mysqli_fetch_assoc($resultado);

if (!$evento) {
    echo "Evento não encontrado ou você não tem permissão para editá-lo.";
    exit();
}

/* CATEGORIAS */

$sqlCategorias = "SELECT * FROM categoria ORDER BY categoria_evento";
$resultCategorias = mysqli_query($conexao, $sqlCategorias);

/* DATAS DO EVENTO */

$sqlDatas = "SELECT *
             FROM datas_evento
             WHERE id_evento = ?
             ORDER BY data_inicio, horario_inicio";

$stmtDatas = mysqli_prepare($conexao, $sqlDatas);
mysqli_stmt_bind_param($stmtDatas, "i", $idEvento);
mysqli_stmt_execute($stmtDatas);

$resultDatas = mysqli_stmt_get_result($stmtDatas);
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Editar Evento - CityFlow</title>
    <link rel="stylesheet" href="header.css"> 
     <link rel="stylesheet" href="submenu.css">
    <link rel="stylesheet" href="footer.css">
    <link rel="stylesheet" href="editarEvento.css">

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

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


<main class="editar-container">

    <div class="titulo-editar">

        <h1>
            <i class="fa-solid fa-pen-to-square"></i>
            Editar evento
        </h1>

        <p>
            Altere as informações do seu evento.
        </p>

    </div>

    <form action="salvarEdicaoEvento.php"
          method="POST"
          enctype="multipart/form-data">

        <input type="hidden"
               name="id_evento"
               value="<?= $evento['id_evento']; ?>">

        <section class="form-section">

            <h2>
                <i class="fa-solid fa-circle-info"></i>
                Informações do evento
            </h2>

            <div class="campo">

                <label for="titulo">Título do evento</label>

                <input
                    type="text"
                    id="titulo"
                    name="titulo"
                    value="<?= htmlspecialchars($evento['titulo']); ?>"
                    required
                >

            </div>

            <div class="campo">

                <label for="subtitulo">Subtítulo</label>

                <input
                    type="text"
                    id="subtitulo"
                    name="subtitulo"
                    value="<?= htmlspecialchars($evento['subtitulo']); ?>"
                >

            </div>

            <div class="campo">

                <label for="descricao">Descrição</label>

                <textarea
                    id="descricao"
                    name="descricao"
                    rows="6"
                    required
                ><?= htmlspecialchars($evento['descricao']); ?></textarea>

            </div>

            <div class="campo">

                <label for="id_categoria">Categoria</label>

                <select id="id_categoria" name="id_categoria" required>

                    <?php while ($categoria = mysqli_fetch_assoc($resultCategorias)): ?>

                        <option
                            value="<?= $categoria['id_categoria']; ?>"
                            <?= ($categoria['id_categoria'] == $evento['id_categoria']) ? 'selected' : ''; ?>
                        >
                            <?= htmlspecialchars($categoria['categoria_evento']); ?>
                        </option>

                    <?php endwhile; ?>

                </select>

            </div>

            <div class="campo">

                <label for="classificacao_indicativa">
                    Classificação indicativa
                </label>

                <select
                    id="classificacao_indicativa"
                    name="classificacao_indicativa"
                >

                    <option value="Livre"
                        <?= $evento['classificacao_indicativa'] == 'Livre' ? 'selected' : ''; ?>>
                        Livre
                    </option>

                    <option value="10 anos"
                        <?= $evento['classificacao_indicativa'] == '10 anos' ? 'selected' : ''; ?>>
                        10 anos
                    </option>

                    <option value="12 anos"
                        <?= $evento['classificacao_indicativa'] == '12 anos' ? 'selected' : ''; ?>>
                        12 anos
                    </option>

                    <option value="14 anos"
                        <?= $evento['classificacao_indicativa'] == '14 anos' ? 'selected' : ''; ?>>
                        14 anos
                    </option>

                    <option value="16 anos"
                        <?= $evento['classificacao_indicativa'] == '16 anos' ? 'selected' : ''; ?>>
                        16 anos
                    </option>

                    <option value="18 anos"
                        <?= $evento['classificacao_indicativa'] == '18 anos' ? 'selected' : ''; ?>>
                        18 anos
                    </option>

                </select>

            </div>

        </section>

        <section class="form-section">

            <h2>
                <i class="fa-solid fa-location-dot"></i>
                Localização
            </h2>

            <div class="linha">

                <div class="campo">

                    <label for="CEP">CEP</label>

                    <input
                        type="text"
                        id="CEP"
                        name="CEP"
                        value="<?= htmlspecialchars($evento['CEP']); ?>"
                    >

                </div>

                <div class="campo">

                    <label for="cidade">Cidade</label>

                    <input
                        type="text"
                        id="cidade"
                        name="cidade"
                        value="<?= htmlspecialchars($evento['cidade']); ?>"
                    >

                </div>

            </div>

            <div class="linha">

                <div class="campo">

                    <label for="bairro">Bairro</label>

                    <input
                        type="text"
                        id="bairro"
                        name="bairro"
                        value="<?= htmlspecialchars($evento['bairro']); ?>"
                    >

                </div>

                <div class="campo">

                    <label for="rua">Rua</label>

                    <input
                        type="text"
                        id="rua"
                        name="rua"
                        value="<?= htmlspecialchars($evento['rua']); ?>"
                    >

                </div>

            </div>

            <div class="linha">

                <div class="campo">

                    <label for="numero">Número</label>

                    <input
                        type="text"
                        id="numero"
                        name="numero"
                        value="<?= htmlspecialchars($evento['numero']); ?>"
                    >

                </div>

                <div class="campo">

                    <label for="ponto_referencia">
                        Ponto de referência
                    </label>

                    <input
                        type="text"
                        id="ponto_referencia"
                        name="ponto_referencia"
                        value="<?= htmlspecialchars($evento['ponto_referencia']); ?>"
                    >

                </div>

            </div>

        </section>

        <section class="form-section">

            <h2>
                <i class="fa-solid fa-calendar"></i>
                Datas e horários
            </h2>

            <?php while ($data = mysqli_fetch_assoc($resultDatas)): ?>

                <div class="data-evento">

                    <input
                        type="hidden"
                        name="id_data[]"
                        value="<?= $data['id_data']; ?>"
                    >

                    <div class="campo">

                        <label>Data de início</label>

                        <input
                            type="date"
                            name="data_inicio[]"
                            value="<?= $data['data_inicio']; ?>"
                            required
                        >

                    </div>

                    <div class="campo">

                        <label>Data de fim</label>

                        <input
                            type="date"
                            name="data_fim[]"
                            value="<?= $data['data_fim']; ?>"
                        >

                    </div>

                    <div class="campo">

                        <label>Horário de início</label>

                        <input
                            type="time"
                            name="horario_inicio[]"
                            value="<?= $data['horario_inicio']; ?>"
                            required
                        >

                    </div>

                    <div class="campo">

                        <label>Horário de fim</label>

                        <input
                            type="time"
                            name="horario_fim[]"
                            value="<?= $data['horario_fim']; ?>"
                            required
                        >

                    </div>

                </div>

            <?php endwhile; ?>

        </section>

        <section class="form-section">

            <h2>
                <i class="fa-solid fa-image"></i>
                Imagem
            </h2>

            <?php if (!empty($evento['Imagem'])): ?>

                <img
                    class="imagem-atual"
                    src="<?= htmlspecialchars($evento['Imagem']); ?>"
                    alt="Imagem atual do evento"
                >

            <?php endif; ?>

            <div class="campo">

                <label for="Imagem">
                    Alterar imagem
                </label>

                <input
                    type="file"
                    id="Imagem"
                    name="Imagem"
                    accept="image/*"
                >

            </div>

            <p class="ajuda-imagem">
                Se não escolher uma nova imagem, a imagem atual será mantida.
            </p>

        </section>

        <div class="botoes">

            <a href="editarMeusEventos.php" class="btn-voltar">
                Cancelar
            </a>

            <button type="submit" class="btn-salvar">
                <i class="fa-solid fa-check"></i>
                Salvar alterações
            </button>

        </div>

    </form>

</main>
<?php include 'footer.php'; ?>

</body>
</html>