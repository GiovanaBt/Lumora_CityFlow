<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>City Flow - Concte-se à cultura de sua cidade</title>
    <link rel="stylesheet" href="index.css">
    <link rel="shortcut icon" href="imgs/logoCityFlow_removebg.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

</head>

<body>
<header>
    <div class='logo'>
        <img src="imgs/logoCityFlow_removebg.png" alt="logo">
    </div>

    <div class="hamburguer" id="hamburguer">
        <i class="fa-solid fa-bars"></i>
    </div>

    <ul class="menu" id="menu">
    <li><a href="#informacoes">Informações</a></li>
    <li><a href="cadastroEvento.php">Divulgar Eventos</a></li>

    <a href="mapa.php" target="_blank">
    <button class="bMapa">Ver eventos no mapa</button>
    </a>

    <?php if (isset($_SESSION['usuario_id'])): ?>
        <li class="perfil">
            <a href="index.php">
                <i class="fa-solid fa-circle-user"></i>
                <?php echo $_SESSION['nome_usuario'];?>
            </a>

            <ul class="submenu">
                <li><a href="minhaConta.php">Minha conta</a></li>
                <li><a href="minhaConta.php#favoritos">Favoritos</a></li>
                <li><a href="minhaConta.php#meusEventos">Meus eventos</a></li>
                <li><a href="ajuda.php">Central de ajuda</a></li>
                <li><a href="logout.php">Sair</a></li>
            </ul>
        </li>

    <?php else: ?>
        <li>
            <a id="abrirModal">
                <i class="fa-solid fa-circle-user"></i>
            </a>
        </li>
    <?php endif; ?>

</ul>

</header>

<h1 class='h1'>tela inicial</h1>

<div id="modal" class="modal">
    <div class="modal-conteudo">
        <span class="fechar">&times;</span>
        <h1>Que bom ter você aqui!</h1>
        <h3>Faça seu Login</h3>

        <form action="fazerLogin.php" method="POST">

            <label>E-mail</label><br>
            <input type="text" name="emailLogin"><br><br>

            <label>Senha</label><br>
            <input type="text" name="senhaLogin"><br><br>

            <button type="submit">Entrar</button>
            <?php
                echo "<script>window.location.href = 'index.php';
                </script>";
            ?>
        </form>

        <h4>Não possui uma conta?</h4>
        <a href="cadastroUsuario.php">Cadastre-se</a>
    </div>
</div>

<script src="script.js"></script>

</body>
</html>