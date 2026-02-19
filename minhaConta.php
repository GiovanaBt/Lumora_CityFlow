<!DOCTYPE html>
<html lang="en">
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

    <?php if (isset($_SESSION['usuario_id'])): ?>
        <!-- Usuário LOGADO -->
        <li class="perfil">
            <a href="#">
                <i class="fa-solid fa-circle-user"></i>
                <?php echo $_SESSION['nome_usuario']; ?>
            </a>

            <ul class="submenu">
                <li><a href="minhaConta.php">Minha conta</a></li>
                <li><a href="favoritos.php">Favoritos</a></li>
                <li><a href="meusEventos.php">Meus eventos</a></li>
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
<body>
    <h1>Minha conta eba eba </h1>
<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
    <section id="favoritos">
        <h1>Favoritos</h1>
    </section>
    <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
    <section id="meusEventos">
        <h1>Meus eventos</h1>
    </section>
</body>
</html>