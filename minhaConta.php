<?php
session_start();
include 'Conexao.php';

/* PROTEÇÃO */
if (!isset($_SESSION['usuario_id'])) {
    header("Location: index.php");
    exit();
}

$idUsuario = $_SESSION['usuario_id'];

$sucessoUsuario = $_SESSION['sucesso_usuario'] ?? '';
$erroUsuario = $_SESSION['erro_usuario'] ?? '';

unset($_SESSION['sucesso_usuario']);
unset($_SESSION['erro_usuario']);

/* DADOS DO USUÁRIO */
$sqlUsuario = "SELECT * FROM usuarios WHERE id_usuarios = $idUsuario";
$resultUsuario = mysqli_query($conexao, $sqlUsuario);
$usuario = mysqli_fetch_assoc($resultUsuario);

/* FAVORITOS */
$sqlFavoritos = "
SELECT e.*
FROM favoritos f
JOIN eventos_cadastrados e ON e.id_evento = f.id_evento
WHERE f.id_usuario = $idUsuario
";
$resultFavoritos = mysqli_query($conexao, $sqlFavoritos);

/* PARTICIPANDO */
$sqlParticipando = "
SELECT e.*
FROM atividade a
JOIN eventos_cadastrados e ON e.id_evento = a.id_evento
WHERE a.id_usuarios = $idUsuario
ORDER BY e.id_evento DESC
";
$resultParticipando = mysqli_query($conexao, $sqlParticipando);

/* MEUS EVENTOS */
$sqlEventos = "
SELECT * FROM eventos_cadastrados   
WHERE id_usuarios = $idUsuario
ORDER BY id_evento DESC
";
$resultEventos = $conexao->query($sqlEventos);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>City Flow - Minha Conta</title>

    <link rel="stylesheet" href="header.css">
    <link rel="stylesheet" href="submenu.css">
    <link rel="stylesheet" href="minhaConta.css">
    <link rel="stylesheet" href="footer.css">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

    <link rel="shortcut icon" href="imgs/logoCityFlow.webp">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body>

<?php if ($sucessoUsuario): ?>
    <div class="mensagem sucesso">
        <?= htmlspecialchars($sucessoUsuario) ?>
    </div>
<?php endif; ?>

<?php if ($erroUsuario): ?>
    <div class="mensagem erro">
        <?= htmlspecialchars($erroUsuario) ?>
    </div>
<?php endif; ?>
<!-- HEADER (NÃO ALTERADO) -->
<header>

    <div class="logo">
        <a href="index.php">
            <img src="imgs/cityFlow.webp">
        </a>
    </div>

    <a href="mapa.php" target="_blank">
        <button class="botaoMapa">MAPA</button>
    </a>

    <nav>
        <ul class="menu">

            <li>
                <a href="index.php">INÍCIO</a>
            </li>

            <li>
                <a href="informacoes.php">INFORMAÇÕES</a>
            </li>

            <li>
                <a href="cadastroEvento.php">
                    <i class="fa-solid fa-circle-plus"></i>
                    DIVULGAR EVENTOS
                </a>
            </li>

            <?php if (isset($_SESSION['usuario_id'])): ?>

                <li class="perfil">

                    <a href="#">
                        <i class="fa-solid fa-circle-user"></i>
                        <?php echo $_SESSION['nome_usuario']; ?>
                    </a>

                    <ul class="submenu">

                        <li>
                            <a href="minhaConta.php">
                                <i class="fa-solid fa-user-gear"></i>
                                Minha Conta
                            </a>
                        </li>

                        <li>
                            <a href="minhaConta.php#favoritos">
                                <i class="fa-solid fa-heart"></i>
                                Favoritos
                            </a>
                        </li>

                        <li>
                            <a href="ajuda.php">
                                <i class="fa-solid fa-circle-question"></i>
                                Central de ajuda
                            </a>
                        </li>

                        <li>
                            <a href="logout.php" class="btn-sair">
                                <i class="fa-solid fa-right-from-bracket"></i>
                                Sair
                            </a>
                        </li>

                    </ul>

                </li>

            <?php endif; ?>

        </ul>
    </nav>

</header>


