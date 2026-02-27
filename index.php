<?php
session_start();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>City Flow - Concte-se à cultura de sua cidade</title>
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="imgs/logoCityFlow.webp" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

</head>

<body>
    <header>
        <div class='logo'>
            <a href="index.php"></a>
            <img src="imgs/cityFlow.webp" alt="logo"> <!-- Logo -->
        </div>
        <a href="mapa.php" target="_blank">
            <button class="botaoMapa">MAPA</button> <!-- Botão para acessar o mapa em uma nova aba -->
        </a>
        <nav> <!-- Navegação do header -->
            <ul class="menu" id="menu"> <!-- Menu de navegação do header -->
                <li><a href="index.php">INÍCIO</a></li>
                <li><a href="#informacoes">INFORMAÇÕES</a></li>
                <li><a href="cadastroEvento.php"><i class="fa-solid fa-circle-plus"></i>DIVULGAR EVENTOS</a></li>



                <?php if (isset($_SESSION['usuario_id'])): ?> <!-- Verifica se o usuário está logado -->
                    <li class="perfil">
                        <a href="index.php">

                            <i class="fa-solid fa-arrow-right-to-bracket"></i>
                            <?php echo $_SESSION['nome_usuario']; ?>
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

                    <div class="menu-container"> <!-- Container para entrar -->

                        <a id="abrirModal"> <!-- Ícone de usuário para abrir o modal de login -->
                            <i class="fa-solid fa-arrow-right-to-bracket"></i>
                            <span class="texto-entrar">ENTRAR</span>
                        </a>
                    </div>

                <?php endif; ?> <!-- Fim da verificação de login -->

            </ul>
        </nav>


    </header>

    <div id="modal" class="modal"> <!-- Modal de login, inicialmente oculto, que será exibido ao clicar no ícone de usuário -->
        <div class="modal-conteudo">
            <span class="fechar">&times;</span> <!-- Botão para fechar o modal -->
            <h1>QUE BOM TER VOCÊ AQUI!</h1>
            <h3>FAÇA SEU LOGIN</h3>

            <form action="fazerLogin.php" method="POST">

                <label>E-MAIL</label><br>
                <input type="text" name="emailLogin"><br><br>

                <label>SENHA</label><br>
                <input type="password" name="senhaLogin"><br><br>


                <button type="submit">ENTRAR</button>
                <?php
                // echo "<script>window.location.href = 'index.php';
                // </script>";
                ?>
            </form>

            <h4>NÃO POSSUI UMA CONTA?</h4>
            <a href="cadastroUsuario.php">CADASTRE-SE</a>
        </div>
    </div> <!-- Fim do modal de login -->

    <script src="script.js"></script>

    <section>

    </section>

</body>

</html>