<!-- LAYOUT NOVO -->
<div class="layout-conta">

    <!-- ESQUERDA (DADOS) -->
    <div class="lado-esquerdo">

        <h1 class="titulo-principal">Minha Conta</h1>

        <h2 class="subtitulo">Dados da Conta</h2>

       <form action="atualizarUsuario.php" method="POST" class="dados">

    <!-- NOME COMPLETO -->
    <div class="campo">
        <label>Nome completo</label>

        <input
            type="text"
            name="nome_completo"
            value="<?= htmlspecialchars($usuario['nome_completo'] ?? ''); ?>"
            id="nome_completo"
            disabled
        >

        <i
            class="fa fa-pen"
            onclick="habilitarEdicao('nome_completo')"
        ></i>
    </div>


    <!-- NOME DE USUÁRIO -->
    <div class="campo">
        <label>Nome de usuário</label>

        <input
            type="text"
            name="nome_usuario"
            value="<?= htmlspecialchars($usuario['nome_usuario'] ?? ''); ?>"
            id="nome_usuario"
            disabled
        >

        <i
            class="fa fa-pen"
            onclick="habilitarEdicao('nome_usuario')"
        ></i>
    </div>


    <!-- DATA DE NASCIMENTO -->
    <div class="campo">
        <label>Data de nascimento</label>

        <input
            type="date"
            name="data_nascimento"
            value="<?= htmlspecialchars($usuario['data_nascimento'] ?? ''); ?>"
            id="data_nascimento"
            disabled
        >

        <i
            class="fa fa-pen"
            onclick="habilitarEdicao('data_nascimento')"
        ></i>
    </div>


    <!-- CPF -->
    <div class="campo">
        <label>CPF</label>

        <input
            type="text"
            name="cpf"
            value="<?= htmlspecialchars($usuario['cpf'] ?? ''); ?>"
            id="cpf"
            disabled
        >

        <i
            class="fa fa-pen"
            onclick="habilitarEdicao('cpf')"
        ></i>
    </div>


    <!-- TELEFONE -->
    <div class="campo">
        <label>Telefone</label>

        <input
            type="text"
            name="telefone"
            value="<?= htmlspecialchars($usuario['telefone'] ?? ''); ?>"
            id="telefone"
            disabled
        >

        <i
            class="fa fa-pen"
            onclick="habilitarEdicao('telefone')"
        ></i>
    </div>


    <!-- E-MAIL -->
    <div class="campo">
        <label>E-mail</label>

        <input
            type="email"
            name="email"
            value="<?= htmlspecialchars($usuario['email'] ?? ''); ?>"
            id="email"
            disabled
        >

        <i
            class="fa fa-pen"
            onclick="habilitarEdicao('email')"
        ></i>
    </div>


    <!-- SENHA -->
    <div class="campo">
        <label>Nova senha</label>

        <input
            type="password"
            name="senha"
            value=""
            placeholder="Digite uma nova senha"
            id="senha"
            disabled
        >

        <i
            class="fa fa-pen"
            onclick="habilitarEdicao('senha')"
        ></i>
    </div>

<div class="botoes-edicao" id="botoesEdicao">

    <button
        type="submit"
        class="btn-salvar"
        id="btnSalvar"
    >
        Salvar Alterações
    </button>

    <button
        type="button"
        class="btn-cancelar"
        id="btnCancelar"
        onclick="cancelarEdicao()"
    >
        Cancelar Alterações
    </button>

</div>

</form>

</div> <!-- FIM DO LADO ESQUERDO -->


<!-- DIREITA (PARTICIPANDO + FAVORITOS + EVENTOS) -->
<div class="lado-direito">

        <!-- PARTICIPANDO -->
        <section id="participando">

            <h2 class="secao">

                <i class="fa-solid fa-calendar-check icone-participando"></i>

                Participando

            </h2>


            <div class="carrossel-wrapper">


                <!-- SETA ESQUERDA -->
                <button
                    type="button"
                    class="seta-carrossel"
                    onclick="rolarCarrossel('carrosselParticipando', -250)"
                >

                    <i class="fa-solid fa-chevron-left"></i>

                </button>


                <!-- CARROSSEL -->
                <div
                    class="carrossel-container"
                    id="carrosselParticipando"
                >

                    <?php if (mysqli_num_rows($resultParticipando) > 0): ?>

                        <?php while ($part = mysqli_fetch_assoc($resultParticipando)): ?>

                            <a
                                href="eventos.php?id=<?= $part['id_evento']; ?>"
                                class="card-link"
                            >

                                <div class="card">

                                    <img
                                        src="uploads/<?= $part['Imagem']; ?>"
                                        alt="<?= htmlspecialchars($part['titulo']); ?>"
                                    >

                                    <div class="descricao">
                                        <?= htmlspecialchars($part['titulo']); ?>
                                    </div>

                                    <div class="local">
                                        <?= htmlspecialchars($part['bairro']); ?>
                                    </div>

                                </div>

                            </a>

                        <?php endwhile; ?>

                    <?php else: ?>

                        <p>Você não está participando de nenhum evento.</p>

                    <?php endif; ?>

                </div>


                <!-- SETA DIREITA -->
                <button
                    type="button"
                    class="seta-carrossel"
                    onclick="rolarCarrossel('carrosselParticipando', 250)"
                >

                    <i class="fa-solid fa-chevron-right"></i>

                </button>

            </div>

        </section>


        <!-- FAVORITOS -->
   <!-- FAVORITOS -->
<section id="favoritos">

    <h2 class="secao">

        <i class="fa-solid fa-star icone-favorito"></i>

        Meus Favoritos

    </h2>


    <div class="carrossel-wrapper">

        <!-- SETA ESQUERDA -->
        <button
            type="button"
            class="seta-carrossel"
            onclick="rolarCarrossel('carrosselFavoritos', -250)"
        >
            <i class="fa-solid fa-chevron-left"></i>
        </button>


        <!-- CARROSSEL -->
        <div
            class="carrossel-container"
            id="carrosselFavoritos"
        >

            <?php if (mysqli_num_rows($resultFavoritos) > 0): ?>

                <?php while ($fav = mysqli_fetch_assoc($resultFavoritos)): ?>

                    <a
                        href="eventos.php?id=<?= $fav['id_evento']; ?>"
                        class="card-link"
                    >

                        <div class="card">

                            <img
                                src="uploads/<?= $fav['Imagem']; ?>"
                                alt="<?= htmlspecialchars($fav['titulo']); ?>"
                            >

                            <div class="descricao">
                                <?= htmlspecialchars($fav['titulo']); ?>
                            </div>

                            <div class="local">
                                <?= htmlspecialchars($fav['bairro']); ?>
                            </div>

                        </div>

                    </a>

                <?php endwhile; ?>

            <?php else: ?>

                <p>Você não tem favoritos</p>

            <?php endif; ?>

        </div>


        <!-- SETA DIREITA -->
        <button
            type="button"
            class="seta-carrossel"
            onclick="rolarCarrossel('carrosselFavoritos', 250)"
        >
            <i class="fa-solid fa-chevron-right"></i>
        </button>

    </div>

</section>


        <!-- EVENTOS -->
    <section id="meusEventos">

    <h2 class="secao">
        <i class="fa-solid fa-ticket icone-eventos"></i>
        Meus Eventos
    </h2>

    <a href="editarMeusEventos.php" class="btn-editar-eventos">
        <i class="fa-solid fa-pen-to-square"></i>
        Editar meus eventos
    </a>

    <div class="container">

        <?php if ($resultEventos->num_rows > 0): ?>

            <?php while ($row = $resultEventos->fetch_assoc()): ?>

                <a href="eventos.php?id=<?= $row['id_evento']; ?>">

                    <div class="card">

                        <img
                            src="uploads/<?= $row['Imagem']; ?>"
                        >

                        <div class="descricao">
                            <?= htmlspecialchars($row['titulo']); ?>
                        </div>

                        <div class="local">
                            <?= htmlspecialchars($row['bairro']); ?>
                        </div>

                    </div>

                </a>

            <?php endwhile; ?>

        <?php else: ?>

            <p>Você não criou eventos</p>

        <?php endif; ?>

    </div>

</section>

    </section>

</div> <!-- FIM DO LADO DIREITO -->

</div> <!-- FIM DO LAYOUT CONTA -->


<!-- FOOTER -->
<?php include 'footer.php'; ?>

<!-- JS -->
<script>

function habilitarEdicao(id) {

    const campo = document.getElementById(id);

    campo.disabled = false;
    campo.focus();

    document.getElementById("botoesEdicao").style.display = "flex";
}

function cancelarEdicao() {
    window.location.reload();
}


document
    .querySelector(".dados")
    .addEventListener("submit", function () {

        /*
        IMPORTANTE:

        Campos disabled não são enviados
        pelo formulário.

        Por isso, antes de salvar,
        todos são habilitados.
        */

        document
            .getElementById("nome_completo")
            .disabled = false;

        document
            .getElementById("nome_usuario")
            .disabled = false;

        document
            .getElementById("data_nascimento")
            .disabled = false;

        document
            .getElementById("cpf")
            .disabled = false;

        document
            .getElementById("telefone")
            .disabled = false;

        document
            .getElementById("email")
            .disabled = false;

        document
            .getElementById("senha")
            .disabled = false;

    });

function rolarCarrossel(id, distancia) {

    const carrossel = document.getElementById(id);

    carrossel.scrollBy({
        left: distancia,
        behavior: "smooth"
    });

}

</script>

</body>
</html>